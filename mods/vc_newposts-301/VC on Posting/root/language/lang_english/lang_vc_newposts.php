<?php
/*-----------------------------------------------------------------------------
    Visual Confirmation on New Posters - A phpBB Add-On
  ----------------------------------------------------------------------------
    lang_vc_newposts.php
       English language file for Visual Confirmation on New Posters
    File Version: 2.0.0
    Begun: December 11, 2006                 Last Modified: March 7, 2007
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
// $lang['TRANSLATION'] .= 'Your Name Here';

/* This file uses a format of:
		'STRING_NAME'	=>	'text'
	Never edit the STRING_NAME part. That is required to be unchanged.
*/

$lang += array(
	'VCNP_TITLE'			=>	'Visual Confirmation on New Posters',
	'VCNP_USER_TYPE'		=>	'Select the users for which confirmation is enabled',
	'VCNP_GUESTS'			=>	'Guest Users Only',
	'VCNP_ALL'				=>	'All Users',
	'VCNP_REGGED'			=>	'Registered Users Only',
	'VCNP_NONE'				=>	'None - Do Not Use Posting Confirmation',
	'VCNP_TYPE'				=>	'Select the type of Visual Confirmation to use',
	'VCNP_STANDARD'			=>	'phpBB Standard or compatible',
	'VCNP_AVC'				=>	'Advanced Visual Confirmation',
	'VCNP_FREECAP'			=>	'FreeCap Visual Confirmation',
	'VCNP_PHOTO'			=>	'Photo Visual Confirmation',
	'VCNP_BETTER'			=>	'Better Captcha',
	'VCNP_WEB'				=>	'Check for Website field',
	'VCNP_WEB_EXPLAIN'		=>	'If enabled, this will block posts from registered users that contain the contents of their website profile field. This also uses the post count setting.',
	'VCNP_RANDOMS'			=>	'Randomizers',
	'VCNP_RANDOMS_EXPLAIN'	=>	'These settings are used to increase the randomness of confirmation codes for posting. You may tweak these, but be sure to test the confirmation codes after making adjustments. You do not have to change these settings; they are just a bonus for advanced users that may want more control over the confirmation codes.',
	'VCNP_MIN_TO'			=>	'Minimum to',
	'VCNP_MAX'				=>	'Maximum',
	'VCNP_RAND5'			=>	'Random Seed Factor',
	'VCNP_RAND1-2'			=>	'Code Modifier 1',
	'VCNP_RAND3-4'			=>	'Code Modifier 2',
	'VCNP_POSTS'			=>	'Maximum Posts',
	'VCNP_POSTS_EXPLAIN'	=>	'Users will be asked to enter a confirmation code until they have made this number of posts. Does not apply to guests.',

	'VCNP_WEB_ERR'			=>	'We have detected that your website is mentioned in your post. To prevent spam, new members are not allowed to mention their own website in their post. Thank you for your co-operation.'
);

?>