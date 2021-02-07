<?php
/*-----------------------------------------------------------------------------
    Visual Confirmation on New Posters - A phpBB Add-On
  ----------------------------------------------------------------------------
    vc_newposts.php
       Confirmation Processing Script
    File Version: 2.1.0
    Begun: August 25, 2006                 Last Modified: March 7, 2007
  ----------------------------------------------------------------------------
    Copyright 2006 by Jeremy Rogers.  Please read the license.txt included
    with the phpBB Add-On listed above for full license and copyright details.
  ----------------------------------------------------------------------------
    Class and Function Quick Reference
             Names                                 Search Labels
         VC_NewPosts.................................[vccls]
            VC_NewPosts..............................[vcnewpts]
            clean_old_codes..........................[clnold]
            build_code...............................[bldcode]
            build_standard_code......................[bldstdcode]
			check_fields.............................[chkflds]
            clear_session_codes......................[clrsess]
            add_error................................[adderr]
            show_field...............................[shwfld]
-----------------------------------------------------------------------------*/

if( !defined('IN_PHPBB') )
{
	die("I really hope you didn't just try to hack this server.");
}

$vc_newposts = new VC_NewPosts();
require_once($phpbb_root_path . 'mods/vc_newposts/constants.' . $phpEx);
require_once($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_vc_newposts.' . $phpEx);

/*	VC_NewPosts                                             [vccls]
       This class controls the visual confirmation for new posters. Both the
	   display of the confirmation image and the checks for the field later
	   are handled here.
                                                                             */
class VC_NewPosts 
{
	var $enabled		= FALSE;
	var $state			= 0;
	var $vc_type		= 0;
	var $additionals	= array();
	var $website_check	= FALSE;
	var $seed;
	var $confirm_id;
	var $confirm_id2;
	var $max_posts;

/*	VC_NewPosts                                             [vcnewpts]
       Sets up some basic configuration options and creates a seed number for
	   the random number generator.

    Arguments:
       None.

    Return:
       None.
                                                                             */
	function VC_NewPosts()
	{
		global $board_config, $userdata;

		$this->max_posts		= $board_config['vcnewposts_max_posts'];
		$this->state			= $board_config['vcnewposts_enable'];
		$this->vc_type			= $board_config['vcnewposts_type'];
		$this->website_check	= $board_config['vcnewposts_webcheck'];

		if( !$this->state )
		{
			$this->enabled = FALSE;
			return;	// Disabled in ACP
		}
		elseif( !$userdata['session_logged_in'] && $this->state <= 2 )
		{
			$this->enabled = TRUE;
		}
		elseif( $userdata['session_logged_in'] && ($this->state == 1 || $this->state > 2) && $userdata['user_posts'] < $this->max_posts )
		{
			$this->enabled = TRUE;
		}

		if( $this->enabled )
		{
			// Define additional randomization numbers
			$this->additionals = array(
				'min1'		=>	$board_config['vcnewposts_rand1'],
				'min2'		=>	$board_config['vcnewposts_rand2'],
				'max1'		=>	$board_config['vcnewposts_rand3'],
				'max2'		=>	$board_config['vcnewposts_rand4'],
				'factor'	=>	$board_config['vcnewposts_rand5']
			);

			// Compute Random Seed
			$power = pow(2,32);
			list($usec, $sec) = explode(' ', microtime());
			$compute = (float) $sec + ((float) $usec * 100000000);
			$factor = ( function_exists('posix_getpid') ) ? posix_getpid() : $this->additionals['factor'];
			$compute = $compute * 1000000 * $factor;
			$this->seed = intval($compute / $power);
			$this->seed = ( !$this->seed || $this->seed == 1 ) ? fmod($compute, $power) : $this->seed;
		}
	}

/*	clean_old_codes                                         [clnold]
       Deletes old confirmation codes. Mostly copied from usercp_register.php.

    Arguments:
       None.

    Return:
       None.
                                                                             */
	function clean_old_codes()
	{
		if ( !$this->enabled )
		{
			return;
		}
		global $db;
		$sql = 'SELECT session_id 
			FROM ' . SESSIONS_TABLE; 
		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Could not select session data', '', __LINE__, __FILE__, $sql);
		}

		if ($row = $db->sql_fetchrow($result))
		{
			$confirm_sql = '';
			do
			{
				$confirm_sql .= (($confirm_sql != '') ? ', ' : '') . "'" . $row['session_id'] . "'";
			}
			while ($row = $db->sql_fetchrow($result));
		
			$sql = 'DELETE FROM ' .  CONFIRM_TABLE . " 
				WHERE session_id NOT IN ($confirm_sql)";
			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not delete stale confirm data', '', __LINE__, __FILE__, $sql);
			}
		}
		$db->sql_freeresult($result);
	}

/*	build_code                                              [bldcode]
       Creates a confirmation code and saves it in the database.

    Arguments:
       $c_id			- Confirmation ID, which will be stored with the code.
       $force_standard	- Forces the creation of the code compatible with
							standard phpBB captcha.

    Return:
       string  $code  The confirmation code.
                                                                             */
	function build_code($c_id, $force_standard = FALSE)
	{
		if ( !$this->enabled )
		{
			return;
		}
		global $db, $lang, $userdata, $user_ip;

		// Seed the random number generator
		mt_srand($this->seed);

		$local_type = ($force_standard) ? CAPTCHA_STANDARD: $this->vc_type;

		switch( $local_type )
		{
			case CAPTCHA_PHOTO:
				$code = dss_rand();
				$code = substr($code, 0, 6);
				break;
			case CAPTCHA_FREECAP:
				$code = $this->build_standard_code();
				$code = strtolower(preg_replace('#(\d)#e', 'chr($1 + 96)', $code));
				break;
			case CAPTCHA_BETTER:
			case CAPTCHA_STANDARD:
			case CAPTCHA_AVC:
			default:
				$code = $this->build_standard_code();
				break;
		}

		// Save the code in the database
		$sql = 'INSERT INTO ' . CONFIRM_TABLE . " (confirm_id, session_id, code) 
			VALUES ('$c_id', '". $userdata['session_id'] . "', '$code')";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not insert new confirm code information', '', __LINE__, __FILE__, $sql);
		}
		return $code;
	}

/*	build_standard_code                                     [bldstdcode]
       Creates a confirmation code based on phpBB's random method, and then
	   tweaks that a little more to make an even more random code.

    Arguments:
       None.

    Return:
       string  $code  The confirmation code.
                                                                             */
	function build_standard_code()
	{
		// Get a code based on phpBB's random method, and then tweak it
		// a little more to make it even more random.
		$code = md5(dss_rand() . mt_rand(mt_rand($this->additionals['min1'], $this->additionals['min2']), mt_rand($this->additionals['max1'], $this->additionals['max2'])));
		$code = strtoupper($code);

		// Remove the number zero and the letter I to prevent confusion.
		$code = str_replace('0', '', $code);
		$code = str_replace('I', '', $code);
		$code = substr($code, mt_rand(2, (strlen($code) - 7)), 6);
		return $code;
	}

/*	check_fields                                            [chkflds]
       Checks a submitted form to see if it includes confirm data, and if that
	   data is valid.

    Arguments:
       None.

    Return:
       None.
                                                                             */
	function check_fields()
	{
		if ( !$this->enabled )
		{
			return;
		}

		global $db, $userdata, $mode, $HTTP_POST_VARS;

		// Trigger only on replies and new topics.
		$allowed_modes = array('reply', 'newtopic');
		if ( !in_array($mode, $allowed_modes))
		{
			return;
		}

		// Website Check
		// This functions even if visual confirmation is turned off for posting.
		// Excludes administrators and moderators.
		if( $this->website_check && $userdata['user_posts'] < $this->max_posts && $userdata['user_level'] < ADMIN )
		{
			// Check to see if the user's website profile field content is also
			// in the message. That would be a pretty good sign of a spammer.
			if( !empty($userdata['user_website']) && !empty($HTTP_POST_VARS['message']) )
			{
				// Strip the http:// from the website, in case they didn't use
				// that in the post.
				$website = substr($userdata['user_website'], 7);
				if( strpos($HTTP_POST_VARS['message'], $website) !== FALSE )
				{
					// Possible spammer, throw an error.
					$this->add_error(2);
					return;
				}
			}
		}

		if ( !$this->enabled )
		{
			return;
		}

		// Is there confirm info?
		if( !isset($HTTP_POST_VARS['confirm_id']) )
		{
			$this->add_error();
			return;
		}
		
		$check_id = htmlspecialchars(trim($HTTP_POST_VARS['confirm_id']));
		if (!preg_match('/^[A-Za-z0-9]+$/', $check_id))
		{
			$this->add_error();
			return;
		}

		// Pull all confirm information for the current session.
		$sql = 'SELECT * FROM ' . CONFIRM_TABLE . "
				WHERE session_id = '" . $userdata['session_id'] . "'";
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain confirmation code', __LINE__, __FILE__, $sql);
		}
		$codes = $db->sql_fetchrowset($result);
		$db->sql_freeresult();
		if( empty($codes) )
		{
			// No info? We quit.
			$this->add_error();
			return;
		}

		$field_found = $confirm_found	= FALSE;
		$confirm_row = $field_row		= '';
		foreach($codes as $k=>$v)
		{
			if( $v['confirm_id'] == $check_id )
			{
				// We've found one piece of the confirm information we want.
				$confirm_found = TRUE;
				$confirm_row = $v;
			}
			else
			{
				// Let's try to find the second, hidden confirmation code that
				// was in the form. 
				$check_field = strtolower($v['code']);
				switch( $this->vc_type )
				{
					case CAPTCHA_PHOTO:
						for( $i=0; $i<20 ; $i++ )
						{
							if( isset($HTTP_POST_VARS[$check_field . $i]) )
							{
								$field_found = TRUE;
								$field_row = $v;
								break 2;
							}
						}
						break;
					case CAPTCHA_BETTER:
					case CAPTCHA_STANDARD:
					case CAPTCHA_AVC:
					case CAPTCHA_FREECAP:
					default:
						if( isset($HTTP_POST_VARS[$check_field]) )
						{
							$field_found = TRUE;
							$field_row = $v;
						}
						break;
				}
			}
		}

		if( !$confirm_found || !$field_found )
		{
			// We didn't find all the info? We quit. :(
			$this->add_error();
			return;
		}

		// Compare our confirm codes
		$field = strtolower($field_row['code']);
		switch( $this->vc_type )
		{
			case CAPTCHA_PHOTO:
				$code_to_check = '';
				for ($i=0; $i<20; $i++)
				{
					$code_to_check .= ($HTTP_POST_VARS["$field$i"] == 'on') ? '1' : '0';
				}
				$confirm_row['code'] = substr(base_convert($confirm_row['code'], 16, 2), 0, 20);
				break;
			case CAPTCHA_FREECAP:
				if( GD_INSTALLED )
				{
					$confirm_row['code'] = strtolower($confirm_row['code']);
					$code_to_check = htmlspecialchars(trim($HTTP_POST_VARS[$field]));
					$code_to_check = strtolower($code_to_check);
					break;
				}
			case CAPTCHA_BETTER:
			case CAPTCHA_STANDARD:
			case CAPTCHA_AVC:
			default:
				$code_to_check = htmlspecialchars(trim($HTTP_POST_VARS[$field]));
				break;
		}

		if( $confirm_row['code'] != $code_to_check )
		{
			// No match. :(
			$this->add_error();
			return;
		}
		else
		{
			// Codes matched, so let's clear all the codes for this session.
			$this->clear_session_codes();
			// Clear old codes, too.
			$this->clean_old_codes();
		}
	}

/*	clear_session_codes                                     [clrsess]
       Deletes all the confirmation codes for the current session.

    Arguments:
       None.

    Return:
       None.
                                                                             */
	function clear_session_codes()
	{
		global $userdata, $db;
		$sql = 'DELETE FROM ' .  CONFIRM_TABLE . " 
			WHERE session_id = '" . $userdata['session_id'] . "'";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not delete stale confirm data', '', __LINE__, __FILE__, $sql);
		}
	}

/*	add_error                                               [adderr]
       Adds "wrong confirm codes" message to pre-existing error messages.

    Arguments:
       $error_type	- Integer indicating the type of error message to show.
						Defaults to 1, for the standard incorrect confirm code
						error.

    Return:
       None.
                                                                             */
	function add_error($error_type = 1)
	{
		global $error_msg, $lang;
		$error_msg .= (!empty($error_msg)) ? '<br />': '';
		switch( $error_type )
		{
			case 2:
				$error_msg .= $lang['VCNP_WEB_ERR'];
				break;
			case 1:
			default:
				$error_msg .= $lang['Confirm_code_wrong'];
				break;
		}
		// Since there was a problem, let's clear the confirmation codes to
		// make the poster enter new ones later.
		$this->clear_session_codes();
	}

/*	show_field                                              [shwfld]
       Displays confirmation code image and form field.

    Arguments:
       None.

    Return:
       None.
                                                                             */
	function show_field()
	{
		global $userdata, $user_ip, $template, $lang, $board_config, $phpEx, $template;
		if ( !$this->enabled )
		{
			return;
		}

		switch( $this->vc_type )
		{
			case CAPTCHA_PHOTO:
				$tpl = 'photo';
				break;
			case CAPTCHA_BETTER:
			case CAPTCHA_STANDARD:
			case CAPTCHA_AVC:
			case CAPTCHA_FREECAP:
			default:
				$tpl = 'standard';
				break;
		}
		$template->set_filenames(array(
			'captcha' => 'vc_newposts/' . $tpl . '.tpl'
		));

		$this->confirm_id  = md5(uniqid($user_ip, true));
		$this->confirm_id2  = md5(uniqid($user_ip . 'gen', true));
		$code = $this->build_code($this->confirm_id);

		$field_name = strtolower($this->build_code($this->confirm_id2, true));
		switch( $this->vc_type )
		{
			case CAPTCHA_PHOTO:
				$l_explain = ((GD_INSTALLED) ? $lang['Confirm_code_explain_photos'] : $lang['Confirm_code_missing_gd']);
				$base_url = append_sid("vc.$phpEx?id={$this->confirm_id}") . '&amp;';
				for( $i=0; $i<5 ; $i++ )
				{
					$template->assign_block_vars('confirmrow', array());
					
					for( $j=0; $j<4 ; $j++ )
					{
						$idx = $i * 4 + $j;
						$template->assign_block_vars('confirmrow.confirmcol', array(
							'URL'	=> $base_url . "idx=$idx",
							'FIELD'	=> $field_name,
							'IDX'	=> $idx
						));
					}
				}
				break;
			case CAPTCHA_BETTER:
			case CAPTCHA_STANDARD:
			case CAPTCHA_AVC:
			case CAPTCHA_FREECAP:
			default:
				$confirm_image = '<img src="' . append_sid("vc.$phpEx?id={$this->confirm_id}") . '" alt="" title="" />';
				$l_explain = $lang['Confirm_code_explain'];
				break;
		}

		$hidden_form_fields = '<input type="hidden" name="confirm_id" value="' . $this->confirm_id . '" />';
		$template->assign_vars(array(
			'L_CONFIRM_CODE_IMPAIRED'	=> sprintf($lang['Confirm_code_impaired'], '<a href="mailto:' . $board_config['board_email'] . '">', '</a>'), 
			'L_CONFIRM_CODE'			=> $lang['Confirm_code'], 
			'L_CONFIRM_CODE_EXPLAIN'	=> $l_explain, 
			'CONFIRM_IMG'				=> $confirm_image,
			'HIDDEN'					=> $hidden_form_fields,
			'FIELD_NAME'				=> $field_name
		));
		
		$template->assign_var_from_handle('VC_NEWPOSTS', 'captcha');
	}
}

?>