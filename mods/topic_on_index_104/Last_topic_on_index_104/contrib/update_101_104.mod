##############################################################
## MOD Title: Last Topic Title on Index - update 1.0.1 to 1.0.4
## MOD Author: Dicky <rfoote@tellink.net> (Richard Foote) http://dicky.askmaggymae.com
## MOD Description: Displays the title of and adds a link to the last topic replied to in a particular forum.
## MOD Version: 1.0.4
##
## Installation Level: Easy
## Installation Time: 3 Minutes
## Files To Edit: (3)
##				index.php
##				language/lang_english/lang_main.php
##				templates/subSilver/index_body.tpl
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
## 	 This MOD has been verified to work with phpBB 2.0.21
##	 This MOD can be installed by EasyMOD
##############################################################
## MOD History:
##
##   2006-03-12 - Version 1.0.4
##      - Improved on converting html characters to prevent XSS exploit
##   2006-03-12 - Version 1.0.3 - Not released
##      - Add function to decode html special characters
##   2006-01-31 - Version 1.0.2 - Not released
##      - Corrected problem with moved topics creating duplicate forum display on Index page
##   2005-12-31 - Version 1.0.1
##      - Optimize the code - No functional changes
##      - No longer need a separate MOD if you have Today/Yesterday installed
##   2005-12-18 - Version 1.0.0
##      - Add filtering for html characters in title
##      - Redo queries to reduce number of queries
##   2005-08-21 - Version 0.0.3
##		- Add word censoring
##		- Add Display topic title only if user allowed to read forum
##   2005-05-17 - Version 0.0.2
##		- Replaced sql query for faster times - query by y.m
##		- Added By: before poster name
##		- Added In: before topic title
##		- Added alternate text to topic title
##   2004-05-31 - Version 0.0.1
##      - initial version of the Last Topic Mod
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
index.php
#
#-----[ FIND ]------------------------------------------
#
include($phpbb_root_path . 'common.'.$phpEx);
#
#-----[ AFTER, ADD ]------------------------------------------
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
		default:
#
#-----[ FIND ]------------------------------------------
#
				ORDER BY f.cat_id, f.forum_order";
#
#-----[ BEFORE, ADD ]------------------------------------------
#
				WHERE t.topic_moved_id = 0 OR t.topic_moved_id IS NULL
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
								if (!$auth_read_ary[$forum_data[$j]['forum_id']]['auth_read'])
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
								if (!$auth_read_ary[$forum_data[$j]['forum_id']]['auth_read'])
								{
									$lttitle = '';
									$lang_in = '';
						    	}

						// undo_htmlspecialchars();
								$lttitle = preg_replace($unhtml_specialchars_match, $unhtml_specialchars_replace, $lttitle);

						// do_htmlspecialchars();
						// set length of topic title to 25 characters
								$lttitle = preg_replace($html_entities_match, $html_entities_replace, (strlen($lttitle) > 25) ? substr($lttitle,0,25) . '...' : $lttitle);
#-----[ SAVE/CLOSE ALL FILES ]-------------------------- 
# 
# EoM