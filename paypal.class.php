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
		var_dump($var);
	}
	
	private function curlReq($url)
	{
		$url = parse_url($url);
		$ch = curl_init();	
		curl_setopt($ch, CURLOPT_URL,$url['scheme'].'://'.$url['host'].$url['path'].'?'.$url['query']);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$content = curl_exec( $ch );
    	curl_close ( $ch );
		return $this->responseObject($content);
	}
	
	public function api($method,$params)
	{
		$req = API.'?METHOD='.$method.'&VERSION='.API_VER.'&'.http_build_query($this->api_cred).'&'.http_build_query($params);
		return $this->curlReq($req);
	}
	
	private function responseObject($str)
	{
		parse_str($str,$arr);
		$listKeys = array();
		foreach($arr as $k=>$v)
		{
			if(preg_match('/^L_([[:alpha:]]+)([[:digit:]]+)/',$k,$matches)){
				$listKeys[$matches[2]][$matches[1]] = $v;
				unset($arr[$k]);
			}
		}
		$arr['RESULTS'] = $listKeys;
		return $arr;
	}
	
	public function transactionSearch($params)
	{
		// required parameter STARTDATE
		if(isset($params['STARTDATE'])){
			$params['RECURSIVE'] = $params['RECURSIVE'] || false;
			$mResult = $this->api('TransactionSearch',$params);
			
			switch($mResult['ACK'])
			{
				case 'Success':
					// All is well
					$mResult = $mResult['RESULTS'];
				break;
				case 'SuccessWithWarning':
					$mResult = $mResult['RESULTS'];
					$newest = $mResult[0];
					$oldest = end($mResult);
					// Over 100 result limit, search recursively (1,000 records / 14 min)
					if($newest['ERRORCODE'] = 11002 && $params['RECURSIVE'] == true) 
					{
						$lastDate = date("Y-m-d H:i:s",(intval(strtotime($oldest['TIMESTAMP'])) - 1));
						$rParams = array('STARTDATE'=>$params['STARTDATE'],'ENDDATE'=>$lastDate);
						$res = $this->transactionSearch($rParams);
						unset(
								$mResult[0]['ERRORCODE'],
								$mResult[0]['SHORTMESSAGE'],
								$mResult[0]['LONGMESSAGE'],
								$mResult[0]['SEVERITYCODE']
							 );
						$mg = array_merge($mResult,$res);
						return $mg;
					}
				break;
			}
			return $mResult;
		}else{
			// Error, no start date
			return false;
		}
	}
	
	public function getTransactionDetails($txn_id)
	{
		// Required param TRANSACTIONID
		if(isset($txn_id))
		{
			$res = $this->api('GetTransactionDetails',array('TRANSACTIONID'=>$txn_id));
			return $res;
		}else{
			// No txn ID
			return false;
		}
	}
		
}