<?php

namespace App\Controller;
use Cake\Utility\Security;

/**
 * Description of ArticlesController
 *
 * @author nagomi
 */
class CommunitiesController extends AppController {
	protected $layout = 'mochi';
	public function isAuthorized($user) {
		// All registered users can add articles
		if ($this->request->action === 'add') {
			return true;
		}

		// The owner of an article can edit and delete it
		if (in_array($this->request->action, ['edit', 'delete'])) {
			$articleId = (int) $this->request->params['pass'][0];
			if ($this->Articles->isOwnedBy($articleId, $user['id'])) {
				return true;
			}
		}

		return parent::isAuthorized($user);
	}

}
