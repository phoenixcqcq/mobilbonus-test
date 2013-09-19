<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DatabaseController extends AbstractActionController
{
	public function indexAction()
	{
		// Get the database adapter
		$sm = $this->getServiceLocator();
		$db = $sm->get('db');

		$userModel = new \Application\Model\User($db);
		$users = $userModel->getAllUsers();

		$form = new \Application\Form\UserForm();
		return new ViewModel(array(
								  'userForm' => $form,
								  'users' => $users,
							 ));
	}

	public function ulozitAction()
	{
		// Get the database adapter
		$sm = $this->getServiceLocator();
		$db = $sm->get('db');

		$post = $this->getRequest()->getPost();
		if($post){
			$firstname = $post['firstname'];
			$lastname = $post['lastname'];

			if($firstname && $lastname){
				$userModel = new \Application\Model\User($db);
				$userModel->addUser($firstname,$lastname);
			}
		}
		$this->redirect()->toUrl($this->getRequest()->getBasePath().'/databaze');
	}

	public function editovatAction()
	{
		// Get the database adapter
		$sm = $this->getServiceLocator();
		$db = $sm->get('db');

		$id = $this->params('id');

		$userModel = new \Application\Model\User($db);
		$user = $userModel->getUserById($id);
		$users = $userModel->getAllUsers();

		$form = new \Application\Form\UserForm();
		$view = new ViewModel(array(
								  'userForm' => $form,
								  'user' => $user,
								  'users' => $users,
							 ));
		$view->setTemplate('application/database/index');
		return $view;
	}
}
