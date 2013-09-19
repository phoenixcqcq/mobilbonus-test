<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Tony
 * Date: 19.9.13
 * Time: 10:15
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Model;

use Application\Form\UserForm;

/**
 * Class UserFormModel
 *
 * @author  Tony
 * @package Application\Model
 */
class UserFormModel{
	/**
	 * @var UserForm
	 */
	private $form;

	/**
	 * Constructor just setup the form
	 */
	function __construct()
	{
		$this->form = new UserForm();
	}

	/**
	 * Return the UserForm
	 *
	 * @return UserForm
	 */
	public function getForm()
	{
		return $this->form;
	}

	/**
	 * Populate the firstname
	 *
	 * @param $firstname
	 */
	public function populateFirstname($firstname)
	{
		$this->form->get('firstname')->setAttribute('value', $firstname);
	}

	/**
	 * Populate the lastname
	 *
	 * @param $lastname
	 */
	public function populateLastname($lastname)
	{
		$this->form->get('lastname')->setAttribute('value', $lastname);
	}

	/**
	 * Populate the street
	 *
	 * @param $street
	 */
	public function populateStreet($street)
	{
		$this->form->get('street')->setAttribute('value', $street);
	}

	/**
	 * Populate the town
	 *
	 * @param $town
	 */
	public function populateTown($town)
	{
		$this->form->get('town')->setAttribute('value', $town);
	}

}
