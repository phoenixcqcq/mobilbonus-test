<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Tony
 * Date: 19.9.13
 * Time: 0:12
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Form;

use Zend\Form\Form;

/**
 * Class FileUploadForm
 *
 * @author  Tony
 * @package Application\Form
 */
class FileUploadForm extends Form
{

	/**
	 * Constructor creates the form
	 *
	 * @param string $name
	 */
	public function __construct(string $name = null)
	{
		parent::__construct('file-upload');

		$this->setAttribute('method', 'post');
        $this->setAttribute('enctype','multipart/form-data');

		$this->add(
			array(
				'name' => 'file',
				'attributes' => array(
					'id'   => 'file',
					'type'  => 'file',
				),
				'options' => array(
					'label' => 'Obrázek:',
				),
			)
		);


		$this->add(
			array(
				'name' => 'submit',
				'attributes' => array(
					'type'  => 'submit',
					'value' => 'Nahrát',
					'id'    => 'submit',
					 'class' => 'btn btn-success'
				),
			)
		);
	}
}