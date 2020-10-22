<?php 

namespace Candra\UpscaleApiIntegration;

use GuzzleHttp\Client;

class UpscaleApiIntegration
{

	private $apiUrl;
	
	public function __construct(String $apiUrl = '')
	{
		$this->apiUrl = $apiUrl;
	}

	public function getAll()
	{
		return $this->requestToApi($this->apiUrl);
	}

	public function getSpecific($userId)
	{
		return $this->requestToApi($this->apiUrl . '/' . $userId);
	}

	public function requestToApi($url)
	{
		$tempData 	= new \GuzzleHttp\Client([
						    'base_uri' => $url,
						    'timeout'  => 5, 	// Timeout max.5 detik, supaya autocut ketika terlalu lama request
						]);

	    $request 	= $tempData->get($url);

	    //	Hanya memproses jika header statusnya 200 (Ok)
	    if ( $request->getStatusCode() === 200 ) {

	    	//	Hanya memproses return berupa file json
	    	if ( $request->getHeaderLine('content-type') === "application/json; charset=utf-8" )
	    		return $request->getBody(); 
	    	else 
	    		return "Failed return-type data";

	    } else {
	    	//	Bisa di ganti dengan custom message, sementara di kembalikan dalam bentuk
	    	//	original return statusnya
	    	return $request->getStatusCode();
	    }
	}

}

?>