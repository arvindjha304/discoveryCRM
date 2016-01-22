<?php
namespace Application\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Authentication\AuthenticationService;
use Zend\Session\Container;


class Api extends AbstractTableGateway implements ServiceLocatorAwareInterface {

	protected $serviceLocator;
	protected $tableGateway;
//	public  $dbAdapterConfig;
//        private $roleRightsArr;
//        private $loggedInUserDetails;
	
    public function getAdapter() {
        return $this->serviceLocator->get('Zend\Db\Adapter\Adapter');
    }
    public function __construct(AbstractTableGateway $tableGateway){
        $this->tableGateway = $tableGateway;
        $auth = new AuthenticationService();
//        $this->loggedInUserDetails = $auth->getIdentity(); 
//        $roleInSession = new Container('roleInSession');
//        $this->roleRightsArr       = $roleInSession->roleRightsArr;
    }
	 
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->serviceLocator = $serviceLocator;
    }

    public function getServiceLocator() {
        return $this->serviceLocator;
    }
    public function updateanywhere($mytable, array $data, $where) {
        $db =$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $table = new TableGateway($mytable, $db);
        $results = $table->update($data, $where);
        return 1;
    }

    public function deleteanywhere($mytable, $where) {
        $db =$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $table = new TableGateway($mytable, $db);
        $data = array(
            'is_delete'	=> 	 1 ,
        );
        $results = $table->update($data, $where);
        //$table->delete($where); 
        return 1;
    }

    public function insertanywhere($mytable, array $data) {
        $db = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $table = new TableGateway($mytable, $db);
        $results = $table->insert($data);
    }
    public function lastInsertId($mytable, array $data) {
        $db = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $table = new TableGateway($mytable, $db);
        $results = $table->insert($data);
        $id = $table->lastInsertValue;
        return $id;
    }
    
    public function getCompanySettings() {
        $table = new TableGateway('company_settings',$this->getAdapter());
        $select = $table->select()->toArray();
        return $select;
    }
    public function auto_assign_source_user($compId) {
        $table = new TableGateway('auto_assign_source_user',$this->getAdapter());
        $select = $table->select(['comp_id'=>$compId])->toArray();
        return $select;
    }
    public function getSourceLeads($source_id,$compId) {
        
        $table = new TableGateway(['ll'=>'lead_list'],$this->getAdapter());
        $result = $table->select(function($select) use($source_id,$compId){
            $oldDate = date('Y-m-j',strtotime( '-2 day' , time()));
            $select->columns(['id','source_of_enquiry','date_created'])
                    ->where(['source_of_enquiry'=>$source_id,'comp_id'=>$compId])
//                    ->where->between('date_created', $oldDate, date('Y-m-d'))
                    ->where->between(new Expression('date(date_created)'), $oldDate, date('Y-m-d'));
        })->toArray();
//        echo '<pre>';print_r($result);exit;
        return $result;
    }
    
    public function assignLeadToUser($lead_id,$user_id,$compId) {
        $data = [
            'lead_id'       => $lead_id,
            'assigned_to'   => $user_id,
            'assigned_by'   => 0,
            'assigned_date' => date('Y-m-d H:i:s'),
            'comp_id'       => $compId
        ]; 
        // check if lead assigned to user
        
        $table = new TableGateway('assigned_lead',$this->getAdapter());
        $select = $table->select(['lead_id'=>$lead_id,'assigned_to'=>$user_id,'is_active'=>1])->toArray();
        
        if(count($select)==0){
            $this->insertanywhere('assigned_lead', $data);
            $this->updateanywhere('lead_list', ['is_assigned'=>1],['id'=>$lead_id]); 
        }
        return 1;
    }
    
    
    
}