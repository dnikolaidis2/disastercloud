<?php
	require 'vendor/autoload.php';
	include 'Utils/Session.php';
	include 'Utils/TemplateManager.php';

	$session = Session::getInstance();

	if (!($session->logedin && isset($session->username))) {
	  header("Location: index.php");
	}

	$templates = new League\Plates\Engine('Templates');
	$templateManager = TemplateManager::getInstance($templates);

	$templateManager->renderTeacher();
?>