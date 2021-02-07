#comments-start
                          phpBB MOD maker
                         version 0.1.8 beta
                    Created by msr2 and bojak71730
	Also, thanks to LxP and Valuater for fixing major read and write issues
                        Written using AutoIt3
                     http://www.autoitscript.com
#comments-end
#region general preparation
; everything in this region does the necesary actions to prevent errors and/or warnings when running the script
#include <GUIConstants.au3>
#include <file.au3>
Dim $file = "", $actions = "", $action = "", $text = "", $TextInput = "", $actionInputText = ""
#endregion
#region GUI
GUICreate("phpBB MOD maker")

GUISetFont(9, 300)

$tab=GUICtrlCreateTab (1,1, 400,400)

$tab0=GUICtrlCreateTabitem ("general MOD information")
GUICtrlSetState(-1,$GUI_SHOW)   ; will be display first
$modName=GUICtrlCreateInput ( "", 85, 25, 100, 21)
$modNameLabel=GUICtrlCreateLabel ("MOD name: ",  10, 30, 100, 21)
$modAuthor=GUICtrlCreateInput ( "", 85, 50, 100, 21)
$modAuthorLabel=GUICtrlCreateLabel ( "MOD Author: ", 10, 55, 100, 21)
$modEmail=GUICtrlCreateInput ( "", 90, 75, 100, 21)
$modEmailLabel=GUICtrlCreateLabel ( "Author E-mail: ", 10, 80, 100, 21)
$modRealName=GUICtrlCreateInput ( "", 117, 100, 100, 21)
$modRealNameLabel=GUICtrlCreateLabel ( "Author Real Name: ", 10, 105, 120, 21)
$modWebsite=GUICtrlCreateInput ( "", 95, 125, 100, 21)
$modWebsiteLabel=GUICtrlCreateLabel ( "Author website: ", 10, 130, 100, 21)
$modVersion=GUICtrlCreateInput ( "0.0.0", 85, 150, 100, 21)
$modVersionLabel=GUICtrlCreateLabel ( "MOD version: ", 10, 155, 100, 21)
$modDescription=GUICtrlCreateEdit ( "", 107, 175, 170, 84)
$modDescriptionLabel=GUICtrlCreateLabel ( "MOD description: ", 10, 180, 100, 21)
$modIncluded=GUICtrlCreateInput ( "", 93, 263, 100, 21)
$modIncludedLabel=GUICtrlCreateLabel ( "Included Files: ", 10, 268, 100, 21)
$modIncludedLabel2=GUICtrlCreateLabel ( "(seperated by commas)", 195, 268, 200, 21)
$modToedit=GUICtrlCreateInput ( "", 85, 288, 100, 21)
$modToeditLabel=GUICtrlCreateLabel ( "Files to Edit: ", 10, 293, 100, 21)

$tab1=GUICtrlCreateTabitem ( "Actions" )
$actionMenu=GUICtrlCreateCombo ( "SQL", 85, 25, 200, 23)
$actionMenuItems=GUICtrlSetData ( -1, "COPY|DIY INSTRUCTIONS|OPEN|FIND|REPLACE WITH|AFTER, ADD|BEFORE, ADD|INCREMENT|_
IN-LINE FIND|IN-LINE AFTER, ADD|IN-LINE BEFORE, ADD|IN-LINE REPLACE WITH" )
$actionMenuLabel=GUICtrlCreateLabel ( "New Action:", 10, 30 )
$actionButton=GUICtrlCreateButton ( "Add", 295, 25, 27, 20 )
$divider1=GUICtrlCreateLabel ( "_____________________________________", 56, 60 )
; the following two lines will be put back in, modified slightly, in a later version.
;$actionLabel=GUICtrlCreateLabel ( "Current Actions", 150, 90 )
;$actionPending=GUICtrlCreateLabel ( "Yet to be added - planned for version 1.1.0 or later", 40, 117 )

GUICtrlCreateTabitem ("")   ; end tabitem definition

$update=GUICtrlCreateButton ("UPDATE!", 165,350)

GUISetState ()


; Run the GUI until the dialog is closed
While 1==1
    global $msg = GUIGetMsg()
    
    If $msg = $update Then Call( "update" )
	If $msg = $actionButton Then Call ( "add" )
    
    If $msg = $GUI_EVENT_CLOSE Then
        $close = MsgBox(100, "Quit?", "Are you sure you want to close?")
        If $close = 6 Then ExitLoop
    EndIf
WEnd
#endregion

#region functions
Func add()
    $action = GUICtrlRead ( $actionMenu )
    $actionInputText = "# " & @CRLF & "#-----[ " & $action & " ]------------------------------------------" & @CRLF & "# " & @CRLF
    $CHILD_GUI = GUICreate ( "New Action", 170, 240, -1, -1, "", "", "phpBB MOD maker" )
    $textInput = GUICtrlCreateEdit ( $actionInputText, 10, 10, 150, 150 )
    $actionCloseWin = GUICtrlCreateButton ( "Close", 65, 170 )
    GUISetState ()
; Run the GUI until the dialog is closed
    While 1
        $msg2 = GuiGetMsg()
        If $msg2 = $actionCloseWin Then
            GUIDelete($CHILD_GUI)
            ExitLoop
        EndIf
        If $msg2 = $GUI_EVENT_CLOSE Then
            GUIDelete($CHILD_GUI)
            ExitLoop
        EndIf
    WEnd
EndFunc
Func action()
	$text1 = GUICtrlRead ( $textInput )
	$text = $text1 & @CRLF
EndFunc
Func update()
	$actions = $actions & $text & @CRLF
	$fileName=InputBox ( "Save as...", "Type the file name you would like to save the mod as. (don't forget to add .mod or .txt"_
	& " at the end, or you will end up with an unusable file!)")
	If $fileName = 2 Then Exit
	global $file=InputBox ( "Save as...", "Type the location of where to save the mod file:", @MyDocumentsDir & "\" & $fileName, "", _
	-1, -1, 0, 0)
	If $file = 2 Then Exit
	save()
EndFunc
Func save()
	$actions = $actions & "#" & @CRLF & "#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------"_
	& @CRLF & "#" & @CRLF & "# EoM"
	If Not FileExists ( $file ) Then
		_FileCreate ( $file )
		$mod = FileOpen ( $file, 2 )
	Else
		$replace = MsgBox ( 4, "Overwrite?", $file & " already exists. Would You like to replace the existing file? If no, the new_
		MOD will be added to the end of the file" )
		If $replace = 6 Then ; if "yes" is selected
			$mod = FileOpen ( $file, 2 )
		Else
			$mod = FileOpen ( $file, 1 )
		EndIf
	EndIf
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
	; this does not work correctly. removed until it can be fixed
	;If $Email <> "*@*.*" Then
	;	$Email = InputBox ( "E-mail address", $Email & " is an invalid E-mail address. Please enter a valid one below." )
	;EndIf
	;If $Version <> "*.*.*" Then
	;	$Version = InputBox ( "Version", $Version & " is not in valid phpBB version format. Please enter a correct one in the_
	;format of *.*.* below." )
	;EndIf
	
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
	FileWrite ( $mod, $actions )
	
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
#endregion