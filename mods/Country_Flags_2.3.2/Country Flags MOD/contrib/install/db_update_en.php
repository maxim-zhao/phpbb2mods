<?php
/**
 *
 * @package SQL Parser
 * @script install/db_update.php
 * @copyright (c) 2005 phpBB Group
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License
 *
 *
 * - WARNINGS:
 *   *** This script contains SQL/DLL statements that will modify your database!!!
 *   *** The SQL/DDL statements contained in this script are optimized for MySQL only!
 *
 * - Installation:
 *   1) Make backups of your database before proceeding!
 *   2) Create a subdirectory named "install" (without quotes) in your phpBB installation.
 *   3) Save this file as "db_update.php" and upload to your newly created install directory.
 *   4) Now, open the script using your browser of choice as in the following example:
 *      http://www.example.com/forums/install/db_update.php
 *      ...and follow instructions.
 *   5) Once, your DB has been updated, remove the install directory and this file.
 *
 * - Notes:
 *   - This script can only be run by board administrators.
 *   - First, a confirmation panel will show all SQL statements.
 *   - Your database will only be updated once the confirmation panel has been confirmed.
 *
 */

define('IN_PHPBB', true);
$phpbb_root_path = '../';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
$gen_simple_header = true;

//
// Language entries used in this script.
//
$lang += array(
	'Update_confirm'			=> 'This panel will update your database with the SQL statements detailed below.<br /><br />Remember to make backups of your database before proceeding!<hr /><table><tr><td><pre>%s</pre></td></tr></table><hr />Click <i>Yes</i> to proceed or <i>No</i> to return to your board index.',
	'Updating_database'			=> 'Updating the Database',
	'Installation_complete'		=> 'Installation Complete',
	'Delete_this_file'			=> 'Please, be sure to delete your install directory and this file from your phpBB installation now.',
	'Successful'				=> 'Successful'
);

//
// Session Management.
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

//
// Only administrators here, please
//
if( !$userdata['session_logged_in'] )
{
	redirect(append_sid("login.$phpEx?redirect=".basename(__FILE__), true));
}
if( $userdata['user_level'] != ADMIN )
{
	if ( @file_exists($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx) )
	{
		include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx);
	}
	else
	{
		include($phpbb_root_path . 'language/lang_english/lang_admin.' . $phpEx);
	}
	message_die(GENERAL_MESSAGE, $lang['Not_admin']);
}

//
// Build Array of SQL Statements.
//
$sql = array();
$sql[] = 'ALTER TABLE ' . $table_prefix . 'users ADD user_from_flag VARCHAR(25) NULL';
$sql[] = 'CREATE TABLE ' . $table_prefix . 'flags (
    flag_id INTEGER(10) NOT NULL AUTO_INCREMENT,
    flag_name VARCHAR(50),
    flag_image VARCHAR(25),
    PRIMARY KEY (flag_id)
)';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'af.gif\',\'Afghanistan\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ax.gif\',\'Akrotiri\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'al.gif\',\'Albania\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ag.gif\',\'Algeria\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'aq.gif\',\'American Samoa\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'an.gif\',\'Andorra\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ao.gif\',\'Angola\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'av.gif\',\'Anguilla\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ac.gif\',\'Antigua and Barbuda\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ar.gif\',\'Argentina\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'am.gif\',\'Armenia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'aa.gif\',\'Aruba\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'at.gif\',\'Ashmore and Cartier Islands\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'as.gif\',\'Australia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'au.gif\',\'Austria\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'aj.gif\',\'Azerbaijan\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bf.gif\',\'Bahamas, The\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ba.gif\',\'Bahrain\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'fq.gif\',\'Baker Island\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bg.gif\',\'Bangladesh\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bb.gif\',\'Barbados\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bs.gif\',\'Bassas da India\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bo.gif\',\'Belarus\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'be.gif\',\'Belgium\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bh.gif\',\'Belize\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bn.gif\',\'Benin\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bd.gif\',\'Bermuda\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bt.gif\',\'Bhutan\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bl.gif\',\'Bolivia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bk.gif\',\'Bosnia and Herzegovina\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bc.gif\',\'Botswana\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bv.gif\',\'Bouvet Island\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'br.gif\',\'Brazil\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'io.gif\',\'British Indian Ocean Territory\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'vi.gif\',\'British Virgin Islands\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bx.gif\',\'Brunei\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bu.gif\',\'Bulgaria\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'uv.gif\',\'Burkina Faso\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bm.gif\',\'Burma\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'by.gif\',\'Burundi\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cb.gif\',\'Cambodia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cm.gif\',\'Cameroon\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ca.gif\',\'Canada\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cv.gif\',\'Cape Verde\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cj.gif\',\'Cayman Islands\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ct.gif\',\'Central African Republic\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cd.gif\',\'Chad\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ci.gif\',\'Chile\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ch.gif\',\'China\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'kt.gif\',\'Christmas Island\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ip.gif\',\'Clipperton Island\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ck.gif\',\'Cocos (Keeling) Islands\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'co.gif\',\'Colombia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cn.gif\',\'Comoros\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cg.gif\',\'Congo, Democratic Republic of the\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cf.gif\',\'Congo, Republic of the\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cw.gif\',\'Cook Islands\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cr.gif\',\'Coral Sea Islands\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cs.gif\',\'Costa Rica\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'iv.gif\',\'Cote d\'Ivoire\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'hr.gif\',\'Croatia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cu.gif\',\'Cuba\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cy.gif\',\'Cyprus\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ez.gif\',\'Czech Republic\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'da.gif\',\'Denmark\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'dx.gif\',\'Dhekelia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'dj.gif\',\'Djibouti\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'do.gif\',\'Dominica\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'dr.gif\',\'Dominican Republic\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'tt.gif\',\'East Timor\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ec.gif\',\'Ecuador\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'eg.gif\',\'Egypt\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'es.gif\',\'El Salvador\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ek.gif\',\'Equatorial Guinea\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'er.gif\',\'Eritrea\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'en.gif\',\'Estonia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'et.gif\',\'Ethiopia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'eu.gif\',\'Europa Island\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'fk.gif\',\'Falkland Islands (Islas Malvinas)\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'fo.gif\',\'Faroe Islands\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'fj.gif\',\'Fiji\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'fi.gif\',\'Finland\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'fr.gif\',\'France\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'fg.gif\',\'French Guiana\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'fp.gif\',\'French Polynesia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'fs.gif\',\'French Southern and Antarctic Lands\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gb.gif\',\'Gabon\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ga.gif\',\'Gambia, The\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gg.gif\',\'Georgia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gm.gif\',\'Germany\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gh.gif\',\'Ghana\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gi.gif\',\'Gibraltar\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'go.gif\',\'Glorioso Islands\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gr.gif\',\'Greece\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gl.gif\',\'Greenland\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gj.gif\',\'Grenada\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gp.gif\',\'Guadeloupe\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gq.gif\',\'Guam\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gt.gif\',\'Guatemala\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gk.gif\',\'Guernsey\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gv.gif\',\'Guinea\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'pu.gif\',\'Guinea-Bissau\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gy.gif\',\'Guyana\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ha.gif\',\'Haiti\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'hm.gif\',\'Heard Island and McDonald Islands\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'vt.gif\',\'Holy See (Vatican City)\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ho.gif\',\'Honduras\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'hk.gif\',\'Hong Kong\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'hq.gif\',\'Howland Island\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'hu.gif\',\'Hungary\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ic.gif\',\'Iceland\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'in.gif\',\'India\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'id.gif\',\'Indonesia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ir.gif\',\'Iran\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'iz.gif\',\'Iraq\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ei.gif\',\'Ireland\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'im.gif\',\'Isle of Man\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'is.gif\',\'Israel\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'it.gif\',\'Italy\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'jm.gif\',\'Jamaica\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'jn.gif\',\'Jan Mayen\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ja.gif\',\'Japan\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'dq.gif\',\'Jarvis Island\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'je.gif\',\'Jersey\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'jq.gif\',\'Johnston Atoll\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'jo.gif\',\'Jordan\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ju.gif\',\'Juan de Nova Island\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'kz.gif\',\'Kazakhstan\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ke.gif\',\'Kenya\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'kq.gif\',\'Kingman Reef\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'kr.gif\',\'Kiribati\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'kn.gif\',\'Korea, North\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ks.gif\',\'Korea, South\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ku.gif\',\'Kuwait\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'kg.gif\',\'Kyrgyzstan\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'la.gif\',\'Laos\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'lg.gif\',\'Latvia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'le.gif\',\'Lebanon\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'lt.gif\',\'Lesotho\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'li.gif\',\'Liberia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ly.gif\',\'Libya\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ls.gif\',\'Liechtenstein\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'lh.gif\',\'Lithuania\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'lu.gif\',\'Luxembourg\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mc.gif\',\'Macau\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mk.gif\',\'Macedonia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ma.gif\',\'Madagascar\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mi.gif\',\'Malawi\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'my.gif\',\'Malaysia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mv.gif\',\'Maldives\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ml.gif\',\'Mali\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mt.gif\',\'Malta\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'rm.gif\',\'Marshall Islands\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mb.gif\',\'Martinique\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mr.gif\',\'Mauritania\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mp.gif\',\'Mauritius\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mf.gif\',\'Mayotte\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mx.gif\',\'Mexico\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'fm.gif\',\'Micronesia, Federated States of\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mq.gif\',\'Midway Islands\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'md.gif\',\'Moldova\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mn.gif\',\'Monaco\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mg.gif\',\'Mongolia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mh.gif\',\'Montserrat\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mo.gif\',\'Morocco\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mz.gif\',\'Mozambique\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'wa.gif\',\'Namibia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'nr.gif\',\'Nauru\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bq.gif\',\'Navassa Island\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'np.gif\',\'Nepal\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'nl.gif\',\'Netherlands\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'nt.gif\',\'Netherlands Antilles\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'nc.gif\',\'New Caledonia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'nz.gif\',\'New Zealand\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'nu.gif\',\'Nicaragua\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ng.gif\',\'Niger\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ni.gif\',\'Nigeria\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ne.gif\',\'Niue\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'nf.gif\',\'Norfolk Island\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cq.gif\',\'Northern Mariana Islands\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'no.gif\',\'Norway\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mu.gif\',\'Oman\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'pk.gif\',\'Pakistan\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ps.gif\',\'Palau\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'lq.gif\',\'Palmyra Atoll\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'pm.gif\',\'Panama\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'pp.gif\',\'Papua New Guinea\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'pa.gif\',\'Paraguay\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'pe.gif\',\'Peru\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'rp.gif\',\'Philippines\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'pc.gif\',\'Pitcairn Islands\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'pl.gif\',\'Poland\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'po.gif\',\'Portugal\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'rq.gif\',\'Puerto Rico\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'qa.gif\',\'Qatar\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'re.gif\',\'Reunion\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ro.gif\',\'Romania\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'rs.gif\',\'Russia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'rw.gif\',\'Rwanda\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sh.gif\',\'Saint Helena\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sc.gif\',\'Saint Kitts and Nevis\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'st.gif\',\'Saint Lucia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sb.gif\',\'Saint Pierre and Miquelon\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'vc.gif\',\'Saint Vincent and the Grenadines\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ws.gif\',\'Samoa\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sm.gif\',\'San Marino\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'tp.gif\',\'Sao Tome and Principe\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sa.gif\',\'Saudi Arabia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sg.gif\',\'Senegal\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'yi.gif\',\'Serbia and Montenegro\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'se.gif\',\'Seychelles\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sl.gif\',\'Sierra Leone\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sn.gif\',\'Singapore\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'lo.gif\',\'Slovakia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'si.gif\',\'Slovenia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bp.gif\',\'Solomon Islands\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'so.gif\',\'Somalia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sf.gif\',\'South Africa\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sx.gif\',\'South Georgia and the South Sandwich Islands\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sp.gif\',\'Spain\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ce.gif\',\'Sri Lanka\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'su.gif\',\'Sudan\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ns.gif\',\'Suriname\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sv.gif\',\'Svalbard\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'wz.gif\',\'Swaziland\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sw.gif\',\'Sweden\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sz.gif\',\'Switzerland\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sy.gif\',\'Syria\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ti.gif\',\'Tajikistan\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'tz.gif\',\'Tanzania\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'th.gif\',\'Thailand\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'to.gif\',\'Togo\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'tl.gif\',\'Tokelau\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'tn.gif\',\'Tonga\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'td.gif\',\'Trinidad and Tobago\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'te.gif\',\'Tromelin Island\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ts.gif\',\'Tunisia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'tu.gif\',\'Turkey\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'tx.gif\',\'Turkmenistan\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'tk.gif\',\'Turks and Caicos Islands\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'tv.gif\',\'Tuvalu\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ug.gif\',\'Uganda\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'up.gif\',\'Ukraine\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ae.gif\',\'United Arab Emirates\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'uk.gif\',\'United Kingdom\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'us.gif\',\'United States\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'um.gif\',\'United States Pacific Island Wildlife Refuges\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'uy.gif\',\'Uruguay\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'uz.gif\',\'Uzbekistan\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'nh.gif\',\'Vanuatu\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ve.gif\',\'Venezuela\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'vm.gif\',\'Vietnam\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'vq.gif\',\'Virgin Islands\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'wq.gif\',\'Wake Island\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'wf.gif\',\'Wallis and Futuna\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ym.gif\',\'Yemen\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'za.gif\',\'Zambia\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'zi.gif\',\'Zimbabwe\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'tw.gif\',\'Taiwan\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ee.gif\',\'European Union\')';
$sql_count = count($sql);

//
// Output confirmation page?
//
$cancel = isset($HTTP_POST_VARS['cancel']) ? true : false;
$confirm = isset($HTTP_POST_VARS['confirm']) ? true : false;
$mode = isset($HTTP_POST_VARS['mode']) ? trim(htmlspecialchars($HTTP_POST_VARS['mode'])) : '';

if( $cancel )
{
	redirect(append_sid("index.$phpEx", true));
}

if( !$confirm || $mode != 'db_update' )
{
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$template->set_filenames(array(
		'confirm_body' => 'confirm_body.tpl')
	);

	$message = sprintf($lang['Update_confirm'], implode(";\n\n", $sql));

	$s_hidden_fields = '<input type="hidden" name="mode" value="db_update" />';

	$template->assign_vars(array(
		'L_INDEX'			=> '',
		'MESSAGE_TITLE'		=> $lang['Information'],
		'MESSAGE_TEXT'		=> $message,
		'L_YES'				=> $lang['Yes'],
		'L_NO'				=> $lang['No'],
		'S_CONFIRM_ACTION'	=> append_sid(basename(__FILE__)),
		'S_HIDDEN_FIELDS'	=> $s_hidden_fields)
	);

	$template->pparse('confirm_body');

	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
}

//
// Send Page Header.
//
$page_title = $lang['Updating_database'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

//
// Execute SQL and get Results.
//
$sql_rows = '';
for( $i = 0; $i < $sql_count; $i++ )
{
	if( !($result = $db->sql_query($sql[$i])) )
	{
		$error = $db->sql_error();
		$color = '#FF0000';
		$success = $lang['Error'] . ':';
		$errmsg = ' ' . $error['message'];
	}
	else
	{
		$color = '#00AA00';
		$success = $lang['Successful'];
		$errmsg = '';
	}
	$class = ($i%2) == 0 ? 'row1' : 'row2';
	$sql_rows .= '<tr><td class="'.$class.'"><div class="genmed">' . $sql[$i] . ';<br /><br /><b style="color:' . $color . ';">' . $success . '</b>' . $errmsg . '</div></td></tr>';
}

//
// Build the Report.
//
$click_return_index = sprintf($lang['Click_return_index'], '<a class="genmed" href="' . append_sid($phpbb_root_path . "index.$phpEx") . '">', '</a>');

$html = <<<EOT
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="forumline">
	<tr>
		<th>{$page_title}</th>
	</tr>
	<tr>
		<td>
			<table cellpadding="8" cellspacing="1" border="0" align="center">
				{$sql_rows}
			</table>
		</td>
	</tr>
	<tr>
		<td class="row3"><img src="{$phpbb_root_path}images/spacer.gif" border="0" height="4" alt="" /></td>
	</tr>
	<tr>
		<th>{$lang['Installation_complete']}</th>
	</tr>
	<tr>
		<td align="center">
			<table cellpadding="8" cellspacing="0" border="0" align="center">
				<tr>
					<td>
						<b class="gen" style="color:#EE0000;">{$lang['Delete_this_file']}</b>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="catBottom" align="center">
			<span class="genmed">{$click_return_index}</span>
		</td>
	</tr>
</table>
EOT;
echo $html;

//
// Send Page Footer.
//
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>