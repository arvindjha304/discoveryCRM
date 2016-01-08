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
        return  $this->getServiceLocator()->get('Application\Model\Index');
    }
    
    public function indexAction()
    {
//        echo 'hii';
        exit;
        
    }
    
    public function nintynineacresapiAction() {
        
        $compId = $this->params()->fromRoute('id1', '');
        if($compId!=''){
//            echo $compId;exit;
            
            $fdate = date('Y-m-d 00:00:00',strtotime('-1 Days'));
            $tdate = date('Y-m-d 00:00:00');   
           
            $nintyNineAcresCredentials = $this->getNintyNineAcresCredentials($compId);
            
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
//echo '<pre>';print_r($array);exit;
                if(array_key_exists('Resp', $array) && count($array->Resp)){
                   foreach($array->Resp as $leads){
                       
                        $mobile = $leads->CntctDtl->Phone;
                        $mobile = base64_encode($mobile);
                        $checkdata = $this->checkIfLeadExists($mobile,$compId);
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
                            $this->insertanywhere('lead_list', $data);
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
            
            $magicBrickCredentials = $this->getMagicBrickCredentials($compId);
            
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
    
    
    public function insertanywhere($mytable, array $data) {
        $db = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $table = new TableGateway($mytable, $db);
        $results = $table->insert($data);
    }
    

}
