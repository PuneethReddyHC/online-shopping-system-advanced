<?php 
session_start();
if(isset($_SESSION['admin_id'])&& $_SESSION['admin_id']!="")
{
    
}
else
{
   header("location: login.php");
}

$inactive=1000;
if(isset($_SESSION['timeout']))
{
	$sessionttl=time()- $_SESSION['timeout'];
	if($sessionttl > $inactive)
	{
	session_destroy();
	header("location:logout.php");	
	}	
}
$_SESSION['timeout']=time();
?>