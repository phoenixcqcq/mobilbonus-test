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
use Application\Form\FileUploadForm;
use Application\Model\FileUploadFormModel;
use Zend\Validator\File\Size;
use Zend\Validator\File\Extension;

class PicturesController extends AbstractActionController
{
    public function indexAction()
    {
        $form = new FileUploadForm();
        return new ViewModel(array(
                                  'fileUploadForm' => $form
                             ));
    }

    public function nahratAction()
    {
        // Get the database adapter
        $sm = $this->getServiceLocator();
        $db = $sm->get('db');

        $form = new FileUploadForm();

        if ($this->getRequest()->isPost()) {
            $formModel = new FileUploadFormModel();

            $form->setInputFilter($formModel->getInputFilter());

            $data = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );

            $form->setData($data);

            if ($form->isValid()) {
                $size = new Size(array('min'=>1, 'max'=>1024*1024)); //minimum bytes filesize
                $extension = new Extension(array('extension' => array('jpg', 'gif')));
                $adapter = new \Zend\File\Transfer\Adapter\Http();
                //validator can be more than one...
                $adapter->setValidators(array($size, $extension), $data['file']['name']);

                if (!$adapter->isValid()){
                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach($dataError as $key=>$row){
                        $error[] = $row;
                    }
                    $form->setMessages(array('fileupload'=>$error ));
                } else {
                    $dir = dirname(__DIR__).'/../../../../public/images/';
                    $adapter->setDestination($dir);
                    if ($adapter->receive($data['file']['name'])) {
                        $formModel->exchangeArray($form->getData());
                    }
                }
            }
        }
        $this->redirect()->toUrl($this->getRequest()->getBasePath().'/prace-s-obrazkem');
    }

    private function fileProcess(){
        
    }

}
