<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Tony
 * Date: 19.9.13
 * Time: 12:43
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class FileUploadFormModel implements InputFilterAwareInterface
{
    public $file;
    protected $inputFilter;

    public function exchangeArray($data)
    {
        $this->file = (isset($data['file'])) ? $data['file'] : null;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add(
                $factory->createInput(array(
                                           'name'     => 'file',
                                           'required' => true,
                                      ))
            );

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}

