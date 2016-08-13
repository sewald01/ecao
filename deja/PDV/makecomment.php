#!/usr/local/bin/php

<?php
require("/home/content/48/7686848/html/includes/bv-library.php");

printHeader("Make a Comment About The Psychology Of D&eacute;j&agrave; Vu"); 
foreach($_POST as $key => $value){
	$$key = $value;
}
if($submission == 0) {
echo <<<EOD
<h1 class="title" align="center">Comment on The Psychology Of D&eacute;j&agrave; Vu</h1>

<br><br>


<p align="center"><small><small>note:
you need not fill in phone and fax number and you can use initials for your 
name if you prefer.</small></small></p>
<FORM METHOD=post ACTION="/ctbm/makecomment.php">
<table align=center border=0 cellpadding=2 cellspacing=3>
<tr>
	<td valign="top">Your name:</td>
	<td valign="top"><Input type="text" name="name" size="50"></td>
</tr>
<tr>
	<td valign="top">Your E-mail address:</td>
	<td valign="top"><Input type="text" name="email" size="50"></td>
</tr>
<tr>
	<td valign="top">Profession or relevant self-description :</td> 
	<td valign="top"><SELECT NAME="profession">
		<OPTION selected value="general_reader">general reader
		<OPTION value="patient">patient
		<OPTION value="family_member">family member
		<OPTION value="MD">MD
		<OPTION value="PhD">PhD
		<OPTION value="psychologist">psychologist
		<OPTION value="psychiatrist">psychiatrist
		<OPTION value="neurologist">neurologist
		<OPTION value="pharmacologist">pharmacologist
		<OPTION value="pharmacist">pharmacist
		<OPTION value="student">student
		<OPTION value="author">author
		<OPTION value="educator">educator
		<OPTION value="other">other
		</SELECT></td>
</tr>
<tr>
	<td valign="top">City, State, (and country if outside the USA):</td>
	<td valign="top"><Input type="text" name="citystate" size="50"></td>
</tr>
<tr>
	<td valign="top">Do you want your name mentioned? (Even if you say "yes" we may choose not to):</td>
	<td valign="top"><SELECT NAME="name_mention">
		<OPTION selected value="yes">yes
		<OPTION value="no">no
		</SELECT></td>
</tr>
<tr>
	<td valign="top">5. Your fax number (this may be used to confirm your quotation):</td>
	<td valign="top"><Input type="text" name="fax" size="50"></td>
</tr>
<tr>
	<td valign="top">6. Phone number:</td>
	<td valign="top"><Input type="text" name="phone" size="50"></td>
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
	<td><textarea name="comments" rows="20" cols="45" wrap></textarea></td>
</tr>
<tr>
	<td colspan=2 align=center><input type="hidden" name="submission" value="1"><INPUT TYPE="submit" value="Send Mail"><INPUT TYPE="reset" value="Reset Form"></td>
</tr>
</table>
</FORM>
<H3 class="title" align=center>Thanks!</H3>
<script type="text/javascript">
<!--
window.onload=openmenu('menu5');
//-->
</script>

EOD;
}else{
echo <<<EOD

<h3 class="title" align="center">Thank you for your submission!</h3>
<br><br>
You will be getting a confirmation email shortly asking you to verify your comments. Please read
this and reply to the message as indicated in the instructions. 
EOD;

$note = <<<EOD
Thank you for your comments on the book "The Psychology Of D&eacute;j&agrave; Vu" at 
http://www.brainvoyage.com/.  We appreciate your 
feedback and would like to consider sharing it with others who visit 
this site.\n
However, first we want to confirm that it was you indeed who actually 
made the comments.  Consequently, we are sending this EMail to you.  
YOU NEED ONLY PRESS "REPLY" to send this EMail back. Sending this 
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
Your comments about the book may be used by Brainvoyage.com in any
promotion (internet or other) entirely at our discretion You will not be
remunerated for such comments and the comments become the sole property
of Brainquest Press.\n
You will understand that only a proportion of the comments made can be
listed and publication of such comments also is at the sole discretion
of Brainquest Press. The order or section in which the comments appear 
is also at our discretion.
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

$x = mail($email, "Comments on The Psychology Of D&eacute;j&agrave; Vu",$note, "From: comments@brainvoyage.com\nReply-To: comments@brainvoyage.com\ncc: comments@brainvoyage.com");
}


 printFooter(); ?>



