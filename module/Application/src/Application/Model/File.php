<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Tony
 * Date: 19.9.13
 * Time: 12:26
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Application\Form\FileUploadForm;
use Zend\Validator\File\Size;
use Zend\Validator\File\Extension;
use Zend\ServiceManager\ServiceLocatorInterface;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Zend\File\Transfer\Adapter\Http;

class File
{
    const MIN_SIZE = 1;
    const MAX_SIZE = 5242880; // 5MB

    /**
     * @var Adapter Database adapter
     */
    protected $dbAdapter;

    /**
     * @var Adapter Database adapter
     */
    protected $serviceLocator;

    /**
     * Constructor only needs to setup the database and service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        $this->dbAdapter = $serviceLocator->get('db');

    }

    public function processImage($data)
    {
        $form = new FileUploadForm();
        $formModel = new FileUploadFormModel();

        $form->setInputFilter($formModel->getInputFilter());

        $form->setData($data);

        if ($form->isValid()) {
            $fileName = $data['file']['name'];
            $dir = dirname(__DIR__).'/../../../../public/images/';

            // Validate image
            $size = new Size(array('min' => $this::MIN_SIZE, 'max' => $this::MAX_SIZE));
            $extension = new Extension(array('extension' => array('jpg', 'gif')));
            $adapter = new Http();
            $adapter->setValidators(array($size, $extension), $fileName);

            if (!$adapter->isValid()) {
                $dataError = $adapter->getMessages();
                $error = array();
                foreach ($dataError as $key => $row) {
                    $error[] = $row;
                }
                $form->setMessages(array('fileupload' => $error));

                return false;
            } else {
                $adapter->setDestination($dir);
                if ($adapter->receive($fileName)) {
                    $formModel->exchangeArray($form->getData());
                }

                return $this->createThumbnail($dir, $dir."min/", $fileName, 100, 100);
            }
        }
        return false;
    }

    private function createThumbnail($dir, $destinationDir, $fileName, $width, $height)
    {

        $imagine = $this->serviceLocator->get('my_image_service');
        $image = $imagine->open($dir.$fileName);

        $size = new Box($width, $height);
        $mode = ImageInterface::THUMBNAIL_INSET;

        $image->thumbnail($size, $mode)->save($destinationDir.$fileName);

        return true;
    }
}
