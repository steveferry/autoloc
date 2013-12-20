<?php
namespace Application\Model;
use Zend\Db\TableGateway\TableGateway;

 class VehiculeTable
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

     public function getVehicule($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveVehicule(Vehicule $vehicule)
     {
         $data = array(
             'brand' => $vehicule->brand,
             'model'  => $vehicule->model,
             'type'  => $vehicule->type,
         );

         $id = (int) $vehicule->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getVehicule($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Vehicule id does not exist');
             }
         }
     }

     public function deleteVehicule($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }
?>