<?php
/*-----------------------------------------------------------------------------
    Subject Check - A phpBB Add-On
  ----------------------------------------------------------------------------
    lang_subchk.php
       English Language file.
    File Version: 1.0.0
    Begun: December 13, 2006                 Last Modified: December 13, 2006
  ----------------------------------------------------------------------------
    Copyright 2006 by Jeremy Rogers.  Please read the license.txt included
    with the phpBB Add-On listed above for full license and copyright details.
  ----------------------------------------------------------------------------
    Translated by:
        <ATTENTION ALL POTENTIAL TRANSLATORS!
            You are free to translate this file into other languages for your
            own use and to distribute translated versions according to the
            terms of the license under which it is released. Add your name and
            contact details in this area.>
-----------------------------------------------------------------------------*/
/* 
	If you would like to add a message indicating you are the translator,
	you may add it below. This will appear with the phpBB copyright and is
	completely optional.
*/
// 	'TRANSLATION'] .= 'Your Name Here';

/* This file uses a format of:
		'STRING_NAME'	=>	'text'
	Never edit the STRING_NAME part. That is required to be unchanged.
*/

$lang += array(

// You can change these messages fit your liking.
// SUBCHK_UNSTRICT is used when someone can submit their post after being given
// a list of similar existing posts.
// SUBCHK_STRICT is used when the person cannot submit after seeing the list.
// The idea for SUBCHK_STRICT is that they should be told "hey, post in one of
// these topics instead of making a new one!"
	'SUBCHK_UNSTRICT'	=> "The subject of your topic is similar to an existing topic in this forum. Please check the topics listed below. If your message is similar to one of those topics, please reply to that topic instead of creating a new post. If your message does not belong in one of those topics, you may post it as a new topic by pressing the Submit button again below.",

	'SUBCHK_STRICT'		=> "The subject of your topic is similar to an existing topic in this forum. Please check the topics listed below and reply to the one that most closely matches your message instead of creating a new post.",

	// ACP Labels
	'SUBCHK_TITLE'			=> 'Subject Check',
	'SUBCHK_FORUM'			=> 'Check subjects of new topics against existing topics?',
	'SUBCHK_FORUM_EXPLAIN'	=> 'This can be configured for each forum under Forum Management. Turning it off here disables this for all forums.',
	'SUBCHK_LOCKED'			=> 'Exclude locked topics when checking subjects?',
	'SUBCHK_STRICT'			=> 'Enable strict mode?',
	'SUBCHK_STRICT_EXPLAIN'	=> 'Strict mode prevents a topic from being added when a topic with an identical subject already exists.',
	'SUBCHK_BYPASS'			=> 'Allow bypassing?',
	'SUBCHK_BYPASS_EXPLAIN'	=> 'Bypassing allows a person to post their topic even after being presented with a list of similar topics.',
	'SUBCHK_LIMIT'			=> 'Maximum number of topics to display:',
	'SUBCHK_MOD'			=> 'Allow moderators to post without checking subjects?',
	'SUBCHK_ADMIN'			=> 'Allow admins to post without checking subjects?',
	'SUBCHK_COUNT'			=> 'Post Count',
	'SUBCHK_COUNT_EXPLAIN'	=> 'Topics from users above this post count will not be checked for similar topics. Leave blank or enter 0 to disable this.',
	'SUBCHK_LIMIT_EXPLAIN'	=> 'Leave blank or enter 0 to disable this.',

);

?>