<?php

namespace Lulucode;

use Lulucode\Queue;

class Post {
	private $requestMethod;

	public function __construct($requestMethod){
		$this->requestMethod = $requestMethod;
	}

	public function processRequest(){
		switch ($this->requestMethod) {
			case 'GET':
				$response = $this->sendMail();
				break;
			case 'POST':
				// $response = $this->sendMail();
				break;
			default:
				$response = $this->notFoundResponse();
				break;
		}

		header( $response['status_code_header'] );

		if( $response['body'] ){
			echo $response['body'];
		}
	}

  	private function sendMail(){
  		$key = '12345';

		$data = array( 
						'_from' 		=> getenv('MAIL_FROM'), 
						'_from_name' 	=> getenv('MAIL_SURENAME'), 
						'_to' 			=> getenv('MAIL_TO'), 
						'_to_name' 		=> getenv('MAIL_TO_NAME'),
						'_subject' 		=> getenv('MAIL_SUBJECT'),
						'_body' 		=> getenv('MAIL_BODY'),
					);

		Queue::addMessage($key, $data);
	}

  	private function notFoundResponse(){
	    $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
	    $response['body'] = null;
	    return $response;
  	}
}