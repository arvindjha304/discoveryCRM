<?php
date_default_timezone_set('America/Chicago');
if(isset($_REQUEST['filename']))
{
$filename2 = $_REQUEST['filename'];
 if(strpos($filename2, '_')){
$filename1=$filename2;
}
else
{
$filename3=explode(' ',$filename2);
$filename1=implode('_',$filename3);
}
$filename=$filename1.'-'.date('m-d-y');
}
else
{
$filename='grid';
}
ini_set('memory_limit', '-1');	
ini_set('max_execution_time', 3600);
require_once 'gridExcelGenerator.php';
require_once 'gridExcelWrapper.php';

$debug = false;
$error_handler = set_error_handler("PDFErrorHandler");

if (get_magic_quotes_gpc()) {
	$xmlString = stripslashes($_POST['grid_xml']);
} else {
	$xmlString = $_POST['grid_xml'];
}

// echo $xmlString;exit;

$xmlString = urldecode($xmlString);

$xmlString = str_replace("®","",$xmlString);
if ($debug == true) {
	error_log($xmlString, 3, 'debug_'.date("Y_m_d__H_i_s").'.xml');
}

$xml = simplexml_load_string($xmlString);
$excel = new gridExcelGenerator();
$excel->filename = $filename;
$excel->printGrid($xml);
function PDFErrorHandler ($errno, $errstr, $errfile, $errline) {
	global $xmlString;
	if ($errno < 1024) {
		//error_log($xmlString, 3, 'error_report_'.date("Y_m_d__H_i_s").'.xml');
	}

}

?>