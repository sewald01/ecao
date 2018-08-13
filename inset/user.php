#!/usr/local/bin/php
<?php  session_start(); 

require("/home/content/48/7686848/html/includes/bv-library.php"); 
require("/home/content/48/7686848/html/inset/inset_includes/insetdb.php");
require("/home/content/48/7686848/html/inset/inset_includes/forms.php");

printHeader("Welcome to Brainvoyage.com");

//check if it is first time on the page or form submited

if ($Submit)
{
	// get time(seconds to epoch) = userID
	$user_id = time().rand(1,9);
	session_register(user_id);
	
	submit_form("user_answers",$user_id,$_POST);
	
	//print root menu |||||||||||||||||||||
	print ("\n  <br> \n <div align=center><a href=sobin.php>QUESTIONNAIRE SOBIN</a></div>");
}

else
{
	print_form("user_questions");
}

printFooter(); 
?>
