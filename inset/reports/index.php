#!/usr/local/bin/php
<?php session_start();

if($_SERVER['HTTPS'])
{

	if  ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		require("/home/content/48/7686848/html/inset/inset_includes/insetdb.php");
	
		$result = mysql_query("select pwd from users where name='$uname'") or die(mysql_error());
		$data = mysql_fetch_array($result);
	
		
		if ($data['pwd'] == $password)
		{
			$logon = $uname;
			session_register(logon);
			session_register(uname);
			
	// forward to list.php
	?>
	<html>
		<head>
			<title>INSET administration system</title>
			<meta http-equiv="Refresh" content="1; URL=https://www.brainvoyage.com/inset/reports/list.php">
		</head>
		<body></body>
	</html>
	<?php
	
		}
		else
		{
			// wrong pwd:
			
		print ("Password incorrect");
		}
	}
	else
	{
	  // login form:
?>
	
<form action="index.php" method="post">
<table align="center">INSET administration system:<br>
<tr><td>Login:</td><td><input type="text" name="uname"></td></tr>
<tr><td>Password: </td><td><input type="password" name="password"></td></tr>
<tr><td><input type="submit" value="submit"></td><td><input type="Reset"></td></tr>
</table></form>
<?php
	}
?>
	
<?php
}else
{
?>

<html>
<head>
	<title>INSET administration system</title>
	<META http-equiv="Refresh" content="10; URL=https://www.brainvoyage.com/inset/reports">
</head>

<body>

This Page does not use independent digital certificate and encryption. Please wait to be redirected to more <a href="https://www.brainvoyage.com/inset/reports">secure page</a> for these transactions.

<br>
<a href="https://www.brainvoyage.com/inset/reports">https://www.brainvoyage.com/inset/reports</a> 

</body>
</html>
<?php
}
?>