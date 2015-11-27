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


 class Admin extends AbstractTableGateway implements ServiceLocatorAwareInterface {

	protected $serviceLocator;
	protected $tableGateway;
	public  $dbAdapterConfig;
    private $loggedInUserDetails;
	
	public function getAdapter() {
     return $this->serviceLocator->get('Zend\Db\Adapter\Adapter');
	}
     public function __construct(AbstractTableGateway $tableGateway)
     {
        $this->tableGateway = $tableGateway;
        $auth = new AuthenticationService();
        $this->loggedInUserDetails = $auth->getIdentity(); 
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
            $select->join(['cr'=>'company_roles'],'cr.id=userlist.role_id','role_name');
            $select->where(['userlist.is_delete'=>0,'userlist.comp_id'=>$this->loggedInUserDetails->comp_id]);
        })->toArray();
        
        
//        echo '<pre>';print_r($userList);exit;
        
        return $userList;
    }
    
    public function getLeadList($leadId=''){
        $tableGateway = new TableGateway('lead_list',$this->getAdapter());
        $leadList = $tableGateway->select(function($select) use ($leadId){
            if($leadId!=''){
                $select->where->equalTo('id',$leadId);
            }else{
                $select->join(['pl'=>'project_list'],'pl.id=lead_list.project_interested',['id','project_name'])
                ->join(['sl'=>'source_list'],'sl.id=lead_list.source_of_enquiry',['id','source_name']);
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
                ->where(['is_delete'=>0,'comp_id'=>$this->loggedInUserDetails->comp_id])
                ->order('seniority');
        $result = $sql->prepareStatementForSqlObject($select)->execute();
        return $result;
    }
	
    public function getAllSources(){
        
        $sql = new Sql($this->getAdapter());
        $select = $sql->select()
            ->from('source_list')
            ->where(['is_delete'=>0,'comp_id'=>$this->loggedInUserDetails->comp_id]);
        $result = $sql->prepareStatementForSqlObject($select)->execute();
        return $result;
    }
    public function getAllProjects(){
        
        $sql = new Sql($this->getAdapter());
        $select = $sql->select()
            ->from('project_list')
            ->where(['is_delete'=>0,'comp_id'=>$this->loggedInUserDetails->comp_id]);
        $result = $sql->prepareStatementForSqlObject($select)->execute();
        return $result;
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
//        echo '1111';exit;
        
        $sql = new Sql($this->getAdapter());
        $select = $sql->select()
                ->from('company_roles')
                ->where(['id'=>$userRoleId]);
        
        $roleDetail = $sql->prepareStatementForSqlObject($select)->execute()->current();
        
//        echo '<pre>';print_r($roleDetail);exit;
        
        
        $where = new Where();
        $sql = new Sql($this->getAdapter());
        $select = $sql->select()
                ->from(['ul' => 'userlist'])
                ->columns(['id','username'])
                ->join(['cr'=>'company_roles'], 'cr.id=ul.role_id','role_name');
        $where->lessThan('cr.seniority', $roleDetail['seniority']);
        $select->where($where);
        $select->where(['ul.is_active'=>1,'ul.is_delete'=>0,'ul.comp_id'=>$this->loggedInUserDetails->comp_id,'cr.is_active'=>1,'cr.is_delete'=>0,'cr.comp_id'=>$this->loggedInUserDetails->comp_id])
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
    
    
}