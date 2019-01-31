<?php 
	$environment = 0;
	if($environment == 0){
		$safetyPayUrl = "https://sandbox-mws2.safetypay.com/express/ws/v.3.0";
		$safetypayHost = "sandbox-mws2.safetypay.com";
		$safetyPayKey = "*************************************";
		$safetypaySignature = "*************************************";
	}else{
		$safetyPayUrl = "https://mws2.safetypay.com/express/ws/v.3.0";
		$safetypayHost = "mws2.safetypay.com";
		$safetyPayKey = "*************************************";
		$safetypaySignature = "*************************************";
	}
	
	$action = $_POST['action'];
	
	if (isset($action)) {
		switch ($action) {
			case 'CreateExpressToken':
				print_r(CreateExpressToken());
				break;
			case 'GetNewOperationActivity':
				print_r(GetNewOperationActivity());
				break;
			case 'ConfirmNewOperationActivity':
				print_r(ConfirmNewOperationActivity());
				break;
		}
	}

	function curlSafetypay($xml){
		global $safetyPayUrl;
		global $safetypayHost;
		global $action;
		
		$len = strlen($xml);
		
		$headers = array(
			'Content-Type: text/xml; charset=utf-8',
			'Content-Length: '.$len,
			'Host: '.$safetypayHost.'',
			'SOAPAction: "urn:safetypay:contract:mws:api:'.$action.'"'
		);
				
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_URL, $safetyPayUrl);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLINFO_HEADER_OUT, 0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
  
		$response = curl_exec($ch);
		
		return $response;		
	}
	
	function CreateExpressToken(){
		$xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:safetypay:messages:mws:api" xmlns:urn1="urn:safetypay:schema:mws:api">
		<soapenv:Header/>
		<soapenv:Body>
		<urn:ExpressTokenRequest>
		<!--Optional:-->
		<urn:ApiKey>**************************************</urn:ApiKey>
		<!--Optional:-->
		<urn:RequestDateTime>2015-02-16T23:00:37</urn:RequestDateTime>
		<!--Optional:-->
		<urn:CurrencyID>CLP</urn:CurrencyID>
		<urn:Amount>30</urn:Amount>
		<!--Optional:-->
		<urn:MerchantSalesID></urn:MerchantSalesID>
		<!--Optional:-->
		<urn1:Language>ES</urn1:Language>
		<!--Optional:-->
		<urn:TrackingCode></urn:TrackingCode>
		<!--Optional:-->
		<urn:ExpirationTime>120</urn:ExpirationTime>
		<!--Optional:-->
		<urn:FilterBy></urn:FilterBy>
		<!--Optional:-->
		<urn:TransactionOkURL>www.google.com</urn:TransactionOkURL>
		<!--Optional:-->
		<urn:TransactionErrorURL>www.google.com</urn:TransactionErrorURL>
		<!--Optional:-->
		<urn:TransactionExpirationTime></urn:TransactionExpirationTime>
		<!--Optional:-->
		<urn:CustomMerchantName>Pruebas</urn:CustomMerchantName>
		<!--Optional:-->
		<urn:ShopperEmail>cbahamonde@safetypay.com</urn:ShopperEmail>
		<!--Optional:-->
		<urn:Signature>**************************************</urn:Signature>
		<urn:LocalizedCurrencyID></urn:LocalizedCurrencyID>
		<urn:ShopperInformation>
		<!--Zero or more repetitions:-->
		<urn:ShopperFieldType Key="?" Value="?"/>
		<urn1:ShopperField Key="ShopperInformation_email" Value="cecigabi92@gmail.com"/>
		<urn1:ShopperField Key="ShopperInformation_phone" Value="78989"/></urn:ShopperInformation>
		</urn:ExpressTokenRequest>
		</soapenv:Body>
		</soapenv:Envelope>';
		
		try{
			$result = curlSafetypay($xml);
			return $result;			
		}catch(Exception $e){
			return 'Excepción capturada: '.  $e->getMessage();
		}
	}
	
	function GetNewOperationActivity(){
		$xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:safetypay:messages:mws:api">
				<soapenv:Header/>
				<soapenv:Body>
				<urn:OperationActivityRequest>
				<urn:ApiKey>**************************************</urn:ApiKey>
				<urn:RequestDateTime>2010-01-01T01:01:01</urn:RequestDateTime>
				<urn:Signature>**************************************</urn:Signature>
				</urn:OperationActivityRequest>
				</soapenv:Body>
				</soapenv:Envelope>';
		
		try{
			$result = curlSafetypay($xml);
			return $result;			
		}catch(Exception $e){
			return 'Excepción capturada: '.  $e->getMessage();
		}
	}
	
	function ConfirmNewOperationActivity(){
		$xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:safetypay:messages:mws:api">
				<soapenv:Header/>
				<soapenv:Body>
				<urn:OperationActivityNotifiedRequest>
				<urn:ApiKey>**************************************</urn:ApiKey>
				<urn:RequestDateTime>2010-01-10T01:01:01</urn:RequestDateTime>
				<urn:ListOfOperationsActivityNotified>
				<urn1:ConfirmOperation xmlns:urn1="urn:safetypay:schema:mws:api">
				<urn1:CreationDateTime>2010-01-01T01:01:01</urn1:CreationDateTime>
				<urn1:OperationID>0119031456493244</urn1:OperationID>
				<urn1:MerchantSalesID>MRN_20190131_041432_862</urn1:MerchantSalesID>
				<urn1:MerchantOrderID>MON_20190131_041432_862</urn1:MerchantOrderID>
				<urn1:OperationStatus>102</urn1:OperationStatus>
				</urn1:ConfirmOperation>
				</urn:ListOfOperationsActivityNotified>
				<urn:Signature>**************************************</urn:Signature>
				</urn:OperationActivityNotifiedRequest>
				</soapenv:Body>
				</soapenv:Envelope>';
		
		try{
			$result = curlSafetypay($xml);
			return $result;			
		}catch(Exception $e){
			return 'Excepción capturada: '.  $e->getMessage();
		}
	}
?>
