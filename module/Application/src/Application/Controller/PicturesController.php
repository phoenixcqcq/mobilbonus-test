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
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

class PicturesController extends AbstractActionController
{
    public function indexAction()
    {
        $form = new FileUploadForm();
        $warning = null;
        if (isset($_SESSION['warning'])) {
            $warning = $_SESSION['warning'];
            unset($_SESSION['warning']);
        }
        return new ViewModel(array(
                                  'fileUploadForm' => $form,
                                  'images'         => $this->getAllImages(),
                                  'warning'        => $warning
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

            if(!$fileModel->processImage($data)){
                $_SESSION['warning'] = "Soubor se nepodařilo nahrát.";
            }
        }

        $this->redirect()->toUrl($this->getRequest()->getBasePath().'/prace-s-obrazkem');
    }

    public function poslatAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);

        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            $email = $post['email'];
            $validator = new \Zend\Validator\EmailAddress();
            if (!$validator->isValid($email)) {
                $_SESSION['warning'] = "Emailová adresa není správná.";
                $this->redirect()->toUrl($this->getRequest()->getBasePath().'/prace-s-obrazkem');
                exit;
            }
            $image = $this->getImageById($id);

            $this->sendEmail($email, $image['name']);
        }

        $this->redirect()->toUrl($this->getRequest()->getBasePath().'/prace-s-obrazkem');
    }

    private function getAllImages()
    {
        $serviceLocator = $this->getServiceLocator();

        $fileModel = new File($serviceLocator);
        return $fileModel->getAllImages();
    }

    private function getImageById($id)
    {
        $serviceLocator = $this->getServiceLocator();

        $fileModel = new File($serviceLocator);
        return $fileModel->getImageById($id);
    }

    private function sendEmail($email, $file)
    {

        $dir = dirname(__DIR__).'/../../../../public/images/';
        $img = file_get_contents($dir.$file);

        $mimeMessage = new MimeMessage();
        $messageText = new Part('Mail Content');
        $messageText->type = 'text/html';

        $messageAttachment = new Part($img);
        $messageAttachment->type = 'image/jpg';
        $messageAttachment->filename = $file;
        $messageAttachment->encoding = \Zend\Mime\Mime::ENCODING_BASE64;
        $messageAttachment->disposition = \Zend\Mime\Mime::DISPOSITION_ATTACHMENT;

        $mimeMessage->setParts(
            array(
                 $messageText,
                 $messageAttachment,
            )
        );

        $message = new Message();
        $message->setEncoding('utf-8')->addTo($email)->addFrom('test@test.com') //not relevat
            ->setSubject('Test')->setBody($mimeMessage);

        $transport = new SmtpTransport();
        $options = new SmtpOptions(array(
                                        'name'              => 'localhost',
                                        'host'              => 'smtp.gmail.com',
                                        'connection_class'  => 'login',
                                        'port'              => '465',
                                        'connection_config' => array(
                                            'ssl'      => 'ssl', /* Page would hang without this line being added */
                                            'username' => 'antonin.vyborny.test@gmail.com',
                                            'password' => 'superheslo',
                                        ),
                                   ));
        $transport->setOptions($options);
        $transport->send($message);
    }
}
