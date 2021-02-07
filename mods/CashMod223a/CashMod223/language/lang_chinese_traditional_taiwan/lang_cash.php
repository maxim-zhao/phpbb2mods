<?php

/*************************************************************************** 
*                            lang_cash.php [Chinese Traditional Taiwan] 
*                              ------------------- 
*     begin                : Sat Jul 20 2003 
*     copyright            : (C) 2003 BlueSky_Ray 
*     email                : blue_sky_ray@hotmail.com 
* 
*     $Id: lang_cash.php,v 1.0.0.0 2003/10/08 00:55:17 Xore Exp $ 
* 
****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

//
// Admin menu
//
$lang['Cmcat_main'] = '主要功能';
$lang['Cmcat_addons'] = '附加功能';
$lang['Cmcat_other'] = '其他';
$lang['Cmcat_help'] = '幫助';

$lang['Cash_Configuration'] = '基本設置';
$lang['Cash_Currencies'] = '貨幣設定';
$lang['Cash_Exchange'] = '兌換';
$lang['Cash_Events'] = '事件';
$lang['Cash_Forums'] = '版區權限';
$lang['Cash_Groups'] = '群組';
$lang['Cash_Help'] = '幫助';
$lang['Cash_Logs'] = '記錄';
$lang['Cash_Settings'] = '細部設定';

$lang['Cmenu_cash_config'] = '所有貨幣的基本設定';
$lang['Cmenu_cash_currencies'] = '增加，刪除或，再定義貨幣';
$lang['Cmenu_cash_settings'] = '特殊設定每一個貨幣';
$lang['Cmenu_cash_events'] = '在用戶事件給用戶的貨幣總額';
$lang['Cmenu_cash_reset'] = '重整 / 重設貨幣總額';
$lang['Cmenu_cash_exchange'] = '開啟 / 關閉貨幣兌換以及兌換比率';
$lang['Cmenu_cash_forums'] = '開啟或關閉貨幣於每一個版區';
$lang['Cmenu_cash_groups'] = '設定群組，等級，封號的貨幣';
$lang['Cmenu_cash_log'] = '觀看 / 刪除已記錄的貨幣設定動作';
$lang['Cmenu_cash_help'] = '虛擬貨幣幫助';

// Config
$lang['Cash_config'] = '虛擬貨幣';
$lang['Cash_config'] = '虛擬貨幣管理選項';

$lang['Cash_admincp'] = '管理員CP 模式';
$lang['Cash_adminnavbar'] = 'Cash Mod Navbar';
$lang['Sidebar'] = 'Sidebar';
$lang['Menu'] = '選單';

$lang['Messages'] = '訊息'; 
$lang['Spam'] = '灌水';
$lang['Click_return_cash_config'] = '點選%s這裡%s回到虛擬貨幣管理選項'; 
$lang['Cash_config_updated'] = '虛擬貨幣管理選項設定完成';
$lang['Cash_disabled'] = '關閉虛擬現金模組'; 
$lang['Cash_message'] = '在發表/回覆確認畫面顯示賺取金額'; 
$lang['Cash_display_message'] = '會員賺取金額時顯示的訊息'; 
$lang['Cash_display_message_explain'] = '其中必須包含一個"%s"';$lang['Cash_spam_disable_num'] = '發文達此數量時(防止灌水)'; 
$lang['Cash_spam_disable_time'] = '多少時間內到達此發文數量停止獲得虛擬貨幣 (小時)';
$lang['Cash_spam_disable_message'] = '給過量發文者停止獲得虛擬貨幣的通告';


// Currencies
$lang['Cash_currencies'] = '流通貨幣';
$lang['Cash_currencies_explain'] = '以下表格可以設定你的論壇流通貨幣';

$lang['Click_return_cash_currencies'] = '點選%s這裡%s回到流通貨幣管理選項';
$lang['Cash_currencies_updated'] = '流通貨幣管理選項設定完成';
$lang['Cash_field'] = '欄位';
$lang['Cash_currency'] = '貨幣';
$lang['Name_of_currency'] = '貨幣名稱';
$lang['Default'] = '預設';
$lang['Cash_order'] = '順序';
$lang['Cash_set_all'] = '設定所有人金錢至此量';
$lang['Cash_delete'] = '刪除貨幣';
$lang['Decimals'] = '小數位數目';

$lang['Cash_confirm_copy'] = '複製用戶%s所有資料到%s?<br />執行後是無法復原的';
$lang['Cash_confirm_delete'] = '刪除%s?<br />執行後是無法復原的';

$lang['Cash_copy_currency'] = '複製貨幣資料';

$lang['Cash_new_currency'] = '開新貨幣';
$lang['Cash_currency_dbfield'] = '貨幣的資料庫欄位';
$lang['Cash_currency_decimals'] = '貨幣的小數位數目';
$lang['Cash_currency_default'] = '貨幣的開始值';

$lang['Bad_dbfield'] = '錯誤的資料庫欄位名稱, 必須是如下的。<br /><br />%s<br /><br/>例如:<br />user_points<br />user_cash<br />user_money<br />user_warnings<br /><br />';

// 0 currencies (most admin panels won't work... )
$lang['Insufficient_currencies'] = '你設定之前必須開新貨幣';

//
// Add-ons ?
//

// Events
$lang['Cash_events'] = '事件';
$lang['Cash_events_explain'] = '你可以設定一個事件，當你執行此事件可以增加 / 減少用戶一定的貨幣';

$lang['No_events'] = '沒有事件';
$lang['Existing_events'] = '事件';
$lang['Add_an_event'] = '增加事件';
$lang['Cash_events_updated'] = '事件設定完成';
$lang['Click_return_cash_events'] = '點選%s這裡%s回到事件設定';

//Reset
$lang['Cash_reset_title'] = '重設';
$lang['Cash_reset_explain'] = '你可以重設所有用戶現有的貨幣';

$lang['Cash_resetting'] = '重設中';
$lang['User_of'] = '%s個用戶於個%s用戶';

$lang['Set_checked'] = '設定重設貨幣於這個數值';
$lang['Recount_checked'] = '所有貨幣重新開始';

$lang['Cash_confirm_reset'] = '貨幣將要重設?<br />執行後是無法復原的';
$lang['Cash_confirm_recount'] = '所有貨幣將重新開始?<br />執行後是無法復原的。<br /><br />這個動作不適用於有大數值貨幣的用戶 或/和 主題。<br /><br />建議你先關閉你的虛擬貨幣。<br />關閉你的虛擬貨幣可到%s基本設定%s';

$lang['Update_successful'] = '更新完成';
$lang['Click_return_cash_reset'] = '點選%s這裡%s回到貨幣重設';
$lang['User_updated'] = '%s 已更新<br />';

//
// Others
//

// Exchange
$lang['Cash_exchange'] = '兌換';
$lang['Cash_exchange_explain'] = '你可以設定以及開啟你貨幣兌換的設定';

$lang['Exchange_insufficient_currencies'] = '你沒有一個以上的貨幣<br />你至少有兩種或以上貨幣';

// Forums
$lang['Forum_cm_settings'] = '版區權限';
$lang['Forum_cm_settings_explain'] = '你可以開啟 / 關閉版區是否可以增加用戶貨幣';

// Groups
$lang['Cash_groups'] = '群組設定';
$lang['Cash_groups_explain'] = '你可以設定每一個群組可得的貨幣數量等等的設定';

$lang['Click_return_cash_groups'] = '點選%s這裡%s回到群組設定';
$lang['Cash_groups_updated'] = '群組設定更新完成';

$lang['Set'] = '設定';
$lang['Up'] = '上';
$lang['Down'] = '下';

// Help
$lang['Cmh_support'] = 'Cash Mod支援';
$lang['Cmh_troubleshooting'] = '排解疑難';
$lang['Cmh_upgrading'] = '升級';
$lang['Cmh_addons'] = '附加功能';
$lang['Cmh_demo_boards'] = '演示';
$lang['Cmh_translations'] = '語系翻譯';
$lang['Cmh_features'] = 'Cash Mod 資訊';

$lang['Cmhe_support'] = 'Cash Mod 的資料';
$lang['Cmhe_troubleshooting'] = '如果你有問題，你可以在這裡來修正你的Cash Mod';
$lang['Cmhe_upgrading'] = '你的版本是%s，最新版本會貼在這裡';
$lang['Cmhe_addons'] = 'Cash Mod 的附加功能一覽';
$lang['Cmhe_demo_boards'] = 'Cash Mod 的演示論壇一覽';
$lang['Cmhe_translations'] = 'Cash Mod 的語系一覽';
$lang['Cmhe_features'] = 'Cash Mod 的版本資訊';

// Logs
$lang['Logs'] = '記錄';
$lang['Logs_explain'] = '你可以看到你曾經更改貨幣的記錄';

// Settings
$lang['Cash_settings'] = '設定';
$lang['Cash_settings_explain'] = '你可以設定你的每個貨幣在論壇中的仔細設定';


$lang['Display'] = '顯示';
$lang['Implementation'] = '貨幣加減設定';
$lang['Allowances'] = '定期貨幣加減設定';
$lang['Allowances_explain'] = '定期貨幣加減設定是Cash Mod定期貨幣加減外掛';
$lang['Click_return_cash_settings'] = '這裡%s這裡%s回到細部設定';
$lang['Cash_settings_updated'] = '細部設定更新完成';

$lang['Cash_enabled'] = '開啟貨幣';
$lang['Cash_custom_currency'] = '貨幣的名稱';
$lang['Cash_image'] = '貨幣名稱以圖片顯示';
$lang['Cash_imageurl'] = '圖片 (PHPBB的根目錄):';
$lang['Cash_imageurl_explain'] = '使用後你的貨幣名稱要變成圖片';
$lang['Prefix'] = '字首';
$lang['Postfix'] = '字尾';
$lang['Cash_currency_style'] = '圖片顯示風格';
$lang['Cash_currency_style_explain'] = '顯示於 ' . $lang['Prefix'] . ' 或 ' . $lang['Postfix'];
$lang['Cash_display_usercp'] = '在個人資料中顯示擁有金額';
$lang['Cash_display_userpost'] = '在文章旁簡介中顯示擁有金額';
$lang['Cash_display_memberlist'] = '在會員列表顯示擁有金額';

$lang['Cash_amount_per_post'] = '每篇發文可獲得的金額 (開新主題)'; 
$lang['Cash_amount_post_bonus'] = '每篇回文中開題作者可得到的紅利金額'; 
$lang['Cash_amount_per_reply'] = '每篇回文可獲得的金額'; 
$lang['Cash_amount_per_character'] = '每個字元可獲得的金額'; 
$lang['Cash_maxearn'] = '每篇發文可獲得金額最大值'; 
$lang['Cash_include_quotes'] = '引言是否包含在字元計算中'; 
$lang['Cash_allow_donate'] = '允許會員將金錢贈送給其它會員'; 
$lang['Cash_allow_mod_edit'] = '允許版面管理員修改會員持有的現金'; 
$lang['Cash_allow_negative'] = '允許會員呈現負債';
$lang['Cash_amount_per_pm'] = '私人訊息是否可獲得的金額';
$lang['Cash_exchangeable'] = '允許用戶可以兌換此貨幣';

$lang['Cash_allowance_enabled'] = '開始定期貨幣加減';
$lang['Cash_allowance_amount'] = '可得到貨幣總額';
$lang['Cash_allownace_frequency'] = '得到貨幣時期';
$lang['Cash_allownace_frequencies'][CASH_ALLOW_DAY] = '日';
$lang['Cash_allownace_frequencies'][CASH_ALLOW_WEEK] = '星期';
$lang['Cash_allownace_frequencies'][CASH_ALLOW_MONTH] = '月';
$lang['Cash_allownace_frequencies'][CASH_ALLOW_YEAR] = '年';
$lang['Cash_allowance_next'] = '下一次定期貨幣加減時間相距';

// Groups
$lang['Cash_status_type'][CASH_GROUPS_DEFAULT] = '預設';
$lang['Cash_status_type'][CASH_GROUPS_CUSTOM] = '預設';
$lang['Cash_status_type'][CASH_GROUPS_OFF] = '關閉';
$lang['Cash_status'] = 'Status';

// Cash Mod Log Text
// Note: there isn't really a whole lot i can do about it, if languages use a
// grammar that requires these arguments (%s) to be in a different order, it's stuck in
// this order. The up side is that this is about 10x more comprehensive than the
// last way i did it.
//

/* argument order: [donater id][donater name][currency list][receiver id][receiver name]

eg.
Joe donated 14 gold, $10, 3 points to Peter
*/
$lang['Cash_clause'][CASH_LOG_DONATE] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> donated <b>%s</b> to <a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a>';

/* argument order: [admin/mod id][admin/mod name][editee id][editee name][Added list][removed list][Set list]

eg.
Joe modified Peter's Cash:
Added 14 gold
Removed $10
Set 3 points
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_MODEDIT] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new">%s</a> edited <a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a>\'s Cash:<br />Added <b>%s</b><br />Removed <b>%s</b><br />Set to <b>%s</b>';

/* argument order: [admin/mod id][admin/mod name][currency name]

eg.
Joe created points 
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_CREATE_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> created <b>%s</b>';

/* argument order: [admin/mod id][admin/mod name][currency name]

eg.
Joe deleted $ 
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_DELETE_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> deleted <b>%s</b>';

/* argument order: [admin/mod id][admin/mod name][old currency name][new currency name]

eg.
Joe renamed silver to gold
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_RENAME_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> renamed <b>%s</b> to <b>%s</b>';

/* argument order: [admin/mod id][admin/mod name][copied currency name][copied over currency name]

eg.
Joe copied users' gold to points
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_COPY_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> copied users\' <b>%s</b> to <b>%s</b>';

$lang['Log'] = '記錄';
$lang['Action'] = '動作';
$lang['Type'] = '種類';
$lang['Cash_all'] = '所有';
$lang['Cash_admin'] = '管理員';
$lang['Cash_user'] = '用戶';
$lang['Delete_all_logs'] = '刪除所有記錄';
$lang['Delete_admin_logs'] = '刪除管理員記錄';
$lang['Delete_user_logs'] = '刪除用戶記錄';
$lang['All'] = '全部';
$lang['Day'] = '日';
$lang['Week'] = '星期';
$lang['Month'] = '月';
$lang['Year'] = '年';
$lang['Page'] = '頁';
$lang['Per_page'] = '每頁';

//
// Now for some regular stuff...
//

//
// User CP
//
$lang['Donate'] = '贈與貨幣';
$lang['Mod_usercash'] = '修改%s貨幣';
$lang['Exchange'] = '兌換';

//
// Exchange
//
$lang['Convert'] = '轉換';
$lang['Select_one'] = '選擇';
$lang['Exchange_lack_of_currencies'] = '你沒有可以足夠兌換的一種以上貨幣<br />如果你要兌換的話，管理員必須發行兩種貨幣以上。';
$lang['You_have'] = '你共有';
$lang['One_worth'] = '一個 %s 價值:';
$lang['Cannot_exchange'] = '現在你不能兌換 %s';

//
// Donate
//
$lang['Amount'] = '總額';
$lang['Donate_to'] = '贈與 %s';
$lang['Donation_recieved'] = '你收到了 %s 贈與的貨幣。';
$lang['Has_donated'] = '%s 贈與 [b]%s[/b] 給你。 \n\n%s 對你說:\n';

//
// Mod Edit
//
$lang['Add'] = '增加';
$lang['Remove'] = '移除';
$lang['Omit'] = '忽略';
$lang['Amount'] = '總額';
$lang['Donate_to'] = '贈與 %s';
$lang['Has_moderated'] = '%s 節制你的 %s';
$lang['Has_added'] = '[*]增加: [b]%s[/b]\n';
$lang['Has_removed'] = '[*]移除: [b]%s[/b]\n';
$lang['Has_set'] = '[*]設為: [b]%s[/b]\n';

// That's all folks!

?>