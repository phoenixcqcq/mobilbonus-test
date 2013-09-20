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

/**
 * Class FileUploadFormModel
 *
 * @author  Tony
 * @package Application\Model
 */
class FileUploadFormModel implements InputFilterAwareInterface
{
    /**
     * @var $file
     */
    public $file;

    /**
     * @var $inputFilter
     */
    protected $inputFilter;

    /**
     * Set data from the form
     *
     * @param $data
     */
    public function exchangeArray($data)
    {
        $this->file = (isset($data['file'])) ? $data['file'] : null;
    }

    /**
     * Set input filter
     *
     * @param InputFilterInterface $inputFilter
     *
     * @throws \Exception
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    /**
     * Retrieve input filter
     *
     * @return \Zend\InputFilter\InputFilter
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add(
                $factory->createInput(
                    array(
                         'name'     => 'file',
                         'required' => true,
                    )
                )
            );

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}

