##############################################################
## MOD Title: Chunk Long URLs
## MOD Author: Joe Belmaati < belmaati@gmail.com > (Joe Belmaati) N/A
## MOD Description: Tired of long urls that strecth your phpBB layout?
## This mod will chunk long urls.
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 1 Minute
## Files To Edit: includes/bbcode.php
##
## Included Files: N/A
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: The long links will look like this:
## http://yoursite.com/fhjfgjf.....dfhdj.php. Short urls will
## not be touched
##############################################################
## MOD History:
##
##   2006-08-16 - 1.0.0
##      - submitted to MODs datatbase at phpBB
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
includes/bbcode.php
#
#-----[ FIND ]------------------------------------------
#
   // matches an email@domain type address at the start of a line, or after a space.
#
#-----[ BEFORE, ADD ]------------------------------------------
#
   chunk_url($ret);

#
#-----[ FIND ]------------------------------------------
#
/**
 * Nathan Codding - Feb 6, 2001
#
#-----[ BEFORE, ADD ]------------------------------------------
#
/**
 * Chunk long urls to avoid page stretching. This function splits a
 * long url into chunks, then glues it back together with a couple
 * of dots. This gaggle of code could be boiled down to fewer lines,
 * but it would make it hard to read.
 */
function chunk_url(&$ret)
{
   /**
    * Split the string into an array. Then loop through
    * the array and process each link separately.
    */
   $links = explode('<a', $ret);
   $countlinks = count($links);
   for ($i = 0; $i < $countlinks; $i++)
   {
      $link = $links[$i];

      /**
       * If the array element is a hyperlink then put the missing
       * '<a' back in, as we will not be imploding...
       */
      $link = (preg_match('#(.*)(href=")#is', $link)) ? '<a' . $link : $link;

      $begin = strpos($link, '>') + 1;
      $end = strpos($link, '<', $begin);
      $length = $end - $begin;
      $urlname = substr($link, $begin, $length);

      /**
       * We chunk urls that are longer than 50 characters. Just change
       * '50' to a value that suits your taste. We are not chunking the link
       * text unless if begins with 'http://', 'ftp://', or 'www.'
       */
      $shorturlname = (strlen($urlname) > 50 && preg_match('#^(http://|ftp://|www\.)#is', $urlname)) ? substr_replace($urlname, '.....', 30, -10) : $urlname;
      $ret = str_replace('>' . $urlname . '<', '>' . $shorturlname . '<', $ret);
   }
}
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM