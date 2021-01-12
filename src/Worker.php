<?php

namespace Lulucode;

use Lulucode\Queue;

class Worker {
	private $queue = NULL;
	private $message = NULL;

	public function __construct() {
		echo 'Worker started ....';
		$this->queue = Queue::getQueue();
		$this->process();
	}

	public function process(){
		
		$messageType = NULL;
		$messageMaxSize = 1024;

		while( msg_receive($this->queue, getenv('QUEUE_TYPE_START'), $messageType, $messageMaxSize, $this->message) ){
			$this->complete($messageType, $this->message);
			$messageType = NULL;
			$this->message = NULL;
		}
	}

	private function complete($messageType, Message $message){
		echo $message->getKey();
	}
}