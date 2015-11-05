<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\TableGateway\TableGateway;
use Zend\Authentication\AuthenticationService;

class AdminController extends AbstractActionController
{
    private $loggedInUserDetails;
    public function onDispatch(\Zend\Mvc\MvcEvent $e) 
    {
        $auth = new AuthenticationService();
        if($auth->hasIdentity())
            $this->loggedInUserDetails = $auth->getIdentity(); 
        else
            return $this->redirect()->toRoute('application',array('controller'=>'index','action' => 'index'));
        
        return parent::onDispatch($e);
    }

	public function getbaseUrl(){
		$baseUrl = $this->getRequest()->getbaseUrl();
	}
    public function getAdapter(){
        return $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
    }
    public function create_salt(){
		return base64_encode(mcrypt_create_iv(8, MCRYPT_DEV_URANDOM));
	}
    public function getModel(){
        return  $this->getServiceLocator()->get('Application\Model\Admin');
    }
    public function dashboardAction()
    {
         $view = new ViewModel();
         $this->layout('layout/layoutadmin');
         // $indexModel = $this->getServiceLocator()->get('Application\Model\Index');
         // $view->setVariable('aboutUsData', $indexModel->getAboutUs());
         return $view;
    }
    public function addedituserAction()
    {
//      echo '<pre>';print_r($this->loggedInUserDetails);exit; 
        $view = new ViewModel();
        $this->layout('layout/layoutadmin');
         
        $userId = $this->params()->fromRoute('id1', '');
        if($userId!=''){
            $arrList = $this->getModel()->getUserList($userId);
            // echo '<pre>';print_r($arrList);exit;     
            if(count($arrList)){
                $password = str_replace($arrList[0]['salt_key'], '', $arrList[0]['password']);
                $view->setVariable('userPassword', base64_decode($password));
                $view->setVariable('userData', $arrList);
            }
        }
        if($this->getRequest()->isPost()){
           $pswdVal = $this->params()->fromPost('userPassword');
           $salt = $this->create_salt();
           $userId = $this->params()->fromPost('userId'); 
           $data = [
              'username'          => $this->params()->fromPost('fullName'),
              'useremail'         => $this->params()->fromPost('useremail'),
              'mobile'            => $this->params()->fromPost('userPhone'),
              'password'          => base64_encode(trim($pswdVal)).$salt,
              'salt_key'          => $salt,
              'role_id'           => $this->params()->fromPost('userRole'),
              'reporting_manager' => $this->params()->fromPost('reportingManagers'),
              'comp_id'        => $this->loggedInUserDetails->comp_id
           ];
           
           if($userId!=''){
                $data['last_updated_by']   = $this->loggedInUserDetails->id;
                $data['last_updated']     = date('Y-m-d H:i:s');
               $this->getModel()->updateanywhere('userlist', $data,['id'=>$userId]);
           }else{
                $data['is_active']          = 1;
                $data['is_delete']          = 0;
                $data['created_by']         = $this->loggedInUserDetails->id;
                $data['last_updated_by']    = $this->loggedInUserDetails->id;
                $data['last_updated']       = date('Y-m-d H:i:s');
                $data['date_created']       = date('Y-m-d H:i:s');
                $this->getModel()->insertanywhere('userlist', $data);
           }
            return $this->redirect()->toRoute('application',array('controller'=>'admin','action' => 'manageusers'));
        }
         return $view;
    }
    public function manageusersAction()
    {
        $view = new ViewModel();
        $this->layout('layout/layoutadmin');
    	$baseUrl = $this->getRequest()->getbaseUrl();
        if($this->getRequest()->isXmlHttpRequest()){
            $arrList = $this->getModel()->getUserList();
            $dataArray = array();
            foreach($arrList as $val1)
            {
//         	    echo '<pre>';print_r($val1);exit;
                $username		=	$val1['username'];
                $mobile         =	$val1['mobile'];
                $status			=	($val1['is_active']==1) ? 'Active' :	'Inactive';
                $action			=	($val1['is_active']==1) ? '<button onclick=inActiveStatus('.$val1["id"].')>Inactive</button>' :'<button onclick=activeStatus('.$val1["id"].')>Active</button>';
                $delete 		=	'<a href="'.$baseUrl.'/admin/addedituser/'.$val1['id'].'" ><button >Edit</button></a><button onclick=deleteRow('.$val1["id"].') >Delete</button>';
                $dataArray[]    = array("id"=>$val1['id'],"data"=>array(0,$username,$mobile,$status,$delete.$action));
            }
            $json = json_encode($dataArray);
            exit('{rows:'.$json.'}');
        }
        return $view;
    }
    
   
    public function updatestatusAction()
    {
    	$action 		= $this->params()->fromPost('action');
    	$id 			= $this->params()->fromPost('id');
    	$selectedIds 	= $this->params()->fromPost('selectedIds');
        $tableType 		= $this->params()->fromPost('tableType','');
        $tableName = '';
        if($tableType!=''){
            if($tableType == 'USERLISTING')  $tableName = 'userlist';
            elseif($tableType == 'ROLELISTING')  $tableName = 'company_roles';
            elseif($tableType == 'PROJECTLISTING')  $tableName = 'project_list';
            elseif($tableType == 'SOURCELISTING')  $tableName = 'source_list';
            
            if($tableName!=''){ 
                if(isset($selectedIds)){
                    $idArr = explode(',',$selectedIds);
                    foreach($idArr as $id)
                        $this->statusUpdate($tableName,$action,$id);
                }else{
                    $this->statusUpdate($tableName,$action,$id);
                }
            }
        }
    	exit('1');
    }
    
    
    public function statusUpdate($table,$action,$id){
    	$data = array(
    		'is_active'	=> 	($action=='active') ? 1 : 0,
    	);
    	$where = array(
    		'id'	=> 	$id,
    	); 
    	if($action=='delete'){
    		$this->getModel()->deleteanywhere($table,$where);
    	}else{
    		$this->getModel()->updateanywhere($table,$data,$where);
    	}
        return 1;
    }
    
    public function addeditroleAction()
    {
        $view = new ViewModel();
        $this->layout('layout/layoutadmin');
        $roleId = $this->params()->fromRoute('id1','');
        $roleRightsArr = [];
        if($roleId!=''){
           $roleArr = $this->getModel()->getRoleDetail($roleId);
        //   echo '<pre>';print_r($roleArr);exit;
           $roleRightsArr = $this->getModel()->getRoleRights($roleId);
           $view->setVariable('roleArr', json_encode($roleArr));
           $view->setVariable('roleRightsArr', json_encode($roleRightsArr));
        }
        if($this->getRequest()->isPost()){
            $roleRightsFormArr  = $this->params()->fromPost('roleRights');
            $roleName           = $this->params()->fromPost('roleName');
            $this->manageAddEditRoles($roleId,$roleRightsFormArr,$roleName,$roleRightsArr);
            return $this->redirect()->toRoute('application',array('controller'=>'admin','action' => 'manageroles'));
        }
        return $view;
    }
    
    public function manageAddEditRoles($roleId,$roleRightsFormArr,$roleName,$roleRightsArr) {
        
        $data = array(
            'role_name'         => $roleName
        );
        if($roleId==''){
            $data['is_active']         = 1;
            $data['is_delete']         = 0;
            $data['creation_date']     = date("Y-m-d H:i:s");
            $data['last_updated']      = date("Y-m-d H:i:s");
            $data['comp_id']           = $this->loggedInUserDetails->comp_id;
            $data['created_by']        = $this->loggedInUserDetails->id;
            $data['last_updated_by']   = $this->loggedInUserDetails->id;
            $roleId = $this->getModel()->lastInsertId('company_roles',$data);
        }else{
            $data['last_updated']      = date("Y-m-d H:i:s");
            $data['last_updated_by']   = $this->loggedInUserDetails->id;
            $this->getModel()->updateanywhere('company_roles',$data,['id'=>$roleId]);
        }

        $allRoleRightsArr = $this->getModel()->getAllRoleRights();
        if(count($allRoleRightsArr)){
            foreach($allRoleRightsArr as $rightId){
                $data = array(
                    'role_id'           => $roleId,
                    'right_id'          => $rightId
                );
                if(count($roleRightsArr)){
                    $data['is_active']          = (in_array($rightId, $roleRightsFormArr)) ? 1 : 0;
                    $data['last_updated']       = date("Y-m-d H:i:s");
                    $data['last_updated_by']    = $this->loggedInUserDetails->id;
                    $whereArr = ['role_id'=>$roleId,'right_id'=>$rightId];
                    $this->getModel()->updateanywhere('company_role_rights',$data,$whereArr);
                }else{
                    $data['is_active']          = (in_array($rightId, $roleRightsFormArr)) ? 1 : 0;
                    $data['comp_id']            = $this->loggedInUserDetails->comp_id;
                    $data['is_delete']          = 0;
                    $data['created_by']         = $this->loggedInUserDetails->id;
                    $data['last_updated_by']    = $this->loggedInUserDetails->id;
                    $data['creation_date']      = date("Y-m-d H:i:s");
                    $data['last_updated']       = date("Y-m-d H:i:s");
                    $this->getModel()->lastInsertId('company_role_rights',$data);
                }   
            }
        }
        return 1;
    }
    
    public function managerolesAction()
    {
        $view = new ViewModel();
        $this->layout('layout/layoutadmin');
    	$baseUrl = $this->getRequest()->getbaseUrl();
        $this->getModel()->getSelectedRoleRights(1);
        
        if($this->getRequest()->isXmlHttpRequest()){
            $allRoles = $this->getModel()->getAllRoles();
            $dataArray = array();
            foreach($allRoles as $roles)
            {
//         	    echo '<pre>';print_r($roles);
                $role_name		=	$roles['role_name'];
                $getRoleRights = $this->getModel()->getSelectedRoleRights($roles['id']);
                $roleRights		=	$getRoleRights['roleRights'];
                $status			=	($roles['is_active']==1) ? 'Active' :	'Inactive';
                $action			=	($roles['is_active']==1) ? '<button onclick=inActiveStatus('.$roles["id"].')>Inactive</button>' :'<button onclick=activeStatus('.$roles["id"].')>Active</button>';
                $delete 		=	'<a href="'.$baseUrl.'/admin/addeditrole/'.$roles['id'].'" ><button >Edit</button></a><button onclick=deleteRow('.$roles["id"].') >Delete</button>';
                $dataArray[]    = array("id"=>$roles['id'],"data"=>array(0,$role_name,$roleRights,$status,$delete.$action));
            }
//          echo '<pre>';print_r($dataArray);exit;
            $json = json_encode($dataArray);
            exit('{rows:'.$json.'}');
        }
        return $view;
    }
    
    
    public function projectsAction()
    {
        $view = new ViewModel();
        $this->layout('layout/layoutadmin');
    	$baseUrl = $this->getRequest()->getbaseUrl();
        $projectId = $this->params()->fromRoute('id1','');
        if($projectId!=''){
            $projectDetail = $this->getModel()->getProjectDetail($projectId);
            $view->setVariable('projectDetail', json_encode($projectDetail));
        }
        
        if($this->getRequest()->isPost()){
//             echo '<pre>';print_r($this->params()->fromPost());exit;
            $projectId = $this->params()->fromPost('projectId');
            $ProjectName = $this->params()->fromPost('ProjectName');
            $data = array(
                'project_name'         => $ProjectName
            );
            if($projectId==''){
                $data['is_active']         = 1;
                $data['is_delete']         = 0;
                $data['creation_date']     = date("Y-m-d H:i:s");
                $data['last_updated']      = date("Y-m-d H:i:s");
                $data['comp_id']           = $this->loggedInUserDetails->comp_id;
                $data['created_by']        = $this->loggedInUserDetails->id;
                $data['last_updated_by']   = $this->loggedInUserDetails->id;
                $projectId = $this->getModel()->lastInsertId('project_list',$data);
            }else{
//                 echo $projectId;exit;
                $data['last_updated']      = date("Y-m-d H:i:s");
                $data['last_updated_by']   = $this->loggedInUserDetails->id;
                $this->getModel()->updateanywhere('project_list',$data,['id'=>$projectId]);
            }
            return $this->redirect()->toRoute('application',array('controller'=>'admin','action' => 'projects'));
        }
        
        if($this->getRequest()->isXmlHttpRequest()){
            //$arrList = $this->getModel()->getUserList();
            $table = new TableGateway('project_list',$this->getAdapter());
            $select = $table->select(['is_delete'=>0,'comp_id'=>$this->loggedInUserDetails->comp_id])->toArray();
//            echo '<pre>';print_r($select);exit;
            $dataArray = array();
            foreach($select as $val1)
            {
//         	    echo '<pre>';print_r($val1);exit;
                $project_name	=	$val1['project_name'];
                $status			=	($val1['is_active']==1) ? 'Active' : 'Inactive';
                $action			=	($val1['is_active']==1) ? '<button onclick=inActiveStatus('.$val1["id"].')>Inactive</button>' :'<button onclick=activeStatus('.$val1["id"].')>Active</button>';
                $delete 		=	'<a href="'.$baseUrl.'/admin/projects/'.$val1['id'].'" ><button >Edit</button></a><button onclick=deleteRow('.$val1["id"].') >Delete</button>';
                $dataArray[]    = array("id"=>$val1['id'],"data"=>array(0,$project_name,$status,$delete.$action));
            }
            $json = json_encode($dataArray);
            exit('{rows:'.$json.'}');
        }
        return $view;
    }
    
    
    public function sourcesAction()
    {
        $view = new ViewModel();
        $this->layout('layout/layoutadmin');
    	$baseUrl = $this->getRequest()->getbaseUrl();
        $sourceId = $this->params()->fromRoute('id1','');
        if($sourceId!=''){
            $sourceDetail = $this->getModel()->getSourceDetail($sourceId);
            $view->setVariable('sourceDetail', json_encode($sourceDetail));
        }
        
        if($this->getRequest()->isPost()){
//          echo '<pre>';print_r($this->params()->fromPost());exit;
            $sourceId = $this->params()->fromPost('sourceId');
            $SourceName = $this->params()->fromPost('SourceName');
            $data = array(
                'source_name'         => $SourceName
            );
            if($sourceId==''){
                $data['is_active']         = 1;
                $data['is_delete']         = 0;
                $data['creation_date']     = date("Y-m-d H:i:s");
                $data['last_updated']      = date("Y-m-d H:i:s");
                $data['comp_id']           = $this->loggedInUserDetails->comp_id;
                $data['created_by']        = $this->loggedInUserDetails->id;
                $data['last_updated_by']   = $this->loggedInUserDetails->id;
                $sourceId = $this->getModel()->lastInsertId('source_list',$data);
            }else{
//                 echo $projectId;exit;
                $data['last_updated']      = date("Y-m-d H:i:s");
                $data['last_updated_by']   = $this->loggedInUserDetails->id;
                $this->getModel()->updateanywhere('source_list',$data,['id'=>$sourceId]);
            }
            return $this->redirect()->toRoute('application',array('controller'=>'admin','action' => 'sources'));
        }
        
        if($this->getRequest()->isXmlHttpRequest()){
            //$arrList = $this->getModel()->getUserList();
            $table = new TableGateway('source_list',$this->getAdapter());
            $select = $table->select(['is_delete'=>0,'comp_id'=>$this->loggedInUserDetails->comp_id])->toArray();
//            echo '<pre>';print_r($select);exit;
            $dataArray = array();
            foreach($select as $val1)
            {
//         	    echo '<pre>';print_r($val1);exit;
                $source_name	=	$val1['source_name'];
                $status			=	($val1['is_active']==1) ? 'Active' : 'Inactive';
                $action			=	($val1['is_active']==1) ? '<button onclick=inActiveStatus('.$val1["id"].')>Inactive</button>' :'<button onclick=activeStatus('.$val1["id"].')>Active</button>';
                $delete 		=	'<a href="'.$baseUrl.'/admin/sources/'.$val1['id'].'" ><button >Edit</button></a><button onclick=deleteRow('.$val1["id"].') >Delete</button>';
                $dataArray[]    = array("id"=>$val1['id'],"data"=>array(0,$source_name,$status,$delete.$action));
            }
            $json = json_encode($dataArray);
            exit('{rows:'.$json.'}');
        }
        return $view;
    }
    
}
