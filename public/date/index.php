<?php 
session_start();
if(!isset($_SESSION['user_session_']) && (!isset($_SESSION['userId_session_'])))
{
	header("Location: ../login.php");
}
?>