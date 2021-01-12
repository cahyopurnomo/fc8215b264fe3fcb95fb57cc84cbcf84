<?php

namespace Lulucode;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Post {
	private $db;
	private $requestMethod;
	private $postId;

	public function __construct($db, $requestMethod, $postId){
		$this->db = $db;
		$this->requestMethod = $requestMethod;
		$this->postId = $postId;
	}

	public function processRequest(){
		switch ($this->requestMethod) {
			case 'GET':
				if( $this->postId !== null ){
					$response = $this->getPost($this->postId);
				}else{
					$response = $this->getAllPost();
				}
				break;
			case 'POST':
				$response = $this->createPost();
				break;
			case 'PUT':
				$response = $this->updatePost($this->postId);
				break;
			case 'DELETE':
				$response = $this->deletePost($this->postId);
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

	private function getAllPost(){
		$query = "SELECT * FROM city;";

	    try {
	      $statement = $this->db->query($query);
	      $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
	    } catch (\PDOException $e) {
	      exit($e->getMessage());
	    }

	    $response['status_code_header'] = 'HTTP/1.1 200 OK';
	    $response['body'] = json_encode($result);
	    return $response;
	}

	private function getPost($id){
	    $result = $this->find($id);

	    if (! $result) {
	        return $this->notFoundResponse();
	    }

	    $response['status_code_header'] = 'HTTP/1.1 200 OK';
	    $response['body'] = json_encode($result);
	    return $response;

	}

	public function find($id){
	    $query = "SELECT * FROM city WHERE ID = id;";

	    try {
	      $statement = $this->db->prepare($query);
	      $statement->execute(array('id' => $id));
	      $result = $statement->fetch(\PDO::FETCH_ASSOC);
	      return $result;
	    } catch (\PDOException $e) {
	      exit($e->getMessage());
	    }
  	}

  	private function createPost(){
	    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
	    $query = "INSERT INTO mail_sent(_from,_to,_content) VALUES(:_from, :_to, :_content);";

	    try {
			$statement = $this->db->prepare($query);
			$statement->execute(array(
			'_from' 	=> $input['from'],
			'_to'  		=> $input['to'],
			'_content'	=> $input['content'],
			));
			
			$statement->rowCount();

	    } catch (\PDOException $e) {
	      	exit($e->getMessage());

	    }

	    $response['status_code_header'] = 'HTTP/1.1 201 Created';
	    $response['body'] = json_encode(array('message' => 'Post Created'));
	    return $response;
	  }

  	private function notFoundResponse(){
	    $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
	    $response['body'] = null;
	    return $response;
  	}
}