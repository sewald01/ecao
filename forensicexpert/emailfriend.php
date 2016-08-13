#!/usr/local/bin/php
<?php 
session_start();
require("/home/content/48/7686848/html/includes/bv-library.php");

printHeader("E-Mail a friend about Forensic Expert"); 
foreach($_POST as $key => $value){
	$$key = $value;
}
if($submission == "") { 

echo <<<EOD
<h2 align="center">Suggest This Book To A Friend</h2>
<p>If you like this site or the book, please alert a friend. Of course, please ensure that your e-mail is legitimate and appropriate (this is monitored and can be traced). For those who would like far more detail in their EMail, please <a href="http://www.brainvoyage.com/ctbm/emailfriend_long.php">click here to send a lengthy e-mail</a> about the book."</p>

<form method=post action="emailfriend.php">
<table border=0 cellpadding=2 cellspacing=3 class="tab">
<tr>
	<td align="right">Name of Recipient:</td>
	<td align="left"><input TYPE="text" NAME="name" SIZE="35" MAXLENGTH="40" class="inputsmall"></td>
</tr>
<tr>
	<td align="right">E-mail of Recipient:</td>
	<td align="left"><input TYPE="text" NAME="email" SIZE="35" MAXLENGTH="40" class="inputsmall"></td>
</tr>
<tr>
	<td align="right">Your Name:</td>
	<td align="left"><input TYPE="text" NAME="sender" SIZE="35" MAXLENGTH="40" class="inputsmall"></td>
</tr>
<tr>
	<td align="right">Your E-mail:</td>
	<td align="left"><input TYPE="text" NAME="senderemail" SIZE="35" MAXLENGTH="40" class="inputsmall"></td>
</tr>
<tr>
	<td align="right" valign="top">Add Personal Message:</td>
	<td align="left" valign="top"><TEXTAREA name="optionalmsg" rows="10" wrap=virtual cols="45" class="inputsmall">
I found this fascinating book called How Attorneys Can Best Utilize Their Medical Expert Witness:
A Medical Expert's Perspective, by Vernon Neppe MD, PhD at http://www.brainvoyage.com. It is like you are in his office talking to him. I thought you might find it of interest. Well worth reading!</TEXTAREA></td>
</tr>
<tr>
	<td> &nbsp; </td>
	<td align="left">
	    <input type="hidden" name="submission" value="1"> 
		
EOD;
		
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

		
		
		<input type="submit" value="Send Mail" class="inputsmall"> 
	</td>
		
</tr>
</table>
</form>
<p><em>Note: We have encoded this page and can trace any spammers or those who illegally abuse this page.</em>
<script type="text/javascript">
<!--
window.onload=openmenu('menu6');
//-->
</script>

</p>
EOD;

} else {

if (md5(strtoupper($_POST['secure_number'])) == $_SESSION['securenum']) { 

echo "<h3 class=\"title\">Your message is on the way. Thanks for your interest!</h3>
<li><a href=\"http://www.brainvoyage.com/forensicexpert/emailfriend.php\">E-mail another friend</a></li>
<li><a href=\"http://www.brainvoyage.com\">Return to Main</a></li><br><br>
";

$message = <<<EOD

Hello $name,

$optionalmsg

With my best wishes,
$sender


*Note: This message was sent by $sender ($senderemail) from www.brainvoyage.com.

EOD;

$x = mail($email, "$sender wants you to see the book Forensic Expert",$message, "From: $senderemail\nReply-To: $senderemail\nbcc: psyche@pni.org");
}

else{
	print("<br><p><strong><font color=\"red\" size=\"+1\">The secure number you entered (</font>".$secure_number."<strong><font size=\"+1\" color=\"red\">) does not correspond with the picture.</p><p>Please press BACK and try again.</p></strong><br></font>");
}


}





printFooter(); 

?>