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

/**
 * Class User
 *
 * @author  Tony
 * @package Application\Model
 */
class User
{

    /**
     * @var $firstname
     */
    private $firstname;
    /**
     * @var $lastname
     */
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

    /**
     * Insert user into database
     *
     * @param $firstname
     * @param $lastname
     *
     * @return int
     */
    public function addUser($firstname, $lastname)
    {
        $sql = "INSERT INTO user (firstname, lastname) VALUES (?,?)";

        $statement = $this->dbAdapter->createStatement($sql, array($firstname, $lastname));
        $result = $statement->execute();
        return $result->getAffectedRows();
    }

    /**
     * Update existig user
     *
     * @param $id
     * @param $firstname
     * @param $lastname
     * @param $street
     * @param $town
     * @return int
     */
    public function updateUser($id, $firstname, $lastname, $street, $town)
    {
        $sql = "UPDATE user SET firstname=?, lastname=?, street=?, town=? WHERE id=?";

        $statement = $this->dbAdapter->createStatement($sql, array($firstname, $lastname, $street, $town, $id));
        $result = $statement->execute();
        return $result->getAffectedRows();
    }

    /**
     * Get all users
     *
     * @return array
     */
    public function getAllUsers()
    {
        $sql = "SELECT * FROM user";

        $statement = $this->dbAdapter->createStatement($sql);
        $result = $statement->execute();

        $return = array();
        while ($result->next()) {
            $return[] = $result->current();
        }

        return $return;
    }

    /**
     * Get one user by id
     *
     * @param $id
     * @return mixed
     */public function getUserById($id)
    {
        $sql = "SELECT * FROM user WHERE id = ? LIMIT 1";

        $statement = $this->dbAdapter->createStatement($sql, array($id));
        $result = $statement->execute()->current();

        return $result;
    }

}
