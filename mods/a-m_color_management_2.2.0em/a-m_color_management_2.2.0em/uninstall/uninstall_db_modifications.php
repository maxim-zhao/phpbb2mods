<?php 
/***************************************************************************
 *                    Uninstall Admins/mods color management
 *                           --------------------
 *   begin                : Sunday, July 16, 2005
 *   copyright            : (C) 2005 -=ET=-
 *   email                : n/a
 *
 *   $Id: uninstall_a-m_color_mngt_2.1.1.php,v 1.0.0 2005/07/16 00:00:00 -=ET=- Exp $
 *
 ***************************************************************************/

/***************************************************************************
*
*    Languages:  French, German, Italian, Spanish for those who use these
*                languages, and English for all others.
*--------
*    Langues:    Français, Allemand, Italien et Espagnol pour ceux utilisant
*                ces langues et anglais pour tous les autres.
* 
****************************************************************************/


define('IN_PHPBB', true); 
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx); 

$userdata = session_pagestart($user_ip, PAGE_INDEX); 
init_userprefs($userdata); 

switch ( $userdata['user_lang'] )
{
	case french:
	case francais:
		$script_lang['mod_name'] = 'Admins/mods color management'; // Ne pas écrire le mot "MOD" dans le nom !

		$script_lang['not_admin'] = '<b>Exécution des requêtes impossible !</b><br /><br />Il vous faut être connecté sous un compte d\'administrateur pour y être autorisé.';
		$script_lang['queries_result'] = sprintf('Résultat des requêtes réalisées pour la désinstallation de %s :', $script_lang['mod_name']);
		$script_lang['query'] = 'Requête ';
		$script_lang['error'] = 'Erreur';
		$script_lang['ok'] = 'OK';
		$script_lang['note'] = '<u>Remarque :</u> si vous avez une ou des requêtes en <b><font color=#FF0000>[Erreur]</font></b>, il est possible que ce soit tout simplement dû<br />au fait que les requêtes aient déjà été exécutées (que la table ou le champ ait déjà été supprimé par exemple).<br />Dans tous les cas, ne repassez plus cette mise à jour. Vérifiez maintenant la source des erreurs en manuel.';
		$script_lang['warning'] = '<b>ATTENTION :</b> maintenant que la ou les requêtes ont été exécutées, vous<br />devez <b>supprimer ce fichier</b> (%s) du répertoire racine de phpBB !';
		break;

//	case german:
//	case deutsch:
//		$script_lang['mod_name'] = 'Admins/mods color management'; // Es darf nicht das Wort "MOD" drin vorkommen !

//		$script_lang['not_admin'] = '<b>Unmöglich die Datenbank zu aktualisieren!</b><br /><br />Nur als Administrator kann man diese Funktion ausführen.';
//		$script_lang['queries_result'] = sprintf('Ergebnisse der Datenbankanpassung vom %s MOD:', $script_lang['mod_name']);
//		$script_lang['query'] = 'Query #';
//		$script_lang['error'] = 'Fehler';
//		$script_lang['ok'] = 'OK';
//		$script_lang['note'] = '<u>Notiz:</u> Wenn ein oder mehrere <b><font color=#FF0000>[Fehler]</font></b> angezeigt werden, wurde die Datenbankanpassung<br />eventuell bereits erfolgreich durchgeführt (z.B. existiert die Tabelle oder das Feld bereits in der Datenbank).<br />Auf jeden Fall sollte man, vor dem erneuten Versuch der Datenbankanpassung, die Fehlerquelle herausfinden.';
//		$script_lang['warning'] = '<b>WARNUNG:</b> Nach erfolgter Datenbankanpassung muss diese Datei<br />(%s) aus dem phpBB-Verzeichnis <b>gelöscht werden</b>!';
//		break;

//	case italian:
//	case italiano:
//		$script_lang['mod_name'] = 'Admins/mods color management'; // Non scrivere la parola "MOD" nel nome! 

//		$script_lang['not_admin'] = '<b>Esecuzione delle richieste d\'aggiornamento impossibile !</b><br /><br />Devi connetterti come amministratore per avere i permessi adatti.';
//		$script_lang['queries_result'] = sprintf('Risultato delle richieste d\'aggiornamento realizzate per conto del MOD %s :', $script_lang['mod_name']);
//		$script_lang['query'] = 'Richiesta n°';
//		$script_lang['error'] = 'Errore';
//		$script_lang['ok'] = 'OK';
//		$script_lang['note'] = '<u>Nota :</u> se avete una o più richieste in <b><font color=#FF0000>[Errore]</font></b>, è possibile che questo sia dovuto al fatto<br />che la richiesta esista già (per esempio che la tabella o il campo sia già stato creato).<br />In tutti i casi non rilanciate più quest\'aggiornamento. Verificate subito l\'origine degli errori manualmente.';
//		$script_lang['warning'] = '<b>ATTENZIONE :</b> ora che la o le richieste sono state eseguite dovete<br /><b>cancellare questo file</b> (%s) dalla cartella di phpBB !';
//		break;

//	case spanish:
//	case espanol:
//		$script_lang['mod_name'] = 'Admins/mods color management'; // No incluya la palabra "MOD" en él nombre!

//		$script_lang['not_admin'] = '<b>Imposible ejecutar las sentencias de actualización!</b><br /><br />Necesitas estar conectado como Adminsitrador para tener los permisos requeridos.';
//		$script_lang['queries_result'] = sprintf('Resultado de las sentencias de actualización para el MOD %s :', $script_lang['mod_name']);
//		$script_lang['query'] = 'Sentencia N°';
//		$script_lang['error'] = 'Error';
//		$script_lang['ok'] = 'OK';
//		$script_lang['note'] = '<u>Nota:</u> si tienes uno o más errores <b><font color=#FF0000>[Error]</font></b> para las sentencias, puede ser simplemente<br />que la actualización ya ha sido realizada (por ejemplo, la tabla o el campo ya existe).<br />En cualquier caso, no vuelva a ejecutar esta actualización. Encuentra el origen de los errores manualmente.';
//		$script_lang['warning'] = '<b>ADVERTENCIA:</b> ya que la sentencia (s) han sido ejecutadas, Ud.<br />debe <b>borrar este fichero</b> (%s) desde el directorio raíz de phpBB!';
//		break;

	default:
		$script_lang['mod_name'] = 'Admins/mods color management'; // Do not include the word "MOD" in the name!

		$script_lang['not_admin'] = '<b>Impossible to run the queries!</b><br /><br />You need to be connected as administrator to have the rights required.';
		$script_lang['queries_result'] = sprintf('Results of queries executed to uninstall %s:', $script_lang['mod_name']);
		$script_lang['query'] = 'Query #';
		$script_lang['error'] = 'Error';
		$script_lang['ok'] = 'OK';
		$script_lang['note'] = '<u>Note:</u> if you have one or more <b><font color=#FF0000>[Error]</font></b> for queries, it can simply be that the query has<br />already been done (the table or the field has already been deleted for example).<br />In any case, do not re execute this update. Find errors origin manually.';
		$script_lang['warning'] = '<b>WARNING:</b> since the query or queries has now been executed, you<br />must <b>delete this file</b> (%s) from the phpBB root directory!';
		break;
}


if( !$userdata['session_logged_in'] ) 
{ 
	header('Location: ' . append_sid("login.$phpEx?redirect=".basename($_SERVER['PHP_SELF']), true)); 
} 

if( $userdata['user_level'] != ADMIN ) 
{ 
	message_die(GENERAL_MESSAGE, $script_lang['not_admin']);
}

$sql = array(" 
ALTER TABLE ".$table_prefix."themes DROP fontcolor5
","
ALTER TABLE ".$table_prefix."themes DROP fontcolor6
","
ALTER TABLE ".$table_prefix."themes_name DROP fontcolor5_name
","
ALTER TABLE ".$table_prefix."themes_name DROP fontcolor6_name
"); 

$n = 0;

$message = '<b>' . $script_lang['queries_result'] . '</b><br /><br />'; 
 
while($sql[$n]) 
{ 
$message .= ($mods[$n-1] != $mods[$n]) ? '<p><b><font size=2>'.$mods[$n].'</font></b><br />' : ''; 
if(!$result = $db->sql_query($sql[$n])) 
{
	$message .= $script_lang['query'] . ($n+1) . ' : ' . $sql[$n] . ' <b><font color=#FF0000>[' . $script_lang['error'] . ']</font></b><br />'; 
} 
else 
{
	$message .= $script_lang['query'] . ($n+1) . ' : ' . $sql[$n] . ' <b><font color=#009900>[' . $script_lang['ok'] . ']</font></b><br />'; 
} 
$n++; 
} 

$message .= '<br /><br /><font size=1>' . $script_lang['note'] . '</font><br /><br /><br />' . sprintf($script_lang['warning'], basename($_SERVER['PHP_SELF'])); 

message_die(GENERAL_MESSAGE, $message); 

?> 