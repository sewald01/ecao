#!/usr/local/bin/php

<?php 
if (get_magic_quotes_gpc()) { 
// Overrides GPC variables 
for (reset($_GET); list($k, $v) = each($_GET); ) 
$$k = stripslashes($v); 
for (reset($_POST); list($k, $v) = each($_POST); ) 
$$k = stripslashes($v); 
for (reset($HTTP_COOKIE_VARS); list($k, $v) = each($HTTP_COOKIE_VARS); ) 
$$k = stripslashes($v); 
}



require("/home/content/48/7686848/html/includes/bv-library.php");

function printBasic($error) {
  printHeader("Request for Media Photo");
  echo <<<EOD
    <h2 class="title">Request for Media Photo</h2>
    <br>
    $error
    <br>
    <form method="POST" action="/media/index.php">
	  <input type="hidden" name="op" value="send">
    <div align="center">
      <table border="0" width="100%" cellpadding="4" cellspacing=1 bgcolor="#000000">
        <tr>
          <td bgcolor="#eaeaea">Name</td>
          <td bgcolor="#eaeaea" align="center"><input type="text" name="name" size="50"></td>
        </tr><tr>
          <td bgcolor="#cfcfcf">E-mail Address:</td>
          <td bgcolor="#cfcfcf" align="center"><input type="text" name="email" size="50"></td>
        </tr><tr>
          <td bgcolor="#eaeaea">Company:</td>
          <td bgcolor="#eaeaea" align="center"><input type="text" name="company" size="50"></td>
        </tr><tr>
          <td bgcolor="#cfcfcf">Press Identity:</td>
          <td bgcolor="#cfcfcf" align="center"><input type="text" name="identity" size="50"></td>
        </tr><tr>
          <td bgcolor="#eaeaea">Phone Number:</td>
          <td bgcolor="#eaeaea" align="center"><input type="text" name="phone" size="50"></td>
        </tr><tr>
          <td bgcolor="#cfcfcf">Select Photo Type:</td>
          <td bgcolor="#cfcfcf" align="center">Black and White Photo</td>
        </tr>
      </table>
	  <input type="submit" value="Submit" name="B1">
    </div>
    </form>
EOD;
}

function sendEMail() {
  global $name,$email,$company,$identity,$phone;
  printHeader("Thank you for requesting a media photo");
  echo "<h1 class=\"Title\">Thank you!</h1><br><br>Thank you for requesting a media photo. You should be getting an email soon with a password to retrieve the photo.";
  $note = "Thank you for your interest in a high resolution photo of Dr. Vernon Neppe, author of Cry the Beloved Mind, and expert psychopharmacologist, neuropsychiatrist and forensic expert at http://www.brainvoyage.com/media/. You can imagine that access to such photos are useful from a press perspective but we want to avoid its misuse by others so we require a password to enter.\n\nTo access this photo which can be downloaded as a JPEG and used in media releases, please go to http://www.brainvoyage.com/media/getphoto.php. Please type in your name in the field marked 'Name', and the password \"VMNphoto\" in the field marked 'Password'. You will be taken to the JPEG of Dr Neppe.";
  $note .= "\n\nName: $name\nEMail: $email\nCompany: $company\nPress Identity: $identity\nPhone: $phone";
           
  mail($email, "Dr Vernon Neppe Media Photo Password", $note, "From: media@brainvoyage.com\nReply-To: media@brainvoyage.com\nbcc: mediarequest@brainvoyage.com"); 
}
  

if($op == "send") {
  if($name == "" or $email == "" or $company == "" or $identity == "" or $phone == "") { 
    printBasic("<div style=\"font-family:verdana;color:#ff0000\">Error: All fields are required.</div>");
  } else {
    sendEMail();
  }
}else{
  printBasic(""); 
}



 printFooter(); ?>
