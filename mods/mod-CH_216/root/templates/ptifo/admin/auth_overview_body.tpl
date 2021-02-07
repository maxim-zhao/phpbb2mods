<script language="JavaScript" type="text/javascript">
<!--
	function branch_set(from_id, to_id)
	{
		from_found = false;
		preset_index = -1;
		for ( i = 0; i < document.post.elements.length; i++ )
		{
			if ( !from_found )
			{
				if ( document.post.elements[i].name == 'preset_ids[' + from_id + ']' )
				{
					from_found = true;
					preset_index = document.post.elements[i].options.selectedIndex;
					if ( preset_index == 0)
					{
						break;
					}
				}
			}
			if ( from_found )
			{
				preset_name = (document.post.elements[i].name).substring(0, 11);
				if ( preset_name == 'preset_ids[' )
				{
					document.post.elements[i].options.selectedIndex = preset_index;
					if ( document.post.elements[i].name == 'preset_ids[' + to_id + ']' )
					{
						break;
					}
				}
			}
		}
	}
//-->
</script>

<!-- BEGIN in_admin -->
<h1>{L_TITLE}</h1>

<p>{L_TITLE_EXPLAIN}</p>
<!-- END in_admin -->

<form action="{S_ACTION}" method="post" name="post">

<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
<tr>
	<th class="thHead" colspan="2">{L_ITEM_TITLE}</th>
</tr>
<tr>
	<td class="row1" nowrap="nowrap"><span class="gen">
		{L_ITEM_NAME}:&nbsp;
	</span></td>
	<td class="row2" width="100%"><span class="gen">
		{ITEM_NAME}
	<!-- BEGIN user_ELSE -->
	</span><span class="gensmall"><br />
		{ITEM_DESC}
	<!-- END user_ELSE -->
	</span></td>
</tr>
<!-- BEGIN items -->
<tr>
	<td class="row1" nowrap="nowrap"><span class="gen">
		{L_ITEM_LIST}:&nbsp;
	</span><hr /><span class="gensmall">
		{L_ITEM_LIST_EXPLAIN}
	</span></td>
	<td class="row2" width="100%"><span class="genmed">
		<!-- BEGIN row --><a href="{items.row.U_ITEM}" class="genmed">{items.row.NAME}</a><!-- BEGIN sep -->, <!-- END sep --><!-- END row -->
	</span></td>
</tr>
<!-- END items -->
<tr>
	<td class="catBottom" colspan="2" align="center" valign="middle"><span class="gensmall">&nbsp;
		<!-- BEGIN buttons --><input type="image" name="{buttons.BUTTON}" src="{buttons.I_BUTTON}" alt="{buttons.L_BUTTON}" title="{buttons.L_BUTTON}" <!-- BEGIN accesskey -->accesskey="{buttons.S_BUTTON}"<!-- END accesskey --> />&nbsp;<!-- END buttons -->
	</span></td>
</tr>
</table>
<br class="nav" />

<!-- BEGIN warning -->
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
<tr>
	<th class="thHead">{warning.WARNING_TITLE}</th>
</tr>
<tr>
	<td class="row1" align="center"><span class="gen"><br />{warning.WARNING_MSG}<br /><br /></span></td>
</tr>
</table>
<br class="nav" />
<!-- END warning -->

<table width="100%" cellpadding="0" cellspacing="1" border="0" class="forumline">
<tr>
	<th class="thCornerL" height="25" nowrap="nowrap" width="100%">&nbsp;{L_OBJECT}&nbsp;</th>
	<th class="thCornerR" nowrap="nowrap">&nbsp;{L_AUTHS}&nbsp;</th>
</tr>
<tr>
	<td><table cellpadding="0" cellspacing="0" border="0" width="100%">
	<!-- BEGIN row -->
	<tr>
		<td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" height="25">
			<table cellpadding="0" cellspacing="0" width="100%"><tr>
			<td><img src="{I_SPACER}" border="0" width="4" alt="" /></td>
			<!-- BEGIN inc -->
			<td><img src="{row.inc.I_INC}" border="0" alt="" /></td>
			<!-- END inc -->
			<td width="100%" nowrap="nowrap"><span class="forumlink">&nbsp;
				<!-- BEGIN command --><a href="{row.U_SWAP}" class="forumlink" title="{row.DESC}"><!-- END command -->{row.NAME}<!-- BEGIN command --></a><!-- END command -->&nbsp;
				<!-- BEGIN folder_icon -->[<img src="{row.I_FOLDER}" title="{row.L_FOLDER}" alt="" border="0" />]&nbsp;<!-- END folder_icon -->
			</span></td>
			</tr></table>
		</td>
	</tr>
	<!-- END row -->
	</table></td>

	<td width="200"><table cellpadding="0" cellspacing="0" border="0" width="100%">
	<!-- BEGIN row -->
	<tr>
		<td nowrap="nowrap" class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" height="25">
			<span class="gensmall">&nbsp;
				<!-- BEGIN command -->
				<a href="#" onclick="branch_set({row.OBJECT_ID}, {row.LAST_CHILD_ID}); return false;"><img src="{I_COPY}" border="0" align="top" alt="{L_COPY}" title="{L_COPY}" /></a>
				<select name="preset_ids[{row.OBJECT_ID}]">{row.S_PRESETS}</select>
				<a href="{row.U_EDIT}" class="gensmall"><img src="{I_EDIT}" border="0" align="top" alt="{L_EDIT}" title="{L_EDIT}" /></a>&nbsp;
				<!-- END command -->
		</span></td>
	</tr>
	<!-- END row -->
	</table></td>
</tr>
<tr>
	<td class="catBottom" colspan="2" align="center" valign="middle">{S_HIDDEN_FIELDS}<span class="gensmall">&nbsp;
		<!-- BEGIN buttons --><input type="image" name="{buttons.BUTTON}" src="{buttons.I_BUTTON}" alt="{buttons.L_BUTTON}" title="{buttons.L_BUTTON}" <!-- BEGIN accesskey -->accesskey="{buttons.S_BUTTON}"<!-- END accesskey --> />&nbsp;<!-- END buttons -->
	</span></td>
</tr>
</table>

</form>
<br clear="all" />
