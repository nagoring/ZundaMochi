<?php
namespace App\Controller\Component;
use Cake\Controller\Component;


class ImageUploadComponent extends Component{
	public function validate($error, $tmp_name){
		$size = filesize($tmp_name);
		$fp = fopen($tmp_name, 'rb');
		$imagebinary = '';
		while(!feof($fp)){
			$imagebinary .= fread($fp, $size);
		}
		fclose($fp);
		checkAttackImage($imagebinary);
		
		if($error === UPLOAD_ERR_OK){
			return true;
		}else{
			return __('ファイルのアップロードに失敗しました');
		}
		$type = exif_imagetype($tmp_name);
		if (!in_array($type, [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG], true)) {
			return __('画像形式が未対応です');
		}
		if($size === 0){
			return __('ファイルサイズが不正です');
		}
		return false;
	}
    function createImage($tmp_name, $path, $filename, $width, $height, $max_size = 5000000) {
    	// 画像アップロード
    	$tmp_file = $tmp_name;
    	$imginfo = getimagesize($tmp_file);
		if(!file_exists($path)){
			mkdir($path, 0644);
		}
		
    	clearstatcache();
    	//300KB、JPEG・GIF・PNG
    	if (filesize($tmp_file) > $max_size || ($imginfo[2] < 1 || $imginfo[2] > 3)) { $this->set('file_error',true); return false; }
    	//            $upload_path = WWW_ROOT . $path . DS;
    	$upload_path = $path . DS;
    	$width_old  = $imginfo[0];
    	$height_old = $imginfo[1];
    	$width_new  = $width;
    	$height_new = $height;
    	if($height_old > $width_old){
    		//高さのほうが高いとき
    		//比率 = (resizeHeight / srcHeight)
    		//アスペクト比保持のwidth = (srcWidth * 比率)
    		$ratio = $height_new / $height_old;
    		$width_new = $width_old * $ratio;
    	}else{
    		//横が高いとき
    		//比率=(resizeWidth / srcWidth)
    		//アスクペクト比保持のwidth = (srcHeight * 比率)
    		$ratio = $width_new / $width_old;
    		$height_new = $height_old * $ratio;
    	}

    	switch ($imginfo[2]) {
    		case IMAGETYPE_JPEG: // jpeg
		    	$filename .= ".jpg";
    			$jpeg = imagecreatefromjpeg($tmp_file);
    			$jpeg_new = imagecreatetruecolor($width_new, $height_new);
    			imagecopyresampled($jpeg_new,$jpeg,0,0,0,0,$width_new,$height_new,$width_old,$height_old);
    			imagejpeg($jpeg_new, $upload_path . $filename, 100);
    			break;
    		case IMAGETYPE_GIF: // gif
		    	$filename .= ".gif";
    			$gif = imagecreatefromgif($tmp_file);
    			$gif_new = imagecreatetruecolor($width_new, $height_new);
    			imagecopyresampled($gif_new,$gif,0,0,0,0,$width_new,$height_new,$width_old,$height_old);
    			imagegif($gif_new, $upload_path . $filename, 100);
    			break;
    		case IMAGETYPE_PNG: // png
		    	$filename .= ".png";
    			$png = imagecreatefrompng($tmp_file);
    			$png_new = imagecreatetruecolor($width_new, $height_new);
    			imagecopyresampled($png_new,$png,0,0,0,0,$width_new,$height_new,$width_old,$height_old);
    			imagepng($png_new, $upload_path . $filename, 9);
    			break;
    		Default:
    			break;
    	}
    	//imageMagickによるセンター寄せ
    	exec("convert " . $upload_path . $filename . " -size " . $width . "x" . $height . " xc:white +swap -gravity center -composite " . $upload_path . $filename);
    	return $filename;
    }
    function convPcJpgToMobileJpg($tmp_name, $path, $filename, $width, $height) {
    	// 画像アップロード
    	$filename .= ".jpg";
    	$tmp_file = $tmp_name;
    	$imginfo = getimagesize($tmp_file);

    	clearstatcache();
    	//300KB、JPEG・GIF・PNG
    	if (filesize($tmp_file)>1000000 || ($imginfo[2] < 1 || $imginfo[2] > 3)) { $this->set('file_error',true); return false; }
    	//            $upload_path = WWW_ROOT . $path . DS;
    	$upload_path = $path;
    	$width_old  = $imginfo[0];
    	$height_old = $imginfo[1];
    	$width_new  = $width;
    	$height_new = $height;

    	switch ($imginfo[2]) {
    		case 2: // jpeg
    			//                    $filename = sprintf("%05d.jpg", $user_id);
    			$jpeg = imagecreatefromjpeg($tmp_file);
    			$jpeg_new = imagecreatetruecolor($width_new, $height_new);
    			imagecopyresampled($jpeg_new,$jpeg,0,0,0,0,$width_new,$height_new,$width_old,$height_old);
    			imagejpeg($jpeg_new, $upload_path . $filename, 100);
    			break;
    		case 1: // gif
    			//                    $filename = sprintf("%05d.jpg", $user_id);
    			$gif = imagecreatefromgif($tmp_file);
    			$gif_new = imagecreatetruecolor($width_new, $height_new);
    			imagecopyresampled($gif_new,$gif,0,0,0,0,$width_new,$height_new,$width_old,$height_old);
    			imagegif($gif_new, $upload_path . $filename, 100);
    			break;
    		case 3: // png
    			//                    $filename = sprintf("%05d.jpg", $user_id);
    			$png = imagecreatefrompng($tmp_file);
    			$png_new = imagecreatetruecolor($width_new, $height_new);
    			imagecopyresampled($png_new,$png,0,0,0,0,$width_new,$height_new,$width_old,$height_old);
    			imagepng($png_new, $upload_path . $filename, 100);
    			break;
    		Default:
    			break;
    	}
    	return $filename;
    }
    function resize_image($image_file){
    	list($src_width,$src_height)=getimagesize($image_file);
    	if ($src_width>280){
    		$resize_width = 280;
    		$resize_height = $src_height * ( $resize_width / $src_width );
    		$image_src = imagecreatefromjpeg($image_file);
    		$image_resize = imagecreatetruecolor($resize_width,$resize_height);
    		imagecopyresized($image_resize,$image_src,0,0,0,0,$resize_width,$resize_height,$src_width,$src_height);
    		imagejpeg($image_resize,$image_file);
    	}
    }
	public function getExtention($tmp_name){
		$type = exif_imagetype($tmp_name);
		if($type === IMAGETYPE_JPEG){
			return '.jpg';
		}
		if($type === IMAGETYPE_PNG){
			return '.png';
		}
		if($type === IMAGETYPE_GIF){
			return '.gif';
		}
		return false;
	}
}