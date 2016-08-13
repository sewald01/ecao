#!/usr/local/bin/php

<?php 
require("/home/content/48/7686848/html/includes/bv-library.php");

printHeader("Questions About Cry the Beloved Mind"); 

if($submission == 0) {
echo <<<EOD
<h1 class="title" align="center">Questions Regarding the Website</h1>

<FORM METHOD=post ACTION="/ctbm/questions.php">
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
      <td valign="top">City, State, (and country if outside the USA):</td>
      <td valign="top"><Input type="text" name="citystate" size="50"></td>
    </tr>
    <tr> 
      <td valign="top">Phone number (if you would like us to contact you):</td>
      <td valign="top"><Input type="text" name="phone" size="50"></td>
    </tr>
    <tr> 
      <td colspan=2><p>&nbsp;
      </td>
    </tr>
    <tr> 
      <td valign=top>Your questions:</td>
      <td><textarea name="questions" cols="45" rows="20" wrap id="questions"></textarea></td>
    </tr>
    <tr> 
      <td colspan=2 align=center><input type="hidden" name="submission" value="1"> 
        <INPUT TYPE="submit" value="Send Mail"> <INPUT TYPE="reset" value="Reset Form"></td>
    </tr>
  </table>
</FORM>
<H3 class="title" align=center>Thank you for your submission!  Please reply to the email we have sent you.</H3>
<script type="text/javascript">
<!--
window.onload=openmenu('menu1');
//-->
</script>

EOD;
}else{
echo <<<EOD

<h3 class="title" align="center">Thank you for your submission!</h3>
<br><br>
You will be getting a confirmation email shortly asking you to verify your submission. Please read
this and reply to the message as indicated in the instructions.  We will not recive your submission until you reply to the email.<br>
EOD;

$note = <<<EOD
Thank you for your questons reagarding the "Cry the Beloved Mind" website at 
http://www.brainvoyage.com/.  We appreciate your 
feedback.\n

---------------------------------------
Name: $name
E-Mail: $email
City, State: $citystate
Phone: $phone
-----Questions-----
$questions
------------------
End of Message
EOD;

$x = mail($email, "Questions on Website",$note, "From: questions@brainvoyage.com\nReply-To: questions@brainvoyage.com");
}


 printFooter(); ?>



