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
    <form method="GET" action="/media/getphoto.php">
	  <input type="hidden" name="op" value="passwd">
    <div align="center">
      <table border="0" width="100%" cellpadding="4" cellspacing=1 bgcolor="#000000">
        <tr>
          <td bgcolor="#eaeaea">Name</td>
          <td bgcolor="#eaeaea" align="center"><input type="text" name="name" size="50"></td>
        </tr><tr>
          <td bgcolor="#cfcfcf">Password:</td>
          <td bgcolor="#cfcfcf" align="center"><input type="text" name="passwd" size="50"></td>
        </tr><tr>
          <td bgcolor="#eaeaea">Click to verify:</td>
          <td bgcolor="#eaeaea" align="center"><input type="submit" value="Verify"></td>
        </tr>
      </table>
    </div>
    </form>
EOD;
}

function showPic() {
  printHeader("Dr. Vernon Neppe Media Photo");
  echo <<<EOD
  <div align="center">You may bookmark this page to return to it at any time.</div><br><br>
  <table align="center" border=0 cellpadding=0 cellspacing=0 bgcolor="#ffffff">
    <tr>
      <td bgcolor="#ffffff"><img src="/media/Dr_Neppe_h_jpeg72.jpg"></td>
    </tr>
  </table>
EOD;
}
  

if($op == "passwd") {
  if($name == "" or $passwd == "") { 
    printBasic("<div style=\"font-family:verdana;color:#ff0000\">Error: All fields are required.</div>");
  } else if($passwd != "VMNphoto") {
    printBasic("<div style=\"font-family:verdana;color:#ff0000\">Error: The password is incorrect.</div>");
  } else {
    showPic();
  }
}else{
  printBasic(""); 
}



 printFooter(); ?>
