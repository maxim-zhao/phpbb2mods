<script language="javascript" type="text/javascript">
function jump_to_profile(url)
{
	opener.document.location.href = url;
	//window.close();
}
</script>

  <p style="margin-top: 0"><span class="gen"><b>{L_POST_BREAKDOWN}</b><br />{L_TOTAL}</span></p>
  <table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr> 
	  <th class="thCornerL" nowrap="nowrap" style="text-align: left">{L_USERNAME}</th>
	  <th class="thCornerR" nowrap="nowrap" style="text-align: left">{L_POSTS}</th>
	</tr>
	<!-- BEGIN posterrow -->
	<tr> 
	  <td class="{posterrow.ROW_CLASS}" nowrap="nowrap"><span class="gen">{posterrow.USERNAME}</span></td>
	  <td class="{posterrow.ROW_CLASS}" nowrap="nowrap"><span class="gen">{posterrow.POSTS}</span></td>
	</tr>
	<!-- END posterrow -->
	<tr>
	  <td class="catBottom" nowrap="nowrap" colspan="2" align="center"><input type="submit" name="submit" value="{L_CLOSE_WINDOW}" class="mainoption" onclick="window.close()" /></td>
	</tr>
  </table>