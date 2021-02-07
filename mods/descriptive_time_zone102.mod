##############################################################
## MOD Title: descriptive_time_zone
## MOD Author: kender < kender@junebugbug.com > (J. Wheeler) http://junebugbug.com
## MOD Description: Add more descriptive time zone to phpBB
## MOD Version: 1.0.2
##
## Installation Level: Easy
## Installation Time: ~1 Minutes
## Files To Edit:
##		  language/lang_english/lang_main.php
## Included Files: 0
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##
## This mod will replace the generic time zone settings, with a 
## more descriptive setting allowing for your users to see a 
## more recognizable format (Eastern, Central, Mountain, Pacific)
## 
##############################################################
## MOD History: 
## 
##   2004-04-08 - Version 1.0.2
##	- Added support for GMT +5.75 Hours
## 
##   2004-04-08 - Version 1.0.1
##	- Added support for GMT -13 hours
## 
##   2004-04-07 - Version 1.0.0 
##      - First Language mod only 
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

# 
#-----[ OPEN ]------------------------------------------ 
#
language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
# 
# if you would like to comment "// " this out instead
# of replacing to keep original it may be helpful.
#
// These are displayed in the timezone select box
$lang['tz']['-12'] = 'GMT - 12 Hours';
$lang['tz']['-11'] = 'GMT - 11 Hours';
$lang['tz']['-10'] = 'GMT - 10 Hours';
$lang['tz']['-9'] = 'GMT - 9 Hours';
$lang['tz']['-8'] = 'GMT - 8 Hours';
$lang['tz']['-7'] = 'GMT - 7 Hours';
$lang['tz']['-6'] = 'GMT - 6 Hours';
$lang['tz']['-5'] = 'GMT - 5 Hours';
$lang['tz']['-4'] = 'GMT - 4 Hours';
$lang['tz']['-3.5'] = 'GMT - 3.5 Hours';
$lang['tz']['-3'] = 'GMT - 3 Hours';
$lang['tz']['-2'] = 'GMT - 2 Hours';
$lang['tz']['-1'] = 'GMT - 1 Hours';
$lang['tz']['0'] = 'GMT';
$lang['tz']['1'] = 'GMT + 1 Hour';
$lang['tz']['2'] = 'GMT + 2 Hours';
$lang['tz']['3'] = 'GMT + 3 Hours';
$lang['tz']['3.5'] = 'GMT + 3.5 Hours';
$lang['tz']['4'] = 'GMT + 4 Hours';
$lang['tz']['4.5'] = 'GMT + 4.5 Hours';
$lang['tz']['5'] = 'GMT + 5 Hours';
$lang['tz']['5.5'] = 'GMT + 5.5 Hours';
$lang['tz']['6'] = 'GMT + 6 Hours';
$lang['tz']['6.5'] = 'GMT + 6.5 Hours';
$lang['tz']['7'] = 'GMT + 7 Hours';
$lang['tz']['8'] = 'GMT + 8 Hours';
$lang['tz']['9'] = 'GMT + 9 Hours';
$lang['tz']['9.5'] = 'GMT + 9.5 Hours';
$lang['tz']['10'] = 'GMT + 10 Hours';
$lang['tz']['11'] = 'GMT + 11 Hours';
$lang['tz']['12'] = 'GMT + 12 Hours';
$lang['tz']['13'] = 'GMT + 13 Hours';

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
//
// Time Zone Mod
// These are displayed in the timezone select box

$lang['tz']['-12'] = '(GMT -12 Hours) Eniwetok, Kwajalein';
$lang['tz']['-11'] = '(GMT -11 Hours) Midway Island, Samoa';
$lang['tz']['-10'] = '(GMT -10 Hours) Hawaii';
$lang['tz']['-9'] = '(GMT -9 Hours) Alaska';
$lang['tz']['-8'] = '(GMT -8 Hours) Pacific Time (US & Canada)';
$lang['tz']['-7'] = '(GMT -7 Hours) Mountain Time (US & Canada)';
$lang['tz']['-6'] = '(GMT -6 Hours) Central Time (US & Canada), Mexico City';
$lang['tz']['-5'] = '(GMT -5 Hours) Eastern Time (US & Canada), Bogota, Lima, Quito';
$lang['tz']['-4'] = '(GMT -4 Hours) Atlantic Time (Canada), Caracas, La Paz';
$lang['tz']['-3.5'] = '(GMT -3.5 Hours) Newfoundland';
$lang['tz']['-3'] = '(GMT -3 Hours) Brazil, Buenos Aires, Georgetown';
$lang['tz']['-2'] = '(GMT -2 Hours) Mid-Atlantic';
$lang['tz']['-1'] = '(GMT -1 Hour) Azores, Cape Verde Islands';
$lang['tz']['0'] = '(GMT) Western Europe Time, London, Lisbon, Casablanca, Monrovia';
$lang['tz']['1'] = '(GMT +1 Hour) CET(Central Europe Time), Brussels, Madrid, Paris';
$lang['tz']['2'] = '(GMT +2 Hours) EET(Eastern Europe Time), Kaliningrad, South Africa';
$lang['tz']['3'] = '(GMT +3 Hours) Baghdad, Kuwait, Riyadh, Moscow, St. Petersburg, Nairobi';
$lang['tz']['3.5'] = '(GMT +3.5 Hours) Tehran';
$lang['tz']['4'] = '(GMT +4 Hours) Abu Dhabi, Muscat, Baku, Tbilisi';
$lang['tz']['4.5'] = '(GMT +4.5 Hours) Kabul';
$lang['tz']['5'] = '(GMT +5 Hours) Ekaterinburg, Islamabad, Karachi, Tashkent';
$lang['tz']['5.5'] = '(GMT +5.5 Hours) Bombay, Calcutta, Madras, New Delhi';
$lang['tz']['5.75'] = '(GMT +5.75 Hours) Kathmandu';
$lang['tz']['6'] = '(GMT +6 Hours) Almaty, Dhaka, Colombo';
$lang['tz']['6.5'] = '(GMT +6.5 Hours)';
$lang['tz']['7'] = '(GMT +7 Hours) Bangkok, Hanoi, Jakarta';
$lang['tz']['8'] = '(GMT +8 Hours) Beijing, Perth, Singapore, Hong Kong, Urumqi, Taipei';
$lang['tz']['9'] = '(GMT +9 Hours) Tokyo, Seoul, Osaka, Sapporo, Yakutsk';
$lang['tz']['9.5'] = '(GMT +9.5 Hours) Adelaide, Darwin';
$lang['tz']['10'] = '(GMT +10 Hours) EAST(East Australian Standard), Guam, Papua New Guinea';
$lang['tz']['11'] = '(GMT +11 Hours) Magadan, Solomon Islands, New Caledonia';
$lang['tz']['12'] = '(GMT +12 Hours) Auckland, Wellington, Fiji, Kamchatka, Marshall Island';
$lang['tz']['13'] = '(GMT +13 Hours) Nuku\'alofa';

//
// End Time Zone Mod
//

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
