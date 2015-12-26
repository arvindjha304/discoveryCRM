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


 class Admin extends AbstractTableGateway implements ServiceLocatorAwareInterface {

	protected $serviceLocator;
	protected $tableGateway;
//	public  $dbAdapterConfig;
        private $roleRightsArr;
        private $loggedInUserDetails;
	
    public function getAdapter() {
        return $this->serviceLocator->get('Zend\Db\Adapter\Adapter');
    }
    public function __construct(AbstractTableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
        $auth = new AuthenticationService();
        $this->loggedInUserDetails = $auth->getIdentity(); 
        $roleInSession = new Container('roleInSession');
        $this->roleRightsArr       = $roleInSession->roleRightsArr;
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
	
    public function getUserList($userId=''){
        $tableGateway = new TableGateway('userlist',$this->getAdapter());
        $userList = $tableGateway->select(function($select) use ($userId){
            if($userId!='')
                $select->where->equalTo('userlist.id',$userId);
            $select->join(['cr'=>'company_roles'],'cr.id=userlist.role_id','role_name')
                    ->join(['usr'=>'userlist'],'usr.id=userlist.last_updated_by',['lastUpdatedBy'=>'username']);
            $select->where(['userlist.is_delete'=>0,'userlist.comp_id'=>$this->loggedInUserDetails->comp_id]);
        })->toArray();
//        echo '<pre>';print_r($userList);exit;
        return $userList;
    }
    
    
    public function getTeamUserArr(){
       $teamUserArr = [];
        if($this->roleRightsArr['seniority']==3){
            $table = new TableGateway('userlist',$this->getAdapter());
            $teamUserArr = $table->select(function($select){
                $select->columns(['teamUsrIds' => new Expression('GROUP_CONCAT(id)')]);
                $select->where(['reporting_manager'=>$this->loggedInUserDetails->id,'is_active'=>1,'is_delete'=>0]);
            })->toArray();
        }
        return $teamUserArr;
    }
    
    
    public function getLeadList($leadId=''){
        $teamUserArr = $this->getTeamUserArr();
        
        $tableGateway = new TableGateway('lead_list',$this->getAdapter());
        $leadList = $tableGateway->select(function($select) use ($leadId,$teamUserArr){
            if($leadId!=''){
                $select->where->equalTo('id',$leadId);
            }else{
                $select->join(['pl'=>'project_list'],'pl.id=lead_list.project_interested',['project_name'])
                ->join(['sl'=>'source_list'],'sl.id=lead_list.source_of_enquiry',['source_name'])
                ->join(['ul'=>'userlist'],'ul.id=lead_list.created_by',['open_by'=>'username'])
                    ->where(['lead_list.is_assigned'=>0,'sl.is_delete'=>0,'ul.is_active'=>1,'ul.is_delete'=>0]);
                if($this->roleRightsArr['seniority']==4){
                    $select->where(['lead_list.created_by'=>$this->loggedInUserDetails->id]);
                }elseif($this->roleRightsArr['seniority']==3){
                    if(count($teamUserArr)){
                        $allUserStr = $teamUserArr[0]['teamUsrIds'].','.$this->loggedInUserDetails->id;
                        $allUserArr = explode(',',$allUserStr);
                        $select->where->in('lead_list.created_by',$allUserArr);
                    }else{
                        $select->where(['lead_list.created_by'=>$this->loggedInUserDetails->id]);
                    }    
                }
            }
            $select->where(['lead_list.is_delete'=>0,'lead_list.comp_id'=>$this->loggedInUserDetails->comp_id]);
        })->toArray();
//        echo '<pre>';print_r($leadList);exit;
        return $leadList;
    }
    
    public function getRoleDetail($roleId){
        $sql = new Sql($this->getAdapter());
        $select = $sql->select()
            ->from('company_roles')
            ->columns(['id','role_name','seniority'])
            ->where(['id'=>$roleId,'is_delete'=>0,'comp_id'=>$this->loggedInUserDetails->comp_id]);
        $result = $sql->prepareStatementForSqlObject($select)->execute()->current();
        return $result;
    }
    
    public function getRoleRights($roleId=''){
        $sql = new Sql($this->getAdapter());
        $whereArr = ['is_active'=>1,'is_delete'=>0,'comp_id'=>$this->loggedInUserDetails->comp_id];
        if($roleId!='') $whereArr['role_id'] = $roleId;
        $select = $sql->select()
            ->from('company_role_rights')
            ->columns(['role_id','right_id'])
            ->where($whereArr);
        $result = $sql->prepareStatementForSqlObject($select)->execute();
        $roleRightsArr = [];
        if(count($result)){
            foreach($result as $res)
                $roleRightsArr[] = $res['right_id'];
        }
        return $roleRightsArr;
    }
    public function getAllRoleRights(){
        $sql = new Sql($this->getAdapter());
        $select = $sql->select()
            ->from('company_rights')
            ->columns(['id'])
            ->where(['is_active'=>1,'is_delete'=>0,'comp_id'=>$this->loggedInUserDetails->comp_id]);
        $result = $sql->prepareStatementForSqlObject($select)->execute();
        $rightsArr = [];
        if(count($result)){
            foreach($result as $res)
                $rightsArr[] = $res['id'];
        }
        return $rightsArr;
    }
	
    public function getAllRoles(){
        
        $sql = new Sql($this->getAdapter());
        $select = $sql->select()
                ->from('company_roles')
                ->where(['is_delete'=>0,'comp_id'=>$this->loggedInUserDetails->comp_id]);
        if($this->roleRightsArr['seniority']!=1)
            $select->where->greaterThan ('seniority', $this->roleRightsArr['seniority']);
        
        $select->order('seniority');
                
        $result = $sql->prepareStatementForSqlObject($select)->execute();
        return $result;
    }
	
    public function getAllRolesJson(){
        
        $allRoles = $this->getAllRoles();
        $dataArray = array(['Id'=>"",'Name'=>'Select Role']);
        foreach($allRoles as $roles)
        {
            if($roles['is_active']==1){
                $tempArr         = [];
                $tempArr['Id']   = $roles['id'];
                $tempArr['Name'] = $roles['role_name'];
                $dataArray[]    = $tempArr;
            }
        }
        
//        echo '<pre>';print_r($dataArray);exit;
        
        return json_encode($dataArray);
    }
    
    
    public function getUsersByRoleJson($role_id){
        
        $tableGateway = new TableGateway('userlist',$this->getAdapter());
        $userList = $tableGateway->select(function($select) use ($role_id){
            $select->where->equalTo('userlist.role_id',$role_id);
            $select->join(['cr'=>'company_roles'],'cr.id=userlist.role_id','role_name');
             if($this->roleRightsArr['seniority']==3)
                 $select->where(['userlist.reporting_manager'=>$this->loggedInUserDetails->id]);
            $select->where(['userlist.is_delete'=>0,'userlist.comp_id'=>$this->loggedInUserDetails->comp_id]);
        })->toArray();
        $dataArray = array(['Id'=>"",'Name'=>'Select User']);
        foreach($userList as $roles)
        {
           $tempArr         = [];
           $tempArr['Id']   = $roles['id'];
           $tempArr['Name'] = $roles['username'];
           $dataArray[]    = $tempArr;
        }
//        echo '<pre>';print_r($dataArray);exit;
        return json_encode($dataArray);
    }
    public function getAllSources(){
        
        $sql = new Sql($this->getAdapter());
        $select = $sql->select()
            ->from('source_list')
            ->where(['is_delete'=>0,'comp_id'=>$this->loggedInUserDetails->comp_id]);
        $allSources = $sql->prepareStatementForSqlObject($select)->execute();
        $dataArray = array();
        foreach($allSources as $sources)
        {
           $tempArr         = [];
           $tempArr['Id']   = $sources['id'];
           $tempArr['Name'] = $sources['source_name'];
           $dataArray[]    = $tempArr;
        }
        return json_encode($dataArray);
    }
    public function getAllProjects(){
        
        $sql = new Sql($this->getAdapter());
        $select = $sql->select()
            ->from('project_list')
            ->where(['is_delete'=>0,'comp_id'=>$this->loggedInUserDetails->comp_id]);
        $allProjects = $sql->prepareStatementForSqlObject($select)->execute();
        $dataArray = array();
        foreach($allProjects as $projects)
        {
           $tempArr         = [];
           $tempArr['Id']   = $projects['id'];
           $tempArr['Name'] = $projects['project_name'];
           $dataArray[]    = $tempArr;
        }
        return json_encode($dataArray);
    }
    public function getProjectDetail($projectId){
        
        $sql = new Sql($this->getAdapter());
        $select = $sql->select()
            ->from('project_list')
            ->columns(['id','project_name'])
            ->where(['id'=>$projectId,'is_delete'=>0,'comp_id'=>$this->loggedInUserDetails->comp_id]);
        $result = $sql->prepareStatementForSqlObject($select)->execute()->current();
        return $result;
    }
	
    public function getSourceDetail($sourceId){
        
        $sql = new Sql($this->getAdapter());
        $select = $sql->select()
                ->from('source_list')
                ->columns(['id','source_name'])
                ->where(['id'=>$sourceId,'is_delete'=>0,'comp_id'=>$this->loggedInUserDetails->comp_id]);
        $result = $sql->prepareStatementForSqlObject($select)->execute()->current();
        return $result;
    }
    public function getSelectedRoleRights($roleId){
        $sql = new Sql($this->getAdapter());
        $select = $sql->select()
            ->from(['cri' => 'company_rights'])
            ->columns(['roleRights' => new \Zend\Db\Sql\Expression('GROUP_CONCAT(right_name)')])
            ->join(['cror'=>'company_role_rights'],'cri.id=cror.right_id')
            ->where(['cror.role_id'=>$roleId,'cror.is_active'=>1,'cror.is_delete'=>0,'cror.comp_id'=>$this->loggedInUserDetails->comp_id])
            ->group('cror.role_id')
            ->order('cror.right_id');
        $result = $sql->prepareStatementForSqlObject($select)->execute()->current();
//        echo '<pre>';print_r($result);exit;
        return $result;
    }
    public function getmanagernames($userRoleId){
        
        $sql = new Sql($this->getAdapter());
        $select = $sql->select()
                ->from('company_roles')
                ->where(['id'=>$userRoleId,'is_active'=>1,'is_delete'=>0]);
        $roleDetail = $sql->prepareStatementForSqlObject($select)->execute()->current();
        $where = new Where();
        $sql = new Sql($this->getAdapter());
        $select = $sql->select()
                ->from(['ul' => 'userlist'])
                ->columns(['id','username'])
                ->join(['cr'=>'company_roles'], 'cr.id=ul.role_id','role_name');
        $where->lessThan('cr.seniority', $roleDetail['seniority']);
        $select->where($where);
        $select->where(['ul.is_active'=>1,'ul.is_delete'=>0,'ul.comp_id'=>$this->loggedInUserDetails->comp_id,'cr.is_active'=>1,'cr.is_delete'=>0])
                ->order('cr.seniority');
        $result = $sql->prepareStatementForSqlObject($select)->execute();
        $dataArray = array();
        if(count($result)){
            foreach($result as $managers)
            {
               $tempArr         = [];
               $tempArr['Id']   = $managers['id'];
               $tempArr['Name'] = $managers['username'].' ('.$managers['role_name'].')';
               $dataArray[]     = $tempArr;
            }
        }
        
//        echo '<pre>';print_r($dataArray);exit;
        
        return json_encode($dataArray);;
    }
    
    public function checkMobile($mobile) {
        
        $sql = new Sql($this->getAdapter());
        $where = new Where();
        $where->OR->equalTo('mobile', $mobile);
        $where->OR->equalTo('alt_no', $mobile);
        $where->OR->equalTo('other_no', $mobile);
        
        $select = $sql->select()->from('lead_list');
        $select->where($where);
        $select->where(['is_active'=>1,'is_delete'=>0,'comp_id'=>$this->loggedInUserDetails->comp_id]);
        $result = $sql->prepareStatementForSqlObject($select)->execute()->count();
//        echo $result;exit;
        if($result>0) return 1; else return 0;
    }
     
//    public function checkMobile($mobile) {
//        
//        $sql = new Sql($this->getAdapter());
//        $where = new Where();
//        $where->OR->equalTo('mobile', $mobile);
////        $where->OR->equalTo('alt_no', $mobile);
////        $where->OR->equalTo('other_no', $mobile);
//        
//        $select = $sql->select()->from('lead_list');
//        $select->where($where);
//        $select->where(['is_active'=>1,'is_delete'=>0,'comp_id'=>$this->loggedInUserDetails->comp_id]);
//        $result = $sql->prepareStatementForSqlObject($select)->execute()->count();
////        echo $result;exit;
//        if($result>0) return 1; else return 0;
//    }
    public function getAssignedLeads(){
        $teamUserArr = $this->getTeamUserArr();
        $tableGateway = new TableGateway('assigned_lead',$this->getAdapter());
        $leadList = $tableGateway->select(function($select) use ($teamUserArr){
            $onExpression = new Expression('uls.lead_id=ll.id AND uls.is_active = 1');
            $select->join(['ll'=>'lead_list'],'assigned_lead.lead_id=ll.id',['lead_id'=>'id','customer_name','mobile','created_by','punchDate'=>'punch_date'])
                    ->join(['pl'=>'project_list'],'pl.id=ll.project_interested',['project_name'])
                    ->join(['sl'=>'source_list'],'sl.id=ll.source_of_enquiry',['source_name'])
                    ->join(['uls'=>'updated_lead_status'],$onExpression,['next_meeting'=>'date_time_value','lead_status'=>'status_type','last_feedback','status_type','interested_type','client_type'],'left')
                    ->join(['usrAsg'=>'userlist'],'usrAsg.id=assigned_lead.assigned_to',['assignedTo'=>'username'])
                    ->join(['asby'=>'userlist'],'asby.id=assigned_lead.assigned_by',['assignedBy'=>'username'])
                    ->join(['usrOpn'=>'userlist'],'usrOpn.id=ll.created_by',['openBy'=>'username']);
            
            $select->where(['ll.is_delete'=>0,'ll.comp_id'=>$this->loggedInUserDetails->comp_id,'assigned_lead.is_active'=>1]);
            if($this->roleRightsArr['seniority']==4){
                $select->where(['assigned_lead.assigned_to'=>$this->loggedInUserDetails->id]);
            }elseif($this->roleRightsArr['seniority']==3){
                if(count($teamUserArr)){
                    $allUserStr = $teamUserArr[0]['teamUsrIds'].','.$this->loggedInUserDetails->id;
                    $allUserArr = explode(',',$allUserStr);
                    $select->where->in('assigned_lead.assigned_to',$allUserArr);
                }else{
                    $select->where(['assigned_lead.assigned_to'=>$this->loggedInUserDetails->id]);
                }    
            }
            $select->order('assigned_lead.assigned_date DESC');
        })->toArray();
        
//        echo '<pre>';print_r($leadList);exit;
        return $leadList;
    }
    
    
    public function getLeadUpdatesHistory($leadId) {
        $tableGateway = new TableGateway('updated_lead_status',$this->getAdapter());
        $projects = $tableGateway->select(function($select) use($leadId){
            $select->join(['usr'=>'userlist'],'usr.id=updated_lead_status.updated_by',['updated_by'=>'username']);
            $select->where(['updated_lead_status.lead_id'=>$leadId,'updated_lead_status.comp_id'=>$this->loggedInUserDetails->comp_id])
                ->order('updated_lead_status.updated_on desc');
        })->toArray();
        return $projects;
    }
    
    public function reassignview($leadId) {
        $table  = new TableGateway('assigned_lead',$this->getAdapter());
        $select = $table->select(function($select) use($leadId){
            $select->columns(['assigned_date','is_active']);
            $select->join(['usr'=>'userlist'],'usr.id=assigned_lead.assigned_to',['assigned_to'=>'username'])
                    ->join(['usr2'=>'userlist'],'usr2.id=assigned_lead.assigned_by',['assigned_by'=>'username']);
            $select->join(['ldlst'=>'lead_list'],'ldlst.id=assigned_lead.lead_id',['customer_name','customer_mobile'=>'mobile']);
            $select->where(['assigned_lead.lead_id'=>$leadId,'assigned_lead.comp_id'=>$this->loggedInUserDetails->comp_id])
                    ->order('assigned_lead.assigned_date desc');
            
        })->toArray();
//        echo '<pre>';print_r($select);exit;
        return $select;
    }
    
    public function checkProjectName($projectName){
        
        $tableGateway = new TableGateway('project_list',$this->getAdapter());
        $projects = $tableGateway->select(function($select) use($projectName){
            $select->where(['project_name'=>$projectName,'is_delete'=>0,'comp_id'=>$this->loggedInUserDetails->comp_id]);
        })->toArray();
        if(count($projects)) return 1; else return 0;
    }
    public function checkSourceName($sourceName){
        $tableGateway = new TableGateway('source_list',$this->getAdapter());
        $projects = $tableGateway->select(function($select) use($sourceName){
            $select->where(['source_name'=>$sourceName,'is_delete'=>0,'comp_id'=>$this->loggedInUserDetails->comp_id]);
        })->toArray();
        
//        echo '<pre>';print_r($projects);exit;
        
        if(count($projects)) return 1; else return 0;
    }
    
    public function checkUserEmail($useremail){
        $tableGateway = new TableGateway('userlist',$this->getAdapter());
        $projects = $tableGateway->select(function($select) use($useremail){
            $select->where(['useremail'=>$useremail,'is_delete'=>0,'comp_id'=>$this->loggedInUserDetails->comp_id]);
        })->toArray();
        if(count($projects)) return 1; else return 0;
    }
    public function checkUserPhone($userPhone){
        $tableGateway = new TableGateway('userlist',$this->getAdapter());
        $projects = $tableGateway->select(function($select) use($userPhone){
            $select->where(['mobile'=>$userPhone,'is_delete'=>0,'comp_id'=>$this->loggedInUserDetails->comp_id]);
        })->toArray();
        if(count($projects)) return 1; else return 0;
    }
}