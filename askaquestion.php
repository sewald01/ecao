#!/usr/local/bin/php
<?php
session_start();
require("/home/content/48/7686848/html/includes/bv-library.php");

printHeader("Ask a Question About ".$_GET['book']); 
foreach($_POST as $key => $value){
	$$key = $value;
}
if($submission == 0) {

echo '<h1 class="title" align="center">Ask a Question on '.$_GET['book'].'</h1>';
echo <<<EOD
<br><br>


<p align="center"><small><small>note:
you need not fill in phone and fax number and you can use initials for your 
name if you prefer.</small></small></p>
<FORM METHOD=post ACTION="askaquestion.php">
<table align=center border=0 cellpadding=2 cellspacing=3>
<tr>
	<td colspan=2>
	<p>
        Instead of making a comment, you have the opportunity to ask a question of the authors. Some  will be chosen and  answered from time to time. Please ask us, so we understand what we should include in our next book.<br>
        <br>
	</td>
</tr>

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
<!--<tr>
	<td valign="top">Do you want your name mentioned? (Even if you say "yes" we may choose not to):</td>
	<td valign="top"><SELECT NAME="name_mention">
		<OPTION selected value="yes">yes
		<OPTION value="no">no
		</SELECT></td>
</tr>-->
<tr>
	<td valign="top">5. Your fax number (this may be used to confirm your quotation):</td>
	<td valign="top"><Input type="text" name="fax" size="50"></td>
</tr>
<tr>
	<td valign="top">6. Phone number:</td>
	<td valign="top"><Input type="text" name="phone" size="50"></td>
</tr>
<tr>
	<td valign=top>Question:</td>
	<td><textarea name="comments" rows="20" cols="45" wrap>
EOD;
echo $_SESSION['commentcache'];
echo <<<EOD
</textarea></td>
</tr>
<tr>
	<td colspan=2 align=center>
	
	<input type="hidden" name="submission" value="1">
	
	
EOD;
	print '<input type="hidden" name="book" value="'.$_GET['book'].'">'."\n";
		$picpath = "/home/content/48/7686848/html/images/securepic/word.jpg";
		$hpicpath = "http://www.brainvoyage.com/images/securepic/word.jpg";
		//$template = imagecreate(60,30);
		//$white = imagecolorallocate($template, rand(1,250), rand(1,250), 60);
		
		$alphanum = "A B C D E F G H I J K L M N P Q R S T U V W X Y 1 2 3 4 5 6 8 9";
		$parts = explode(" ",$alphanum);
		// generate the verication code
		$rand;
		for($i=0;$i<5;$i++){
			$rand .= $parts[rand(0,32)];
		}
		// choose one of four background images
		$bgNum = rand(3, 4);
		$image = imagecreatefromjpeg("/home/content/48/7686848/html/images/securepic/background$bgNum.jpg");
		$textColor = imagecolorallocate ($image, 0, 0, 0);
		// write the code on the background image
		imagestring ($image, 5, 5, 8, $rand, $textColor); 
		
		
		
		fopen($picpath,"w+");
		imagejpeg($image,$picpath);
		imagedestroy($image);
		session_unset();
		$_SESSION['securenum'] = md5($rand);
		
		print('<img src="http://www.brainvoyage.com/images/securepic/word.jpg" />');
		
echo <<<EOD
 <a name="pic" id="pic"></a><br>Enter the number you see above: <input type="text" name="secure_number"><br>
	<INPUT TYPE="submit" value="Send Mail"><INPUT TYPE="reset" value="Reset Form"></td>
</tr>
</table>
</FORM>
<H3 class="title" align=center>Thanks!</H3>
EOD;
}else{

if (md5(strtoupper($_POST['secure_number'])) == $_SESSION['securenum']) { 


echo <<<EOD

<h3 class="title" align="center">Thank you for your submission!</h3>
<br><br>
You will be getting a confirmation email shortly asking you to verify your question. Please read
this and reply to the message as indicated in the instructions. 
EOD;


$note = "Thank you for your question on the book \"".$_POST['book']."\" at "; 
$note .= <<<EOD
http://www.brainvoyage.com/.  We appreciate your 
feedback and would like to consider sharing it with others who visit 
this site.\n
However, first we want to confirm that it was you indeed who actually 
made the comments.  Consequently, we are sending this EMail to you.  
YOU NEED ONLY PRESS "REPLY" to send this EMail back. Sending this 
reply to this EMail is your official permission to use the comments 
you have made.\n
Please understand that your question may or may not be used. If used, 
they be in full or abbreviated format which may imply ensuring full 
sentences or phrases so that words like "the" may be added or subtracted.\n
Also, we still may not identify you by name even if you have given such 
permission to do so.\n
If you have indicated that we can identify this as your question, we
may contact you again by Email , fax and/or phone if we need to.\n
Your questions about the book may be used by Brainvoyage.com in any
promotion (internet or other) entirely at our discretion You will not be
remunerated for such comments and the comments become the sole property
of Brainquest Press.\n
You will understand that only a proportion of the question made can be
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

$x = mail($email, "Comments on ".$_POST['book'],$note, "From: comments@brainvoyage.com\nReply-To: comments@brainvoyage.com\ncc: comments@brainvoyage.com");
//for testing
//$x = mail($email, "Comments on ".$_POST['book'],$note, "From: comments@brainvoyage.com\nReply-To: comments@brainvoyage.com\ncc: pnibv@stevenssite.com");

}
else{
	
	print("<br><p><strong><font color=\"red\" size=\"+1\">The secure number you entered (</font>".$secure_number."<strong><font size=\"+1\" color=\"red\">) does not correspond with the picture.</p><p>Please click <a href=\"makecomment.php\">HERE</a> to try again.</p></strong><br></font>");
	$_SESSION['commentcache'] = $_POST['comments'];
}


}


 printFooter(); 
 
?>


