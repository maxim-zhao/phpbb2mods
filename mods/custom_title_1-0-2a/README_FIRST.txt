##############################################################
## MOD Title: Custom Title MOD
## MOD Author: Aexoden < gerek@softhome.net > (Jason Lynch) http://www.aexoden.com
## MOD Description: Adds a custom title field to a user's profile, and displays it next to their posts and in their profile.
##		    Can be configured to only activate after a certain number of days and/or posts.  A custom title 
##		    can also be manually activated or disabled by an administrator. 
## MOD Version: 1.0.2
##
## Installation Level: Advanced
## Installation Time: 25-30 Minutes
## Files To Edit: 14: admin/admin_board.php 
##                    admin/admin_users.php 
##                    includes/constants.php
##                    includes/usercp_avatar.php 
##                    includes/usercp_register.php 
##                    includes/usercp_viewprofile.php 
##                    language/lang_english/lang_admin.php 
##                    language/lang_english/lang_main.php 
##                    templates/subSilver/admin/board_config_body.tpl 
##                    templates/subSilver/admin/user_edit_body.tpl 
##                    templates/subSilver/profile_add_body.tpl 
##                    templates/subSilver/profile_view_body.tpl 
##                    templates/subSilver/viewtopic_body.tpl 
##		      viewtopic.php
## Included Files: title_install.php (See README_FIRST.txt for details)
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes: Please read this entire file before asking questions.
##
##############################################################
## MOD History:  Available below
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
############################################################## 
--------------------------------------------------------------------------------
--------------------------------------------------------------------------------
Thank you for downloading my custom title MOD.  This document contains several
bits of useful information.  Please read the entire thing.  Any questions that
are answered in this document will be met with a terse reply.  This document is
designed to limit the amount of basic support I need to provide.  Please help me
to maintain that goal.
--------------------------------------------------------------------------------
Contents:
I.   Changelog
II.  Features
III. The Future of the MOD
IV. Installation Guide
	a. EasyMOD Installation
	b. Manual Installation
V.   Configuration Guide
	a. Mode of Operation
	b. Criteria for Activation
	c. Maximum Length
VI.  Where to Report Bugs
--------------------------------------------------------------------------------
--------------------------------------------------------------------------------
I. Changelog

Version	Date		Changes
--------------------------------------------------------------------------------
0.9.0	03 Aug 2002	Initial public release
0.9.1	04 Aug 2002	Removed a commented out section of code from an earlier
			internal version.  Only served to make more work for the
			MOD installer.
0.9.2	04 Aug 2002	Added a missing line of code in admin/admin_users.php
0.9.3	Unreleased	In reponse to user feedback, added the ability to choose
			from three different modes of operation.
0.9.4	15 Aug 2002	Added the ability for administrators to set the maximum
			allowable title length.  Also added EasyMOD Alpha 2
			compliance.
0.9.5   23 Aug 2002     Based on feedback from Nuttzy99, made a couple of
			changes to ensure EasyMOD compliance.  Also repackaged
			the Easymod_install.zip as to not include superfluous
			directories.
0.9.5.1 20 Sep 2002     Corrected a minor typo in manual_install.txt. *grumble*
1.0.0a	Unreleased	Packaged for database submission.  Never accepted or
			rejected.
1.0.0	02 Feb 2003	Small changes in input processing, following similar
			changes in phpBB 2.0.4.  MOD Database submitted.
1.0.1   09 Mar 2003	Corrected a bug involving activation upon a certain
			number of registration days.
1.0.2	07 May 2003	Thanks to ComradeF, corrected a bug that allowed users
			to set their title during registration, even if there
			was a days of registration requirement.
--------------------------------------------------------------------------------
--------------------------------------------------------------------------------
II. Features

--	Three different modes of operation, which allow an administrator to
	customize the output.
--	Titles can be configured to only activate after a certain number of days
	of membership and posts.
--	Any user's title can be manually activated by an administrator, 
	regardless of posts and days of membership.
--	A user's title can be manually disabled by an administrator, regardless
	of posts and days of membership.
--	The maximum length is fully configurable (From 1 to 255 characters).
--	Administrators setting titles through user administration can circumvent
	the definable limit.
--------------------------------------------------------------------------------
--------------------------------------------------------------------------------
III. The Future of the MOD

--	If I get any requests, I may change the functionality to more resemble
	the vBulletin interface.  That is, admins would be given the ability to
	add arbitrary HTML.  The user would be able to either keep their custom
	title the way it is, reset it, or change it to something else.  This
	would be the most efficient way of allowing admins to use HTML. Feedback
	is welcome.
--	I've been thinking about how limiting the current activation system is.
	Some ideas I've been pondering are a system for multiple activation
	criteria (e.g. a title is activated after 10 posts, 45 days, or 20 posts
	and 20 days.) and integration with the points system or similar MODs.
	Once again, feedback would be appreciated.
--	Feel free to submit other feature requests, though I'm at a point where
	I can't think of much else to add.  Requests may or may not happen, so
	don't expect too much.
--------------------------------------------------------------------------------
--------------------------------------------------------------------------------
IV. Installation Guide

This MOD can be installed in one of two ways.  If you have EasyMOD Alpha 2, use
that section.  Otherwise, scroll down for the manual install.  Regardless of
installation method, be sure to scroll down to the Configuration Guide for post-
installation instructions.
--------------------------------------------------------------------------------
a. EasyMOD Installation

This MOD is 100% EasyMOD Alpha compatible.  I have tested the installation to
work perfectly.  However, there may be small bugs.  If you have errors during
install, please be sure to report them.  Be sure to use the latest version of
EasyMOD! (As of this writing, the current version is 0.0.10a, and is available
at http://www.phpbb.com/phpBB/viewtopic.php?t=124436)

1. Extract the included easymod_install.zip into your admin/mods/ directory.
   This will automatically create the necessary EasyMOD setup.
2. Using the "Install MODs" section in the administration panel, install the
   MOD.  Follow the standard EasyMOD MOD installation instructions.
3. Place the included title_install.php into your root phpBB directory, and then
   run it.  This will make the necessary database alterations. When it has
   completed, make sure it didn't report any errors, and then delete the file.
   WARNING: FAILURE TO DELETE THIS FILE MAY PUT YOUR FORUM, SITE, AND SERVER AT
   A POTENTIAL SECURITY RISK.
4. Follow the Configuration Guide provided below in section V.
--------------------------------------------------------------------------------
b. Manual Installation

As with all MODs, manual installation is possible.  If something doesn't work,
or if the directions seem unclear, please let me know.

1. Open the included manual_install.txt.  Follow the instructions carefully, and
   be sure to read everything.  Many common questions asked in the support 
   thread can be answered simply by reading carefully!
2. Place the included title_install.php into your root phpBB directory, and then
   run it.  This will make the necessary database alterations. When it has
   completed, make sure it didn't report any errors, and then delete the file.
   WARNING: FAILURE TO DELETE THIS FILE MAY PUT YOUR FORUM, SITE, AND SERVER AT
   A POTENTIAL SECURITY RISK.
3. Follow the Configuration Guide provided below.
--------------------------------------------------------------------------------
--------------------------------------------------------------------------------
V. Configuration Guide

This MOD ships with several different options to customize the operation of the
custom title system.  Here is a guide that details each option and how it works.
--------------------------------------------------------------------------------
a. Mode of Operation (Default: No Replacement)

There are three possible modes of operation.  While they are very similar, they
extend the use of this MOD to both "Custom Rank" and "Custom Title" styles.

1. No Replacement: If the user enters a custom title, it will appear on their
		   posts and profile as a separate bold title.  If they enter
		   nothing, no changes will appear.
2. Replace Rank Only: If a user enters a custom title, it will replace their 
		      default rank based on posts.  However, the rank image
		      associated with their default rank will remain.  This is a
		      useful compromise between the other two modes.
3. Replace Rank and Image: If a user enters a custom title, it will replace both
			   their default post-based rank and the associated rank
			   image.
--------------------------------------------------------------------------------
b. Criteria for Activation (Default for both: 0)

These two options allow you to configure the time and posts it takes to gain the
use of a custom title.  These options can be overridden, and a user can have
their title manually activated or disabled by an administrator.

1. Posts Required: This sets the number of posts a user must make before they
		   gain access to the custom title.
2. Days Required:  This sets the number of days a user must be a member of your
		   forums before they will gain access to a custom title.
--------------------------------------------------------------------------------
c. Maximum Length (Default: 45)

This sets the maximum allowable length for users' custom titles.  Remember, this
only applies to users entering their titles in their profile.  An administrator
can circumvent this length and enter a longer title if they do it via the admin
panel.  If a user with a "too-long" title changes their profile, their title 
remain extra long, as long as they don't change it.  Once they change it, they
are required to shrink it back down to this maximum length.
--------------------------------------------------------------------------------
--------------------------------------------------------------------------------
VI. Where to Report Bugs

If you discover a bug in the installation process or in the MOD itself, please
report it.  The best way to report is to e-mail it to me, or to send me a
private message at the phpBB web site.  In addition, you may wish to post
information in the following release thread, so other users can learn from
your experience:

http://www.phpbb.com/phpBB/viewtopic.php?t=73968

I have the topic and my PM box on watch, so I will generally respond within a 
few hours.

In addition, you'll always find the latest patches and language packs on my
special phpBB MODs website at http://www.aexoden.com/files/mods/
--------------------------------------------------------------------------------
--------------------------------------------------------------------------------