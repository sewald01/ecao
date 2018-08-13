#!/usr/local/bin/php
<?php session_start();

require("/home/content/48/7686848/html/includes/bv-library.php");

if($_SERVER['HTTPS'])
{
	if  ($_SERVER['REQUEST_METHOD'] == 'POST')
#POST - login verification - data
	{
		//connect to the DB (address / user / password)    db: http://mydatabase.registeredsite.com/
		$dbconn = mysql_connect("72.167.233.102","bvdatabase","silverhair") or die(mysql_error());
		mysql_select_db("bvdatabase") or die(mysql_error());
		$result = mysql_query("select * from orders where OrderTime='$password'", $dbconn);

		$data = mysql_fetch_array($result);
		# loged in
		if ($data['EMail'] == $uname && $uname != "")
		{	printHeader("EBook"); ?>
		
			<h3><?= $data['Name'] ?> Welcome to EBook section of Brainvoyage.com</h3>
			You can read or downlowd an electronic version of Cry the Beloved Mind by following this link:<br>
			
<div align="center">			
	<a href="pdf/CTBMBook.pdf">
	Cry the Beloved Mind Book <img src="https://www.adobe.com/images/pdficon.gif" border="0" alt="Book"></a>
	<br><br>
	<a href="pdf/CTBM_Glossary.pdf">
	Glossary <img src="https://www.adobe.com/images/pdficon.gif" border="0" alt="Glossary"></a>
	<br><br>
	<a href="pdf/agree_readme_doc.pdf">
	Agreement <img src="https://www.adobe.com/images/pdficon.gif" border="0" alt="Doc"></a>
	
	</div>
			
			<br>your user name is: reader and password is: ebook
			 
			
<br><br>			
You can view and print a PDF file using the free Adobe(R) Acrobat(R) Reader
<a href="http://www.adobe.com/products/acrobat/readstep.html"><img src="https://www.adobe.com/images/getacro.gif" border="0" alt=""></a>
<br> 
There are three main files to download: <br>
<br>They are all in the very standard PDF format which requires Adobe Acrobat Reader, a free program. They are not compressed.
<br>You can these files download them in any order. 
<br>1. An Agreement file which includes a disclaimer including mentioning always seeking appropriate medical advice.
This is only about 16K in size and should take seconds to download on a fast connection, and only minutes or less on a modem.  
<br>2. A convenient Glossary file of about 33 pages derived from the book Cry the Beloved
Mind: A Voyage of Hope (about 600K). This should take take seconds to download on a fast connection, and only minutes or less on a modem.
<br>3. The full text of the book Cry the Beloved Mind: A Voyage of Hope. This text is slightly updated from the printed copy of the book to ensure easy readability.  This  electronic book  is 1917K or about 2 megabytes. Download on cable lines takes about 8 seconds. This file has the Glossary included, as well.
<br><br>
We do not recommend a download on regular modem unless you have resources to maintain downloads 
for several minutes. If you disconnect, please try again.
We cannot offer tech support for downloads besides the instructions given here and on the FAQ at 
http://www.brainquestpress.com/order/faq.html
as this is straightforward. Once a download has occurred, we cannot offer refunds unless the download did not go through.
If you have problems with the downloads, you can try again.  

			<? printFooter(); 
		}
		else
		{	printHeader("EBook"); ?>
		
		
<font color="#FF0000">The login and password you entered did not match any accounts in our file. <a href=".">Please try again.</a></font>
		
			<? printFooter(); 
		
		}
	}
	else
#GET - default screen - login form:
	{
		printHeader("Login");
		?>
		
		<h3>Welcome to Cry the Beloved Mind electronic version.<h3>
		<img src="../order/thawte.gif" width="120" height="79" alt="Thawte secure site" border="0" align="right">
		
		<form action="index.php" method="post">
<table align="center">
<tr><td>Login:</td><td><input type="text" name="uname"></td></tr>
<tr><td>Password: </td><td><input type="password" name="password"></td></tr>
<tr><td><input type="submit" value="submit"></td><td><input type="Reset"></td></tr>
</table></form>
		
		<? 
		printFooter();
	}
	
	
}
else
# https not used: redirect to https
{
?>

<html>
<head>
	<title>EBook</title>
	<META http-equiv="Refresh" content="1; URL=https://www.brainvoyage.com/ebook/">
</head>

<body>

This Page does not use independent digital certificate and encryption. Please wait to be redirected to more <a href="https://www.brainvoyage.com/OrderVerifications/">secure page</a> for these transactions.

<br>
<a href="https://www.brainvoyage.com/ebook/">https://www.brainvoyage.com/ebook/</a> 

</body>
</html>
<?php
}
?>
