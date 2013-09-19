<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Tony
 * Date: 19.9.13
 * Time: 0:15
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Form;

use Zend\Form\Form;

/**
 * Class UserForm
 *
 * @author  Tony
 * @package Application\Form
 */
class UserForm extends Form
{

	/**
	 * Constructor creates the form
	 *
	 * @param string $name
	 */
	public function __construct(string $name = null)
	{
		parent::__construct('user');

		$this->setAttribute('method', 'post');

		$this->add(
			array(
				 'name'       => 'firstname',
				 'attributes' => array(
					 'id'   => 'firstname',
					 'type' => 'text',
				 ),
				 'options'    => array(
					 'label' => 'Jméno:',
				 ),
			)
		);
		$this->add(
			array(
				 'name'       => 'lastname',
				 'attributes' => array(
					 'id'   => 'lastname',
					 'type' => 'text',
				 ),
				 'options'    => array(
					 'label' => 'Příjmení:',
				 ),
			)
		);
		$this->add(
			array(
				 'name'       => 'submit',
				 'attributes' => array(
					 'type'  => 'submit',
					 'value' => 'Uložit',
					 'id'    => 'submit',
					 'class' => 'btn btn-success'
				 ),
			)
		);
	}
}
