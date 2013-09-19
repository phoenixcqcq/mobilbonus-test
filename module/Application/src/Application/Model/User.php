<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Tony
 * Date: 19.9.13
 * Time: 9:13
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class User{

	private $firstname;
	private $lastname;

	/**
	 * @var Adapter Database adapter
	 */
	protected $dbAdapter;

	/**
	 * Constructor only needs to setup the database
	 *
	 * @param Adapter $dbAdapter
	 */
	public function __construct(Adapter $dbAdapter)
	{
		$this->dbAdapter = $dbAdapter;
	}

	public function addUser($firstname, $lastname){
		$sql = "INSERT INTO user (firstname, lastname) VALUES (?,?)";

		$statement = $this->dbAdapter->createStatement($sql, array($firstname, $lastname));
		$result    = $statement->execute();
		return $result->getAffectedRows();
	}

	public function getAllUsers(){
		$sql = "SELECT * FROM user";

		$statement = $this->dbAdapter->createStatement($sql);
		$result    = $statement->execute();

		$return = array();
		while ($result->next()) {
			$return[] = $result->current();
		}

		return $return;
	}

	public function getUserById($id){
		$sql = "SELECT * FROM user WHERE id = ? LIMIT 1";

		$statement = $this->dbAdapter->createStatement($sql, array($id));
		$result    = $statement->execute()->current();

		return $result;
	}

}
