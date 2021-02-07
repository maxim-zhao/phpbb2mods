;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
;                         mmFunctions.au3
;           This file contains functions necesary to MODmaker
;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
Func update()
	$fileName=InputBox ( "Save as...", "Type the file name you would like to save the mod as. (don't forget to add .mod or .txt"_
	& " at the end!)")
	global $file=InputBox ( "Save as...", "Type the location of where to save the mod file:", @HomeDrive & @HomePath & "\" & $fileName, "", _
	-1, -1, 0, 0)
	save()
EndFunc
Func save()
	_FileCreate ( $file )
	$mod = FileOpen ( $file, 2 )
	; Check if file opened for reading OK
	If $mod = -1 Then
		MsgBox(0, "Error", "ERROR: Unable to open file for writing. ABORTING APPLICATION.")
		Exit
	EndIf
	
	$Name = GUICtrlRead( $modName )
	$Author = GUICtrlRead( $modAuthor )
	$Email = GUICtrlRead( $modEmail )
	$RealName = GUICtrlRead( $modRealName )
	$Website = GUICtrlRead( $modWebsite )
	$Description = GUICtrlRead( $modDescription )
	$Version = GUICtrlRead( $modVersion )
	$ToEdit = GUICtrlRead( $modToEdit )
	$Included = GUICtrlRead( $modIncluded )
	; check "Files to Edit" and "Included Files" for empty strings
	If $ToEdit = "" Then
		$ToEdit = "N/A"
	EndIf
	If $Included = "" Then
		$Included = "N/A"
	EndIf
	
	; check e-mail address and version for correct format
	If $Email <> "*@*.*" Then
		$Email = InputBox ( "E-mail address", $Email & " is an invalid E-mail address. Please enter a valid one below." )
	EndIf
	If $Version <> "*.*.*" Then
		$Version = InputBox ( "Version", $Version & " is not in valid phpBB version format. Please enter a correct one in the format of *.*.* below." )
	EndIf
	
	; Start - file writing

	FileWriteLine ( $mod, "##############################################################" )
	FileWriteLine ( $mod, "## MOD Title: " & $Name )
	FileWriteLine ( $mod, "## MOD Author: " & $Author & " < " & $Email & " > (" & $RealName & ") " & $Website )
	FileWriteLine ( $mod, "## MOD Description: " & $Description )
	FileWriteLine ( $mod, "## MOD Version: " & $Version )
	FileWriteLine ( $mod, "##" )
	FileWriteLine ( $mod, "## Installation Level: (Easy/Intermediate/Advanced)" )
	FileWriteLine ( $mod, "## Installation Time: x Minutes" )
	FileWriteLine ( $mod, "## Files To Edit: " & $Toedit )
	FileWriteLine ( $mod, "## Included Files: " & $Included )
	FileWriteLine ( $mod, "## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2" )
	FileWriteLine ( $mod, "##############################################################" )
	FileWriteLine ( $mod, "## For security purposes, please check: http://www.phpbb.com/mods/" )
	FileWriteLine ( $mod, "## for the latest version of this MOD. Although MODs are checked" )
	FileWriteLine ( $mod, "## before being allowed in the MODs Database there is no guarantee" )
	FileWriteLine ( $mod, "## that there are no security problems within the MOD. No support" )
	FileWriteLine ( $mod, "## will be given for MODs not found within the MODs Database which" )
	FileWriteLine ( $mod, "## can be found at http://www.phpbb.com/mods/" )
	FileWriteLine ( $mod, "##############################################################" )
	FileWriteLine ( $mod, "## Author Notes:" )
	FileWriteLine ( $mod, "## none" )
	FileWriteLine ( $mod, "##############################################################" )
	FileWriteLine ( $mod, "## MOD History:" )
	FileWriteLine ( $mod, "## " )
	FileWriteLine ( $mod, "##   " &  @YEAR  & "-" & @MON & "-" & @MDAY & " - Version " & $Version)
	FileWriteLine ( $mod, "##      - (no version notes)" )
	FileWriteLine ( $mod, "##############################################################" )
	FileWriteLine ( $mod, "## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD" )
	FileWriteLine ( $mod, "##############################################################" )
	FileWriteLine ( $mod, " " )
	
	; End - File Writing
	
    FileClose( $mod )
	;
	; Start - File Reading (fixed by LxP)
	;
	if (fileGetSize($file) = 0) then
		MsgBox (0, "ERROR", "ERROR: could not write to file " & $file & ". MOD creation failed.")
	EndIf
	;
	; End - File Reading
	;
EndFunc