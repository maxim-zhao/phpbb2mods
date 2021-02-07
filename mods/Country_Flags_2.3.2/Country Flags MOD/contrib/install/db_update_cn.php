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
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'af.gif\',\'阿富汗\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ax.gif\',\'阿克罗底利\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'al.gif\',\'阿尔巴尼亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ag.gif\',\'阿尔及利亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'aq.gif\',\'美属萨摩亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'an.gif\',\'安道尔\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ao.gif\',\'安哥拉\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'av.gif\',\'安圭拉\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ac.gif\',\'安地卡\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ar.gif\',\'阿根廷\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'am.gif\',\'亚美尼亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'aa.gif\',\'阿鲁巴\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'at.gif\',\'阿士摩卡提尔群岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'as.gif\',\'澳大利亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'au.gif\',\'奥地利\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'aj.gif\',\'亚塞拜然\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bf.gif\',\'巴哈马\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ba.gif\',\'巴林\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'fq.gif\',\'贝克群岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bg.gif\',\'孟加拉\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bb.gif\',\'巴贝多\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bs.gif\',\'印度礁\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bo.gif\',\'白俄罗斯\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'be.gif\',\'比利时\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bh.gif\',\'贝里斯\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bn.gif\',\'贝南\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bd.gif\',\'百慕达\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bt.gif\',\'不丹\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bl.gif\',\'玻利维亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bk.gif\',\'波士尼亚赫塞哥维纳\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bc.gif\',\'波札那\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bv.gif\',\'波维特岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'br.gif\',\'巴西\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'io.gif\',\'英属印度洋地区\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'vi.gif\',\'英属维尔京群岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bx.gif\',\'汶莱\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bu.gif\',\'保加利亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'uv.gif\',\'布吉纳法索\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bm.gif\',\'缅甸\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'by.gif\',\'蒲隆地\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cb.gif\',\'柬埔寨\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cm.gif\',\'喀麦隆\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ca.gif\',\'加拿大\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cv.gif\',\'维德角\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cj.gif\',\'开曼群岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ct.gif\',\'中非\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cd.gif\',\'查德\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ci.gif\',\'智利\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ch.gif\',\'China\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'kt.gif\',\'圣诞岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ip.gif\',\'克利珀顿岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ck.gif\',\'可可斯群岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'co.gif\',\'哥伦比亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cn.gif\',\'葛摩\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cg.gif\',\'刚果民主共和国\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cf.gif\',\'刚果\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cw.gif\',\'库克群岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cr.gif\',\'珊瑚海群岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cs.gif\',\'哥斯大黎加\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'iv.gif\',\'象牙海岸\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'hr.gif\',\'克罗埃西亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cu.gif\',\'古巴\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cy.gif\',\'赛普勒斯\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ez.gif\',\'捷克\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'da.gif\',\'丹麦\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'dx.gif\',\'德凯利亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'dj.gif\',\'吉布地\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'do.gif\',\'多米尼克\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'dr.gif\',\'多明尼加\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'tt.gif\',\'东帝汶\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ec.gif\',\'厄瓜多\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'eg.gif\',\'埃及阿拉伯\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'es.gif\',\'萨尔瓦多\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ek.gif\',\'赤道几内亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'er.gif\',\'厄利垂亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'en.gif\',\'爱沙尼亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'et.gif\',\'衣索比亚联邦民主共和国\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'eu.gif\',\'尤罗帕岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'fk.gif\',\'福克兰群岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'fo.gif\',\'法罗群岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'fj.gif\',\'斐济\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'fi.gif\',\'芬兰\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'fr.gif\',\'法兰西\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'fg.gif\',\'法属圭亚那\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'fp.gif\',\'法属玻里尼西亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'fs.gif\',\'法属南半球和南极地区\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gb.gif\',\'加彭\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ga.gif\',\'甘比亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gg.gif\',\'乔治亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gm.gif\',\'德意志\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gh.gif\',\'迦纳\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gi.gif\',\'直布罗陀\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'go.gif\',\'格洛里厄斯群岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gr.gif\',\'希腊\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gl.gif\',\'格陵兰\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gj.gif\',\'格瑞那达\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gp.gif\',\'瓜德鲁普岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gq.gif\',\'关岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gt.gif\',\'瓜地马拉\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gk.gif\',\'英属根息\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gv.gif\',\'几内亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'pu.gif\',\'几内亚比索\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'gy.gif\',\'盖亚那\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ha.gif\',\'海地\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'hm.gif\',\'赫德及麦当劳群岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'vt.gif\',\'教廷\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ho.gif\',\'宏都拉斯\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'hk.gif\',\'香港\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'hq.gif\',\'豪兰岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'hu.gif\',\'匈牙利\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ic.gif\',\'冰岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'in.gif\',\'印度\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'id.gif\',\'印度尼西亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ir.gif\',\'伊朗\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'iz.gif\',\'伊拉克\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ei.gif\',\'爱尔兰\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'im.gif\',\'英属马恩岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'is.gif\',\'以色列\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'it.gif\',\'义大利\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'jm.gif\',\'牙买加\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'jn.gif\',\'央棉岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ja.gif\',\'日本\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'dq.gif\',\'加维斯岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'je.gif\',\'英属泽西岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'jq.gif\',\'詹斯顿岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'jo.gif\',\'约旦\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ju.gif\',\'万诺瓦岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'kz.gif\',\'哈萨克\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ke.gif\',\'肯亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'kq.gif\',\'京曼岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'kr.gif\',\'吉里巴斯\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'kn.gif\',\'北韩\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ks.gif\',\'大韩民国(南韩)\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ku.gif\',\'科威特\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'kg.gif\',\'吉尔吉斯\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'la.gif\',\'寮国\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'lg.gif\',\'拉脱维亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'le.gif\',\'黎巴嫩\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'lt.gif\',\'赖索托\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'li.gif\',\'赖比瑞亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ly.gif\',\'利比亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ls.gif\',\'列支敦斯登\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'lh.gif\',\'立陶宛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'lu.gif\',\'卢森堡\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mc.gif\',\'澳门\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mk.gif\',\'马其顿\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ma.gif\',\'马达加斯加\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mi.gif\',\'马拉威\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'my.gif\',\'马来西亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mv.gif\',\'马尔地夫\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ml.gif\',\'马利\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mt.gif\',\'马尔他\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'rm.gif\',\'马绍尔群岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mb.gif\',\'法属马丁尼克\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mr.gif\',\'茅利塔尼亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mp.gif\',\'模里西斯\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mf.gif\',\'马约特\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mx.gif\',\'墨西哥\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'fm.gif\',\'密克罗尼西亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mq.gif\',\'中途岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'md.gif\',\'摩尔多瓦\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mn.gif\',\'摩纳哥\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mg.gif\',\'蒙古\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mh.gif\',\'蒙瑟拉特岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mo.gif\',\'摩洛哥\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mz.gif\',\'莫三比克\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'wa.gif\',\'纳米比亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'nr.gif\',\'诺鲁\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bq.gif\',\'那瓦萨岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'np.gif\',\'尼泊尔\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'nl.gif\',\'荷兰\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'nt.gif\',\'荷属安地列斯\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'nc.gif\',\'新喀里多尼亚岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'nz.gif\',\'纽西兰\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'nu.gif\',\'尼加拉瓜\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ng.gif\',\'尼日\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ni.gif\',\'奈及利亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ne.gif\',\'纽埃\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'nf.gif\',\'诺福克群岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'cq.gif\',\'北马里亚纳群岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'no.gif\',\'挪威\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'mu.gif\',\'阿曼\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'pk.gif\',\'巴基斯坦\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ps.gif\',\'帛琉\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'lq.gif\',\'帕迈拉岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'pm.gif\',\'巴拿马\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'pp.gif\',\'巴布亚纽几内亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'pa.gif\',\'巴拉圭\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'pe.gif\',\'秘鲁\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'rp.gif\',\'菲律宾\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'pc.gif\',\'皮特康岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'pl.gif\',\'波兰\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'po.gif\',\'葡萄牙\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'rq.gif\',\'波多黎各\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'qa.gif\',\'卡达\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'re.gif\',\'留尼旺\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ro.gif\',\'罗马尼亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'rs.gif\',\'俄罗斯\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'rw.gif\',\'卢安达\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sh.gif\',\'圣赫勒拿岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sc.gif\',\'圣克里斯多福\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'st.gif\',\'圣露西亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sb.gif\',\'圣匹及密启伦群岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'vc.gif\',\'圣文森\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ws.gif\',\'萨摩亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sm.gif\',\'圣马利诺\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'tp.gif\',\'圣多美普林西比\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sa.gif\',\'沙乌地阿拉伯\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sg.gif\',\'塞内加尔\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'yi.gif\',\'塞尔维亚与蒙特内哥罗\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'se.gif\',\'塞席尔\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sl.gif\',\'狮子山共和国\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sn.gif\',\'新加坡\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'lo.gif\',\'斯洛伐克\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'si.gif\',\'斯洛维尼亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'bp.gif\',\'索罗门群岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'so.gif\',\'索马利亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sf.gif\',\'南非\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sx.gif\',\'南乔治亚及南桑威奇群岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sp.gif\',\'西班牙\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ce.gif\',\'斯里兰卡\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'su.gif\',\'苏丹\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ns.gif\',\'苏利南\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sv.gif\',\'斯瓦尔巴群岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'wz.gif\',\'史瓦济兰\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sw.gif\',\'瑞典\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sz.gif\',\'瑞士\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'sy.gif\',\'叙利亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ti.gif\',\'塔吉克\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'tz.gif\',\'坦尚尼亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'th.gif\',\'泰国\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'to.gif\',\'多哥\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'tl.gif\',\'拖克劳群岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'tn.gif\',\'东加\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'td.gif\',\'千里达\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'te.gif\',\'特罗姆兰岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ts.gif\',\'突尼西亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'tu.gif\',\'土耳其\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'tx.gif\',\'土库曼\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'tk.gif\',\'土克斯及开科斯群岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'tv.gif\',\'吐瓦鲁\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ug.gif\',\'乌干达\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'up.gif\',\'乌克兰\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ae.gif\',\'阿拉伯联合大公国\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'uk.gif\',\'英国\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'us.gif\',\'美国\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'um.gif\',\'United States Pacific Island Wildlife Refuges\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'uy.gif\',\'乌拉圭\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'uz.gif\',\'乌兹别克\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'nh.gif\',\'万那杜\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ve.gif\',\'委内瑞拉\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'vm.gif\',\'越南\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'vq.gif\',\'维尔京群岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'wq.gif\',\'威克岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'wf.gif\',\'沃里斯与伏塔那岛\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ym.gif\',\'叶门\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'za.gif\',\'尚比亚\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'zi.gif\',\'辛巴威\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'tw.gif\',\'中华名国(台湾)\')';
$sql[] = 'INSERT INTO ' . $table_prefix . 'flags(flag_id,flag_image,flag_name) VALUES(\'\',\'ee.gif\',\'欧盟\')';
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