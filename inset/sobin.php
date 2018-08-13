#!/usr/local/bin/php
<?php  session_start(); 

require("/home/content/48/7686848/html/includes/bv-library.php"); 
require("/home/content/48/7686848/html/inset/inset_includes/insetdb.php");
require("/home/content/48/7686848/html/inset/inset_includes/forms.php");

printHeader("Welcome to Brainvoyage.com");

//check if it is first time on the page or form submited

if ($Submit)
{
	$readabeT = strftime("%D %R");
	// user_id from session
	submit_form("sobin_answers",$user_id,$_POST);
}

else
{
	print_form("sobin_questions");
}
	
printFooter(); 
?>
