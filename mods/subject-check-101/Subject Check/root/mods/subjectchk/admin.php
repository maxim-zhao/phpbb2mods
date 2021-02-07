<?php
/*-----------------------------------------------------------------------------
    Subject Check - A phpBB Add-On
  ----------------------------------------------------------------------------
    admin.php
       Admin Class File
    File Version: 1.0.0
    Begun: November 3, 2006                 Last Modified: December 13, 2006
  ----------------------------------------------------------------------------
    Copyright 2006 by Jeremy Rogers.  Please read the license.txt included
    with the phpBB Add-On listed above for full license and copyright details.
  ----------------------------------------------------------------------------
    Class and Function Quick Reference
             Names                                 Search Labels
         SubjectCheck_Admin..........................[admcls]
            print_forum_fields.......................[pff]
            add_to_insert............................[ati]
            add_to_update............................[atu]
            print_config_fields......................[pcf]
-----------------------------------------------------------------------------*/

if( !defined('IN_PHPBB') || !defined('IN_ADMIN') )
{
	die('Nope, not gonna do it.');
}

require_once($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_subchk.' . $phpEx);
$subchk = new SubjectCheck_Admin();

/*	SubjectCheck_Admin                                      [admcls]
       Handles administration tasks for Subject Check.
                                                                             */
class SubjectCheck_Admin 
{
/*	print_forum_fields                                      [pff]
       Prints forum administration fields in template.

    Arguments:
       None.

    Return:
       None.
                                                                             */
	function print_forum_fields()
	{
		global $mode, $row, $lang, $template;
		$forum_subject_check = ( $mode == 'editforum' ) ? intval($row['forum_subject_check']) : 0;
		$check_yes = $check_no = '';
		( $forum_subject_check ) ? $check_yes = 'checked="checked"' : $check_no = 'checked="checked"';

		$template->assign_vars(array(
			'SUBJECT_CHECK_YES'		=> $check_yes,
			'SUBJECT_CHECK_NO'		=> $check_no,
			'L_YES'					=> $lang['Yes'],
			'L_NO'					=> $lang['No'],
			'L_SUBJECT_CHECK'		=> $lang['SUBCHK_FORUM']
		));
	}

/*	add_to_insert                                           [ati]
       Adds fields to the INSERT query used to create new forums.

    Arguments:
       None.

    Return:
       None.
                                                                             */
	function add_to_insert()
	{
		global $field_sql, $value_sql, $HTTP_POST_VARS;

		$field_sql .= ', forum_subject_check';
		$value_sql .= ', ' . intval($HTTP_POST_VARS['forum_subject_check']);
	}

/*	add_to_update                                           [atu]
       Adds fields to the UPDATE query used to change forums.
	   This may be incompatible with some other modifications.

    Arguments:
       None.

    Return:
       None.
                                                                             */
	function add_to_update()
	{
		global $sql, $HTTP_POST_VARS;

		$sql = str_replace('SET forum_name =', 'SET forum_subject_check = ' . intval($HTTP_POST_VARS['forum_subject_check']) . ', forum_name =', $sql);
	}

/*	print_config_fields                                     [pcf]
       Prints form fields in the board configuration form.

    Arguments:
       None.

    Return:
       None.
                                                                             */
	function print_config_fields()
	{
		global $new, $lang, $template;
		$template->set_filenames(array('subject_check' => 'admin/subject_check.tpl'));
		$vars = array(
			'L_SUBCHK_TITLE'			=>	$lang['SUBCHK_TITLE'],
			'L_SUBCHK_FORUM_EXPLAIN'	=>	$lang['SUBCHK_FORUM_EXPLAIN'],
			'L_SUBCHK_FORUM'			=>	$lang['SUBCHK_FORUM'],
			'L_SUBCHK_LOCKED'			=>	$lang['SUBCHK_LOCKED'],
			'L_SUBCHK_STRICT'			=>	$lang['SUBCHK_STRICT'],
			'L_SUBCHK_BYPASS'			=>	$lang['SUBCHK_BYPASS'],
			'L_SUBCHK_BYPASS_EXPLAIN'	=>	$lang['SUBCHK_BYPASS_EXPLAIN'],
			'L_SUBCHK_STRICT_EXPLAIN'	=>	$lang['SUBCHK_STRICT_EXPLAIN'],
			'L_SUBCHK_LIMIT'			=>	$lang['SUBCHK_LIMIT'],
			'L_SUBCHK_LIMIT_EXPLAIN'	=>	$lang['SUBCHK_LIMIT_EXPLAIN'],
			'L_SUBCHK_MOD'				=>	$lang['SUBCHK_MOD'],
			'L_SUBCHK_ADMIN'			=>	$lang['SUBCHK_ADMIN'],
			'L_SUBCHK_COUNT'			=>	$lang['SUBCHK_COUNT'],
			'L_SUBCHK_COUNT_EXPLAIN'	=>	$lang['SUBCHK_COUNT_EXPLAIN'],

			'SUBCHK_LIMIT'				=>	$new['subchk_limit'],
			'SUBCHK_POSTCOUNT'			=>	$new['subchk_postcount'],
		);
		$vars += $this->get_check('subchk_admin');
		$vars += $this->get_check('subchk_mod');
		$vars += $this->get_check('subchk_enable');
		$vars += $this->get_check('subchk_bypass');
		$vars += $this->get_check('subchk_strict');
		$vars += $this->get_check('subchk_locked');

		$template->assign_vars($vars);
		$template->assign_var_from_handle('SUBJECT_CHECK', 'subject_check');
	}

	function get_check($value)
	{
		global $new;
		$result = array(
			strtoupper($value) . '_YES'	=>	( $new[$value] ) ? 'checked="checked"' : '',
			strtoupper($value) . '_NO'	=>	( !$new[$value] ) ? 'checked="checked"' : '',
		);
		return $result;
	}
}

?>