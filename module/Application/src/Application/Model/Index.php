<?php
namespace Application\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Session\Container;
use Zend\Authentication\AuthenticationService;

use Zend\Mail;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

 class Index extends AbstractTableGateway implements ServiceLocatorAwareInterface {

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
    public function getUserDetails(){
        $auth = new AuthenticationService();
        if($auth->hasIdentity())
            return $auth->getIdentity(); 
        else
            $this->redirect()->toUrl('index');
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
		$table->delete($where); 
        return 1;
	}

	public function insertanywhere($mytable, array $data) {
		$db = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$table = new TableGateway($mytable, $db);
		$results = $table->insert($data);
        return 1;
	}
	
    public function checkIfEmailExist($email){
        $table = new TableGateway('userlist',$this->getAdapter());
        $userData = $table->select(['useremail'=>$email,'is_active'=>1,'is_delete'=>0])->toArray();
        return $userData;
    }
    public function forgotPasswordMail($userId,$user_email){
        $baseUrl = $this->serviceLocator->get('Zend\View\Renderer\RendererInterface')->basePath();
        $indexModel = $this->getServiceLocator()->get('Application\Model\Index');
        $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Reset Password</title>
        </head>
        <body style="margin:0; padding:0;">
        <table width="640" border="0" cellpadding="0" cellspacing="0"  bgcolor="#fff" style="margin:auto; border:3px solid #02753e;">
        <tr>
        <td colspan="2" align="center" style="font-family:Arial, Helvetica, sans-serif;font-size:24px;font-weight:bold;padding:10px;color:#fff;background-color:#02753e;"><a href="localhost/discoveryCRM/index/reset-password?user='.base64_encode($userId).'">Click</a> this to reset your password.</td>
        </tr>
        </table>
        </body>
        </html>'; 
        $subject = 'Reset Password Link';
       $this->sendmailHTML($user_email,'',$subject,$html);
       return 1;
    }
    
    public function generateOTP(){
        $userDetails = $this->getUserDetails();
//      echo '<pre>';print_r($userDetails);exit; 
        $userid     = $userDetails->id;
        $username   = $userDetails->username;
        $useremail  = $userDetails->useremail;
        $otp = rand(100000,999999);
        $data = array(
            'otp_code'      => base64_encode($otp),
            'user_id'       =>  $userid,
            'is_used'       =>  0,
            'company_id'    =>  $userDetails->comp_id,
            'date_created'  =>  date('Y-m-d H:i:s')
        );
        
       // echo '<pre>';print_r($data);exit;
        
        $this->insertanywhere('otp_codes',$data);
        $subject = ''.$otp.' is your verification code for secure access';
        $body = "<p>Hi ".$username.",</p>
        <p>Greetings!</p>
        <p>You are just a step away from accessing your DiscoveryCRM account.<br>
        We are sharing a verification code to access your account. The code is valid for 30 minutes and usable only once.<br>
        Once you have verified the code, you'll be redirected to the Dashboard page.</p>
        <p>Your OTP: ".$otp." <br>
        Expires in: 30 minutes only</p>
        <p>Best Regards, <br>
        Team DiscoveryCRM</p>";
        
        $this->sendmailHTML($useremail,$username,$subject,$body);
        return 1;
    }

    public function checkUserOTP($otpcode,$userId){
        $table = new TableGateway('otp_codes',$this->getAdapter());
        $userData = $table->select(['otp_code'=>$otpcode,'user_id'=>$userId,'is_used'=>0])->toArray();
//        echo '<pre>';print_r($userData);exit; 
        if(count($userData)){
            $this->updateanywhere('otp_codes', ['is_used'=>1], ['id'=>$userData[0]['id']]);
            $createdTime = strtotime($userData[0]['date_created']);
            $timeDiff = time()-$createdTime;
            if($timeDiff > 1800) return 0;
            return 1;
        }else
            return 0;
    }

    public function sendmail($to_email,$to_name,$subject,$body){
        $message = new \Zend\Mail\Message();
        $message->addTo($to_email, $to_name)
                ->setFrom('arvind@discoverysolutions.in', 'DiscoveryCRM')
                ->setSubject($subject)
                ->setBody($body);
        
        if($_SERVER['HTTP_HOST']=='localhost'){
           
            $smtpOptions = new \Zend\Mail\Transport\SmtpOptions();
            $smtpOptions->setHost('smtp.gmail.com')
            ->setConnectionClass('login')
            ->setName('smtp.gmail.com')
            ->setConnectionConfig(array(
                    'username' => 'mail.discoverysolutions@gmail.com',
                    'password' => 'Discovery@123',
//                    'username' => 'test00455@gmail.com',
//                    'password' => 'Test@1423',
                    'ssl' => 'tls',
                )
            ); 
            $transport = new \Zend\Mail\Transport\Smtp($smtpOptions);
            $transport->send($message);
        }else{
            $transport = new \Zend\Mail\Transport\Sendmail();
            $transport->send($message);
        }
        return 1;
    }
    public function sendmailHTML($to_email,$to_name,$subject,$htmltext){
        $message = new \Zend\Mail\Message();
        $message->addTo($to_email, $to_name)
                ->setFrom('arvind@discoverysolutions.in', 'DiscoveryCRM')
                ->setSubject($subject);
       // $htmltext = '<b>heii, <i>sorry</i>, i\'m going late</b>';
        
        if($_SERVER['HTTP_HOST']=='localhost'){
            $transport = new \Zend\Mail\Transport\Smtp();
            $options   = new \Zend\Mail\Transport\SmtpOptions(array(
                'host'              => 'smtp.gmail.com',
                'connection_class'  => 'login',
                'connection_config' => array(
                    'ssl'       => 'tls',
                    'username' => 'mail.discoverysolutions@gmail.com',
                    'password' => 'Discovery@123'
//                      'username' => 'test00455@gmail.com',
//                      'password' => 'Test@1423', 
                ),
                'port' => 587,
            ));
            $html = new \Zend\Mime\Part($htmltext);
            $html->type = "text/html";
            $body = new \Zend\Mime\Message();
            $body->addPart($html);
            $message->setBody($body);
            $transport->setOptions($options);
            $transport->send($message);
        }else{
            $bodyPart = new \Zend\Mime\Message();
            $bodyMessage = new \Zend\Mime\Part($htmltext);
            $bodyMessage->type = 'text/html';
            $bodyPart->setParts(array($bodyMessage));
            $message->setBody($bodyPart);
            $message->setEncoding('UTF-8');
            $transport = new \Zend\Mail\Transport\Sendmail();
            $transport->send($message); 
        }
        return 1;
    }
    public function insertUserHistory($user_id) {
        
        $where = array(
            'user_id' => $user_id,
            'comp_id' => $this->loggedInUserDetails->comp_id
        );
        
        $this->updateanywhere('user_login_history', ['status'=>1], $where);
        
        $data = [];
        $data['user_id']        = $user_id;
        $data['ip_address']     = $_SERVER['REMOTE_ADDR'];
        $data['login_time']     = date('Y-m-d H-i-s');
        $data['logout_time']    = '';
        $data['status']         = 0;
        $data['comp_id']        = $this->loggedInUserDetails->comp_id;
        $this->insertanywhere('user_login_history',$data);
        return 1;
    }
    
    public function updateUserHistory($user_id) {
        
        $where = array(
            'user_id'   => $this->loggedInUserDetails->id,
            'comp_id'   => $this->loggedInUserDetails->comp_id,
            'status'    => 0
        );
        
        $data = array(
            'logout_time' =>    date('Y-m-d H-i-s'),
            'status'      =>    1
        );
        
        $this->updateanywhere('user_login_history', $data, $where);
        
    }
    
    
    
    public function getRoleInSession($role_id) {
        $table = new TableGateway('company_roles',$this->getAdapter());
        $select = $table->select(function($select) use($role_id){
            $select->columns(['seniority','role_name'])
                ->join(['crr'=>'company_role_rights'],'company_roles.id=crr.role_id',['right_id'])
                ->where(['crr.comp_id'=>$this->loggedInUserDetails->comp_id,'crr.role_id'=>$role_id,'crr.is_active'=>1,'crr.is_delete'=>0]);
        })->toArray();
        
//         echo '<pre>';print_r($select);exit; 
        
        $tempArr = [];
        foreach($select as $key=>$value){
            if($key==0){
                $tempArr['seniority']   =  $value['seniority'];
                $tempArr['role_name']   =  $value['role_name'];
            }
            $tempArr['rightsArr'][]     =  $value['right_id'];
        }
        
//        echo '<pre>';print_r($tempArr);exit; 
        
        $roleInSession = new Container('roleInSession');
        $roleInSession->roleRightsArr  = $tempArr;        
        return 1;
    }
    
}