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

class ReportsController extends AbstractActionController
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
        return  $this->getServiceLocator()->get('Application\Model\Reports');
    }    
    public function adminpages(){
        if($this->roleRightsArr['seniority'] == 3 || $this->roleRightsArr['seniority'] == 4){
            $this->redirect()->toRoute('application',array('controller'=>'index','action' => 'logout'));
        }
    }
    
    public function reportgeneratorAction() {
        $view = new ViewModel();
        $this->layout('layout/layoutadmin');
        
        
//        echo '2222';exit;
        
        return $view;
        
    }
    
    public function getreportAction() {
        
        $start_date = $this->params()->fromQuery('report_start_date'); 
        $end_date = $this->params()->fromQuery('report_end_date'); 
        $report_type = $this->params()->fromQuery('report_type');
//        exit;
        if($report_type=='user_report')
            $report = $this->getModel()->getUserReport($start_date,$end_date);
        elseif($report_type=='source_wise_report')
            $report = $this->getModel()->getSourceWiseReport($start_date,$end_date);
        elseif($report_type=='project_wise_report')
            $report = $this->getModel()->getProjectWiseReport($start_date,$end_date);
        elseif($report_type=='lead_report')
            $report = $this->getModel()->getLeadReport($start_date,$end_date);
        elseif($report_type=='user_lead_report')
            $report = $this->getModel()->getUserLeadReport($start_date,$end_date);
        
        
        exit;
        
        
        
//        echo '<pre>';print_r($this->params()->fromQuery());exit;
        
        
        
    }
    
    
    
}
