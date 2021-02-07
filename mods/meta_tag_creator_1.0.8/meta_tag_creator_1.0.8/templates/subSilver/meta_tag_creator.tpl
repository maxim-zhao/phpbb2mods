<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  <tr> 
    <td align="left"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> </td>
  </tr>
</table>
<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0" align="center">
  <tr> 
    <th class="thHead">{L_INTRO}</th>
  </tr>
  <tr> 
    <td class="row1"> <span class="gen"><b>{L_WHAT}</b></span><br> <br> 
      <span class="gensmall">{L_EXPLAIN}</span><br>
      <br>
      </td>
  </tr>
  <tr> 
    <td class="catBottom" height="28">&nbsp;</td>
  </tr>
</table>
<br>
<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0">
  <tr> 
    <th colspan="2" class="thHead">{L_HEADER}</th>
  </tr>
  <tr> 
    <td class="row1" align="center"> <form action="meta_tag_results.php" method="post">
        <table border="0" cellpadding="2">
          <tr> 
            <td colspan="3"><br></td>
          </tr>
          <tr> 
            <td><span class="genmed">{L_SITE_TITLE}:</span></td>
            <td><input name="title" type="text" size="40" maxlength="50" value="{TITLE}"> 
            </td>
            <td> <a href="metafaq.php#0" target="_blank">{IMG_FAQ}</a></td>
          </tr>
          <tr> 
            <td><span class="genmed">{L_DESCRIPTION}:</span><br> <span class="gensmall"> 
              ({L_LENGTH})</span></td>
            <td valign="middle"><textarea name="description" cols="39" rows="4">{DESCRIPTION}</textarea> 
            </td>
            <td valign="middle"> <a href="metafaq.php#1" target="_blank">{IMG_FAQ}</a></td>
          </tr>
          <tr> 
            <td><span class="genmed">{L_KEYWORDS}:</span></td>
            <td><input name="keywords" type="text" size="40" maxlength="100" value="{KEYWORDS}"> 
            </td>
            <td> <a href="metafaq.php#2" target="_blank">{IMG_FAQ}</a></td>
          </tr>
          <tr> 
            <td><span class="genmed">{L_SITE_AUTHOR}:</span></td>
            <td><input name="author" type="text" size="40" maxlength="30" value="{AUTHOR}"> 
            </td>
            <td> <a href="metafaq.php#3" target="_blank">{IMG_FAQ}</a></td>
          </tr>
          <tr> 
            <td><span class="genmed">{L_ROBOTS}:</span></td>
            <td><select name="robots" value="{ROBOTS}">
                <option value="All" selected>{L_ALL} 
                <option value="None">{L_NONE}
                <option value="Index">{L_MINDEX} 
                <option value="No Index">{L_NOINDEX}
                <option value="Follow">{L_FOLLOW}
                <option value="No Follow">{L_NOFOLLOW} </select> </td>
            <td> <a href="metafaq.php#4" target="_blank">{IMG_FAQ}</a></td>
          </tr>
          <tr> 
            <td colspan="3" align="right"><br> <input type="submit" value="{L_CREATE}" class="liteoption"> 
              <input type="reset" value="{L_CLEAR}" class="liteoption"></td>
          </tr>
        </table>
      </form>
      <span class="gensmall">{L_WROTE} <a href="http://www.funender.com/phpBB2/index.php" target="_blank">funender.com</a></span><br> 
      <br> </td>
  </tr>
</table>
<br>
