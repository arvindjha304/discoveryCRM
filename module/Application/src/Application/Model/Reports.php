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


class Reports extends AbstractTableGateway implements ServiceLocatorAwareInterface {

	protected $serviceLocator;
	protected $tableGateway;
//	public  $dbAdapterConfig;
        private $roleRightsArr;
        private $loggedInUserDetails;
	
    public function getAdapter() {
        return $this->serviceLocator->get('Zend\Db\Adapter\Adapter');
    }
    public function __construct(AbstractTableGateway $tableGateway){
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
    
    public function getUserReport($start_date,$end_date) {
    $tableGateway = new TableGateway(['ul'=>'userlist'],$this->getAdapter());
        $userList = $tableGateway->select(function($select) use ($start_date,$end_date){
            $select->join(['cr'=>'company_roles'],'cr.id=ul.role_id','role_name')
                    ->join(['usr'=>'userlist'],'usr.id=ul.last_updated_by',['lastUpdatedBy'=>'username'])
                    ->join(['usr2'=>'userlist'],'ul.reporting_manager=usr2.id',['managerName'=>'username'],'left')
                    ->where(['ul.is_delete'=>0,'ul.comp_id'=>$this->loggedInUserDetails->comp_id]);
            if($start_date!='' && $end_date=='')
                $select->where->greaterThanOrEqualTo('ul.date_created',date('Y-m-d',  strtotime($start_date)));
            elseif($start_date=='' && $end_date!='')
                $select->where->lessThanOrEqualTo('ul.date_created',date('Y-m-d',  strtotime($end_date)));
            elseif($start_date!='' && $end_date!='')
                $select->where->between('ul.date_created',date('Y-m-d',  strtotime($start_date)),date('Y-m-d',  strtotime($end_date)));
        })->toArray();
//        echo '<pre>';print_r($userList);exit;
        $dataArray = array();
        if(count($userList))
        {    
            foreach($userList as $val1)
            {
                $dateArr = explode(' ',$val1['date_created']);
                $username		= ucwords($val1['username']);
                $useremail		=	$val1['useremail'];
                $mobile                 =	$val1['mobile'];
                $role_name              =	$val1['role_name'];
                $managerName            = ucwords($val1['managerName']);
                $date_joined            =	$dateArr[0];
                $status                 =	($val1['is_active']==1) ? 'Active' :	'Inactive';

                $dataArray[]    = array("id"=>$val1['id'],"data"=>array($username,$useremail,$mobile,$role_name,$managerName,$date_joined,$status));
            }
        }    
//        echo '<pre>';print_r($dataArray);exit;
        $json = json_encode($dataArray);
        exit('{rows:'.$json.'}');
    }
    
    public function getSourceWiseReport($start_date,$end_date) {
        
        
        
        //select sl.source_name,count(ll.id) as total_leads,count(al.id) as assigned_leads 
        //from source_list sl 
        //left join lead_list ll on sl.id=ll.source_of_enquiry and ll.is_active=1 and ll.is_delete=0 and ll.comp_id=1
        //left join assigned_lead al on al.lead_id=ll.id  and al.is_active=1 and al.comp_id=1
        //where sl.is_active=1 and sl.is_delete=0 and sl.comp_id=1
        //group by sl.id

  
        
    }
    
    public function getProjectWiseReport($start_date,$end_date) {
        
        
        
        //select pl.project_name ,count(ll.id) as total_leads,count(al.id) as assigned_leads 
        //from project_list pl 
        //left join lead_list ll on pl.id=ll.project_interested and ll.is_active=1 and ll.is_delete=0 and ll.comp_id=1
        //left join assigned_lead al on al.lead_id=ll.id  and al.is_active=1 and al.comp_id=1
        //where pl.is_active=1 and pl.is_delete=0 and pl.comp_id=1
        //group by pl.id
        
    }
    
    
    
}