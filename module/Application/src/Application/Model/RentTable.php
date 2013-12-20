<?php
namespace Application\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

 class RentTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }
	 
	 public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function fetchAllFromUser($idUser)
     {
		echo $idUser;
		$select = new \Zend\Db\Sql\Select ; 
        $select->from('rents'); 
        $select->columns(array('id','vehicleId','startDate','stopDate')); 
		$select->where(array('userId' => $idUser));


		$resultSet = $this->tableGateway->selectWith($select);
		
		return $resultSet; 
		/*$result  = $this->select(function (Select $select) use ($idUser){
			$select->where(array('idUser'=>$idUser));
			$select->join('user', 'rents.userId = user.id');
			$select->join('vehicle', 'rents.vehicleId = vehicle.id');
		 });
	   
		 return $result;*/
     }
	 
	 public function fetchAllFromVehicle($idVehicle)
     {
          $id  = (int) $id;
         $resultset = $this->tableGateway->select(array('idVehicle' => $idVehicle));
         if (!$resultset) {
             throw new \Exception("Could not find rent from vehicle $id");
         }
         return $resultset;
     }

     public function getRent($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveRent(Rent $rent)
     {
         $data = array(
             'userId' => $rent->userId,
             'vehicleId'  => $rent->vehicleId,
             'dateStart'  => $rent->dateStart,
         );

         $id = (int) $rent->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getVehicule($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Rent id does not exist');
             }
         }
     }

     public function deleteRent($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }
?>