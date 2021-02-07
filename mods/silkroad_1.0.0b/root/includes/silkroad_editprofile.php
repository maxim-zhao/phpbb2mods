<?php
/***************************************************************************
 *                      silkroad_editprofile.php
 *                            -------------------
 *   begin                : Wednesday, Sept 20, 2006
 *   copyright         : (C) 2006 The Exiled
 *   email                : noxwizard@gmail.com
 *
 *	Silkroad Online is a registered trademark of Joymax Co., Ltd
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
   die("Hacking attempt");
   exit;
}


$error = FALSE;
$error_msg = '';
$page_title = $lang['Edit_profile'];

// Will be overriden by $error boolean
$template->set_filenames(array(
   'body' => 'silkroad_edit_body.tpl')
);


//
// Check and initialize some variables if needed
//
if (isset($HTTP_POST_VARS['submit']))
{
   include($phpbb_root_path . 'includes/functions_validate.'.$phpEx);
   include($phpbb_root_path . 'includes/functions_post.'.$phpEx);
   
   $user_id = intval($HTTP_POST_VARS['user_id']);
   $questdata = get_quest_data($user_id);
   $skilldata = get_skill_data($user_id);
   $forcedata = get_force_data($user_id);
//
// Did the user submit? In this case build a query to update the users profile in the DB
//
   if ( $user_id != $userdata['user_id'] )
   {
      $error = TRUE;
      $error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Wrong_Profile'];
   }

   if ( !$error )
   {

     $the_silkdata_array = array();
     $i = 0;
	 $j = 0;
	 $k = 0;
     $posted_or_updated = array();
	 //Update Quests
     while($i < MAX_QUESTS)
     {
        $i++;
         $posted_or_updated["quest" . $i] = ( isset($HTTP_POST_VARS["quest" . $i]) ) ? ( ($HTTP_POST_VARS["quest" . $i]) ? TRUE : 0 ) : ((isset($questdata["quest" . $i]) && $questdata["quest" . $i]) ? TRUE : 0 );

      if($questdata["quest" . $i] && $posted_or_updated["quest" . $i] === 0)
      {
         // update the DB
         //Echo "<BR>TODO : delete silk_id".$i;
		 $sql = "DELETE FROM " . SILKROAD_QUESTS_TABLE . "
			WHERE " . SILKROAD_QUESTS_TABLE . ".user_id = " . $user_id . "
			AND " . SILKROAD_QUESTS_TABLE . ".quest_id = " . $i;
		 //Echo "<BR />Running SQL: " . $sql;
		
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update user quests', '', __LINE__, __FILE__, $sql);
		}
      }
      else
      {
         if($posted_or_updated["quest" . $i] && !(isset($questdata["quest" . $i])))
         {
            // insert into the DB
            // INSERT INTO `phpbb_silkroad_data` (`user_id`, `quest_id`, `quest_value`) VALUES (2, 2, '1');
            //Echo "<BR>TODO : insert quest_id".$i;
			$sql = "INSERT INTO " . SILKROAD_QUESTS_TABLE . " (`user_id`, `quest_id`, `quest_value`)
				VALUES ( $user_id, $i, 1)";
			//Echo "<BR />Running SQL: " . $sql;
			
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not update user quests', '', __LINE__, __FILE__, $sql);
			}
         }
      }

     } // END while
	 
	 //Update Skills
     while($j < MAX_SKILLS)
     {
        $j++;
         $posted_or_updated["skill" . $j] = ( isset($HTTP_POST_VARS["skill" . $j]) ) ? ( ($HTTP_POST_VARS["skill" . $j]) ? TRUE : 0 ) : ((isset($skilldata["skill" . $j]) && $skilldata["skill" . $j]) ? TRUE : 0 );

      if($skilldata["skill" . $j] && $posted_or_updated["skill" . $j] === 0)
      {
         // update the DB
         //Echo "<BR>TODO : delete skill_id".$j;
		 $sql = "DELETE FROM " . SILKROAD_SKILLS_TABLE . "
			WHERE " . SILKROAD_SKILLS_TABLE . ".user_id = " . $user_id . "
			AND " . SILKROAD_SKILLS_TABLE . ".skill_id = " . $j;
		 //Echo "<BR />Running SQL: " . $sql;
		
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update user skills', '', __LINE__, __FILE__, $sql);
		}
      }
      else
      {
         if($posted_or_updated["skill" . $j] && !(isset($skilldata["skill" . $j])))
         {
            // insert into the DB
            //Echo "<BR>TODO : insert skill_id".$j;
			$sql = "INSERT INTO " . SILKROAD_SKILLS_TABLE . " (`user_id`, `skill_id`, `skill_value`)
				VALUES ( $user_id, $j, 1)";
			//Echo "<BR />Running SQL: " . $sql;
			
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not update user skills', '', __LINE__, __FILE__, $sql);
			}
         }
      }

     } // END while
	 
	 //Update Quests
     while($k < MAX_FORCES)
     {
        $k++;
         $posted_or_updated["force" . $k] = ( isset($HTTP_POST_VARS["force" . $k]) ) ? ( ($HTTP_POST_VARS["force" . $k]) ? TRUE : 0 ) : ((isset($forcedata["force" . $k]) && $forcedata["force" . $k]) ? TRUE : 0 );

      if($forcedata["force" . $k] && $posted_or_updated["force" . $k] === 0)
      {
         // update the DB
         //Echo "<BR>TODO : delete force_id".$k;
		 $sql = "DELETE FROM " . SILKROAD_FORCES_TABLE . "
			WHERE " . SILKROAD_FORCES_TABLE . ".user_id = " . $user_id . "
			AND " . SILKROAD_FORCES_TABLE . ".force_id = " . $k;
		 //Echo "<BR />Running SQL: " . $sql;
		
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update user forces', '', __LINE__, __FILE__, $sql);
		}
      }
      else
      {
         if($posted_or_updated["force" . $k] && !(isset($forcedata["force" . $k])))
         {
            // insert into the DB
            // INSERT INTO `phpbb_silkroad_data` (`user_id`, `force_id`, `force_value`) VALUES (2, 2, '1');
            //Echo "<BR>TODO : insert force_id".$k;
			$sql = "INSERT INTO " . SILKROAD_FORCES_TABLE . " (`user_id`, `force_id`, `force_value`)
				VALUES ( $user_id, $k, 1)";
			//Echo "<BR />Running SQL: " . $sql;
			
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not update user forces', '', __LINE__, __FILE__, $sql);
			}
         }
      }

     } // END while

      $message = $lang['Profile_updated'] . '<br /><br />' . sprintf($lang['Click_return_index'],  '<a href="' . append_sid("index.$phpEx") . '">', '</a>');
      $template->assign_vars(array(
         "META" => '<meta http-equiv="refresh" content="5;url=' . append_sid("index.$phpEx") . '">')
      );
      message_die(GENERAL_MESSAGE, $message);
   }
}  //End of submit

$user_id = $userdata['user_id'];
$silksn = $userdata['user_silk'];
$questdata = get_quest_data($user_id);
$skilldata = get_skill_data($user_id);
$forcedata = get_force_data($user_id);

   $the_silkdata_array = array();
   $i = 0;
   $j = 0;
   $k = 0;
   //Quests
   while($i < MAX_QUESTS)
   {
      $i++;
      $questdata["quest" . $i] = ( isset($HTTP_POST_VARS["quest" . $i]) ) ? ( ($HTTP_POST_VARS["quest" . $i]) ? TRUE : 0 ) : ((isset($questdata["quest" . $i]) && $questdata["quest" . $i]) ? TRUE : 0 );

      // Echo "<BR>$i ___ ".$silkdata["quest$i"];

      $template->assign_vars(array(
         "L_QUEST" . $i => $lang["Quest" . $i],
         "L_QUEST" .$i . "_DESC" => $lang["Quest" . $i . "_Desc"],
         'QUEST'.$i.'_YES' => ( $questdata["quest" . $i] ) ? 'checked="checked"' : '',
         'QUEST'.$i.'_NO' => ( !$questdata["quest" . $i] ) ? 'checked="checked"' : ''));
   }
   //Skillls
   while($j < MAX_SKILLS)
   {
      $j++;
      $skilldata["skill" . $j] = ( isset($HTTP_POST_VARS["skill" . $j]) ) ? ( ($HTTP_POST_VARS["skill" . $j]) ? TRUE : 0 ) : ((isset($skilldata["skill" . $j]) && $skilldata["skill" . $j]) ? TRUE : 0 );

      $template->assign_vars(array(
         "L_SKILL" . $j => $lang["Skill" . $j],
         "L_SKILL" .$j . "_DESC" => $lang["Skill" . $j . "_Desc"],
         'SKILL'.$j.'_YES' => ( $skilldata["skill" . $j] ) ? 'checked="checked"' : '',
         'SKILL'.$j.'_NO' => ( !$skilldata["skill" . $j] ) ? 'checked="checked"' : '',
		 'SKILL' . $j . '_IMG' => '<img src="' . $images['skill' . $j] . '" alt="' . $lang['Skill' . $j] . '" title="' . $lang['Skill' . $j] . '" border="0" />')
		 
		 );
   }
   //Forces
   while($k < MAX_FORCES)
   {
		$k++;
		$forcedata["force" . $k] = ( isset($HTTP_POST_VARS["force" . $k]) ) ? ( ($HTTP_POST_VARS["force" . $k]) ? TRUE : 0 ) : ((isset($forcedata["force" . $k]) && $forcedata["force" . $k]) ? TRUE : 0 );

		$template->assign_vars(array(
			'L_FORCE' . $k => $lang['Force' . $k],
			'L_FORCE' .$k . '_DESC' => $lang['Force' . $k . '_Desc'],
			'FORCE'.$k.'_YES' => ( $forcedata['force' . $k] ) ? 'checked="checked"' : '',
			'FORCE'.$k.'_NO' => ( !$forcedata['force' . $k] ) ? 'checked="checked"' : '',
			'FORCE' . $k . '_IMG' => '<img src="' . $images['force' . $k] . '" alt="' . $lang['Force' . $k] . '" title="' . $lang['Force' . $k] . '" border="0" />')
			);
   }
   
//
// Default pages
//
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

make_jumpbox('viewforum.'.$phpEx);


if ( $user_id != $userdata['user_id'] )
{
   $error = TRUE;
   $error_msg = $lang['Wrong_Profile'];
}


include($phpbb_root_path . 'includes/functions_selects.'.$phpEx);

$s_hidden_fields .= '<input type="hidden" name="user_id" value="' . $userdata['user_id'] . '" />';


if ( $error )
{
   $template->set_filenames(array(
      'reg_header' => 'error_body.tpl')
   );
   $template->assign_vars(array(
      'ERROR_MESSAGE' => $error_msg)
   );
   $template->assign_var_from_handle('ERROR_BOX', 'reg_header');
}



$ini_val = ( phpversion() >= '4.0.0' ) ? 'ini_get' : 'get_cfg_var';
$form_enctype = ( @$ini_val('file_uploads') == '0' || strtolower(@$ini_val('file_uploads') == 'off') || phpversion() == '4.0.4pl1' || ( phpversion() < '4.0.3' && @$ini_val('open_basedir') != '' ) ) ? '' : 'enctype="multipart/form-data"';

$template->assign_vars(array(
   'SILKROAD_USERNAME' => $silksn,
   'L_SILK_SN' => $lang['SILK_SN'],
   'L_QUEST' => $lang['QUEST'],
	'L_SILK_DONE' => $lang['SILK_DONE'],
	'L_SILK_TODO' => $lang['SILK_TODO'],
	'L_SILK_MASTERY' => $lang['SILK_MASTERY'],
	'L_QUEST' => $lang['QUEST'],
	'L_SKILL' => $lang['SKILL'],
	'L_FORCE' => $lang['FORCE'],
	
	//skills	
	'L_BICHEON' => $lang['Bicheon'],
	'L_SMASHING' => $lang['Smashing'],
	'L_CHAIN' => $lang['Chain'],
	'L_SHIELD' => $lang['Shield'],
	'L_BLADE_FORCE' => $lang['Blade_Force'],
	'L_HIDDEN_BLADE' => $lang['Hidden_Blade'],
	'L_KILLING_BLADE' => $lang['Killing_Blade'],
	'L_SWORD_DANCE' => $lang['Sword_Dance'],
	'L_SHIELD_PROTECTION' => $lang['Shield_Protection'],
	'L_HEUKSAL' => $lang['Heuksal'],
	'L_ANNIHILATING' => $lang['Annihilating'],
	'L_FANNING_SPEAR' => $lang['Fanning_Spear'],
	'L_SPEAR_SERIES' => $lang['Spear_Series'],
	'L_SOUL_SPEAR' => $lang['Soul_Spear'],
	'L_GHOST_SPEAR' => $lang['Ghost_Spear'],
	'L_CHAIN_SPEAR' => $lang['Chain_Spear'],
	'L_FLYING_DRAGON' => $lang['Flying_Dragon'],
	'L_CHEOLSAN_FORCE' => $lang['Cheolsan_Force'],
	'L_PACHEON' => $lang['Pacheon'],
	'L_ANTI_DEVIL' => $lang['Anti_Devil'],
	'L_ARROW_COMBO' => $lang['Arrow_Combo'],
	'L_HAWK' => $lang['Hawk'],
	'L_AUTUMN' => $lang['Autumn'],
	'L_BREAK_HEAVEN' => $lang['Break_Heaven'],
	'L_EXPLOSION_ARROW' => $lang['Explosion_Arrow'],
	'L_STRONG_BOW' => $lang['Strong_Bow'],
	'L_MIND_CONCENTRATION' => $lang['Mind_Concentration'],
	//forces
	'L_COLD' => $lang['Cold'],
	'L_COLD_FORCE' => $lang['Cold_Force'],
	'L_FROST_GUARD' => $lang['Frost_Guard'],
	'L_COLD_WAVE' => $lang['Cold_Wave'],
	'L_FROST_WALL' => $lang['Frost_Wall'],
	'L_FROST_NOVA' => $lang['Frost_Nova'],
	'L_SNOW_STORM' => $lang['Snow_Storm'],
	'L_COLD_ARMOR' => $lang['Cold_Armor'],
	'L_FIRE' => $lang['Fire'],
	'L_FIRE_FORCE' => $lang['Fire_Force'],
	'L_FIRE_SHIELD' => $lang['Fire_Shield'],
	'L_FLAME_BODY' => $lang['Flame_Body'],
	'L_FIRE_PROTECTION' => $lang['Fire_Protection'],
	'L_FIRE_WALL' => $lang['Fire_Wall'],
	'L_FLAME_WAVE' => $lang['Flame_Wave'],
	'L_FLAME_DEVIL' => $lang['Flame_Devil'],
	'L_THUNDER' => $lang['Thunder'],
	'L_THUNDER_FORCE' => $lang['Thunder_Force'],
	'L_PIERCING_FORCE' => $lang['Piercing_Force'],
	'L_WIND_WALK' => $lang['Wind_Walk'],
	'L_LION_SHOUT' => $lang['Lion_Shout'],
	'L_CONCENTRATION' => $lang['Concentration'],
	'L_THUNDERBOLT_FORCE' => $lang['Thunderbolt_Force'],
	'L_HEAVEN_FORCE' => $lang['Heaven_Force'],
	'L_FORCE' => $lang['Force'],
	'L_SELF_HEAL' => $lang['Self_Heal'],
	'L_FORCE_CURE' => $lang['Force_Cure'],
	'L_HEAL' => $lang['Heal'],
	'L_REBIRTH' => $lang['Rebirth'],
	'L_NATURAL_THERAPY' => $lang['Natural_Therapy'],
	'L_VITAL_SPOT' => $lang['Vital_Spot'],
	'L_FORCE_INCREASING' => $lang['Force_Increasing'],

   'L_SUBMIT' => $lang['Submit'],
   'L_RESET' => $lang['Reset'],

   'S_HIDDEN_FIELDS' => $s_hidden_fields,
   'S_FORM_ENCTYPE' => $form_enctype,
   'S_SILKROAD_ACTION' => append_sid("silkroad.$phpEx?mode=editprofile"))
);

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
?>
