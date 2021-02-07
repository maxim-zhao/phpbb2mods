<?php
	/*******************************************
	*        admin_uploadpic_config.php        *
	*        --------------------------        *
	*                                          *
	*   date       : 08/2005 - 04/2006         *
    *   version    : 1.3.2                     *
	*   (C)/author : B.Funke                   *
	*   URL        : http://forum.beehave.de   *
	*                                          *
	********************************************/

/* UploadPic can be freely copied and used, as long as all provided files remain unchanged. */
/* For all further terms, the GNU GENERAL PUBLIC LICENSE applies to this MOD. */


	// Start
	define('IN_PHPBB', 1);

	if( !empty($setmodules) )
	{
		$filename = basename(__FILE__);
		$module['UploadPic']['UploadPic_menu_config'] = $filename;
		return;
	}


	// Include required files, get $phpEx and check permissions
	$phpbb_root_path = "./../";
	require($phpbb_root_path . 'extension.inc');
	require('./pagestart.' . $phpEx);
	require($phpbb_root_path . 'includes/uploadpic_functions.'.$phpEx);

	// change configuration
	if(!empty($HTTP_POST_VARS['GO']))
	{
		uploadpic_update_config("uploadpic_allowed", $HTTP_POST_VARS['uploadpic_allowed']);
		uploadpic_update_config("uploadpic_allowpm", intval($HTTP_POST_VARS['uploadpic_allowpm']));
		uploadpic_update_config("uploadpic_delete", intval($HTTP_POST_VARS['uploadpic_delete']));
		uploadpic_update_config("uploadpic_forcepath", $HTTP_POST_VARS['uploadpic_forcepath']);
		uploadpic_update_config("uploadpic_gallery", intval($HTTP_POST_VARS['uploadpic_gallery']));
		uploadpic_update_config("uploadpic_gallerysize", intval($HTTP_POST_VARS['uploadpic_gallerysize']));
		uploadpic_update_config("uploadpic_jpgqual", intval($HTTP_POST_VARS['uploadpic_jpgqual']));
		uploadpic_update_config("uploadpic_lrmod", intval($HTTP_POST_VARS['uploadpic_lrmod']));
		uploadpic_update_config("uploadpic_maxpicx", intval($HTTP_POST_VARS['uploadpic_maxpicx']));
		uploadpic_update_config("uploadpic_maxpicy", intval($HTTP_POST_VARS['uploadpic_maxpicy']));
		uploadpic_update_config("uploadpic_maxpmdays", intval($HTTP_POST_VARS['uploadpic_maxpmdays']));
		uploadpic_update_config("uploadpic_maxsize", intval($HTTP_POST_VARS['uploadpic_maxsize']));
		uploadpic_update_config("uploadpic_minimum", intval($HTTP_POST_VARS['uploadpic_minimum']));
		uploadpic_update_config("uploadpic_minposts", intval($HTTP_POST_VARS['uploadpic_minposts']));
		uploadpic_update_config("uploadpic_multiple", intval($HTTP_POST_VARS['uploadpic_multiple']));
		uploadpic_update_config("uploadpic_numlatest", intval($HTTP_POST_VARS['uploadpic_numlatest']));
		uploadpic_update_config("uploadpic_showlink", intval($HTTP_POST_VARS['uploadpic_showlink']));
		uploadpic_update_config("uploadpic_uniqfn", intval($HTTP_POST_VARS['uploadpic_uniqfn']));
		uploadpic_update_config("uploadpic_vbbcode", intval($HTTP_POST_VARS['uploadpic_vbbcode']));
		uploadpic_update_config("uploadpic_watermark", intval($HTTP_POST_VARS['uploadpic_watermark']));
		uploadpic_update_config("uploadpic_wmpicture", preg_replace('#^\/?(.*?)\/?$#', '\1', trim($HTTP_POST_VARS['uploadpic_wmpicture'])));
		uploadpic_update_config("uploadpic_wmpicx", intval($HTTP_POST_VARS['uploadpic_wmpicx']));
		uploadpic_update_config("uploadpic_wmpicy", intval($HTTP_POST_VARS['uploadpic_wmpicy']));
		uploadpic_update_config("uploadpic_wmposition", intval($HTTP_POST_VARS['uploadpic_wmposition']));
	}


	// Start
    $template->set_filenames(array('body' => 'admin/admin_uploadpic_config.tpl'));

	$template->assign_vars(array(
		'L_TITLE' => $lang['UploadPic_menu_config'],
		'L_UP_ALLOWED' => $lang['UP_conf_allowed'],
		'L_UP_ALLOWPM' => $lang['UP_conf_allowpm'],
		'L_UP_DELETE' => $lang['UP_conf_delete'],
		'L_UP_GALLERY' => $lang['UP_conf_gallery'],
		'L_UP_GALLERYSIZE' => $lang['UP_conf_gallerysize'],
		'L_UP_JPGQUAL' => $lang['UP_conf_jpgqual'],
		'L_UP_LRMOD' => $lang['UP_conf_lrmod'],
		'L_UP_MAXPICX' => $lang['UP_conf_maxpicx'],
		'L_UP_MAXPICY' => $lang['UP_conf_maxpicy'],
		'L_UP_MAXPMDAYS' => $lang['UP_conf_maxpmdays'],
		'L_UP_MAXSIZE' => $lang['UP_conf_maxsize'],
		'L_UP_MINIMUM' => $lang['UP_conf_minimum'],
		'L_UP_MINPOSTS' => $lang['UP_conf_minposts'],
		'L_UP_PICDIR' => $lang['UP_conf_picdir'],
		'L_UP_SHOWLINK' => $lang['UP_conf_showlink'],
		'L_UP_UNIQFN' => $lang['UP_conf_uniqfn'],
		'L_UP_VBBCODE' => $lang['UP_conf_vbbcode'],
		'L_UP_MULTIPLE' => $lang['UP_conf_multiple'],
		'L_UP_WATERMARK' => $lang['UP_conf_watermark'],
		'L_UP_WMPICTURE' => $lang['UP_conf_wmpicture'],
		'L_UP_WMPOSITION' => $lang['UP_conf_wmposition'],
		'L_UP_POSTL' => $lang['UP_conf_PosTL'],
		'L_UP_POSTC' => $lang['UP_conf_PosTC'],
		'L_UP_POSTR' => $lang['UP_conf_PosTR'],
		'L_UP_POSBL' => $lang['UP_conf_PosBL'],
		'L_UP_POSBC' => $lang['UP_conf_PosBC'],
		'L_UP_POSBR' => $lang['UP_conf_PosBR'],
		'L_UP_WMMINSIZE' => $lang['UP_conf_wmminsize'],
		'L_UP_NUMLATEST' => $lang['UP_conf_numlatest'],
		'L_UP_FORCEPATH' => $lang['UP_conf_forcepath'],
		'L_BOTH' => $lang['UP_Both'],
		'V_UP_ALLOWED' => $board_config['uploadpic_allowed'],
		'V_UP_ALLOWPM_CHECKED' => ($board_config['uploadpic_allowpm']) ? 'checked="checked"' : '',
		'V_UP_DELETE_CHECKED' => ($board_config['uploadpic_delete']) ? 'checked="checked"' : '',
		'V_UP_GALLERY_CHECKED' => ($board_config['uploadpic_gallery']) ? 'checked="checked"' : '',
		'V_UP_GALLERYSIZE' => $board_config['uploadpic_gallerysize'],
		'V_UP_JPGQUAL' => $board_config['uploadpic_jpgqual'],
		'V_UP_LRMOD_CHECKED' => ($board_config['uploadpic_lrmod']) ? 'checked="checked"' : '',
		'V_UP_MAXPICX' => $board_config['uploadpic_maxpicx'],
		'V_UP_MAXPICY' => $board_config['uploadpic_maxpicy'],
		'V_UP_MAXPMDAYS' => $board_config['uploadpic_maxpmdays'],
		'V_UP_MAXSIZE' => $board_config['uploadpic_maxsize'],
		'V_UP_MINIMUM' => $board_config['uploadpic_minimum'],
		'V_UP_MINPOSTS' => $board_config['uploadpic_minposts'],
		'V_UP_PICDIR' => $board_config['uploadpic_picdir'],
		'V_UP_SHOWLINK0_CHECKED' => ($board_config['uploadpic_showlink'] == 0) ? 'checked="checked"' : '',
		'V_UP_SHOWLINK1_CHECKED' => ($board_config['uploadpic_showlink'] == 1) ? 'checked="checked"' : '',
		'V_UP_SHOWLINK2_CHECKED' => ($board_config['uploadpic_showlink'] == 2) ? 'checked="checked"' : '',
		'V_UP_UNIQFN_CHECKED' => ($board_config['uploadpic_uniqfn']) ? 'checked="checked"' : '',
		'V_UP_VBBCODE_CHECKED' => ($board_config['uploadpic_vbbcode']) ? 'checked="checked"' : '',
		'V_UP_MULTIPLE_CHECKED' => ($board_config['uploadpic_multiple']) ? 'checked="checked"' : '',
		'V_UP_WATERMARK_CHECKED' => ($board_config['uploadpic_watermark']) ? 'checked="checked"' : '',
		'V_UP_WMPICTURE' => $board_config['uploadpic_wmpicture'],
		'V_UP_WMPICEXISTS' => (!file_exists(str_replace("//", "/", $phpbb_root_path.$board_config['uploadpic_wmpicture']))) ? $lang['Restore_Error_no_file'].'!' : '<img src="'.str_replace("//", "/", $phpbb_root_path.$board_config['uploadpic_wmpicture']).'">',
		'V_UP_WMPICX' => $board_config['uploadpic_wmpicx'],
		'V_UP_WMPICY' => $board_config['uploadpic_wmpicy'],
		'V_UP_WMPOSTL_CHECKED' => ($board_config['uploadpic_wmposition'] == 1) ? 'checked="checked"' : '',
		'V_UP_WMPOSTC_CHECKED' => ($board_config['uploadpic_wmposition'] == 2) ? 'checked="checked"' : '',
		'V_UP_WMPOSTR_CHECKED' => ($board_config['uploadpic_wmposition'] == 3) ? 'checked="checked"' : '',
		'V_UP_WMPOSBL_CHECKED' => ($board_config['uploadpic_wmposition'] == 4) ? 'checked="checked"' : '',
		'V_UP_WMPOSBC_CHECKED' => ($board_config['uploadpic_wmposition'] == 5) ? 'checked="checked"' : '',
		'V_UP_WMPOSBR_CHECKED' => ($board_config['uploadpic_wmposition'] == 6) ? 'checked="checked"' : '',
		'V_UP_NUMLATEST' => $board_config['uploadpic_numlatest'],
		'V_UP_FORCEPATH' => $board_config['uploadpic_forcepath'],
		'L_SAVE' => $lang['UP_Save'],
		'URL_SELF' => append_sid($HTTP_SERVER_VARS['PHP_SELF'])
	));


	// prepare page & output
	$template->pparse("body");

	include('./page_footer_admin.'.$phpEx);
?>