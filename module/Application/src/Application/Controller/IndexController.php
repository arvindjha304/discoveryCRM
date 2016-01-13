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
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Session\Container;

class IndexController extends AbstractActionController
{
    
    public function getbaseUrl(){
        $baseUrl = $this->getRequest()->getbaseUrl();
    }
    public function getAdapter(){
        return $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
    }
    public function getModel(){
        return  $this->getServiceLocator()->get('Application\Model\Index');
    }
    public function getUserDetails(){
        $auth = new AuthenticationService();
        if($auth->hasIdentity())
            return $auth->getIdentity(); 
        else
            $this->redirect()->toRoute('application',array('controller'=>'index','action' => 'index'));
    }
    public function indexAction()
    {
        $view = new ViewModel();
	$view->setTerminal(true);
        
        $id1 =  $this->params()->fromRoute('id1');
        if(isset($id1)){
          $view->setVariable('loginFailed', $id1);
        }
       
        if($this->request->isPost()){
            $useremail = $this->params()->fromPost('email');
            $password = $this->params()->fromPost('password');
            $remember_me = $this->params()->fromPost('remember_me');
            $remember_me = (isset($remember_me)) ? 1 : 0;
            if($useremail!='' && $password!=''){
                $loginStatus = $this->userLogin($useremail,$password,$remember_me);
                if($loginStatus==0){
                    $this->redirect()->toUrl('index/index/0');
                }else{
                   $this->redirect()->toRoute('application',array('controller'=>'index','action' => 'otp-code')); 
                } 
            }
        }
        return $view;
    }
    
    public function userLogin($useremail,$password,$remember_me=0){
        
        $authAdapter 	= new AuthAdapter($this->getAdapter(), 'userlist','useremail', 'password', 'CONCAT(?,salt_key) and is_active=1 and is_delete=0');
        $authAdapter->setIdentity(trim($useremail));
        $authAdapter->setCredential(base64_encode(trim($password)));
        $auth = new AuthenticationService();
        $result = $authAdapter->authenticate($authAdapter);
        if ($result->isValid()) {
            if($remember_me ==1){
                setcookie('discoveryCRMcookieEmail', $useremail, time() + (86400 * 365), "/");
                setcookie('discoveryCRMcookiePswd', $password, time() + (86400 * 365), "/");
            }else{
                setcookie('discoveryCRMcookieEmail', $useremail, time() - 86400, "/");
                setcookie('discoveryCRMcookiePswd', $password, time() - 86400, "/");
            }
            $data = $authAdapter->getResultRowObject();
            $auth->getStorage()->write($data);
            $identity = $auth->getIdentity();
            $this->getModel()->generateOTP();
            return 1;	
        }else{
            return 0;
        }
    }
    
    
	public function forgotPasswordAction()
    {
        $view = new ViewModel();
		$view->setTerminal(true);
        if($this->getRequest()->isPost()){
            $forgotEmail = $this->params()->fromPost('email');  
            $userData = $this->getModel()->checkIfEmailExist($forgotEmail);
             //echo '<pre>';print_r($userData);exit; 
            if(count($userData)){ 
                $this->getModel()->forgotPasswordMail($userData[0]['id'],$forgotEmail);
                $view->setVariable('successMsg', "Password reset link has been sent to your Email");
            }else{
                $view->setVariable('errorMsg', "Email doesn't exist");
            }
        }
        return $view;
    }
    
    public function resetPasswordAction(){
        $view = new ViewModel();
        $view->setTerminal(true);
        $userId = $this->params()->fromQuery('user');
        $view->setVariable('userId', base64_decode($userId));
        if($this->getRequest()->isPost()){
            $user_id        = $this->params()->fromPost('userId');
            $pswdVal        = $this->params()->fromPost('pswdVal');
            $confPswdVal    = $this->params()->fromPost('confPswdVal');
            if($pswdVal!='' && $confPswdVal!='' && $user_id!='' && $pswdVal==$confPswdVal){
                $salt = $this->create_salt();
                $data = [];
                $data['password']       =   base64_encode(trim($pswdVal)).$salt;
                $data['salt_key']       =   $salt; 
                $this->getModel()->updateanywhere('userlist',$data,['id'=>$user_id]);
                $view->setVariable('successMsg', 'success');
               // $this->redirect()->toRoute('homepage');
            }
        }
        return $view;
    }
    public function create_salt(){
		return base64_encode(mcrypt_create_iv(8, MCRYPT_DEV_URANDOM));
	}
    
    public function otpCodeAction()
    {
        $view = new ViewModel();
	$view->setTerminal(true);
        
        $userDetails = $this->getUserDetails();
        $userId     = $userDetails->id;
        $useremail  = $userDetails->useremail;
        $mobile     = $userDetails->mobile;
        
        $emailArr = explode('@',$useremail);
        $emailName = $emailArr[0];
        $emailLength = strlen($emailName);
        $emailInitial = substr($emailName,0,3);
        $starStr = '';
        for($i=0;$i<(strlen($emailName)-strlen($emailInitial));$i++){
            $starStr .= '*';
        }
        $displayEmail = $emailInitial.$starStr.'@'.$emailArr[1];
        $displayMobile = '******'.substr($mobile,-4);
//        echo $displayMobile;
//        echo $displayEmail;
//        echo '<pre>';print_r($userDetails);exit; 
        $view->setVariable('displayEmail', $displayEmail);
        $view->setVariable('displayMobile', $displayMobile);
        
        if($this->getRequest()->isPost()){
            $otpcode = $this->params()->fromPost('otpcode');  
            
            if($otpcode!=''){
//              echo base64_encode($otpcode);exit;
                $checkUserOTP = $this->getModel()->checkUserOTP(base64_encode($otpcode),$userId);
                if($checkUserOTP==1){
                    $this->getModel()->getRoleInSession($userDetails->role_id);
                    
                    $this->getModel()->insertUserHistory($userDetails->id);
                    $roleInSession  = new Container('roleInSession');
                    $roleRightsArr  = $roleInSession->roleRightsArr;
//                    if($roleRightsArr['seniority'] == 1)
                        $this->redirect()->toRoute('application',array('controller'=>'admin','action' => 'dashboard'));
//                    else
//                        $this->redirect()->toRoute('application',array('controller'=>'admin','action' => 'userdashboard'));
                }else
                    $view->setVariable ('errorMsg', 'wrongOTP');
            }
            $view->setVariable ('errorMsg', 'wrongOTP');
        }
        return $view;
    }
    
    public function resendotpAction(){
        $this->getModel()->generateOTP();
        $this->redirect()->toRoute('application',array('controller'=>'index','action' => 'otp-code'));
    }
    
    public function logoutAction(){
        $auth = new AuthenticationService();
        $this->getModel()->updateUserHistory();
        $auth->clearIdentity();
        $this->redirect()->toRoute('application',array('controller'=>'index'));
    }
}
