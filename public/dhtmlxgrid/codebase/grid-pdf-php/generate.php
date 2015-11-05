<?php
date_default_timezone_set('America/Chicago');
if(isset($_REQUEST['filename']))
{
$filename1 = $_REQUEST['filename'];
$filename=$filename1.'-'.date('m-d-y');
}else
{
$filename='grid';
}
require_once 'gridPdfGenerator.php';
require_once 'tcpdf/tcpdf.php';
require_once 'gridPdfWrapper.php';

$debug = false;
$error_handler = set_error_handler("PDFErrorHandler");

if (get_magic_quotes_gpc()) {
	$xmlString = stripslashes($_POST['grid_xml']);
} else {
	$xmlString = $_POST['grid_xml'];
}
$xmlString = urldecode($xmlString);
if ($debug == true) {
	error_log($xmlString, 3, 'debug_'.date("Y_m_d__H_i_s").'.xml');
}

$xml = simplexml_load_string($xmlString);
$pdf = new gridPdfGenerator();
$pdf->filename = $filename;
$pdf->printGrid($xml);

function PDFErrorHandler ($errno, $errstr, $errfile, $errline) {
	global $xmlString;
	if ($errno < 1024) {
		//error_log($xmlString, 3, 'error_report_'.date("Y_m_d__H_i_s").'.xml');
		//echo $errfile." at ".$errline." : ".$errstr;
		exit(1);
	}

}

?>