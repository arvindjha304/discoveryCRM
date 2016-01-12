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
use Zend\Session\Container;

class AdminController extends AbstractActionController
{
    private $loggedInUserDetails;
    private $roleRightsArr;
    public function onDispatch(\Zend\Mvc\MvcEvent $e) 
    {
        $auth = new AuthenticationService();
        $roleInSession = new Container('roleInSession');
        if($auth->hasIdentity()){
            $this->loggedInUserDetails  = $auth->getIdentity();
            $this->roleRightsArr        = $roleInSession->roleRightsArr;
        }else
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
        $leadByExecutive = $this->getModel()->getLeadByExecutive();
        $view->setVariable('leadByExecutive', $leadByExecutive);
        return $view;
    }
    
    public function leadbysourceAction() {
        $leadBySource = $this->getModel()->getLeadBySource();
        exit(json_encode($leadBySource));
    }
    public function leadbystatusAction() {
        $leadByStatus = $this->getModel()->getLeadByStatus();
        exit(json_encode($leadByStatus));
    }
    
    public function leadbydaysAction() {
        $leadByStatus = $this->getModel()->getLeadByDays();
        exit(json_encode($leadByStatus));
    }
    
    public function userdashboardAction()
    {
        $view = new ViewModel();
        $this->layout('layout/layoutadmin');

//        $roleInSession = new Container('roleInSession');
//        $roleRightsArr  = $roleInSession->roleRightsArr; 
        
//         echo '<pre>';print_r($this->roleRightsArr);exit; 
        
        return $view;
    }
    public function checkuseremailAction(){
         $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        if(count($request)){
            
//            echo '<pre>';print_r($request);exit; 
            
            
            $useremail  = $request->useremail;
            if($useremail!='')
              echo $this->getModel()->checkUserEmail($useremail);
        }
        exit;
    }
    public function checkuserphoneAction(){
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        if(count($request)){
            $userPhone  = $request->userPhone;
            if($userPhone!='')
                echo $this->getModel()->checkUserPhone($userPhone);
        }
        exit;
    }
    public function addedituserAction()
    {
        $view = new ViewModel();
        $this->layout('layout/layoutadmin');
        $this->adminpages();
        $allRoles = $this->getModel()->getAllRolesJson();
        $view->setVariable('allRoles', $allRoles);
        $userId = $this->params()->fromRoute('id1', '');
        $userId = base64_decode($userId);
        if($userId!=''){
            $arrList = $this->getModel()->getUserList($userId);
//             echo '<pre>';print_r($arrList);exit;     
            if(count($arrList)){
                $password = str_replace($arrList[0]['salt_key'], '', $arrList[0]['password']);
                $view->setVariable('userPassword', base64_decode($password));
                $view->setVariable('userData', $arrList);
                $allManagers = $this->getModel()->getmanagernames($arrList[0]['role_id']);
                $view->setVariable('allManagers', $allManagers);
            }
        }
        if($this->getRequest()->isPost()){
           $pswdVal = $this->params()->fromPost('userPassword');
           $salt = $this->create_salt();
           $userId = trim($this->params()->fromPost('userId')); 
           $userRole = $this->params()->fromPost('userRole');
           $data = [
              'username'          => trim($this->params()->fromPost('fullName')),
              'useremail'         => trim($this->params()->fromPost('useremail')),
              'mobile'            => trim($this->params()->fromPost('userPhone')),
              'password'          => base64_encode(trim($pswdVal)).$salt,
              'salt_key'          => $salt,
              'role_id'           => $userRole,
              'reporting_manager' => ($userRole!=1) ? $this->params()->fromPost('reportingManagers'): 0,
              'comp_id'           => $this->loggedInUserDetails->comp_id
           ];
           
           if($userId!=''){
                $data['last_updated_by']    = $this->loggedInUserDetails->id;
                $data['last_updated']       = date('Y-m-d H:i:s');
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
    
    public function getmanagernamesAction() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
//        echo '<pre>';print_r($request);exit;
        $userRoleId = $request->userRoleId; 
        $allManagers = $this->getModel()->getmanagernames($userRoleId);
        exit($allManagers);
    }
    
    
    public function manageusersAction()
    {
        $view = new ViewModel();
        $this->layout('layout/layoutadmin');
        $this->adminpages();
    	$baseUrl = $this->getRequest()->getbaseUrl();
        if($this->getRequest()->isXmlHttpRequest()){
            $arrList = $this->getModel()->getUserList();
            
            
            
            $dataArray = array();
            foreach($arrList as $val1)
            {
         	$dateArr = explode(' ',$val1['last_updated']);
                $disableEdit            =       (in_array(4, $this->roleRightsArr['rightsArr'])) ? '' : 'disabled';
                $username		=	$val1['username'];
                $role_name              =	$val1['role_name'];
                $managerName            =	$val1['managerName'];
                $mobile                 =	$val1['mobile'];
                $last_updated           =	$dateArr[0].' | '.substr($dateArr[1], 0, 5);
                $lastUpdatedBy          =	$val1['lastUpdatedBy'];
                $status			=	($val1['is_active']==1) ? 'Active' :	'Inactive';
                $action			=	($val1['is_active']==1) ? '<button title="Inactive" data-toggle="tooltip"  data-placement="right" onclick=inActiveStatus('.$val1["id"].') class="btn btn-primary" type="button"><i class="fa fa-ban"></i></button>' :'<button  title="Active" data-toggle="tooltip"  data-placement="right" onclick=activeStatus('.$val1["id"].') class="btn btn-primary" type="button"><i class="fa fa-check-square-o"></i></button>';
                $delete 		=	'<a href="'.$baseUrl.'/admin/addedituser/'.base64_encode($val1['id']).'" ><button title="Edit" data-toggle="tooltip"  data-placement="left" class="btn btn-primary" type="button"><i class="fa fa-pencil-square-o"></i></button></a> <button '.$disableEdit.' title="Delete" data-toggle="tooltip"  data-placement="right" onclick=deleteRow('.$val1["id"].') class="btn btn-primary" type="button"><i class="fa fa-trash-o"></i></button>';
                $dataArray[]    = array("id"=>$val1['id'],"data"=>array(0,$username,$role_name,$managerName,$mobile,$lastUpdatedBy,$last_updated,$status,$delete.' '.$action));
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
            elseif($tableType == 'LEADLISTING')  $tableName = 'lead_list';
            
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
        $this->adminpages();
        $roleId = $this->params()->fromRoute('id1','');
        $roleId = base64_decode($roleId);
        $roleRightsArr = [];
        if($roleId!=''){
           $roleArr = $this->getModel()->getRoleDetail($roleId);
        // echo '<pre>';print_r($roleArr);exit;
           $roleRightsArr = $this->getModel()->getRoleRights($roleId);
           $view->setVariable('roleArr', json_encode($roleArr));
           $view->setVariable('roleRightsArr', json_encode($roleRightsArr));
        }
        if($this->getRequest()->isPost()){
            $formData = $this->params()->fromPost();
//            $roleRightsFormArr  = $this->params()->fromPost('roleRights');
//            $roleName           = $this->params()->fromPost('roleName');
//            $this->manageAddEditRoles($roleId,$roleRightsFormArr,$roleName,$roleRightsArr);
            $this->manageAddEditRoles($formData,$roleRightsArr);
            return $this->redirect()->toRoute('application',array('controller'=>'admin','action' => 'manageroles'));
        }
        return $view;
    }
    
    public function manageAddEditRoles($formData,$roleRightsArr) {
        
//        echo '<pre>';print_r($formData);exit;
        
        $roleId             =   (isset($formData['roleId']) ?  $formData['roleId'] : '');
        $roleRightsFormArr  =   $formData['roleRights'];
        $roleName           =   $formData['roleName'];
       // $seniority          =   $formData['seniority'];
        $data = array(
            'role_name'         =>  $roleName,
//            'seniority'         =>  $seniority
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
        $this->adminpages();
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
                $delete 		=	($this->roleRightsArr['seniority'] == 1) ? '<a href="'.$baseUrl.'/admin/addeditrole/'.base64_encode($roles['id']).'" ><button title="Edit" data-toggle="tooltip"  data-placement="right" class="btn btn-primary" type="button"><i class="fa fa-pencil-square-o"></i></button></a>': '<button title="Edit" data-toggle="tooltip"  data-placement="right" class="btn btn-primary" disabled type="button"><i class="fa fa-pencil-square-o"></i></button>';
                $dataArray[]    = array("id"=>$roles['id'],"data"=>array($role_name,$roleRights,$delete));
            }
//          echo '<pre>';print_r($dataArray);exit;
            $json = json_encode($dataArray);
            exit('{rows:'.$json.'}');
        }
        return $view;
    }
    
    public function updateroleseniorityAction()
    {
        if($this->getRequest()->isXmlHttpRequest()){
    		$admin = $this->getServiceLocator()->get('Application\Model\Admin');
    		$id 	= $this->params()->fromPost('id');
    		$value 	= $this->params()->fromPost('value');
			$admin->updateanywhere('company_roles', array('seniority'=>$value), array('id'=>$id));
    		exit(1);
    	}
    }
    
    public function projectsAction()
    {
        $view = new ViewModel();
        $this->layout('layout/layoutadmin');
        $this->adminpages();
    	$baseUrl = $this->getRequest()->getbaseUrl();
        $projectId = $this->params()->fromRoute('id1','');
        $projectId = base64_decode($projectId);
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
            $projectList = $table->select(function($select) {
                $select->join(['ul'=>'userlist'],'ul.id=project_list.last_updated_by',['lastUpdatedBy'=>'username'])
                        ->where(['project_list.is_delete'=>0,'project_list.comp_id'=>$this->loggedInUserDetails->comp_id]);
                
                })->toArray();
            
//            $projectList = $table->select(['is_delete'=>0,'comp_id'=>$this->loggedInUserDetails->comp_id])->toArray();
            
//            echo '<pre>';print_r($projectList);exit;
            $dataArray = array();
            foreach($projectList as $val1)
            {
         	$disableEdit            =       (in_array(4, $this->roleRightsArr['rightsArr'])) ? '' : 'disabled';
                $project_name           =	$val1['project_name'];
                $lastUpdatedBy          =	$val1['lastUpdatedBy'];
                $dateArr = explode(' ',$val1['last_updated']);
                $last_updated_time      =       $dateArr[0].' | '.substr($dateArr[1], 0, 5);
                
                //$action			=	($val1['is_active']==1) ? '<button  onclick=inActiveStatus('.$val1["id"].') class="btn btn-primary" type="button"><i class="fa fa-ban"></i></button>' :'<button  onclick=activeStatus('.$val1["id"].') class="btn btn-primary" type="button"><i class="fa fa-check-square-o"></i></button>';
                $delete 		=	'<a href="'.$baseUrl.'/admin/projects/'.base64_encode($val1['id']).'" ><button  class="btn btn-primary" title="Edit" data-toggle="tooltip"  data-placement="left" type="button"><i class="fa fa-pencil-square-o"></i></button></a> <button title="Delete" data-toggle="tooltip"  data-placement="right" '.$disableEdit.'  onclick=deleteRow('.$val1["id"].') class="btn btn-primary" type="button"><i class="fa fa-trash-o"></i></button>';
                $dataArray[]    = array("id"=>$val1['id'],"data"=>array(0,$project_name,$lastUpdatedBy,$last_updated_time,$delete));
            }
            $json = json_encode($dataArray);
            exit('{rows:'.$json.'}');
        }
        return $view;
    }
    
    public function checkprojectnameAction(){
         $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $projectName  = $request->projectName;
        if($projectName!='')
            echo $this->getModel()->checkProjectName($projectName);
        exit;
    }
    
    public function sourcesAction()
    {
        $view = new ViewModel();
        $this->layout('layout/layoutadmin');
        $this->adminpages();
    	$baseUrl = $this->getRequest()->getbaseUrl();
        $sourceId = $this->params()->fromRoute('id1','');
        $sourceId = base64_decode($sourceId);
        if($sourceId!=''){
            $sourceDetail = $this->getModel()->getSourceDetail($sourceId);
            $view->setVariable('sourceDetail', json_encode($sourceDetail));
        }
        
        if($this->getRequest()->isPost()){
//          echo '<pre>';print_r($this->params()->fromPost());exit;
            $sourceId   = $this->params()->fromPost('sourceId');
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
//            $select = $table->select(['is_delete'=>0,'comp_id'=>$this->loggedInUserDetails->comp_id])->toArray();

            
            $sourcetList = $table->select(function($select) {
                $select->join(['ul'=>'userlist'],'ul.id=source_list.last_updated_by',['lastUpdatedBy'=>'username'])
                        ->where(['source_list.is_delete'=>0,'source_list.comp_id'=>$this->loggedInUserDetails->comp_id]);
            })->toArray();
//            echo '<pre>';print_r($sourcetList);exit;
            $dataArray = array();
            foreach($sourcetList as $val1)
            {
         	$disableEdit    =       (in_array(4, $this->roleRightsArr['rightsArr'])) ? '' : 'disabled';
                $source_name	=	$val1['source_name'];
                $lastUpdatedBy  =	$val1['lastUpdatedBy'];
                $dateArr = explode(' ',$val1['last_updated']);
                $last_updated_time      =   $dateArr[0].' | '.substr($dateArr[1], 0, 5);
                //$action		=	($val1['is_active']==1) ? '<button  onclick=inActiveStatus('.$val1["id"].') class="btn btn-primary" type="button"><i class="fa fa-ban"></i></button>' :'<button  onclick=activeStatus('.$val1["id"].') class="btn btn-primary" type="button"><i class="fa fa-check-square-o"></i></button>';
                $delete 	=	'<a href="'.$baseUrl.'/admin/sources/'.base64_encode($val1['id']).'" ><button title="Edit" data-toggle="tooltip"  data-placement="left" class="btn btn-primary" type="button"><i class="fa fa-pencil-square-o"></i></button></a> <button '.$disableEdit.'  onclick=deleteRow('.$val1["id"].') class="btn btn-primary" type="button" title="Delete" data-toggle="tooltip"  data-placement="right" ><i class="fa fa-trash-o"></i></button>';
                $dataArray[]    = array("id"=>$val1['id'],"data"=>array(0,$source_name,$lastUpdatedBy,$last_updated_time,$delete));
            }
            $json = json_encode($dataArray);
            exit('{rows:'.$json.'}');
        }
        return $view;
    }
    
    public function checksourcenameAction(){
         $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $sourceName  = $request->sourceName;
        if($sourceName!='')
            echo $this->getModel()->checkSourceName($sourceName);
        exit;
    }
    
    public function addeditleadsAction()
    {
        if(in_array(1, $this->roleRightsArr['rightsArr'])){
            $view = new ViewModel();
            $this->layout('layout/layoutadmin');

            $allSources = $this->getModel()->getAllSources();
            $view->setVariable('allSources',$allSources);

            $allProjects = $this->getModel()->getAllProjects();
            $view->setVariable('allProjects',$allProjects);

            $leadId = $this->params()->fromRoute('id1', '');
            $leadId = base64_decode($leadId);
            if($leadId!=''){
                $arrList = $this->getModel()->getLeadList($leadId);
    //             echo '<pre>';print_r($arrList);exit;     
                if(count($arrList)){
                    $view->setVariable('formData', $arrList);
                }
            }
            if($this->getRequest()->isPost()){
//                echo '<pre>';print_r($this->params()->fromPost());exit;   
                
                $formData = $this->params()->fromPost();
                
                
                
               $leadId = $formData['leadId']; 
               $data = [
                  'customer_name'       => $formData['CustomerName'],
                  'mobile'              => base64_encode($formData['MobileNumber']),
                  'alt_no'              => ($formData['AlternateName']!='')? base64_encode($formData['AlternateName']) : '',
                  'other_no'            => ($formData['OtherName']!='')? base64_encode($formData['OtherName']) : '',
                  'email'               => $formData['EmailAddress'],
                  'address'             => $formData['Address'],
                  'source_of_enquiry'   => $formData['SourceOfEnquiry'],
                  'budget'              => $formData['Budget'],
                  'project_interested'  => $formData['ProjectInterested'],
                  'requirement'         => $formData['Requirement']
               ];

               if($leadId!=''){
                    $data['last_updated_by']   = $this->loggedInUserDetails->id;
                    $data['last_updated']     = date('Y-m-d H:i:s');

                   $this->getModel()->updateanywhere('lead_list', $data,['id'=>$leadId]);
               }else{
                    $data['comp_id']            = $this->loggedInUserDetails->comp_id;
                    $data['is_active']          = 1;
                    $data['is_delete']          = 0;
                    $data['created_by']         = $this->loggedInUserDetails->id;
                    $data['last_updated_by']    = $this->loggedInUserDetails->id;
                    $data['last_updated']       = date('Y-m-d H:i:s');
                    $data['punch_date']         = date('Y-m-d H:i:s');
                    $data['date_created']       = date('Y-m-d H:i:s');
                    $this->getModel()->insertanywhere('lead_list', $data);
               }
                return $this->redirect()->toRoute('application',array('controller'=>'admin','action' => 'manageleads'));
            }
             return $view;
        }else{
            $this->redirect()->toRoute('application',array('controller'=>'index','action' => 'logout'));
        }
    }
    
    public function manageleadsAction(){
      
        $view = new ViewModel();
        $this->layout('layout/layoutadmin');
        $allRoles = $this->getModel()->getAllRolesJson();
        $view->setVariable('allRoles', $allRoles);
    	$baseUrl = $this->getRequest()->getbaseUrl();
        if($this->getRequest()->isXmlHttpRequest()){
           $arrList = $this->getModel()->getLeadList();
//           $table = new TableGateway('source_list',$this->getAdapter());
//           $source_list = $table->select(['is_delete'=>0,'comp_id'=>$this->loggedInUserDetails->comp_id])->toArray();
            $dataArray = array();
            foreach($arrList as $val1)
            {
                $disableEdit            =   (in_array(4, $this->roleRightsArr['rightsArr'])) ? '' : 'disabled';
                $customer_name          =   $val1['customer_name'];
                $mobile                 =   base64_decode($val1['mobile']);
                $source_of_enquiry      =   $val1['source_name'];
                $project_interested     =   $val1['project_name'];
                $requirement            =   '<a href="#" data-toggle="tooltip" data-placement="right" title="Requirement - '.$val1['requirement'].'">'.  substr($val1['requirement'], 0, 15).'</a>';
                $dateArr = explode(' ',$val1['punch_date']);
                $punch_date             =   $dateArr[0];
                $open_by                =   $val1['open_by'];
                $edit                   =   (in_array(3, $this->roleRightsArr['rightsArr'])) ? '<a href="'.$baseUrl.'/admin/addeditleads/'.base64_encode($val1['id']).'" ><button title="Edit" data-toggle="tooltip"  data-placement="left" class="btn btn-primary" type="button"><i class="fa fa-pencil-square-o"></i></button></a>' : '<button title="Edit" data-toggle="tooltip"  data-placement="left" disabled="disabled" class="btn btn-primary" type="button"><i class="fa fa-pencil-square-o"></i></button>';
                $delete                 =  '<button title="Delete" data-toggle="tooltip"  data-placement="right" '.$disableEdit.'  onclick=deleteRow('.$val1["id"].') class="btn btn-primary" type="button"><i class="fa fa-trash-o"></i></button>';
                
                $dataArray[]            =   array("id"=>$val1['id'],"data"=>array(0,$customer_name,$mobile,$source_of_enquiry,$project_interested,$requirement,$punch_date,$open_by,$edit.' '.$delete));
            }
            
//    echo '<pre>';print_r($dataArray);exit;        
            
            $json = json_encode($dataArray);
            exit('{rows:'.$json.'}');
        }
        return $view;  
    }
    
    public function getusersbyroleAction(){
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $role_id = $request->role_id; 
        $userList = $this->getModel()->getUsersByRoleJson($role_id);
        exit($userList);
    }
    
    public function updateleadAction(){
        $view = new ViewModel();
        $this->layout('layout/layoutadmin');
        
        $allSources = $this->getModel()->getAllSources();
        $view->setVariable('allSources',$allSources);
        
        $allProjects = $this->getModel()->getAllProjects();
        $view->setVariable('allProjects',$allProjects);
        
        $leadId = $this->params()->fromRoute('id1', '');
        $leadId = base64_decode($leadId);
        $leadUpdatesCurrent = '';
        if($leadId!=''){
            $arrList = $this->getModel()->getLeadList($leadId);
//             echo '<pre>';print_r($arrList);exit;     
            if(count($arrList)){
                $view->setVariable('formData', $arrList);
            }
            $leadUpdatesHistory = $this->getModel()->getLeadUpdatesHistory($leadId);
//             echo '<pre>';print_r($leadUpdatesHistory);exit;     
            $view->setVariable('leadUpdatesHistory', $leadUpdatesHistory);
            
            if(count($leadUpdatesHistory)) {
                $leadUpdatesCurrent = $leadUpdatesHistory[0];
            }
            
        }
         $view->setVariable('leadUpdatesCurrent', (count($leadUpdatesCurrent)) ? json_encode($leadUpdatesCurrent) : $leadUpdatesCurrent);
        return $view;
    }
    
    public function updateleadstatusAction(){   
        
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
//         echo '<pre>';print_r($request);exit;  
        $leadId = $request->leadId; 
        $data = [
           'customer_name'       => $request->CustomerName,
           'mobile'              => base64_encode($request->MobileNumber),
           'alt_no'              => base64_encode($request->AlternateName),
           'other_no'            => base64_encode($request->OtherName),
           'email'               => $request->EmailAddress,
           'address'             => $request->Address,
           'source_of_enquiry'   => $request->SourceOfEnquiry,
           'budget'              => $request->Budget,
           'project_interested'  => $request->ProjectInterested,
           'requirement'         => $request->Requirement,
//           'punch_date'          => $request->PunchDate,
        ];   
        $data['last_updated_by']   = $this->loggedInUserDetails->id;
        $data['last_updated']     = date('Y-m-d H:i:s');
//        echo '<pre>';print_r($data);
        $this->getModel()->updateanywhere('lead_list', $data,['id'=>$leadId]);
        exit('Lead Updated');
    }
    
    
    public function submitleadstatusAction(){
        
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
//         echo '<pre>';print_r($request);exit;  
            $data = [
                'lead_id'            => $request->leadId,
                'client_type'        => $request->clientType,
                'status_type'        => $request->statusType,
                'interested_type'    => ($request->statusType==1) ? $request->interestedType : 0,
                'bogus_lead'         => ($request->statusType==2) ? $request->bogusLead : 0,
                'date_time_value'    => ($request->statusType==1) ? $request->dateTimeValue.':00' : '',
                'lead_rating'        => ($request->statusType==1) ? $request->rateThisLead : 0,
                'last_feedback'      => $request->description,
                'updated_by'         => $this->loggedInUserDetails->id,
                'updated_on'         => date('Y-m-d H:i:s'),
                'comp_id'            => $this->loggedInUserDetails->comp_id
            ];  
        $leadId   = $request->leadId;
        $leadUpdatesHistory = $this->getModel()->getLeadUpdatesHistory($leadId); 
        
//        echo '<pre>';print_r($leadUpdatesHistory);exit;
        if(count($leadUpdatesHistory)){
            $updatedata = ['is_active'=>0];
            $where      = ['lead_id'=>$leadId];
            $this->getModel()->updateanywhere('updated_lead_status', $updatedata, $where); 
        }
            
        $this->getModel()->insertanywhere('updated_lead_status', $data); 
        exit('Added Lead Status');
    }
    
    public function assignedleadsAction(){
      
        $view = new ViewModel();
        $this->layout('layout/layoutadmin');
        $allRoles = $this->getModel()->getAllRolesJson();
        $view->setVariable('allRoles', $allRoles);
    	$baseUrl = $this->getRequest()->getbaseUrl();
        $arrList = $this->getModel()->getAssignedLeads();
//         echo '<pre>';print_r($arrList);exit;
        if(count($arrList)){
            $notAssignedArr       = [];
            $siteVisitArr       = [];
            $meetingArr         = [];
            $followUpArr        = [];
            $notInterestedArr   = []; 
            $notAnsweringArr    = [];
                       
           foreach($arrList as $val1)
           {    
                if($val1['status_type']=='')   {
                    $notAssignedArr[] =  $val1['lead_id'] ;
                }elseif($val1['status_type']==1)   {
                    if($val1['interested_type']==1)   
                      $siteVisitArr[] =  $val1['lead_id'] ;
                    elseif($val1['interested_type']==2)   
                      $meetingArr[] =  $val1['lead_id'] ;
                    elseif($val1['interested_type']==3)   
                      $followUpArr[] =  $val1['lead_id'] ;
                }elseif($val1['status_type']==2)   {
                    $notInterestedArr[] =  $val1['lead_id'] ;
                }elseif($val1['status_type']==3)   {
                    $notAnsweringArr[] =  $val1['lead_id'] ;
                }
           }
           $view->setVariable('notAssignedArr', json_encode($notAssignedArr));
           $view->setVariable('siteVisitArr', json_encode($siteVisitArr));
           $view->setVariable('meetingArr', json_encode($meetingArr));
           $view->setVariable('followUpArr', json_encode($followUpArr));
           $view->setVariable('notInterestedArr', json_encode($notInterestedArr));
           $view->setVariable('notAnsweringArr', json_encode($notAnsweringArr));
        }
        
        if($this->getRequest()->isXmlHttpRequest()){
//            $arrList = $this->getModel()->getAssignedLeads();
//             echo '<pre>';print_r($arrList);exit;
            $dataArray = array();
            $kk=1;
            foreach($arrList as $val1)
            {
//         	    echo '<pre>';print_r($val1);exit;
                $reassignView = ($val1['is_reassigned']==1) ? '<br><span class="label label-danger" onclick="return reassignView(\''.$val1['lead_id'].'\')">Reassign View</span>' : '';
                $customer_name          =   $val1['customer_name'].$reassignView;
                $mobile                 =   base64_decode($val1['mobile']);
                $source_of_enquiry      =   $val1['source_name'];
                $project_interested     =   $val1['project_name'];
                $punchDateArr = explode(' ', $val1['punchDate']);
                $punch_date             =   $punchDateArr[0].' | '.substr($punchDateArr[1], 0, 5);
                $assigned_to            =   $val1['assignedTo'];
                $assigned_by            =   $val1['assignedBy'];
                $assignedDateArr        =   explode(' ', $val1['assigned_date']);
                $assigned_date          =   $assignedDateArr[0].' | '.substr($assignedDateArr[1], 0, 5);
                if($val1['next_meeting']!=''){
                    $nextMeetingDateArr    = explode(' ', $val1['next_meeting']);
                    $next_meeting          =   ($nextMeetingDateArr[0]!='0000-00-00') ? $nextMeetingDateArr[0].' | '.substr($nextMeetingDateArr[1], 0, 5) : '';
                }else{
                  $next_meeting = '';  
                }
                $open_by                =   $val1['openBy'];
                $last_feedback          =   '<a href="#" data-toggle="tooltip" data-placement="left" title="Last Activity - '.$val1['last_feedback'].'">'.  substr($val1['last_feedback'], 0, 15).'</a>';
                $client_type            =   ($val1['client_type'] ==1) ? 'Client' : ($val1['client_type'] ==2 ? 'Broker' : '');
                
                if($val1['status_type']==''){
                    $lead_status  =   'Not Updated';
                }elseif($val1['status_type']==1){
                    if($val1['interested_type']==1) 
                    $lead_status   =   'Site Visit';
                    elseif($val1['interested_type']==2)
                    $lead_status   =   'Meeting';
                    elseif($val1['interested_type']==3) 
                    $lead_status   =   'Follow Up';
                }elseif($val1['status_type']==2){
                    $lead_status   =   'Not Interested';
                }elseif($val1['status_type']==3){
                    $lead_status   =   'Not Answering';
                }
                $delete      =   (in_array(3, $this->roleRightsArr['rightsArr'])) ? '<a href="'.$baseUrl.'/admin/updatelead/'.base64_encode($val1['lead_id']).'" ><button title="Update" data-toggle="tooltip"  data-placement="left" class="btn btn-primary" type="button"><i class="fa fa-pencil-square-o"></i></button></a>' : "<button title='Update' class='btn btn-primary' type='button' data-toggle='tooltip' data-placement='left' disabled='disabled'><i class='fa fa-pencil-square-o'></i></button>";
                
                $dataArray[] =   array("id"=>$val1['lead_id'],"data"=>array(0,$kk,$customer_name,$mobile,$source_of_enquiry,$project_interested,$punch_date,$assigned_to,$assigned_by,$assigned_date,$next_meeting,$open_by,$lead_status,$last_feedback,$client_type,$delete));
                $kk++;
            }
//    echo '<pre>';print_r($dataArray);exit; 
            $json = json_encode($dataArray);
            exit('{rows:'.$json.'}');
        }
        return $view;  
    }
    
    public function assignleadstouserAction(){
        $view = new ViewModel();
        $this->layout('layout/layoutadmin');
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
//        echo '<pre>';print_r($request);exit;
        $leadIds    = $request->leadIds; 
        $userId     = $request->userId; 
        if($leadIds!=''){
            $leadArr = explode(',',$leadIds);
            foreach($leadArr as $leads){
                $data = [
                    'lead_id'       => $leads,
                    'assigned_to'   => $userId,
                    'assigned_by'   => $this->loggedInUserDetails->id,
                    'assigned_date' => date('Y-m-d H:i:s'),
                    'comp_id'       => $this->loggedInUserDetails->comp_id
                ]; 
                $this->getModel()->insertanywhere('assigned_lead', $data);
                $this->getModel()->updateanywhere('lead_list', ['is_assigned'=>1],['id'=>$leads]);
            }
        }
        exit;
    }
    
    public function reassignleadstouserAction(){
//        $this->layout('layout/layoutadmin');
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
//        echo '<pre>';print_r($request);exit;
        $leadIds    = $request->leadIds; 
        $userId     = $request->userId; 
        if($leadIds!=''){
            $leadArr = explode(',',$leadIds);
            foreach($leadArr as $leads){
                $this->getModel()->updateanywhere('assigned_lead', ['is_active'=>0],['lead_id'=>$leads]);
                $data = [
                    'lead_id'       => $leads,
                    'assigned_to'   => $userId,
                    'assigned_by'   => $this->loggedInUserDetails->id,
                    'assigned_date' => date('Y-m-d H:i:s'),
                    'is_reassigned' => 1,
                    'comp_id'       => $this->loggedInUserDetails->comp_id
                ]; 
                $this->getModel()->insertanywhere('assigned_lead', $data);
            }
        }
        exit;
    }
      
    public function checkmobilenumberAction()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        if(count($request)){
            $mobile = $request->mobileNumber; 
            if($mobile!=''){
                $admin = $this->getServiceLocator()->get('Application\Model\Admin');
                echo $admin->checkMobile(base64_encode($mobile));  
            }   
        }
        exit;
    }
    
      
    public function userforloginhistoryAction(){
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        if(count($request)){
            $searchUser = $request->searchUser; 
            if($searchUser!=''){
                
//                $this->getModel()->userforloginhistory();
                
                
                
                echo $searchUser;exit;
                
                
            }   
        }
        exit;
    }  
    public function loginhistoryAction(){
        $view = new ViewModel();
        $this->layout('layout/layoutadmin');
        
        $loginHistory = $this->getModel()->getLoginHistory();
        $view->setVariable('loginHistory', $loginHistory);
        
        return $view;
        
    }
    
    public function apicredentialsAction(){
        $view = new ViewModel();
        $this->layout('layout/layoutadmin');
        
        $magicBrickDetail   = $this->getModel()->getMagicBrickData();
        $acresData          = $this->getModel()->getAcresData();
        $smsApiData         = $this->getModel()->getSmsApiData();
        
        $view->setVariable('magicBrickDetail', $magicBrickDetail);
        $view->setVariable('acresData', $acresData);
        $view->setVariable('smsApiData', $smsApiData);
        
        return $view;
    }
    
    public function magicbricksformAction() {
        if($this->getRequest()->isXmlHttpRequest()){
            $id     = $this->params()->fromPost('Id');
            $data = [
                'source_id'         => trim($this->params()->fromPost('Source')),
                'magic_brick_key'   => trim($this->params()->fromPost('Key')),
                'comp_id'           => $this->loggedInUserDetails->comp_id,
                'last_updated_by'   => $this->loggedInUserDetails->id
            ];
            if($id==''){
                $this->getModel()->insertanywhere('magic_brick_credentials', $data);
            }else{
                $this->getModel()->updateanywhere('magic_brick_credentials', $data,['id'=>$id]);
            }
        }
        exit;
    }
    
    public function acresformAction() {
        if($this->getRequest()->isXmlHttpRequest()){
            $id         = $this->params()->fromPost('Id');
            $data = [
                'source_id'         => trim($this->params()->fromPost('Source')),
                'acres_username'    => trim($this->params()->fromPost('UserName')),
                'acres_pswd'        => trim($this->params()->fromPost('Pswd')),
                'comp_id'           => $this->loggedInUserDetails->comp_id,
                'last_updated_by'   => $this->loggedInUserDetails->id
            ];
            if($id==''){
                $this->getModel()->insertanywhere('acres_api_credentials', $data);
            }else{
                $this->getModel()->updateanywhere('acres_api_credentials', $data,['id'=>$id]);
            }
        }
        exit;
    }
    
    public function smsapiformAction() {
        if($this->getRequest()->isXmlHttpRequest()){
            $id         = $this->params()->fromPost('Id');
            $data = [
                'sms_user_name'     => trim($this->params()->fromPost('UserName')),
                'sms_pswd'          => trim($this->params()->fromPost('Pswd')),
                'comp_id'           => $this->loggedInUserDetails->comp_id,
                'last_updated_by'   => $this->loggedInUserDetails->id
            ];
            if($id==''){
                $this->getModel()->insertanywhere('sms_api_credentials', $data);
            }else{
                $this->getModel()->updateanywhere('sms_api_credentials', $data,['id'=>$id]);
            }
        }
        exit;
    }
    
    
    public function updateleadintableAction(){
        if($this->getRequest()->isXmlHttpRequest()){
            $leadId = $this->params()->fromPost('leadId');
            $reassignviewList = $this->getModel()->reassignview($leadId);
//          echo '<pre>';print_r($reassignviewList);exit;
            exit(json_encode($reassignviewList));
        }
    }
     public function reassignviewAction(){
        if($this->getRequest()->isXmlHttpRequest()){
            $leadId = $this->params()->fromPost('leadId');
            $reassignviewList = $this->getModel()->reassignview($leadId);
//          echo '<pre>';print_r($reassignviewList);exit;
            exit(json_encode($reassignviewList));
        }
    }
    
    public function adminpages(){
        if($this->roleRightsArr['seniority'] == 3 || $this->roleRightsArr['seniority'] == 4){
            $this->redirect()->toRoute('application',array('controller'=>'index','action' => 'logout'));
        }
    }
}
