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
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;

class ApiController extends AbstractActionController
{
    
    public function getbaseUrl(){
        $baseUrl = $this->getRequest()->getbaseUrl();
    }
    public function getAdapter(){
        return $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
    }
    
    public function getModel(){
        return  $this->getServiceLocator()->get('Application\Model\Api');
    }
    
    public function indexAction()
    {
//      echo 'hii';
        exit;
    }
    
    public function autoleadassignAction() {
        $companySettings = $this->getModel()->getCompanySettings();
        if(count($companySettings)){
            foreach ($companySettings as $company){
                $compId = $company['comp_id'];
                $lead_auto_assign = $company['lead_auto_assign'];
                if($lead_auto_assign==1){
                    $autoAssignSourceUser = $this->getModel()->auto_assign_source_user($compId);
                    if(count($autoAssignSourceUser)){
                        foreach ($autoAssignSourceUser as $autoAssign){
                            $source_id      = $autoAssign['source_id'];
                            $user_id        = $autoAssign['user_id'];
                            $leadList = $this->getModel()->getSourceLeads($source_id,$compId);
                            if(count($leadList)){
                                foreach($leadList as $leads){
                                    $lead_id = $leads['id'];
                                    $this->getModel()->assignLeadToUser($lead_id,$user_id,$compId);
                                }
                            } 
                        } 
                    }   
                }

            }
        }
        exit('Lead Assgned Successfully');
    }
    
    public function nintynineacresapiAction() {
        
        $compId = $this->params()->fromRoute('id1', '');
        if($compId!=''){
            $fdate = date('Y-m-d 00:00:00',strtotime('-1 Days'));
            $tdate = date('Y-m-d 00:00:00');   
           
            $nintyNineAcresCredentials = $this->getModel()->getNintyNineAcresCredentials($compId);
            
            if(count($nintyNineAcresCredentials)){
                
                $userName = $nintyNineAcresCredentials[0]['acres_username'];
                $password = $nintyNineAcresCredentials[0]['acres_pswd'];
                $sourceId = $nintyNineAcresCredentials[0]['source_id'];

                $xml_data ='<?xml version="1.0" encoding="utf-8"?>
                <query>
                <user_name>'.$userName.'</user_name>
                <pswd>'.$password.'</pswd>
                <start_date>'.$fdate.'</start_date>
                <end_date>'.$tdate.'</end_date>
                </query>';  

                $url = "http://www.99acres.com/99api/v1/getmy99Response/OeAuXClO43hwseaXEQ/uid/";

                $post_data = array('xml' => $xml_data);
                $stream_options = array(
                    'http' => array(
                            'method'  => 'POST',
                            'header'  => 'Content-type: application/x-www-form-urlencoded' . "\r\n",
                            'content' =>  http_build_query($post_data)
                    )
                );

                $context  = stream_context_create($stream_options);
                $response = file_get_contents($url, null, $context);
                
                $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
                $json = json_encode($xml);
                $array = json_decode($json,false);
                
//                echo '<pre>';print_r($array);exit;
                
                if(array_key_exists('Resp', $array) && count($array->Resp)){
                   foreach($array->Resp as $leads){
                       
                        $mobile = $leads->CntctDtl->Phone;
                        $mobile = base64_encode($mobile);
                        $checkdata = $this->getModel()->checkIfLeadExists($mobile,$compId);
    //                      echo $checkdata;exit; 
                        if($checkdata == 0)
                        { 
                            $data = [
                                'customer_name'       => ucwords($leads->CntctDtl->Name),
                                'mobile'              => $mobile,
                                'alt_no'              => '',
                                'other_no'            => '',
                                'email'               => $leads->CntctDtl->Email,
                                'address'             => '',
                                'source_of_enquiry'   => $sourceId,
                                'budget'              => '',
                                'project_interested'  => 0,
                                'requirement'         => $leads->QryDtl->CmpctLabl,
                                'comp_id'             => $compId,
                                'is_active'           => 1,
                                'is_delete'           => 0,
                                'created_by'          => 1,
                                'last_updated_by'     => 1,
                                'last_updated'        => date('Y-m-d H:i:s'),
                                'punch_date'          => $leads->QryDtl->RcvdOn,
                                'date_created'        => date('Y-m-d H:i:s')
                            ];
//                                echo '<pre>';print_r($data);exit;
                            $this->getModel()->insertanywhere('lead_list', $data);
                        }
                    } 
                }
            }
        }
       exit('99 Acres Lead Added Succesfully');
    }
    
    
    public function magicbricksapiAction() {
        
        $compId = $this->params()->fromRoute('id1', '');
        
        if($compId!=''){
//            echo $compId;exit;
            
            $magicBrickCredentials = $this->getModel()->getMagicBrickCredentials($compId);
            
            if(count($magicBrickCredentials)){
                
//                echo '<pre>';print_r($magicBrickCredentials); exit;
                $magicBricksKey = $magicBrickCredentials[0]['magic_brick_key'];
                $sourceId       = $magicBrickCredentials[0]['source_id'];

                $fdate = date('Ymd',strtotime('-1 Days'));
                $tdate = date('Ymd');

                $url = "http://rating.magicbricks.com/mbRating/download.xml?key=".$magicBricksKey."&startDate=".$fdate."&endDate=".$tdate;
                $xml_response = file_get_contents($url);
                $xml = new \SimpleXMLElement($xml_response);
                if(count($xml->leads->lead)){
//                 echo '<pre>';print_r($xml);exit;
                    foreach($xml->leads->lead as $leads){
//                        echo '<pre>';print_r($leads);exit;
                        $mobile = $leads->mobile;
//                        settype($mobile,"float"); 
                        $mobile = base64_encode($mobile);
                        $checkdata = $this->checkIfLeadExists($mobile,$compId);
//                      echo $checkdata;exit;  
                        if($checkdata == 0)
                        { 
                            $data = [
                                'customer_name'       => ucwords($leads->name),
                                'mobile'              => $mobile,
                                'alt_no'              => '',
                                'other_no'            => '',
                                'email'               => $leads->email,
                                'address'             => '',
                                'source_of_enquiry'   => $sourceId,
                                'budget'              => '',
                                'project_interested'  => 0,
                                'requirement'         => $leads->msg,
                                'comp_id'             => $compId,
                                'is_active'           => 1,
                                'is_delete'           => 0,
                                'created_by'          => 1,
                                'last_updated_by'     => 1,
                                'last_updated'        => date('Y-m-d H:i:s'),
                                'punch_date'          => $leads->dt,
                                'date_created'        => date('Y-m-d H:i:s')
                             ];
//                            echo '<pre>';print_r($data);exit;
                            $this->insertanywhere('lead_list', $data);
//                            exit('1111');
                        }
                    } 
                }
            }
        }
       exit('Magic Brick Lead Added Succesfully');
    }
    
    public function morningmailAction() {
        $allCompanies = $this->getModel()->getAllCompanies();
        if(count($allCompanies)){
            foreach($allCompanies as $comp){
                $comp_id = $comp['id'];
                $user_list = $this->getModel()->getUserList($comp_id);
                foreach($user_list as $user){
                    $user_id = $user['id'];
                    $seniority = $user['seniority'];
                    $morningReport = $this->getModel()->getMorningReport($comp_id,$user_id,$seniority);
                    echo '<pre>';print_r($morningReport);exit;
                }
            }
            
        }
      exit;
    }
    
    public function eveningmailAction(){
        $allCompanies = $this->getModel()->getAllCompanies();
        if(count($allCompanies)){
            foreach($allCompanies as $comp){
                $comp_id = $comp['id'];
                $user_list = $this->getModel()->getUserList($comp_id);
                foreach($user_list as $user){
                    $user_id = $user['id'];
                    $seniority = $user['seniority'];
                    $morningReport = $this->getModel()->getEveningReport($comp_id,$user_id,$seniority);
                    echo '<pre>';print_r($morningReport);exit;
                }
            }
            
        }
      exit;  
    }
    
    
    
    
    
    
    
    

}
