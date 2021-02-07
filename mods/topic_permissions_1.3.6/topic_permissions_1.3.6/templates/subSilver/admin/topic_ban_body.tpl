
<h1>{L_CONFIGURATION_TITLE}</h1>

<p>{L_CONFIGURATION_EXPLAIN}</p>

<form action="{S_CONFIG_ACTION}" method="post"><table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	  <th class="thHead" colspan="2">{L_BAN_CONFIG}</th>
	</tr>
	<tr><td class="row1"><table width="100%" cellpadding="4" cellspacing="1" border="0" align="center">
	  <!-- BEGIN arebans -->
	  <tr> 
	    <th nowrap="nowrap">&nbsp;{L_TOPICS}&nbsp;</th>
	    <th width="17%" nowrap="nowrap">&nbsp;{L_BANER}&nbsp;</th>
	    <th width="17%" nowrap="nowrap">&nbsp;{L_BANNED}&nbsp;</th>
	    <th width="17%" nowrap="nowrap">&nbsp;{L_DESC}&nbsp;</th>
	    <th width="5%" class="thRight" nowrap="nowrap">&nbsp;{L_DELETE}&nbsp;</th>
	  </tr>
	  <!-- END arebans -->
	  <!-- BEGIN nobans -->
	  <tr><td class="row1" align="center"><span class="gen">{L_NOBANS}</span></td></tr>
	  <!-- END nobans -->
	  <!-- BEGIN banrow -->
	  <tr>
	    <td class="row1" align="left">&nbsp;<span class="topictitle"><a href="{banrow.U_VIEW_TOPIC}" class="topictitle" align="center">{banrow.TOPIC_TITLE}</a></span></td>
	    <td class="row2" align="center">&nbsp;<span class="topictitle"><a href="{banrow.U_BANER}" class="topictitle">{banrow.BANER}</a></span></td>
	    <td class="row2" align="center">&nbsp;<span class="topictitle"><a href="{banrow.U_BANNED}" class="topictitle">{banrow.BANNED}</a></span></td>
	    <td class="row2" align="center"><textarea name="desc_list[]" cols="20" rows="4" >{banrow.DESC}</textarea></td>
	    <td class="row3" align="center"><input type="checkbox" name="del_list[]" value="{banrow.ID}"/></td>
	    <td><input type="hidden" name="id_list[]" value="{banrow.ID}"><input type="hidden" name="num_list[]" value="{banrow.NUM}"></td>
	  </tr>
	  <!-- END banrow -->
	</table></td></tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table></form>

<br clear="all" />
