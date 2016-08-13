#!/usr/local/bin/php
<?php 
session_start();
 // Date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
// always modified
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
// HTTP/1.1
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
// HTTP/1.0
header("Pragma: no-cache");


require("/home/content/48/7686848/html/includes/bv-library.php");

printHeader("Make a Comment About Cry the Beloved Mind"); 


foreach($_POST as $key => $value){
	$$key = $value;
}


if($_POST['submission'] == 1){
if (md5(strtoupper($_POST['secure_number'])) == $_SESSION['securenum']) { 

echo <<<EOD

<h3 class="title" align="center">Thank you for your submission!</h3>
<br><br>
Thank you for your comments on the book "Cry the Beloved Mind" at 
<a href="http://www.brainvoyage.com/">http://www.brainvoyage.com/</a>.  We appreciate your 
feedback and would like to consider sharing it with others who visit this site.
<p>Please understand that your comments may or may not be used. If used, 
they be in full or abbreviated format which may imply ensuring full 
sentences or phrases so that words like "the" may be added or subtracted.
<br><br>
Also, we still may not identify you by name even if you have given such 
permission to do so.
<br><br>
If you have indicated that we can identify this as your quotation, we
may contact you again by Email , fax and/or phone if we need to. For
examples of how comments have been cited on our website, please go to
<a href="http://www.brainvoyage.com/ctbm/comments.php#readers">http://www.brainvoyage.com/ctbm/comments.php#readers</a>
<br><br>
Your comments about the book may be used by Brainquest Press in any
promotion (internet or other) entirely at our discretion You will not be
remunerated for such comments and the comments become the sole property
of Brainquest Press.
<br><br>
You will understand that only a proportion of the comments made can be
listed and publication of such comments also is at the sole discretion
of Brainquest Press. The order or section in which the comments appear 
is also at our discretion.
</p>
EOD;

$note = <<<EOD
A Comment on "Cry the Beloved Mind" has been submitted.
---------------------------------------
Name: $name
E-Mail: $email
Profession: $profession
City, State: $citystate
Mention Name: $name_mention
Fax: $fax
Phone: $phone
-----Comments-----
$comments
------------------
End of Message
EOD;

/* ----------- OLD MESSAGE ---------------

Thank you for your comments on the book "Cry the Beloved Mind" at 
http://www.brainvoyage.com/.  We appreciate your 
feedback and would like to consider sharing it with others who visit 
this site.\n
However, first we want to confirm that it was you indeed who actually 
made the comments.  Consequently, we are sending this EMail to you.  
You need only press "reply" to send this EMail back. Sending this 
reply to this EMail is your official permission to use the comments 
you have made.\n
Please understand that your comments may or may not be used. If used, 
they be in full or abbreviated format which may imply ensuring full 
sentences or phrases so that words like "the" may be added or subtracted.\n
Also, we still may not identify you by name even if you have given such 
permission to do so.\n
If you have indicated that we can identify this as your quotation, we
may contact you again by Email , fax and/or phone if we need to. For
examples of how comments have been cited on our website, please go to
http://www.brainvoyage.com/ctbm/comments.php#readers
\n
Your comments about the book may be used by Brainquest Press in any
promotion (internet or other) entirely at our discretion You will not be
remunerated for such comments and the comments become the sole property
of Brainquest Press.\n
You will understand that only a proportion of the comments made can be
listed and publication of such comments also is at the sole discretion
of Brainquest Press. The order or section in which the comments appear 
is also at our discretion.

*/


$x = mail("questions@brainvoyage.com", "Comments on Cry the Beloved Mind",$note, "From: $email");
printFooter();
exit;
}
else{
print("<br><p><strong><font color=\"red\" size=\"+1\">The <a href=\"#pic\">secure number</a> you entered (</font>".$secure_number."<strong><font size=\"+1\" color=\"red\">) does not correspond with the picture.</p><p>Please try again.</p></strong><br></font>");
}
}
?>
<script language="JavaScript" type="text/javascript">
<!--
function checkform ( form )
{
  // see http://www.thesitewizard.com/archive/validation.shtml
  // for an explanation of this script and how to use it on your
  // own website

  // ** START **
  if (form.email.value == "") {
    alert( "Please enter your email address." );
    form.email.focus();
    return false ;
  }
  // ** END **
  return true ;
}
//-->
</script>
<h1 class="title" align="center">Comment on Cry the Beloved Mind</h1>

<br><br>


<p align="center"><small><small>note:
you need not fill in phone and fax number and you can use initials for your 
name if you prefer.</small></small></p>
<FORM METHOD=post ACTION="/questions.php" onsubmit="return checkform(this);">
<table align=center border=0 cellpadding=2 cellspacing=3>
<tr>
	<td valign="top">Your name:</td>
	<td valign="top"><Input type="text" name="name" size="50" value="<?php echo $_POST['name'];?>"></td>
</tr>
<tr>
	<td valign="top">Your E-mail address:</td>
	<td valign="top"><Input type="text" name="email" size="50" value="<?php echo $_POST['email'];?>"></td>
</tr>
<tr>
	<td valign="top">Profession or relevant self-description :</td> 
	<td valign="top"><SELECT NAME="profession">
		<OPTION <?php if($_POST['profession']=="general_reader" || $_POST['profession']==""){ print("selected ");} ?> value="general_reader">general reader
		<OPTION <?php if($_POST['profession']=="patient"){ print("selected ");} ?>value="patient">patient
		<OPTION <?php if($_POST['profession']=="family_member"){ print("selected ");} ?>value="family_member">family member
		<OPTION <?php if($_POST['profession']=="MD"){ print("selected ");} ?>value="MD">MD
		<OPTION <?php if($_POST['profession']=="PhD"){ print("selected ");} ?>value="PhD">PhD
		<OPTION <?php if($_POST['profession']=="psychologist"){ print("selected ");} ?>value="psychologist">psychologist
		<OPTION <?php if($_POST['profession']=="psychiatrist"){ print("selected ");} ?>value="psychiatrist">psychiatrist
		<OPTION <?php if($_POST['profession']=="neurologist"){ print("selected ");} ?>value="neurologist">neurologist
		<OPTION <?php if($_POST['profession']=="pharmacologist"){ print("selected ");} ?>value="pharmacologist">pharmacologist
		<OPTION <?php if($_POST['profession']=="pharmacist"){ print("selected ");} ?>value="pharmacist">pharmacist
		<OPTION <?php if($_POST['profession']=="student"){ print("selected ");} ?>value="student">student
		<OPTION <?php if($_POST['profession']=="author"){ print("selected ");} ?>value="author">author
		<OPTION <?php if($_POST['profession']=="educator"){ print("selected ");} ?>value="educator">educator
		<OPTION <?php if($_POST['profession']=="other"){ print("selected ");} ?>value="other">other
		</SELECT></td>
</tr>
<tr>
	<td valign="top">City, State, (and country if outside the USA):</td>
	<td valign="top"><Input type="text" name="citystate" size="50" value="<?php echo $_POST['citystate'];?>"></td>
</tr>
<tr>
	<td valign="top">Do you want your name mentioned? (Even if you say "yes" we may choose not to):</td>
	<td valign="top"><SELECT NAME="name_mention">
		<OPTION <?php if($_POST['name_mention']=="yes" || $_POST['profession']==""){ print("selected ");} ?>selected value="yes">yes
		<OPTION <?php if($_POST['name_mention']=="no"){ print("selected ");} ?>value="no">no
		</SELECT></td>
</tr>
<tr>
	<td valign="top">5. Your fax number (this may be used to confirm your quotation):</td>
	<td valign="top"><Input type="text" name="fax" size="50" value="<?php echo $_POST['fax'];?>"></td>
</tr>
<tr>
	<td valign="top">6. Phone number:</td>
	<td valign="top"><Input type="text" name="phone" size="50" value="<?php echo $_POST['phone'];?>"></td>
</tr>
<tr>
	<td colspan=2>
	<p>
        Please understand that your comments may or may not be used in full or
abbreviated format. Also, we still may not  identify you by name if you
give such permission to do so. If you indicate we can identify you, we
may contact you by EMail , fax and / or phone to confirm that the
comments are attributable to you.
Your phone and fax number are for us to contact you. These will not appear on 
the website if your comments are published.&nbsp; The comments may be used by Brainquest
Press in promotion.<br>
        <br>
	</td>
</tr>
<tr>
	<td valign=top>Comments:</td>
	<td><textarea name="comments" rows="20" cols="45" wrap><?php echo $_POST['comments'];?></textarea></td>
</tr>
<tr>
	<td colspan=2 align=center>
<?php

$picpath = "/home/content/48/7686848/html/images/securepic/word.jpg";
$hpicpath = "http://www.brainvoyage.com/images/securepic/word.jpg";
//$template = imagecreate(60,30);
//$white = imagecolorallocate($template, rand(1,250), rand(1,250), 60);

$alphanum = "A B C D E F G H I J K L M N P Q R S T U V W X Y 1 2 3 4 5 6 8 9";
$parts = explode(" ",$alphanum);
// generate the verication code
for($i=0;$i<5;$i++){
	$rand .= $parts[rand(0,32)];
}
// choose one of four background images
$bgNum = rand(3, 4);
$image = imagecreatefromjpeg("images/securepic/background$bgNum.jpg");
$textColor = imagecolorallocate ($image, 0, 0, 0);
// write the code on the background image
imagestring ($image, 5, 5, 8, $rand, $textColor); 

/*$left = -3;
for($i=0;$i<5;$i++){
	$char = rand(1,9);
	$pnum .= $char;
	$left += rand(10,13);
	imagechar($template,5,($left),rand(1,22),$char,255);
	
}
*/


fopen($picpath,"w+");
imagejpeg($image,$picpath);
imagedestroy($image);
session_unset();
$_SESSION['securenum'] = md5($rand);


print('<img src="http://www.brainvoyage.com/images/securepic/word.jpg" />');
?>
<a name="pic" id="pic"></a><br>Enter the number you see above: <input type="text" name="secure_number"><br>

	<input type="hidden" name="submission" value="1"><INPUT TYPE="submit" value="Send Mail"><INPUT TYPE="reset" value="Reset Form"></td>
</tr>
</table>
</FORM>
<H3 class="title" align=center>Thanks!</H3>
<?php
printFooter();

?>