Advanced Version Check
Readme

Thank you for downloading the Advanced Version Check MOD, the first and most popular version checking system of its kind for phpBB2. This guide serves as a "roadmap" for the contents of this zip.

The main installation file can be found by opening install_part1.xml in your web browser. This will display the MOD installation instructions in a formatted view using the phpBB MODX Template. You can also, if you wish, open it in a text editor to view the XML source for the MODX Template.

If you prefer the old Text MOD Template view, or if you are using EasyMOD (at the time of writing, EasyMOD is incompatible with MODX), you may wish to open the Text MOD Template-formatted installation instructions, found in contrib/easymod_installation/ in this zip. Note that you will need to move the files to the root directory of this zip (where this file is located) before you can install using EasyMOD.

For both sets of MOD installation files, there is a part 1 and a part 2 file. Part 1 is mandatory for all installations of AVC. Part 2 is required only if you are installing this MOD on top of Ptirhiik's Categories Hierarchy (versions 2.1.1-2.1.4); failure to install part 2 in this instance will cause errors on your Admin Index. If you are using earlier versions of Categories Hierarchy, you only need to install part 1. AVC is currently incompatible with later versions of CH, however this is on the to-do list.

AVC Requirements:
- PHP 4.0.3 or later (the latest version of PHP 4 is recommended)
	* It is not recommended to run phpBB2 (and therefore, AVC) under PHP 5.x, however both have been successfully run under PHP 5 by certain users.
- MySQL, PostgreSQL, or Microsoft SQL Server (any version supported by phpBB2)
- phpBB 2.0.19 or later (it's recommended that you update to the latest version!); phpBB 2.1.x/3.x not supported by this version
- Cannot install over Ptirhiik's Categories Hierarchy 2.1.5 RC-1 or later
- Please make sure that if you are installing by hand, you know how to properly install a phpBB MOD.

To update AVC from an earlier version, refer to updates/versions.txt which contains a list of provided update scripts and instructions for using them.

A general guide for using AVC can be found in docs/userguide.txt. A comprehensive MOD History for this MOD (right down to version 0.1.0!) can be found in docs/history.txt. The fulltext of the GNU General Public License version 2, which this MOD is released under, can be found in docs/LICENSE.txt, or via the link listed in the MOD installation file.

The docs/avc_mod-authors/ directory contains files and instructions for MOD Authors interested in creating AVC-compatible version checkers for their MODs. The readme.html file contains the instructions; the other folders contain sample files that are needed. See that readme for more info.

The root/ directory contains the included files to upload, as instructed in the MOD install file.

modx.fountainofapples.en.xsl and the contents of the xsl/ directory simply are files needed for the MODX Template; please ignore them and leave their structure in the zip intact.