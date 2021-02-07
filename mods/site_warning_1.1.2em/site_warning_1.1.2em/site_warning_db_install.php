<?php
#########################################################
## SQL commands to phpBB2
## Author: Niels Chr. Rød
## Nickname: Niels Chr. Denmark
## Email: ncr@db9.dk
##
## Ver 1.0.8
##
## phpBB2 database update script for mods
## this file is intended to use with phpBB2, when installing mods
## after so you may delete this file, but only admin can use so it really doesen't matter
## The script will look what prefix you are using, and use the existing DB defined by congig.php
## The execution of this script's included SQL is harmless, so you can run it as meny times you like
## note, though that the users last visit, will be set back to his/her last login, 
## but that is a minor cosmetic isue, that will correct it self next time the use  logs in
##
## the following example are from my mods, and you can add some self, for other mods if you like
## you will after execution get a list over those commands that are run with succes and those with warnings !
## delete the sample lines if you are using it only for other mods
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
'INSERT INTO '.CONFIG_TABLE.' (config_name, config_value) VALUES ("warning_enable", "1")',
'INSERT INTO '.CONFIG_TABLE.' (config_name, config_value) VALUES ("warning_title", "MOD installation information")',
'INSERT INTO '.CONFIG_TABLE.' (config_name, config_value) VALUES ("warning_msg", "site_warning_1.1.2 was installed successfully. Now change the settings in the ACP.")'
);


$mods = array ( 
'Site warning MOD','Site warning MOD','Site warning MOD'
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
$message="<b>This list is a result of the SQL queries needed for MOD</b><br/><br/>";
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