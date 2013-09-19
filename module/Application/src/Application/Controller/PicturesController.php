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
use Application\Model\File;
use Application\Form\FileUploadForm;

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
        if ($this->getRequest()->isPost()) {
            $data = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );

            $serviceLocator = $this->getServiceLocator();

            $fileModel = new File($serviceLocator);

            $fileModel->processImage($data);
        }

        $this->redirect()->toUrl($this->getRequest()->getBasePath().'/prace-s-obrazkem');
    }

    private function fileProcess(){
        
    }

}
