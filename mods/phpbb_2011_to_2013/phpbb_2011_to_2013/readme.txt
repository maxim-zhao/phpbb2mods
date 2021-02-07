The files you now have in front of you are the code changes from phpBB 2.0.11 to 2.0.13 in MOD format.
If you already have phpBB 2.0.12 you only need to apply the following changes:

# 
#-----[ OPEN ]--------------------------------------------- 
# * (Change from 2.0.12 to 2.0.13)
includes/sessions.php

#
#-----[ FIND ]---------------------------------------------
# Line 82
				if( $sessiondata['autologinid'] == $auto_login_key )

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
				if( $sessiondata['autologinid'] === $auto_login_key )


# 
#-----[ OPEN ]--------------------------------------------- 
# 
viewtopic.php

#
#-----[ FIND ]---------------------------------------------
# Line 1110 (* Change from 2.0.12 to 2.0.13) - only the two @ has been added in front of preg_replace
		$message = str_replace('\"', '"', substr(preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "preg_replace('#\b(" . $highlight_match . ")\b#i', '<span style=\"color:#" . $theme['fontcolor3'] . "\"><b>\\\\1</b></span>', '\\0')", '>' . $message . '<'), 1, -1));

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
		$message = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace('#\b(" . $highlight_match . ")\b#i', '<span style=\"color:#" . $theme['fontcolor3'] . "\"><b>\\\\1</b></span>', '\\0')", '>' . $message . '<'), 1, -1));


Acyd Burn.