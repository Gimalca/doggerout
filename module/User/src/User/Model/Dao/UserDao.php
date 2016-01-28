<?php

namespace User\Model\Dao;

/**
 * Description of CustomerDao
 *
 * @author Pedro
 */
use Zend\Db\TableGateway\TableGateway;
use User\Model\Entity\User;

class UserDao {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function saveUser($userEntity) {
        //print_r($branch);die;        
        $dataUser = $userEntity->getArrayCopy();
//        var_dump($dataUser);die;
        return $this->tableGateway->insert($dataUser);
    }

    public function saveInterview($interviewEntity) {
        //print_r($branch);die;        
        $dataInterview = $interviewEntity->getArrayCopy();
//        var_dump($dataUser);die;
        return $this->tableGateway->insert($dataInterview);
    }

    public function getByEmail($email, $columns = null) {

//        echo $email;
        $sql = $this->tableGateway->getSql();

        $query = $sql->select()
                ->columns($columns)
                ->where(array('pr_customer.email' => $email));
        //echo $query->getSqlString();die;
        $resultSet = $this->tableGateway->selectWith($query);

//        print_r($resultSet);die;
        $row = $resultSet->current();
        return $row;
    }

    public function activateUser($usr_id) {
        $data['status'] = 1;
        $data['email_confirmed'] = 1;
        $this->tableGateway->update($data, array('customer_id' => (int) $usr_id));
    }

}
