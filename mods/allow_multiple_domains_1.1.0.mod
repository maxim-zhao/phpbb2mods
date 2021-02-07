############################################################## 
## MOD Title: Allow multiple domain names 
## MOD Author: dirtdart <drew@burchett-family.com> (Drew Burchett) http://www.conservativefriends.com 
## MOD Author, Secondary: HSorgYves < N/A > (Yves Kreis) N/A 
## MOD Description: This MOD allows you to use multiple domain names and/or access paths with your phpbb board 
## MOD Version: 1.1.0 
## 
## Installation Level: Easy 
## Installation Time: 1 Minute 
## Files To Edit: common.php 
## Included Files: n/a 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
## This MOD allows multiple domain names (ie: www.mydomain.com and www.yourdomain.com) as well as different 
## access paths (ie: forum.mydomain.com and www.mydomain.com/forum ) to the same phpbb board. It is able to 
## set cookie domain and cookie path accordingly. It might require users who move from one access way to 
## another to re-login the first time each access way is used. 
## This MOD requires some changes in your configuration in the admin control panel: 
## - if you want to use multiple domain names, then you need to remove any entry in the "Domain Name" field 
## - if you want to use different access paths, then you need to remove any entry in the "Script path" field 
## Do not forget to save your configuration after your changes. 
## 
## Thanks to A_Jelly_Donut for the php3 compliant code change. 
############################################################## 
## MOD History: 
## 
##   2005-04-30 - Version 1.1.0 (HSorgYves) 
##      - different way to detect the domain name 
##      - multiple access paths 
##      - set cookie domain and cookie path if they are empty as well 
##      - removed the comments
## 
##   2004-07-25 - Version 1.0.0 (dirtdart) 
##      - Initial release 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
common.php 
# 
#-----[ FIND ]------------------------------------------ 
# 
while ( $row = $db->sql_fetchrow($result) )
{
	$board_config[$row['config_name']] = $row['config_value'];
}

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
if (!empty($HTTP_SERVER_VARS['SERVER_NAME']) || !empty($HTTP_ENV_VARS['SERVER_NAME']))
{
	$server_name = (!empty($HTTP_SERVER_VARS['SERVER_NAME'])) ? $HTTP_SERVER_VARS['SERVER_NAME'] : $HTTP_ENV_VARS['SERVER_NAME'];
}
else if (!empty($HTTP_SERVER_VARS['HTTP_HOST']) || !empty($HTTP_ENV_VARS['HTTP_HOST']))
{
	$server_name = (!empty($HTTP_SERVER_VARS['HTTP_HOST'])) ? $HTTP_SERVER_VARS['HTTP_HOST'] : $HTTP_ENV_VARS['HTTP_HOST'];
}
else
{
	$server_name = '';
}
if (empty($board_config['server_name']) && !empty($server_name))
{
	$board_config['server_name'] = $server_name;
	if (empty($board_config['cookie_domain'])) {
		$board_config['cookie_domain'] = $board_config['server_name'];
	}
}
if (empty($board_config['script_path'])) {
	$board_config['script_path'] = str_replace('admin/', '', dirname($HTTP_SERVER_VARS['PHP_SELF']) . '/');
	if (empty($board_config['cookie_path'])) {
		$board_config['cookie_path'] = $board_config['script_path'];
	}
}

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM