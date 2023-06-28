<?php
session_start();
include('db_connect.php');
	extract($_POST);
	$data = " name = '$name' ";
	$data .= ", username = '$username' ";
	$data .= ", password = '$password' ";

	$update= $conn->query("UPDATE users set ".$data." where id =".$id);
	if($update){
		$_SESSION['login_name'] = $name;
		$_SESSION['login_username'] = $username;
		echo 1;
	}