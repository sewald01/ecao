#!/usr/local/bin/php
<?php 

require("/home/content/48/7686848/html/includes/bv-library.php"); 
require("/home/content/48/7686848/html/inset/inset_includes/insetdb.php");
require("/home/content/48/7686848/html/inset/inset_includes/forms.php");

//printHeader("Welcome to Brainvoyage.com");

//check if it is first time on the page or form submited
if($id)
// print out user data by user ID
{
	$table = $root."_answers";
	$result = mysql_query("SELECT * FROM $table where user_id=$id") or die(mysql_error());
	?>
	<table border="0" align="center">
	<?php	
	while ($data = mysql_fetch_array($result))
	{
		$i++;
		?>
		<tr bgcolor="<?php if(is_float( $i/2 )) print ("66CCFF");
						else print ("CCFFFF"); ?>"> 
		<td><?php print ($i); ?>&nbsp;</td>
<!-- 	<td><?php print ($data['id']); ?></td>
		<td><?php print ($data['user_id']); ?></td> 	-->
		<td><?php print (question($data['question'], $root)); ?>&nbsp;</td>
		<td><?php print ($data['answer']); ?>&nbsp;</td>
		</tr>
		<?php
	}?> </table> <?php
}
elseif($delete)
{
	if ($delete == 1)
	{
		mysql_query("DELETE FROM user_answers") or die(mysql_error());
		mysql_query("DELETE FROM sobin_answers") or die(mysql_error());
	//	mysql_query("DELETE FROM inset_answers") or die(mysql_error());
		print ("<a href=list.php>List all</a>");
	}
	else
	{
		mysql_query("DELETE FROM user_answers where user_id='$delete'") or die(mysql_error());
		mysql_query("DELETE FROM sobin_answers where user_id='$delete'") or die(mysql_error());
	//	mysql_query("DELETE FROM inset_answers where user_id='$delete'") or die(mysql_error());
		print ("<a href=list.php>List all</a>");
	}
}
else
{
	$result = mysql_query("SELECT DISTINCT user_id FROM user_answers") or die(mysql_error());
	?>
	<table border="0" align="center">
	<?php	
	while ($data = mysql_fetch_array($result))
	{
		$i++?>
		<tr bgcolor="<?php if(is_float( $i/2 )) print ("66CCFF");
						else print ("CCFFFF"); ?>">
		<td><a href="list.php?id=<?= ($data['user_id']) ?>&root=user"><?= ($data['user_id']) ?></a></td>
		<td><a href="list.php?id=<?= ($data['user_id']) ?>&root=sobin">SOBIN</a></td>
		<!-- <td><a href="list.php?id=<?= ($data['user_id']) ?>&root=inset">INSET</a></td> -->
		<td><a href="list.php?delete=<?= ($data['user_id']) ?>">Delete</a></td>
		</tr>
	<?php	}	?>
	<td><a href="list.php?delete=1">Delete All Data</a></td><td></td>
	</table>
	
	<?php
}
// validates Question id and returnd Question as str
function question($q_id, $root)
{
	$intQ_id = intval($q_id);
	if($intQ_id)
	{
		if ( $intQ_id < 10000 )
		{
			return get_q($intQ_id, $root);		
		}
		else
		{
			$n = round($intQ_id/10000);
			return get_q($n, $root);
		}
	}
	else return ($q_id);
}
// querrees DB and returns Questions as str
function get_q($intQ_id, $root)
{
	$table = $root."_questions";
	$result = mysql_query("SELECT question FROM $table where id='$intQ_id'") or die(mysql_error());
	$data = mysql_fetch_array($result);
	return $data['question'];
}

//printFooter(); 
?>
