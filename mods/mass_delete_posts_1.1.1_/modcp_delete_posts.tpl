
<form method="post" action="{S_DELETE_POSTS_ACTION}">
  <table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
	  <td align="left" class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a><span class="nav"> 
		-> <a href="{U_VIEW_FORUM}" class="nav">{FORUM_NAME}</a></span></td>
	</tr>
  </table>
  <table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
	<tr> 
	  <th height="25" class="thHead" colspan="3" nowrap="nowrap">{L_DELETE_POSTS}</th>
	</tr>
	<tr> 
	  <td class="row2" colspan="3" align="center"><span class="gensmall">{L_DELETE_POSTS_EXPLAIN}</span></td>
	</tr>
	<tr> 
	  <td class="catHead" colspan="3" height="28" align="center"> 
		  <input class="liteoption" type="submit" name="delete_posts" value="{L_DELETE_POSTS}" />
	  </td>
	</tr>
	<tr> 
	  <th class="thLeft" nowrap="nowrap">{L_AUTHOR}</th>
	  <th nowrap="nowrap">{L_MESSAGE}</th>
	  <th class="thRight" nowrap="nowrap">{L_SELECT}</th>
	</tr>
	<!-- BEGIN postrow -->
	<tr> 
	  <td align="left" valign="top" class="{postrow.ROW_CLASS}"><span class="name"><a name="{postrow.U_POST_ID}"></a>{postrow.POSTER_NAME}</span></td>
	  <td width="100%" valign="top" class="{postrow.ROW_CLASS}"> 
		<table width="100%" cellspacing="0" cellpadding="3" border="0">
		  <tr> 
			<td valign="middle"><img src="templates/subSilver/images/icon_minipost.gif" alt="{L_POST}"><span class="postdetails">{L_POSTED}: 
			  {postrow.POST_DATE}&nbsp;&nbsp;&nbsp;&nbsp;{L_POST_SUBJECT}: {postrow.POST_SUBJECT}</span></td>
		  </tr>
		  <tr> 
			<td valign="top"> 
			  <hr size="1" />
			  <span class="postbody">{postrow.MESSAGE}</span></td> 
		  </tr>
		</table>
	  </td>
	  <td width="5%" align="center" class="{postrow.ROW_CLASS}">{postrow.S_DELETE_POST_CHECKBOX}</td>
	</tr>
	<tr> 
	  <td colspan="3" height="1" class="row3"><img src="templates/subSilver/images/spacer.gif" width="1" height="1" alt="."></td>
	</tr>
	<!-- END postrow -->
	<tr> 
	  <td class="catBottom" colspan="3" height="28" align="center"> 
		  <input class="liteoption" type="submit" name="delete_posts" value="{L_DELETE_POSTS}" />
		  {S_HIDDEN_FIELDS}
	  </td>
	</tr>
  </table>
  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
	  <td align="right" valign="top"><span class="gensmall">{S_TIMEZONE}</span></td>
	</tr>
  </table>
</form>
