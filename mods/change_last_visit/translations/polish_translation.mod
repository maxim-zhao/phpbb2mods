##############################################################
## MOD Title: (Polish translation) Oznaczanie postów jako nieprzeczytane.
## MOD Author: Nux < egil -at- wp.pl > (Maciej Jaros) N/A
## MOD Description:
##		Proszê nie instalowaæ tego t³umaczenia EasyMODem! 
##		Please do not install this translation with EasyMOD.
##
##		MOD daje wszystkim u¿ytkownikom mo¿liwoœæ zmiany daty 
##		ostatniej wizyty. Czas ten (na spó³kê z tzw. ciasteczkami)
##		umo¿liwia oznaczanie tematów jako nieprzeczytanych.
##		Dla przyk³adu jeœli ktoœ zmieni tê datê na 18 may 2005,
##		to bêdzie mia³ wszystkie posty od tej daty bêd¹ oznaczone 
##		jako nie przeczytane (jeœli nie zosta³y ju¿ zaznaczone jako 
##		przeczytane przez ciasteczka).
##		U¿ytkownik mo¿e równie¿ zobaczyæ wszystkie tematy 
##		od ustawionej daty (w tym wypdaku ciasteczka nie maj¹ 
##		znaczenia). Mo¿na to osi¹gn¹æ naciskaj¹c link 
##		'Zobacz posty od ostatniej wizyty'.
##		
## MOD Version:   1.0.0
##
## Installation Level: Easy
## Installation Time: 1 Minute
##
## Files To Edit: 
##		language/lang_polish/lang_main.php
##
## Included Files:
##		N/A
##
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2 
############################################################## 
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
############################################################## 
## Author Notes: 
##
##	Uwaga: Ten mod dotyczy _tylko_ zmian w pliku jêzykowym, 
##	wiêc najpierw nale¿y dokonaæ zmian wed³ug ogólnego pliku 
##	'change_last_visit.mod'. 
##	Mo¿na oczywiœcie pomin¹æ zmiany wykonywane na pliku 
##	jêzyka angielskiego (jeœli nie jest u¿ywany).
##
##	Rêczna instalacja:
##	 + Jeœli natrafisz na polecenie 'AFTER, ADD',
##	   to wstaw kod w nim zawarty ZA ostatni¹ lini¹ znalezion¹
##	   w poprzednim poleceniu 'FIND'
##	 + Jeœli natrafisz na polecenie 'BEFORE, ADD',
##	   to wstaw kod w nim zawarty PRZED pierwsz¹ lini¹ znalezion¹
##	   w poprzednim poleceniu 'FIND'
##	 + Jeœli natrafisz na polecenie 'REPLACE WITH',
##	   to wstaw kod w nim zawarty ZAMIAST wszystkich linii, które
##	   zosta³y odnalezione w poprzednim poleceniu 'FIND'
##
############################################################## 
## MOD History: 
## 
##	2006-01-19 - Version 1.0.0 (RC1)
##	 - pierwsza oficjalna publikacja MODa
##
##	2006-01-17 - Version 0.1.2 (beta)
##	 - naprawione bugi w JavaSkrypcie zwi¹zane z obsuwk¹ czasu/daty
##	 - parê zmian w notatkach MODów
##	 - zmiana nazwy MODa
##
##	2006-01-13 - Version 0.1.1 (beta)
##	 - naprawiony bug w JavaSkrypcie
##
##	2006-01-13 - Version 0.1.0 (beta)
##	 - kalendarz w JavaSkrypcie
##
##	2005-05-27 - Version 0.0.2 (beta)
##	 - poprawka w b³êdu zwi¹zanego ze zmian¹ roku
##
##  	2005-05-26 - Version 0.0.1 (beta)
##	 - pierwsza beta
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#------------------[ OPEN ]------------------
#
language/lang_polish/lang_main.php

#
#------------------[ FIND ]------------------
#
# prawie na pocz¹tku pliku
#
<?php

#
#------------------[ AFTER, ADD ]------------------
#
# po to, ¿eby oznaczyæ plik jako zmieniony
#
// MOD: modvisit

#
#------------------[ FIND ]------------------
#
# tu¿ przed koñcem pliku
#
?>

#
#------------------[ BEFORE, ADD ]------------------
#
# jeœli instalowa³eœ/-aœ EasyMODem, to skasuj napierw
# niepotrzebne zmienne jêzykowe - miêdzy tym:
# // MOD: modvisit :BEGIN
# a tym:
# // MOD: modvisit :END
#
#
// MOD: modvisit :BEGIN
$lang['Change'] = 'Zmieñ';
$lang['Click_return_login'] = 'Kliknij %sTutaj%s aby spróbowaæ ponownie';
$lang['modvisit_title'] = 'Zmiana ustawieñ dotycz±cych postów nieprzeczytanych.';
$lang['modvisit_date_title'] = 'Oznacz jako nieprzeczytane posty od daty:';
$lang['modvisit_explain'] = 'Zostanie zmieniona data Twojej ostatniej wizyty, która obs³uguje oznaczanie postów (na spó³kê z tzw. cookiesami) jako przeczytane lub nie.';
$lang['modvisit_date_invalid'] = 'Data jest nieprawid³owa.';
// tu maja byc pojedyncze cudzyslowy, zeby zostalo prawidlowo zinterpretowane przez JavaScript
$lang['modvisit_time_invalid'] = 'Nieprawid³owy format czasu!\nSpróbuj 13:10, albo 14:57:29.';
// MOD: modvisit :END

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM