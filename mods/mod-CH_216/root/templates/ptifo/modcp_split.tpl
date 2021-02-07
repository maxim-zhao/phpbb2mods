
<table border="0" cellpadding="4" cellspacing="1" width="100%">
<tr>
	<td><span class="maintitle">
		<a href="{U_MOD_CP}" class="maintitle">{L_MOD_CP}</a>
	</span><span class="gensmall"><br />
		{L_SPLIT_TOPIC_EXPLAIN}<br />
	</span></td>
</tr>
</table>
<form method="post" action="{S_SPLIT_ACTION}">
{NAVIGATION_BOX}
  <table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
	<tr> 
	  <th height="25" class="thHead" colspan="3" nowrap="nowrap">{L_SPLIT_TOPIC}</th>
	</tr>
	<tr>
	  <td class="row1" nowrap="nowrap"><span class="gen">{L_SPLIT_SUBJECT}</span></td>
	  <td class="row2" colspan="2"><input class="post" type="text" size="35" style="width: 350px" maxlength="60" name="subject" /></td>
	</tr>
	<tr> 
	  <td class="row1" nowrap="nowrap"><span class="gen">{L_SPLIT_FORUM}</span></td>
	  <td class="row2" colspan="2">{S_FORUM_SELECT}</td>
	</tr>
	<tr> 
	  <td class="catHead" colspan="3" height="28"> 
		<table width="60%" cellspacing="0" cellpadding="0" border="0" align="center">
		  <tr> 
			<td width="50%" align="center"> 
			  <input class="liteoption" type="submit" name="split_type_all" value="{L_SPLIT_POSTS}" />
			</td>
			<td width="50%" align="center"> 
			  <input class="liteoption" type="submit" name="split_type_beyond" value="{L_SPLIT_AFTER}" />
			</td>
		  </tr>
		</table>
	  </td>
	</tr>
	<tr> 
	  <th class="thLeft" nowrap="nowrap">{L_AUTHOR}</th>
	  <th class="thTop">{L_MESSAGE}</th>
	  <th class="thRight" nowrap="nowrap">&nbsp;{L_SELECT}&nbsp;</th>
	</tr>
	<!-- BEGIN postrow -->
	<tr> 
	  <td align="left" valign="top" class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->"><span class="name"><a name="{postrow.U_POST_ID}"></a>{postrow.POSTER_NAME}</span></td>
	  <td width="100%" valign="top" class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->"> 
		<table width="100%" cellspacing="0" cellpadding="3" border="0">
		  <tr> 
			<td valign="middle"><img src="{I_POST}" alt="{L_POST}" /><span class="postdetails">{L_POSTED}: 
			  {postrow.POST_DATE}&nbsp;&nbsp;&nbsp;&nbsp;{L_POST_SUBJECT}: {postrow.POST_SUBJECT}</span></td>
		  </tr>
		  <tr> 
			<td valign="top"> 
			  <hr size="1" />
			  <span class="postbody">{postrow.MESSAGE}</span></td> 
		  </tr>
		</table>
	  </td>
	  <td width="5%" align="center" class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->">{postrow.S_SPLIT_CHECKBOX}</td>
	</tr>
	<tr> 
	  <td colspan="3" height="1" class="row3"><img src="{I_SPACER}" width="1" height="1" alt="." /></td>
	</tr>
	<!-- END postrow -->
	<tr> 
	  <td class="catBottom" colspan="3" height="28"> 
		<table width="60%" cellspacing="0" cellpadding="0" border="0" align="center">
		  <tr> 
			<td width="50%" align="center"> 
			  <input class="liteoption" type="submit" name="split_type_all" value="{L_SPLIT_POSTS}" />
			</td>
			<td width="50%" align="center"> 
			  <input class="liteoption" type="submit" name="split_type_beyond" value="{L_SPLIT_AFTER}" />
			  {S_HIDDEN_FIELDS} </td>
		  </tr>
		</table>
	  </td>
	</tr>
  </table></form>

<br clear="all" />