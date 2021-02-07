<?php
/***************************************************************************
 *                      silkroad_viewprofile.php
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

if ( empty($HTTP_GET_VARS[POST_USERS_URL]) || $HTTP_GET_VARS[POST_USERS_URL] == ANONYMOUS )
{
   message_die(GENERAL_MESSAGE, $lang['No_user_id_specified']);
}

$profiledata = get_userdata($HTTP_GET_VARS[POST_USERS_URL]);

$questdata = get_quest_data($HTTP_GET_VARS[POST_USERS_URL]);
$skilldata = get_skill_data($HTTP_GET_VARS[POST_USERS_URL]);
$forcedata = get_force_data($HTTP_GET_VARS[POST_USERS_URL]);

if (!$questdata && !$skilldata && !$forcedata)
{
   message_die(GENERAL_MESSAGE, $lang['SILK_EMPTY']);
}

//
// Output page header and profile_view template
//
$template->set_filenames(array(
   'body' => 'silkroad_view_body.tpl')
);
make_jumpbox('viewforum.'.$phpEx);

//
// Generate page
//
$page_title = $lang['Viewing_profile'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$the_silkdata_array = array();
$i = 0;
$j = 0;
$k = 0;
//Quests
while($i < MAX_QUESTS)
{
   $i++;
   $the_silkdata_array["quest" . $i] = (isset($questdata["quest" . $i]) && $questdata["quest" . $i]) ? $lang['SILK_COMPLETE'] : $lang['SILK_PROGRESS'];

   $template->assign_vars(array(
      "L_QUEST" . $i => $lang["Quest" . $i],
      "L_QUEST" . $i . "_DESC" => $lang["Quest"  . $i . "_Desc"],
      'QUEST'.$i.'_STATUS' => $the_silkdata_array["quest" . $i]));
}

//Skills
while($j < MAX_SKILLS)
{
   $j++;
   $the_silkdata_array["skill" . $j] = (isset($skilldata["skill" . $j]) && $skilldata["skill" . $j]) ? $lang['SILK_MASTERED'] : $lang['SILK_ACQUIRING'];

   $template->assign_vars(array(
      "L_SKILL" . $j => $lang["Skill" . $j],
      "L_SKILL" . $j . "_DESC" => $lang["Skill"  . $j . "_Desc"],
      'SKILL'.$j.'_STATUS' => $the_silkdata_array["skill" . $j],
	  'SKILL' . $j . '_IMG' => '<img src="' . $images['skill' . $j] . '" alt="' . $lang['Skill' . $j] . '" title="' . $lang['Skill' . $j] . '" border="0" />')
	  );
}
//Forces
while($k < MAX_FORCES)
{
   $k++;
   $the_silkdata_array["force" . $k] = (isset($forcedata["force" . $k]) && $forcedata["force" . $k]) ? $lang['SILK_MASTERED'] : $lang['SILK_ACQUIRING'];

   $template->assign_vars(array(
      "L_FORCE" . $k => $lang["Force" . $k],
      "L_FORCE" . $k . "_DESC" => $lang["Force"  . $k . "_Desc"],
      'FORCE'.$k.'_STATUS' => $the_silkdata_array["force" . $k],
	  'FORCE' . $k . '_IMG' => '<img src="' . $images['force' . $k] . '" alt="' . $lang['Force' . $k] . '" title="' . $lang['Force' . $k] . '" border="0" />')
	  );
}

$template->assign_vars(array(
	'SILKROAD_USERNAME' => $profiledata['user_silk'],
	'L_SILK_SN' => $lang['SILK_SN'],
	'L_SILK_STATUS' => $lang['SILK_STATUS'],
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
	'L_FORCE_INCREASING' => $lang['Force_Increasing'])
);

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
