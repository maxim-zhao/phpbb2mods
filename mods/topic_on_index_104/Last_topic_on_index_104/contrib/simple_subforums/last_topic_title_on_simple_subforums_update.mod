##############################################################
## MOD Title: Last Topic Title on Simple Subforums Mod = Update 0.0.1 to 0.0.3
## MOD Author: Dicky <rfoote@tellink.net> (Richard Foote) http://dicky.askmaggymae.com
## MOD Description: Displays the title of and adds a link to the last topic replied to 
##                    in a particular subforum on the view forum page.
## MOD Version: 0.0.3
##
## Installation Level: Easy
## Installation Time: 10 Minutes
## Files To Edit: (1)
##				viewforum.php
## Included Files: N/A
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/ 
##############################################################
## Author Notes: Dicky
##
##   Requires the installation of Simple Subforums by pentapenquin http://www.phpbb.com/phpBB/viewtopic.php?t=336974
##   Requires the installation of Last Topic Title on Index by Dicky http://www.phpbb.com/phpBB/viewtopic.php?t=350442
## 	 This MOD has been verified to work with phpBB 2.0.21
##	 This MOD can be installed by EasyMOD
##############################################################
## MOD History:
##
##   2006-11-28 - Version 0.0.3
##		- Improved on converting html characters to prevent XSS exploit
##		- Fixed selection of topics with null status
##   2006-03-12 - Version 0.0.2 - Not released
##      - Change function to strip html characters
##   2006-01-26 - Version 0.0.1
##      - initial version of the Last Topic Title on Simple Subforums Mod
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#

viewforum.php

# 
#-----[ FIND ]----------------------------------------- 
#
include($phpbb_root_path . 'common.'.$phpEx);
#
#-----[ AFTER, ADD ]----------------------------------------- 
#

//-- MOD BEGIN: Last Topic Title on Index -------------------
$unhtml_specialchars_match = array('#&gt;#', '#&lt;#', '#&quot;#', '#&amp;#');
$unhtml_specialchars_replace = array('>', '<', '"', '&');
 
$html_entities_match = array('#&(?!(\#[0-9]+;))#', '#<#', '#>#', '#"#');
$html_entities_replace = array('&amp;', '&lt;', '&gt;', '&quot;');
//-- MOD END: Last Topic Title on Index -------------------

#
#-----[ FIND ]------------------------------------------
#
						// undo_htmlspecialchars();
								$lttitle = preg_replace("/&gt;/i", ">", $lttitle);
								$lttitle = preg_replace("/&lt;/i", "<", $lttitle);
								$lttitle = preg_replace("/&quot;/i", "\"", $lttitle);
								$lttitle = preg_replace("/&amp;/i", "&", $lttitle);

						//
						// Filter topic_title if not allowed to read
						//
								if (!$auth_read_ary[$subforum_data[$j]['forum_id']]['auth_read'])
								{
									$lttitle = '';
									$lang_in = '';
						    	}

							// append first 25 characters of topic title to last topic data
								$lttitle = (strlen($lttitle) > 25) ? substr($lttitle,0,25) . '...' : $lttitle;
#
#-----[ REPLACE WITH ]------------------------------------------
#

						//
						// Filter topic_title if not allowed to read
						//
								if (!$auth_read_ary[$subforum_data[$j]['forum_id']]['auth_read'])
								{
									$lttitle = '';
									$lang_in = '';
						    	}

						// undo_htmlspecialchars();
								$lttitle = preg_replace($unhtml_specialchars_match, $unhtml_specialchars_replace, $lttitle);

						// do_htmlspecialchars();
						// set length of topic title to 25 characters
								$lttitle = preg_replace($html_entities_match, $html_entities_replace, (strlen($lttitle) > 25) ? substr($lttitle,0,25) . '...' : $lttitle);

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM