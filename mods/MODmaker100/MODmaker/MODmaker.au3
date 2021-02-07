;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
;                          phpBB MOD maker
;                         version 0.1.6 beta
;                    Created by msr2 and bojak71730
;             Also, thanks to LxP for fixing major write issues
;                        Written using AutoIt3
;                     http://www.autoitscript.com
;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
#include <GUIConstants.au3>
#include <file.au3>
#include <bin\mmFunctions.au3>

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
$modDescription=GUICtrlCreateInput ( "", 107, 175, 170, 84)
$modDescriptionLabel=GUICtrlCreateLabel ( "MOD description: ", 10, 180, 100, 21)
$modIncluded=GUICtrlCreateInput ( "", 93, 263, 100, 21)
$modIncludedLabel=GUICtrlCreateLabel ( "Included Files: ", 10, 268, 100, 21)
$modIncludedLabel2=GUICtrlCreateLabel ( "(seperated by commas)", 195, 268, 200, 21)
$modToedit=GUICtrlCreateInput ( "", 85, 288, 100, 21)
$modToeditLabel=GUICtrlCreateLabel ( "Files to Edit: ", 10, 293, 100, 21)

GUICtrlCreateTabitem ("")   ; end tabitem definition

$update=GUICtrlCreateButton ("UPDATE!", 165,350)

GUISetState ()

; Run the GUI until the dialog is closed
While 1
    global $msg = GUIGetMsg()
    
    If $msg = $update Then Call( "update" )
    
    If $msg = $GUI_EVENT_CLOSE Then
        $close = MsgBox(100, "Quit?", "Are you sure you want to close?")
        If $close = 6 Then ExitLoop
    EndIf
WEnd