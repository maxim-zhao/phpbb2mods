<?
//-------------------------
// messagecan_install.php
// version: 1.0.5
// by bu(Buwei Chiu) 2005
//-------------------------

/* 
 This program is free software; you can redistribute it and/or
 modify it under the terms of the GNU General Public License
 as published by the Free Software Foundation; either version 2
 of the License, or (at your option) any later version.
*/

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

// SQLs

$sql=array();

$sql[]="CREATE TABLE `".$table_prefix."messagecan` (
  `msg_id` int(8) NOT NULL auto_increment,
  `msg_title` text NOT NULL,
  `msg_text` text NOT NULL,
  PRIMARY KEY  (`msg_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;";

$sql[]="INSERT INTO `phpbb_messagecan` VALUES ('', 'Message Can', 'If you can see this message, it means you have done install Message Can');";

for($i=0;$i<=count($sql);$i++) {
if( !($result = $db->sql_query($sql[$i]))) { 
	$error=$db->sql_error();
	$res[]="<b><font color=\"red\">Fail</font><br />Reason: <font color=\"#CC0000\" face=\"Courier New\" style=\"font-size:10pt\">".$error['message']."</font></b>"; } else { $res[]="<b><font color=\"#0000FF\">Successful</font></b>"; 
}
}
?>

<h1 style="font-family:Trebuchet MS;font-size:20pt">Message Can 1.0.5 Install Result</h1>

<?
for($i=0;$i<count($sql);$i++) {
echo "<font face=\"Courier New\" color=\"#006600\">SQL:".$sql[$i] .'</font><br /><font face="Verdana">Result: ' . $res[$i] . '</font><br /><br />' ;
}
?>

<h3 style="font-family:Trebuchet MS;font-size:16pt">After successful execute, don't forget to delete this file as soon as possible.</h1>
