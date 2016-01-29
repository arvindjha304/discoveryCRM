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
    
    public function getMagicBrickCredentials($compId){
        $table = new TableGateway('magic_brick_credentials',$this->getAdapter());
        $select = $table->select(['comp_id'=>$compId])->toArray();
        return $select;
    }
    
    public function getNintyNineAcresCredentials($compId){
        $table = new TableGateway('acres_api_credentials',$this->getAdapter());
        $select = $table->select(['comp_id'=>$compId])->toArray();
        return $select;
    }
    
    public function checkIfLeadExists($mobile,$compId) {
//        settype($mobile,"float"); 
        $table = new TableGateway('lead_list',$this->getAdapter());
        $result = $table->select(function($select) use($mobile){
            $select->where->OR->equalTo('mobile', $mobile);
            $select->where->OR->equalTo('alt_no', $mobile);
            $select->where->OR->equalTo('other_no', $mobile);
        })->toArray();
        if(count($result)>0) return 1; else return 0;
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
        $table = new TableGateway('assigned_lead',$this->getAdapter());
        $select = $table->select(['lead_id'=>$lead_id,'assigned_to'=>$user_id,'is_active'=>1])->toArray();
        if(count($select)==0){
            $this->insertanywhere('assigned_lead', $data);
            $this->updateanywhere('lead_list', ['is_assigned'=>1],['id'=>$lead_id]); 
        }
        return 1;
    }
    
    public function getAllCompanies() {
        $table = new TableGateway('companies',$this->getAdapter());
        $select = $table->select(['is_active'=>1,'is_delete'=>0])->toArray();
        return $select;
    }
    
    public function getUserList($comp_id){
        $tableGateway = new TableGateway(['ul'=>'userlist'],$this->getAdapter());
        $userList = $tableGateway->select(function($select) use ($comp_id){
            $select->columns(['id','role_id','comp_id'])
                    ->join(['cr'=>'company_roles'],'cr.id=ul.role_id',['role_name','seniority']);
            $select->where(['ul.is_delete'=>0,'ul.comp_id'=>$comp_id]);
        })->toArray();
//        echo '<pre>';print_r($userList);exit;
        return $userList;
    }
    
    public function getMorningReport($comp_id,$user_id,$seniority) {
        $tableGateway = new TableGateway(['uls'=>'updated_lead_status'],$this->getAdapter());
        $returnArr      = $tableGateway->select(function($select) use($comp_id,$user_id,$seniority){
            $teamUserArr = $this->getTeamUserArr($comp_id,$user_id,$seniority);
            $select->columns(['statusName'=>new Expression("IF(uls.interested_type=1,'Site Visit',IF(uls.interested_type=2,'Meeting','Follow Up'))"),'numOfLeads'=>new Expression("count(uls.status_type)")]);
            $select->join(['ll'=>'lead_list'],'ll.id=uls.lead_id',[]);
            if($seniority==4){
                $select->join(['al'=>'assigned_lead'],'uls.lead_id=al.lead_id',[]);
                $select->where(['al.assigned_to'=>$user_id]);
            }elseif($seniority==3){
                $select->join(['al'=>'assigned_lead'],'uls.lead_id=al.lead_id',[]);
                if(count($teamUserArr)){
                    $allUserStr = $teamUserArr[0]['teamUsrIds'].','.$user_id;
                    $allUserArr = explode(',',$allUserStr);
                    $select->where->in('al.assigned_to',$allUserArr);
                }else{
                    $select->where(['al.assigned_to'=>$user_id]);
                }    
            }  
            $oldDate = date('Y-m-j',strtotime( '-1 day' , time()));
            $futureDate = date('Y-m-j',strtotime( '+1 day' , time()));
            $select->where->between('uls.date_time_value', $oldDate, $futureDate);
            $select->where(['uls.comp_id'=>$comp_id,'uls.is_active'=>1,'uls.status_type'=>1])
                    ->group('uls.status_type')
                    ->group('uls.interested_type');
        })->toArray(); 
        echo '<pre>';print_r($returnArr);exit;
        return $returnArr;
    }
     
    public function getEveningReport($comp_id,$user_id,$seniority) {
        $tableGateway = new TableGateway(['uls'=>'updated_lead_status'],$this->getAdapter());
        $returnArr      = $tableGateway->select(function($select) use($comp_id,$user_id,$seniority){
            $teamUserArr = $this->getTeamUserArr($comp_id,$user_id,$seniority);
            $select->columns(['statusName'=>new Expression("IF(uls.interested_type=1,'Site Visit',IF(uls.interested_type=2,'Meeting','Follow Up'))"),'numOfLeads'=>new Expression("count(uls.status_type)")]);
            $select->join(['ll'=>'lead_list'],'ll.id=uls.lead_id',[]);
            
            if($seniority==4){
                $select->join(['al'=>'assigned_lead'],'uls.lead_id=al.lead_id',[]);
                $select->where(['al.assigned_to'=>$user_id]);
            }elseif($seniority==3){
                $select->join(['al'=>'assigned_lead'],'uls.lead_id=al.lead_id',[]);
                if(count($teamUserArr)){
                    $allUserStr = $teamUserArr[0]['teamUsrIds'].','.$user_id;
                    $allUserArr = explode(',',$allUserStr);
                    $select->where->in('al.assigned_to',$allUserArr);
                }else{
                    $select->where(['al.assigned_to'=>$user_id]);
                }    
            }
            
            $oldDate = date('Y-m-j',strtotime( '-1 day' , time()));
            $futureDate = date('Y-m-j',strtotime( '+1 day' , time()));
            $select->where->between('uls.date_time_value', $oldDate, $futureDate);
            $select->where(['uls.comp_id'=>$comp_id,'uls.is_active'=>1,'uls.status_type'=>1])
                    ->group('uls.status_type')
                    ->group('uls.interested_type');
        })->toArray(); 
        echo '<pre>';print_r($returnArr);exit;
        return $returnArr;
    }   
    
    public function getTeamUserArr($comp_id,$user_id,$seniority){
       $teamUserArr = [];
        if($seniority==3){
            $table = new TableGateway('userlist',$this->getAdapter());
            $teamUserArr = $table->select(function($select){
                $select->columns(['teamUsrIds' => new Expression('GROUP_CONCAT(id)')]);
                $select->where(['reporting_manager'=>$user_id,'is_active'=>1,'is_delete'=>0]);
            })->toArray();
        }
        return $teamUserArr;
    }
    
    
    
    
}