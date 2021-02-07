GLOBAL ADMIN TEMPLATE
A phpBB extension by Thoul
Current Release: 1.2.0
Official Supported phpBB Release: 2.0.x

Table of Contents:
1) Introduction
2) Release Notes
3) Included Files
4) Contact Information

--------------------------------------------------------------------------------
                                  INTRODUCTION
--------------------------------------------------------------------------------

Have you ever installed a modification that required editing a template file on
a board that uses multiple templates?  If so, you know that you have to edit the
same file in every template for the modification's changes to be shown on all of
them.  That can take a lot of time, especially if many files need to be edited.

You may have also noticed that while templates can be very different from one
another, many of them use the original subSilver files for their admin panel.
They just copy the admin/ directory of subSilver and use it without any changes.
If this was not done, then you wouldn't be able to access the admin panel while
you're using that template.  The bad thing about this is that you've got a one
copy of the exact same files for each template taking up space on your server
that you could be using for something better.  And worse yet, if you have to
edit an admin/ template file for a modification, you've got to do it multiple
times!

Global Admin Template will help you out with both of these problems.  It gives
one copy of admin/ template files that will be used no matter what theme you
choose for use on the rest of the board.  It'll save you space by getting rid of
those other admin/ template directories and save you time by cutting down the
number of files you have to edit and upload.

--------------------------------------------------------------------------------
                                 RELEASE NOTES
--------------------------------------------------------------------------------

Version 1.2.0 - July 23, 2006
General update to confirm that the modification still works correctly on newer
phpBBs, and a repacking for submission to the database at phpBB.com.  The admin
template files are moved to a new location in this version, which has some
benefits.
Added upgrade instructions.
Removed the old Categories Hierarchy additional changes, replacing them with a
full alternate install that is more current.

See contrib/changelog.txt for a detailed list of changes in this version.

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
Alongside these directories, you should see a file_edits.txt file.  This has the
install instructions.

The "contrib" directory may contain the following files:
	license.txt       - License information regarding this download.
	release_notes.txt - Short summary of changes in each version.
	changelog.txt     - Detailed list of changes to each version.
	upgrade*.txt      - Instructions for upgrading from a previous version.
	uninstall.txt     - Instructions for uninstalling.
The "contrib" directory may also contain a file with the extension .hl, such as
"contact.hl."  This is a file for use with Nivisec's Mods/Hack List
modification.  If you don't have that modification installed, ignore this file.
If you do have it installed, then check it includes documentation for this file.

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