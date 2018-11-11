<?php
session_start();

if(!isset($_SESSION["uid"])){
	header("location:index.php");
}

?>
<?php
include "profile_header.php";

include "body.php";
include "newslettter.php";
include "footer.php";
?>

		