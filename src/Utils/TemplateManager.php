<?php

	class TemplateManager
	{
		
		private $engine;
		private static $instance;

		private function __construct() {}

		public static function getInstance(League\Plates\Engine $templates = null)
		{
			if ( !isset(self::$instance))
			{
				self::$instance = new self;
				self::$instance->setEngine($templates);
			}

			return self::$instance;
		}

		public function setEngine(League\Plates\Engine $engine)
		{
			$this->engine = $engine;
		}

		public function renderIndexLogin($error_message = null, $modal_error_message = null)
		{
			$data = [];
			if ($error_message !== null) 
			{
				$data['login'] = ['active' => true, 'error' => true, 'message' => $error_message];
			}
			else
			{
				$data['login'] = ['active' => true, 'error' => false, 'message' => ""];
			}

			$data['signup'] = ['active' => false, 'error' => false, 'message' => ""];

			if ($modal_error_message !== null) 
			{
				$data['modal'] = ['active' => true, 'message' => $modal_error_message];
			}
			else
			{
				$data['modal'] = ['active' => false, 'message' => ""];
			}

			echo $this->engine->render('index', $data);
		}

		public function renderIndexSignup($error_message = null, $modal_error_message = null)
		{
			$data = [];
			if ($error_message !== null) 
			{
				$data['signup'] = ['active' => true, 'error' => true, 'message' => $error_message];
			}
			else
			{
				$data['signup'] = ['active' => true, 'error' => false, 'message' => ""];
			}

			$data['login'] = ['active' => false, 'error' => false, 'message' => ""];

			if ($modal_error_message !== null) 
			{
				$data['modal'] = ['active' => true, 'message' => $modal_error_message];
			}
			else
			{
				$data['modal'] = ['active' => false, 'message' => ""];
			}

			echo $this->engine->render('index', $data);
		}

		public function renderTeacher()
		{
			echo $this->engine->render('Teacher');
		}

	}

?>