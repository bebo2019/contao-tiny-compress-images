<?php

/**
 * Initialize the system
 */
define('TL_MODE', 'FE');
require '../../../system/initialize.php';


class TinyCompressImagesTest extends \System
{
	public function __construct()
	{
		parent::__construct();
	}
	

	public function run()
	{
		$strUrl = 'https://api.tinypng.com/shrink';
		$strKey = $GLOBALS['TL_CONFIG']['tinypng_api_key'];
		$strAuthorization = 'Basic '.base64_encode("api:$strKey");
		
		$objRequest = new Request();
		$objRequest->method = 'post';
		$objRequest->data = file_get_contents(TL_ROOT . '/files/!/10854473_403593456473882_4756343055560037901_o.jpg');
		$objRequest->setHeader('Content-type', 'image/png');
		$objRequest->setHeader('Authorization', $strAuthorization);
		$objRequest->send($strUrl);
		
		if ($objRequest->code == 201) {
			//print 'Error: ' . $objRequest->error . '<br>';
			//print 'Message:' . $objRequest->message . '<br>';
			
			$xxx = json_decode($objRequest->response);
			file_put_contents(TL_ROOT . '/xxx.jpg', fopen($xxx->output->url, "rb", false));
		} else {
			// Logs
			// [strResponse:protected] => {"error":"InputMissing","message":"File is empty"}
		}
	}
}

$objTest = new TinyCompressImagesTest();
$objTest->run();
