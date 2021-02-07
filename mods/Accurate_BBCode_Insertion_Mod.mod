##############################################################
## MOD Title: Accurate BBCode Insertion Mod
## MOD Author: Lord Z < info@znok.tk > (Jelle Aalbers) http://www.znok.tk
## MOD Description: This mod will insert BBCode accuratly into a post, (at the caret position) instead of putting it at the bottom.
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: ~ 1 Minute
## Files To Edit: templates/subSilver/posting_body.tpl
## Included Files: n/a
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##	
##	Why I wrote this mod
##	------------------------------------------------------
##	Usually, when a user wants to insert BBCode at a specific location while typing his post,
##	he has to type and select the text he wants to apply the BBCode to first, and then apply 
##	the BBCode to the selected text. When you try to just insert a BBCode-tag, it will appear
##	at the end of the post, and not at the caret position. This can be quite annoying.
##
##
##	What it does
##	------------------------------------------------------
##	It changes the way BBCode is inserted in a post into a more natural way. When you click
##	a BBCode-button, the tag will appear at the same place you where typing instead of at the
##	bottom of the post. If the caret isn't inside the message field, the tag will appear where the
##	user has lastly placed the caret inside the message field.
##
##	It won't alter the way BBCode is applied to selections, this worked well already.
##
##	It won't alter the behaviour of the 'Close all tags' button.  All tags are are still closed
##	at the bottom of the post when a user clicks this button.
##
##	If the client's browser doesn't support the technology to insert BBCode accuratly, it will
##	be placed the old-fashioned way.
##
##	The javascript function used to insert the code is (almost) identical to the function
##	wich is used for emoticons, so it behaves in almost the same way. It won't put any spaces
##	around your tag though, which does happens with emoticons.
##
##############################################################
## MOD History:
##
##   2004-12-16 - Version 1.0.0
##      - First version
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/posting_body.tpl

#
#-----[ FIND ]------------------------------------------
#
function emoticon(text) {

#
#-----[ BEFORE, ADD ]------------------------------------------
#
function bbplace(text) {
	var txtarea = document.post.message;
	if (txtarea.createTextRange && txtarea.caretPos) {
		var caretPos = txtarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
		txtarea.focus();
	} else {
		txtarea.value  += text;
		txtarea.focus();
	}
}


#
#-----[ FIND ]------------------------------------------
#
		while (bbcode[bblast]) {
				butnumber = arraypop(bbcode) - 1;
				txtarea.value += bbtags[butnumber + 1];

#
#-----[ REPLACE WITH ]------------------------------------------
#
		while (bbcode[bblast]) {
				butnumber = arraypop(bbcode) - 1;
				bbplace(bbtags[butnumber + 1]);

#
#-----[ FIND ]------------------------------------------
#
		if (imageTag && (bbnumber != 14)) {		// Close image tag before adding another
			txtarea.value += bbtags[15];

#
#-----[ REPLACE WITH ]------------------------------------------
#
		if (imageTag && (bbnumber != 14)) {		// Close image tag before adding another
			bbplace(bbtags[15]);

#
#-----[ FIND ]------------------------------------------
#
		// Open tag
		txtarea.value += bbtags[bbnumber];

#
#-----[ REPLACE WITH ]------------------------------------------
#
		// Open tag
		bbplace(bbtags[bbnumber]);

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 