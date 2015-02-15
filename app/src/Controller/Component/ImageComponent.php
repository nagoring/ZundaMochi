<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ImageComponent extends Component {

	function image($imageObject) {
		$quality = 75;
		$filepath = $imageObject->filedir . $imageObject->filename;
		switch ($imageObject->info[2]) {
			case IMAGETYPE_GIF:
				$image = imagecreatefromgif($imageObject->tmpName);
				imagegif($image, $filepath, $quality);
				break;
			case IMAGETYPE_JPEG:
				$image = imagecreatefromjpeg($imageObject->tmpName);
				imagejpeg($image, $filepath, $quality);
				break;
			case IMAGETYPE_PNG:
				$image = imagecreatefrompng($imageObject->tmpName);
				$quality = round($quality / 10);
				if ($quality >= 10)
					$quality = 9;
				imagepng($image, $filepath, $quality);
				break;
			default:
				return false;
		}
		return true;
	}

	function smart_resize_image($file, $width = 0, $height = 0, $proportional = false, $output = 'file', $delete_original = true, $use_linux_commands = false) {
		if ($height <= 0 && $width <= 0) {
			return false;
		}

		$info = getimagesize($file);
		$image = '';

		$final_width = 0;
		$final_height = 0;
		list($width_old, $height_old) = $info;

		if ($proportional) {
			if ($width == 0)
				$factor = $height / $height_old;
			elseif ($height == 0)
				$factor = $width / $width_old;
			else
				$factor = min($width / $width_old, $height / $height_old);

			$final_width = round($width_old * $factor);
			$final_height = round($height_old * $factor);
		}
		else {
			$final_width = ( $width <= 0 ) ? $width_old : $width;
			$final_height = ( $height <= 0 ) ? $height_old : $height;
		}

		switch ($info[2]) {
			case IMAGETYPE_GIF:
				$image = imagecreatefromgif($file);
				break;
			case IMAGETYPE_JPEG:
				$image = imagecreatefromjpeg($file);
				break;
			case IMAGETYPE_PNG:
				$image = imagecreatefrompng($file);
				break;
			default:
				return false;
		}

		$image_resized = imagecreatetruecolor($final_width, $final_height);

		if (($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG)) {
			$trnprt_indx = imagecolortransparent($image);
			$palletsize = imagecolorstotal($image);
			// If we have a specific transparent color
			if ($trnprt_indx >= 0 && $trnprt_indx < $palletsize) {

				// Get the original image's transparent color's RGB values
				$trnprt_color = imagecolorsforindex($image, $trnprt_indx);

				// Allocate the same color in the new image resource
				$trnprt_indx = imagecolorallocate($image_resized, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);

				// Completely fill the background of the new image with allocated color.
				imagefill($image_resized, 0, 0, $trnprt_indx);

				// Set the background color for new image to transparent
				imagecolortransparent($image_resized, $trnprt_indx);
			}
			// Always make a transparent background color for PNGs that don't have one allocated already
			elseif ($info[2] == IMAGETYPE_PNG) {

				// Turn off transparency blending (temporarily)
				imagealphablending($image_resized, false);

				// Create a new transparent color for image
				$color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);

				// Completely fill the background of the new image with allocated color.
				imagefill($image_resized, 0, 0, $color);

				// Restore transparency blending
				imagesavealpha($image_resized, true);
			}
		}

		imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);

		if ($delete_original) {
			if ($use_linux_commands)
				exec('rm ' . $file);
			else
				@unlink($file);
		}

		switch (strtolower($output)) {
			case 'browser':
				$mime = image_type_to_mime_type($info[2]);
				header("Content-type: $mime");
				$output = NULL;
				break;
			case 'file':
				$output = $file;
				break;
			case 'return':
				return $image_resized;
				break;
			default:
				break;
		}

		switch ($info[2]) {
			case IMAGETYPE_GIF:
				imagegif($image_resized, $output);
				break;
			case IMAGETYPE_JPEG:
				imagejpeg($image_resized, $output);
				break;
			case IMAGETYPE_PNG:
				imagepng($image_resized, $output);
				break;
			default:
				return false;
		}

		return true;
	}

	function unique_file_name($file, $prefix = '', $suffix = '') {
		$info = getimagesize($file);

		switch ($info[2]) {
			case IMAGETYPE_GIF:
				$extension = '.gif';
				break;
			case IMAGETYPE_JPEG:
				$extension = '.jpg';
				break;
			case IMAGETYPE_PNG:
				$extension = '.png';
				break;
			default:
				$extension = '';
		}

		return $prefix . sprintf("%04d%02d%02d%02d%02d%02d", date("Y"), date("m"), date("d"), date("H"), date("i"), date("s")) . $suffix . $extension;
	}

	function get_type($file) {
		$info = getimagesize($file);
		return $info[2];
	}

	function get_extension($file) {
		$type = $this->get_type($file);
		switch ($type) {
			case IMAGETYPE_GIF:
				$extension = '.gif';
				break;
			case IMAGETYPE_JPEG:
				$extension = '.jpg';
				break;
			case IMAGETYPE_PNG:
				$extension = '.png';
				break;
			default:
				$info = getimagesize($file);
				throw new Exception("Failed extension: " . $type . 'var:' . var_export($info, true));
		}
		return $extension;
	}

	function create_image($image, $filename, $quality = 75) {
		$path_parts = pathinfo($filename);

		switch ($path_parts['extension']) {
			case 'gif':
				imagegif($image, $filename, $quality);
				break;
			case 'jpg':
				imagejpeg($image, $filename, $quality);
				break;
			case 'png':
				$quality = round($quality / 10);
				if ($quality >= 10)
					$quality = 9;
				imagepng($image, $filename, $quality);
				break;
		}
	}

	function getExtenstion($image) {
		switch ($image->info[2]) {
			case IMAGETYPE_GIF:
				return '.gif';
				break;
			case IMAGETYPE_JPEG:
				return '.jpg';
				break;
			case IMAGETYPE_PNG:
				return '.png';
				break;
				return false;
		}
	}

}
