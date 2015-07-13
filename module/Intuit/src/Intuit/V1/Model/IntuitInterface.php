<?php
namespace Intuit\V1\Model;

require_once( APPLICATION_PATH . '/module/Intuit/src/Intuit/V1/Model/IntuitInterface/aggcatauth.php' );
require_once( APPLICATION_PATH . '/module/Intuit/src/Intuit/V1/Model/IntuitInterface/OAuthSimple.php' );

class IntuitInterface {

	private $oauth_token = null, $oauth_token_secret = null;
	
	private function initializeSession( $sessionId ) {
	
		\IntuitAggCatHelpers::GetOAuthTokens( $sessionId, 
											 $oauth_token, 
											 $oauth_token_secret);
		
		$this->oauth_token = $oauth_token;
		$this->oauth_token_secret = $oauth_token_secret;
	}

	public function deleteAccount( $customerId, $accountId ) {

			
		$action = 'DELETE';
		$url = 'v1/accounts/' . $accountId;

		$this->initializeSession( $customerId );
		return( $this->sendJSONRequest( $action, $url ) );
		
	}
	
	public function deleteCustomer( $customerId )  {
	
		$action = 'DELETE';
		$url = 'v1/customers';
		
		$this->initializeSession( $customerId );
		return( $this->sendJSONRequest( $action, $url ) );
	}

	public function discoverAndAddAccounts( $customerId, $institutionId, $institutionLoginParameters ) {
	
		$action = 'POST';
		$url = 'v1/institutions/' . $institutionId . '/logins';
		$postData['credentials']['credential'] = $institutionLoginParameters;

		$this->initializeSession( $customerId );	
		return( $this->sendJSONRequest( $action, $url, array(), $postData ) );
		
	}
	
	public function discoverAndAddAccountsChallenge( $customerId,
													 $institutionId,
													 $challengeNodeId,
													 $challengeSessionId,
													 $challengeResponses ) {
													 
		$action = 'POST';
		$url = 'v1/institutions/' . $institutionId . '/logins';
		$headerAttribs = array ( 'challengeNodeId: ' .  $challengeNodeId,
								 'challengeSessionId: ' .  $challengeSessionId
		);

		$postData['challengeResponses'] = new \stdClass;
		$postData['challengeResponses']->response = $challengeResponses;

		$this->initializeSession( $customerId );		
		return( $this->sendJSONRequest( $action, $url, array(), $postData, $headerAttribs ) );	
	}
		
	public function getAccount( $customerId, $accountId ) {
	
		$action = 'GET';
		$url = 'v1/accounts/' . $accountId;

		$this->initializeSession( $customerId );		
		return( $this->sendJSONRequest( $action, $url ) );
	}
	
	public function getAccountTransactions( $customerId,
											$accountId,
											$txnStartDate, 
											$txnEndDate = null ) {
	
		$action = 'GET';
		$url = 'v1/accounts/' . $accountId . '/transactions';
		$parameters['txnStartDate'] = $txnStartDate;
		
		if( $txnEndDate != null )
			$parameters['txnEndDate'] = $txnEndDate;

		$this->initializeSession( $customerId );		
		return( $this->sendJSONRequest( $action, $url, $parameters ) );
	}
	
	public function getCustomerAccounts( $customerId ) {
	
		$action = 'GET';
		$url = 'v1/accounts';

		$this->initializeSession( $customerId );				
		return( $this->sendJSONRequest( $action, $url ) );
	}
	
	public function getInstitutionDetails( $customerId, $institutionId ) {
	
		$action = 'GET';
		$url = 'v1/institutions/' . $institutionId;

		$this->initializeSession( $customerId );						
		return( $this->sendJSONRequest( $action, $url ) );
	}
	
	public function getInstitutions( $customerId ) {
	
		$action = 'GET';
		$url = 'v1/institutions';
		
		$this->initializeSession( $customerId );				
		return( $this->sendJSONRequest( $action, $url ) );	
	}
	
	public function getInvestmentPositions( $customerId, $accountId ) {
	
		$action = 'GET';
		$url = 'v1/accounts/' . $accountId . '/positions';
		
		$this->initializeSession( $customerId );				
		return( $this->sendJSONRequest( $action, $url ) );
	}
	
	public function getLoginAccounts( $customerId, $loginId ) {
	
		$action = 'GET';
		$url = 'v1/logins/' . $loginId . '/accounts';
	
		$this->initializeSession( $customerId );				
		return( $this->sendJSONRequest( $action, $url ) );
	}

	public function updateAccountType( $customerId,
										$accountId,
										$accountClassification,
										$accountType ) {
	
		$action = 'PUT';
		$url = 'v1/accounts/' . $accountId;
		$parameters[$accountClassification] = $accountType;

		$this->initializeSession( $customerId );					
		return( $this->sendJSONRequest( $action, $url, $parameters ) );	
	}
	
	public function updateInstitutionLogin( $customerId,
											$loginId, 
											$isRefreshReqd, 
											$institutionLoginParameters ) {
	
		$action = 'PUT';
		$url = 'v1/logins/' . $loginId . '/?refresh=' . (($isRefreshReqd)?('true'):('false'));
		
		$this->initializeSession( $customerId );					
		return( $this->sendJSONRequest( $action, $url, array() ) );
	}
	
	public function updateInstitutionLoginChallenge( $customerId,
													 $loginId,
													 $challengeNodeId,
													 $challengeSessionId,
													 $challengeResponses ) {

		$headerAttribs = array ( 'challengeNodeId: ' .  $challengeNodeId,
								 'challengeSessionId: ' .  $challengeSessionId
		);
	
		$action = 'PUT';
		$url = 'v1/logins/' . $loginId;													 
		$postData['challengeResponses'] = new \stdClass;
		$postData['challengeResponses']->response = $challengeResponses;

		$this->initializeSession( $customerId );		
		return( $this->sendJSONRequest( $action, $url, array(), $postData, $headerAttribs ) );	
	}

	public function listFiles() {
	
		$action = 'GET';
		$url = 'v1/export/files/';

		$this->initializeSession( BATCH_AUTH_ID  );					
		return( $this->sendXMLRequest( $action, $url ) );
	}

	public function getFileData( $filename ) {
	
		$action = 'GET';
		$url = 'v1/export/files/' . $filename;

		$this->initializeSession( BATCH_AUTH_ID  );					
		return( $this->sendOctetRequest( $action, $url ) );
	}

	public function deleteFile( $filename ) {
	
		$action = 'DELETE';
		$url = 'v1/export/files/' . $filename;

		$this->initializeSession( BATCH_AUTH_ID  );					
		return( $this->sendJSONRequest( $action, $url ) );
	}	

	private function jsonDateConversion( $milliseconds ) {
		
		return( date( "Y-m-d h:i:s", floor( $milliseconds / 1000 ) ) );
	}
	
	private function traverseResponse( $object ) {
	
		if( is_array( $object ) ) {
			foreach( $object as $key => $value ) {
				if( is_string( $key ) && ( substr( $key, -4 ) == 'Date' ) )
					$object[$key] = $this->jsonDateConversion( $value );
				$this->traverseResponse( $value );
			}
		} else if( is_object( $object ) ) {
			foreach( get_object_vars( $object ) as $property => $value ) {
				if( is_string( $property ) && ( substr( $property, -4 ) == 'Date' ) )
					$object->$property = $this->jsonDateConversion( $value );
				$this->traverseResponse( $value );
			}
		}
	}
	
	private function getHeaderAttributes( $header, $header_size ) {

		$headerAttribs = array();
		
		$lines = explode( "\n", substr( $header, 0, $header_size ) );

		foreach( $lines as $line ) {			
			$colon = strpos( $line, ':' );
			if( $colon != false ) {
				$headerAttribs[substr( $line, 0, $colon )] = substr( $line, $colon+2, -1  );
			}
		}

		return $headerAttribs;
	}
	
	private function processResponse( $r, $ch ) {
		
		$response = new \stdClass;

		$header_size = curl_getinfo( $ch, CURLINFO_HEADER_SIZE );
		$header = substr( $r, 0, $header_size );
		error_log( var_export( $header, true ) );
		$body = substr( $r, $header_size );
		error_log( var_export( $body, true ) );

		$contentType = curl_getinfo( $ch, CURLINFO_CONTENT_TYPE );

		$responseData = '';
		switch( $contentType ) {
			case 'application/json':
				$responseData = json_decode( $body );
				break;
			case 'application/xml':
				$xml = simplexml_load_string( $body );
				$json = json_encode( $xml );
				$responseData = json_decode( $json );
				break;
			case 'application/octet-stream':
				$gzdata = gzdecode( $body );
				/*
				$xml = simplexml_load_string( $gzdata );
				$json = json_encode( $xml );
				$responseData = json_decode( $json );
				*/
				$responseData = $gzdata;
				break;
		}

		error_log( var_export( $responseData, true ) );

		$this->traverseResponse( $responseData );

		
		switch( curl_getinfo( $ch, CURLINFO_HTTP_CODE ) ) {
			case 200:
			case 201:
				$response->result = 'success';
				$response->data = $responseData;
				break;
			case 401:
				if( strpos( $header, 'challengeNodeId' ) != false ) {
					$headerAttribs = $this->getHeaderAttributes( $header, $header_size );
					$response->result = 'challenge';
					$jsonResponse->challengeNodeId = $headerAttribs['challengeNodeId'];
					$jsonResponse->challengeSessionId = $headerAttribs['challengeSessionId'];
					$response->data = $responseData;
					break;
				}
			case 400:
			case 403:
			case 404:
			case 408:
			case 500:
			case 503:
			default:
				$response->result = 'error';
				if( isset( $responseData->errorInfo ) )
					$response->error = $responseData->errorInfo;
				else
					$response->error = $r;
		}
		
		return( $response );
	}
	
	private function authorizeRequest( $action, $requestURL, $parameters ) {

		$signatures = array( 'consumer_key'     => OAUTH_CONSUMER_KEY,
						 'shared_secret'    => OAUTH_SHARED_SECRET,
						 'oauth_token'      => $this->oauth_token,
						 'oauth_secret'     => $this->oauth_token_secret);
	
		$oauthObject = new \OAuthSimple();
		$oauthObject->setAction( $action );
		$oauthObject->reset();
		
		$parameters['oauth_signature_method'] = 'HMAC-SHA1';
		$parameters['Host'] = FINANCIAL_FEED_HOST;

		error_log( var_export( $oauthObject, true ) );
		
		return( $oauthObject->sign(array(
								'path'      => FINANCIAL_FEED_URL . $requestURL,
								'parameters'=> $parameters, 
								'signatures'=> $signatures))
		);
		
	}


	private function sendOctetRequest( 
																$action, 
																$requestURL, 
																$parameters = array(), 
																$postData = array(),
																$headerAttribs = array() ) {


		$headerAttribs = array_merge( 
								array (
										'Accept-Encoding: gzip,deflate',
									),
								$headerAttribs
						);

		return $this->sendRequest( $action, $requestURL, $parameters, $postData, $headerAttribs );
	}

	private function sendXMLRequest( 
																$action, 
																$requestURL, 
																$parameters = array(), 
																$postData = array(),
																$headerAttribs = array() ) {


		$headerAttribs = array_merge( 
								array (
										'Accept: application/xml',
										'Accept-Encoding: gzip,deflate',
									),
								$headerAttribs
						);

		return $this->sendRequest( $action, $requestURL, $parameters, $postData, $headerAttribs );
	}

	private function sendJSONRequest( 
																$action, 
																$requestURL, 
																$parameters = array(), 
																$postData = array(),
																$headerAttribs = array() ) {

		$headerAttribs = array_merge( 
						array (
								'Accept: application/json',
							),
						$headerAttribs
				);

		return $this->sendRequest( $action, $requestURL, $parameters, $postData, $headerAttribs );

	}

	private function sendRequest( 
																$action, 
																$requestURL, 
																$parameters = array(), 
																$postData = array(),
																$headerAttribs = array() ) {

		$auth = $this->authorizeRequest( $action, $requestURL, $parameters );

		$headerAttribs = array_merge( 
								array (
										'Host: '. FINANCIAL_FEED_HOST
									),
								$headerAttribs
						);

		$parameters = array_merge( $auth['parameters'], $parameters );

		$options = array();
		$options[CURLOPT_VERBOSE] = 0;
		$options[CURLOPT_RETURNTRANSFER] = 1;
		$options[CURLOPT_HEADER] = 1;
		$options[CURLOPT_SSL_VERIFYPEER] = 0;
		$options[CURLINFO_HEADER_OUT] = 1;
		$options[CURLOPT_CUSTOMREQUEST] = $action;
		$options[CURLOPT_URL] = $auth['signed_url'];
						
		if( ( $action == 'POST' ) && ( $postData != null ) ) {
		
			$options[CURLOPT_POST] = true;
			if( isset( $postData['xml'] ) ) {
				$headerAttribs[] = 'Content-Type: application/xml';
				$headerAttribs[] = 'Content-Length: ' . strlen( $postData['xml'] );
				$options[CURLOPT_POSTFIELDS] = $postData['xml'];
			} else {
				$json = json_encode( $postData );

				$headerAttribs[] = 'Content-Type: application/json';
				$headerAttribs[] = 'Content-Length: ' . strlen( $json );
				$options[CURLOPT_POSTFIELDS] = $json;
			}
		}
		
		$options[CURLOPT_HTTPHEADER] = $headerAttribs;

		$ch = curl_init();
		curl_setopt_array( $ch, $options );
		$r = curl_exec( $ch );

		$response = $this->processResponse( $r, $ch );
		
		return( $response );
	}
}