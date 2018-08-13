#!/usr/local/bin/php 
<?php

require("/home/content/48/7686848/html/includes/bv-library.php"); 

printHeader("Add/Edit IP settings");

//connect to the DB (address / user / password)
$dbconn = mysql_connect("72.167.233.102","bvdatabase","silverhair") or die(mysql_error());
mysql_select_db("bvdatabase") or die(mysql_error());


//check if it is first time on the page or form submited
//1st time         get mothod - default 
if  ($_SERVER['REQUEST_METHOD'] == 'GET')
{	$ip = $REMOTE_ADDR;
	print ("your IP:".$ip);
				
	//check if this IP is already in the DB	// not in the DB, add form	
	if (ip_check($ip) == false)	print_addform($ip);	
	//in the DB, change form 
	else	print_changeform($ip);
}
else
{	//get values from form
	$ip = $_POST['ip'];
	$access = $_POST['access'];
	$description = $_POST['description'];
	$query = $_POST['query'];
	
	if ($query == "insert") print insert_ip($ip, $access, $description);
	else print update_ip($ip, $access, $description);
}	
			

 function ip_check ($ip) 
 {
	//queriing DB
 	$result = mysql_query("select ipid from ips where ip='$ip'") or die(mysql_error());  
	
	if(mysql_num_rows($result) == 0)
	return false;
	else return true;
 }
 
 function print_addform($ip) 
 {
 	?>
		
		<form action="addip.php" method="post" name="addip" id="addip">
			
			<input type="text" name="ip" value="<?php print $ip ?>">
			<br><br>
			<select name="access">
				<option value="0">Denied Access</option>
				<option value="1">Internet Access</option>
				<option value="2">Allow Access</option>
				<option value="3">Administration Access</option>
			</select>
			<br><br>
			Description:
			<br>
			<textarea cols="35" rows="3" name="description" id="description"></textarea>
			<br><br>
			<input type="hidden" name="query" value="insert">
			<input type="submit" name="Submit" value="Submit">
			<input type="reset" name="Reset" value="Reset">
		
		</form>
		
	<?php
 }
 
 function print_changeform($ip)
 {
	//queriing DB
 	$result = mysql_query("select * from ips where ip='$ip'") or die(mysql_error());
	$data = mysql_fetch_array($result);
		
	?>
		<h4>This IP is already in the Database</h4>
		
		<form action="addip.php" method="post" name="addip" id="addip">
			
			<input type="text" name="ip" value="<?php print $data['ip']; ?>">
			<br><br>
			<select name="access">
				<option value="0" <?php if($data['access'] == '0') print ("selected"); ?> >Denied Access</option>
				<option value="1" <?php if($data['access'] == '1') print ("selected"); ?> >Internet Access</option>
				<option value="2" <?php if($data['access'] == '2') print ("selected"); ?> >Allow Access</option>
				<option value="3" <?php if($data['access'] == '3') print ("selected"); ?> >Admin Access</option>
			</select>
			<br><br>
			Description:
			<br>
			<textarea cols="35" rows="3" name="description" id="description"><?php print $data['description']; ?></textarea>
			<br><br>
			<input type="hidden" name="query" value="update">
			<input type="submit" name="Submit" value="Submit Changes">
			<input type="reset" name="Reset" value="Reset">
			
		
		</form>
	<?php
 }
 
 function insert_ip($ip, $access, $description)
 {
 	$result = mysql_query("INSERT INTO ips VALUES ('', '$ip', '$access', '$description')") or die(mysql_error());
	return "<p>IP added to the Database</p>";
 }
 
 function update_ip($ip, $access, $description)
 {
 	$result = mysql_query("UPDATE ips SET ips.access='$access', ips.description='$description' WHERE ip='$ip'") or die(mysql_error());
	return "<p>Record updated</p>";
 }
 
 printFooter(); 
 ?>
