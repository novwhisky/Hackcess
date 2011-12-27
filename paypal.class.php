<?php

class Paypal{
	
	protected static $api_cred;
	
	function __construct($usr,$pwd,$sig)
	{
		$this->api_cred['USER'] = $usr;
		$this->api_cred['PWD'] = $pwd;
		$this->api_cred['SIGNATURE'] = $sig;
	}
	
	private function debug($var)
	{
		//var_dump($var);
	}
	
	private function curlReq($url)
	{
		$url = parse_url($url);
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL,$url['scheme'].'://'.$url['host'].$url['path'].'?'.$url['query']);
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
	   	
		$content = curl_exec( $ch );
    	$response = curl_getinfo( $ch );
    	curl_close ( $ch );
		return $response;
	}
	
	public function api($method,$params)
	{
		$req = API.'?METHOD='.$method.'&VERSION='.API_VER.'&'.http_build_query($this->api_cred).'&'.http_build_query($params);
		return $this->curlReq($req);
	}
		
}