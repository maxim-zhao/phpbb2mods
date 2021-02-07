##############################################################
## MOD Title: TextArea with full width
## MOD Author: RadikalQ3 < radikal@q3.nu > (RadikalQ3) http://www.q3.nu/trucomania/
## MOD Description: Full wide testarea for write your posts & replys.
##                  The original phpBB new posting page is ridicously always 450 pixels width.
##                  With this mod, the areatext is shown at full width of the screen.
## MOD Version: 1.0.1
## 
## Installation Level: Easy
## Installation Time: 2 minutes
## Files To Edit: templates/subSilver/posting_body.tpl
## Included Files: 
## Generator: MOD Studio 3.0 Beta 1 [mod functions 0.4.1788.30363]
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
##############################################################
## Author Notes: 
##
##      The MOD symply remove the row in witch is contained the 
##      textarea field, and change its style tag.
##      In the standard phpBB installation, the textarea fiel
##      in the new post and reply pages is ridicously widh...
##      With this mod, the textarea fills all screen wide, and
##      makes more comfortable the post's editing.
##
##    Symply but... tremendous!
##  You can test the modification at http://foros.pasote.com 
##  in a standard phpBB 2.0.11 installation with the mod applyed.
##############################################################
## MOD History:
## 
##   2005-02-01 - Version 1.0.0
##      - First version.
##   2005-02-02 - Version 1.0.1
##      - First typographic error...
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
		  <tr> 
			<td colspan="9"><span class="gen"> 
			  <textarea name="message" rows="15" cols="35" wrap="virtual" style="width:450px" tabindex="3" class="post" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">{MESSAGE}</textarea>
			  </span></td>
		  </tr>
		</table>
#
#-----[ REPLACE WITH ]------------------------------------------
#
		</table>
		<textarea name="message" wrap="virtual" style="width:99%; height:450px;" tabindex="3" class="post" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">{MESSAGE}</textarea>
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM

