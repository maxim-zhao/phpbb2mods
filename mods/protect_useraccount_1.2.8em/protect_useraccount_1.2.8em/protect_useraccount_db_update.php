<?php
#########################################################
## SQL commands to phpBB2
## Author: Niels Chr. Rød
## Nickname: Niels Chr. Denmark
## Email: ncr@db9.dk
##
## Ver 1.0.9
##
## phpBB2 database update script for mods
## this file is intended to use with phpBB2, when installing mods
## after so you may delete this file, but only admin can use so it really doesen't matter
## The script will look what prefix you are using, and use the existing DB defined by congig.php
## The execution of this script's included SQL is harmless, so you can run it as meny times you like
##
#########################################################

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/functions_selects.'.$phpEx);

###################################################################################################
##
## put the SQL commands below here, the SQL commands listed below are only exampels, substitude them with the one you need ##
##
###################################################################################################
$sql=array(
'ALTER TABLE ' . USERS_TABLE . ' ADD user_passwd_change INT(11) NOT NULL',
'UPDATE ' . USERS_TABLE . ' SET user_passwd_change=user_regdate',
'UPDATE ' . USERS_TABLE . ' SET user_passwd_change=' .time(). ' WHERE user_level='.ADMIN,
'INSERT INTO '. CONFIG_TABLE . ' (config_name, config_value) VALUES ("max_password_age", "730")',
'ALTER TABLE ' . USERS_TABLE . ' ADD user_badlogin SMALLINT(5) NOT NULL',
'ALTER TABLE ' . USERS_TABLE . ' ADD user_blocktime INT(11) NOT NULL',
'ALTER TABLE ' . USERS_TABLE . ' ADD user_block_by VARCHAR (8)',
'INSERT INTO '. CONFIG_TABLE . ' (config_name, config_value) VALUES ("block_time", "15")',
'INSERT INTO '. CONFIG_TABLE . ' (config_name, config_value) VALUES ("max_login_error", "3")',
'INSERT INTO '. CONFIG_TABLE . ' (config_name, config_value) VALUES ("min_password_len", "6")',
'INSERT INTO '. CONFIG_TABLE . ' (config_name, config_value) VALUES ("force_complex_password", "0")',
'INSERT INTO '. CONFIG_TABLE . ' (config_name, config_value) VALUES ("password_not_login", "1")'
);

$mods = array ( 
'Protect useraccount','Protect useraccount','Protect useraccount','Protect useraccount',
'Protect useraccount','Protect useraccount','Protect useraccount','Protect useraccount'
);

############################################### Do not change anything below this line #######################################

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
//
// End session management
//

if ($userdata['user_level']!=ADMIN)
      message_die(GENERAL_ERROR, "You are not Authorised to do this"); 
$n=0;
$message="<b>This list is a result of the SQL queries needed for mod</b><br/><br/>";
while($sql[$n])
{
	$message .= ($mods[$n-1] != $mods[$n]) ? '<p><b><font size=3>'.$mods[$n].'</font></b><br/>' : '';
	if(!$result = $db->sql_query($sql[$n])) 
	$message .= '<b><font color=#FF0000>[Already added]</font></b> line: '.($n+1).' , '.$sql[$n].'<br />';
	else $message .='<b><font color=#0000fF>[Added/Updated]</font></b> line: '.($n+1).' , '.$sql[$n].'<br />';
	$n++;
}
 message_die(GENERAL_MESSAGE, $message); 
?>