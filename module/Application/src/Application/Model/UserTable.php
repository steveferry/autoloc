<?php
namespace Application\Model;

/**
 * User table interface
 */
class UserTable extends \Zend\Db\TableGateway\AbstractTableGateway
{
    /**
     * @var string 
     */
    protected $table = 'user';

    /**
     * Create the User table interface
     * @param Adapter $adapter The adapter to handle
     */
    public function __construct(\Zend\Db\Adapter\Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new \Zend\Db\ResultSet\ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new User());
        $this->initialize();
    }

    /**
     * Fetch all the user in database
     * @return Array 
     */
    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }
    
    /**
     * Check if a username already exists in database
     * @param string $name
     * @return boolean 
     */
    public function nameExists($name) {
        $result = $this->select("username = '$name'");
        return $result->count()>0;
    }

    /**
     * Retrieve a user by id
     * @param int $id
     * @return User 
     */
    public function getUser($id)
    {
        $id  = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    /**
     * Save a given user to database (create if not exists)
     * @param User $user
     */
    public function saveUser(User $user)
    {
        $data = array(
            //'completename' => $user->completename,
            'username' => $user->username,
            'password' => $user->password,
        );
        $id = (int)$user->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getUser($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
        
        return $this;
    }

    /**
     * Delete a user by id
     * @param int $id
     */
    public function deleteUser($id)
    {
        $this->delete(array('id' => $id));
    }
}

?>
