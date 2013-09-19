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
use Application\Model\User;
use Application\Form\UserForm;
use Application\Model\UserFormModel;

class DatabaseController extends AbstractActionController
{
    public function indexAction()
    {
        $form = new UserForm();
        return new ViewModel(array('userForm' => $form, 'users' => $this->getAllUsers()));
    }

    public function ulozitAction()
    {
        // Get the database adapter
        $sm = $this->getServiceLocator();
        $db = $sm->get('db');

        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            $id = $post['id'];
            $firstname = $post['firstname'];
            $lastname = $post['lastname'];
            $street = $post['street'];
            $town = $post['town'];

            $userModel = new User($db);

            if ($id) {
                $userModel->updateUser($id, $firstname, $lastname, $street, $town);
            } else {
                $userModel->addUser($firstname, $lastname);
            }
        }
        $this->redirect()->toUrl($this->getRequest()->getBasePath().'/databaze');
    }

    public function editovatAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);

        $user = $this->getUserById($id);

        $userFormModel = new UserFormModel();

        if ($user) {
            $userFormModel->populateFirstname($user['firstname']);
            $userFormModel->populateLastname($user['lastname']);
            $userFormModel->populateStreet($user['street']);
            $userFormModel->populateTown($user['town']);
        }

        $form = $userFormModel->getForm();

        $view = new ViewModel(array('userForm' => $form, 'user' => $user, 'users' => $this->getAllUsers()));
        $view->setTemplate('application/database/index');
        return $view;
    }

    private function getAllUsers()
    {
        // Get database adapter
        $db = $this->getServiceLocator()->get('db');

        $userModel = new User($db);
        return $userModel->getAllUsers();
    }

    private function getUserById($id)
    {
        // Get database adapter
        $db = $this->getServiceLocator()->get('db');

        $userModel = new User($db);
        return $userModel->getUserById($id);
    }
}
