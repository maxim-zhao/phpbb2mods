<!-- BEGIN in_admin -->
<h1>{L_TITLE}</h1>

<p>{L_TITLE_EXPLAIN}</p>
<!-- END in_admin -->

<form action="{S_ACTION}" method="post" name="post"><table width="100%" cellpadding="0" cellspacing="1" border="0" class="forumline">
<tr>
	<th class="thCornerL" height="25" nowrap="nowrap" width="100%">&nbsp;{L_PANELS}&nbsp;</th>
	<th class="thTop" nowrap="nowrap" width="100">&nbsp;{L_INFO}&nbsp;</th>
	<th class="thCornerR" nowrap="nowrap" width="140">&nbsp;{L_ACTION}&nbsp;</th>
</tr>
<tr>
	<td><table cellpadding="0" cellspacing="0" border="0" width="100%">
	<!-- BEGIN row -->
	<tr>
		<td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" height="25">
			<table cellpadding="0" cellspacing="0" width="100%"><tr>
			<td><img src="{I_SPACER}" border="0" width="4" alt="" /></td>
			<!-- BEGIN inc --><td><img src="{row.inc.I_INC}" border="0" alt="" /></td><!-- END inc -->
			<td width="100%" nowrap="nowrap"><span class="forumlink">
				<!-- BEGIN preview -->&nbsp;<a href="{row.U_PREVIEW}" class="forumlink" title="{PREVIEW}"><img src="{I_PREVIEW}" border="0" alt="{L_PREVIEW}" class="absbottom" /></a><!-- END preview -->
				&nbsp;<!-- BEGIN root_ELSE --><a href="{row.U_EDIT}" class="forumlink" title="{row.PANEL_SHORTCUT}"><!-- END root_ELSE -->{row.PANEL_NAME}<!-- BEGIN root_ELSE --></a><!-- END root_ELSE -->
			</span></td>
			</tr></table>
		</td>
	</tr>
	<!-- END row -->
	</table></td>

	<td><table cellpadding="0" cellspacing="0" border="0" width="100%">
	<!-- BEGIN row -->
	<tr>
		<td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" height="25" nowrap="nowrap">
			<table cellpadding="2" cellspacing="2" border="0" width="100%" align="center"><tr>
				<td width="20%" align="center">
					<!-- BEGIN hidden --><img src="{I_HIDDEN}" border="0" class="absbottom" alt="{L_HIDDEN}" title="{L_HIDDEN}" /><!-- END hidden -->
				</td>
				<td width="20%" align="center">
					<!-- BEGIN auth_group --><img src="{I_GROUP}" border="0" class="absbottom" alt="{L_GROUP}" title="{row.PANEL_AUTH}" /><!-- END auth_group -->
					<!-- BEGIN auth_other --><img src="{I_OTHER}" border="0" class="absbottom" alt="{L_OTHER}" title="{row.PANEL_AUTH}" /><!-- END auth_other -->
				</td>
				<td width="20%" align="center">
					<!-- BEGIN script --><img src="{I_SCRIPT}" border="0" class="absbottom" alt="{L_SCRIPT}" title="{row.PANEL_FILE}" /><!-- END script -->
				</td>
				<td width="20%" align="center">
					<!-- BEGIN form --><a href="{row.U_FORM_MNG}" title="{L_FORM_MNG}"><img src="{I_FORM}" border="0" class="absbottom" alt="{L_FORM}" /></a><!-- END form -->
				</td>
			</tr></table>
		</td>
	</tr>
	<!-- END row -->
	</table></td>

	<td><table cellpadding="0" cellspacing="0" border="0" width="100%">
	<!-- BEGIN row -->
	<tr>
		<td align="center" class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" height="25" nowrap="nowrap"><span class="gensmall">&nbsp;
			<!-- BEGIN button --><a href="{row.button.U_BUTTON}" title="{row.button.L_BUTTON}"><img src="{row.button.I_BUTTON}" border="0" alt="{row.button.L_BUTTON}" /></a>&nbsp;<!-- END button -->
		</span></td>
	</tr>
	<!-- END row -->
	</table></td>
</tr>
<tr>
	<td class="catBottom" colspan="3" align="center" valign="middle">{S_HIDDEN_FIELDS}<span class="gensmall">
		<!-- BEGIN buttons --><a href="{buttons.U_BUTTON}" title="{buttons.L_BUTTON}" accesskey="{buttons.S_BUTTON}"><img src="{buttons.I_BUTTON}" border="0" alt="{buttons.L_BUTTON}" /></a>&nbsp;<!-- END buttons -->
	</span></td>
</tr>
</table></form>

<br clear="all" />
