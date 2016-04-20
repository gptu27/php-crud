<?php
	error_reporting(1);
	header('Content-Type: text/html; charset=utf-8');

	$username = "root";
	$password = "";
	$hostname = "localhost";

	//connection to the database
	$dbhandle = mysql_connect($hostname, $username, $password) or die("Unable to connect to MySQL");
	mysql_query('SET NAMES utf8');
	mysql_select_db("phonebook") or die(mysql_error());

	?>
