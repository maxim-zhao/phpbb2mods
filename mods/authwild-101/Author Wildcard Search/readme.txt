ALLOW AUTHOR WILDCARD SEARCH
A phpBB extension by Thoul
Current Release: 1.0.1
Official Supported phpBB Release: 2.0.20 - 2.0.21

Table of Contents:
1) Introduction
2) Features
3) Release Notes
4) Included Files
5) Contact Information

--------------------------------------------------------------------------------
                                  INTRODUCTION
--------------------------------------------------------------------------------

With the release of phpBB 2.0.14, the developers of phpBB introduced changes to
limit and prevent certain types of server-intensive searches.  As a side effect,
some hacks that relied on author searches of only the "*" wildcard were broken.
Allow Author Wildcard Search was created as a middle path: the wildcard becomes
enabled in author searches, while still cutting down on searches that could
cause high server load.

Installing this hack is recommended for users of hacks like Niels' Search back
(also known as Search Posts by Time) that wish to continue using these hacks on
phpBB 2.0.14 or later versions.

--------------------------------------------------------------------------------
                                    FEATURES
--------------------------------------------------------------------------------

-Enables author searching for just the "*" wildcard in phpBB 2.0.20+.
 (For phpBB 2.0.14 - 2.0.19, see the previous release).
-Avoids use of intensive "LIKE '%'" SQL query for wildcard-only author search.
-Preserves phpBB 2.0.14+ style limitations on other searches.

--------------------------------------------------------------------------------
                                 RELEASE NOTES
--------------------------------------------------------------------------------

Version 1.0.1 - November 15, 2006
Updated for phpBB 2.0.20 - 2.0.21 compatibility.

--------------------------------------------------------------------------------
                                 INCLUDED FILES
--------------------------------------------------------------------------------

When the ZIP file for this download is unpacked, the following new directories
may be created on your system, each containing the noted files.
	contrib   - Important documents regarding usage of the download. READ THEM.
	root      - New files that will be added to your forum, if any.
	premodded - Original phpBB files, with this download already installed.
The "root" and "premodded" directories may not be present - this usually means
they are either not needed or included for this modification.
Alongside these directories, you should see a install.txt file.  This has the
install instructions.

The "contrib" directory may contain the following files:
	license.txt       - License information regarding this download.
	release_notes.txt - Short summary of changes in each version.
	changelog.txt     - Detailed list of changes to each version.
	uninstall.txt     - Instructions for uninstalling.
	upgrades/*.txt     - Instructions for upgrading from a previous version.
The "contrib" directory may also contain a file with the extension .hl, such as
"contact.hl."  This is a file for use with Nivisec's Mods/Hack List
modification.  If you don't have that modification installed, ignore this file.
If you do have it installed, then check its documentation for more on .hl files.

--------------------------------------------------------------------------------
                              CONTACT INFORMATION
--------------------------------------------------------------------------------

To find other phpBB material I have created, please visit these web sites:
phpBB Smith            http://www.phpbbsmith.com/
phpBB.com              http://www.phpbb.com/
phpBBHacks.com         http://www.phpbbhacks.com/
                       http://www.phpbbhacks.com/searchresults.php?author=Thoul

phpBB Smith is my personal phpBB related web site and therefore tends to have
most of my works (including older versions if needed), while the other sites
generally have some, but not all, of my stuff around somewhere.  Basically, they
all have different things, so check them all.  If you need to e-mail me, I can
be reached via a contact form at the phpBB Smith site.

Have a nice day. :D