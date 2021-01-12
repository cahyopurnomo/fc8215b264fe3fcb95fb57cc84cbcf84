<?php

namespace Lulucode;

use Lulucode\Message;
use Lulucode\Database;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Queue {
	private static $queue = NULL;

	public static function getQueue(){
		self::$queue = msg_get_queue(getenv('QUEUE_KEY'));
		return self::$queue;
	}

	public static function addMessage($key, $data = array()){
		self::$queue = self::getQueue(getenv('QUEUE_KEY'));
		
		$message = new Message($key, $data);
		
		if( msg_send(self::$queue, getenv('QUEUE_TYPE_START'), $message) ){
			
			$mail = new PHPMailer();

			try {
				$mail->isSMTP();
				$mail->SMTPDebug 	= 2;
				$mail->Debugoutput 	= 'html';
				$mail->Host 		= getenv('MAIL_HOST');
				$mail->SMTPAuth 	= true;
				$mail->Username 	= getenv('MAIL_USERNAME');
				$mail->Password 	= getenv('MAIL_PASSWORD');
				$mail->SMTPSecure 	= getenv('MAIL_SECURE');
				$mail->Port 		= getenv('MAIL_PORT');

				$mail->setFrom($data['_from'], $data['_from_name']);
				$mail->addAddress($data['_to'], $data['_to_name']);
				$mail->isHTML(true);
				$mail->Subject 		= $data['_subject'];
				$mail->Body  		= $data['_body'];
				
				if( !$mail->send() ){
					echo $mail->ErrorInfo;
				}else{
					$dbConnection = (new Database())->connect();
					$query = "INSERT INTO mail_sent(_subject,_from,_to,_content) VALUES(:_subject,:_from, :_to, :_content);";
					$statement = $dbConnection->prepare($query);
					$statement->execute(array(
												'_subject' 	=> $data['_subject'],
												'_from' 	=> $data['_from'],
												'_to'  		=> $data['_to'],
												'_content'	=> $data['_body'],
											));

				    $response['status_code_header'] = 'HTTP/1.1 201 Created';
				    $response['body'] = json_encode(array('message' => 'Email Sent'));
				    return $response;
				}
			}catch (Exception $e ){
				exit($e->getMessage());
			}
			
		}else{
			echo 'Error adding to the queue';
		}
	}
}