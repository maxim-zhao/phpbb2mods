<!-- BEGIN in_admin -->
<h1>{L_TITLE}</h1>

<p>{L_TITLE_EXPLAIN}</p>
<!-- END in_admin -->

<!-- BEGIN javascript -->
<script language="JavaScript" type="text/javascript" src="{javascript.U_JAVASCRIPT}"></script>
<!-- END javascript -->

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

<!-- BEGIN main_include -->
{main_include.TPL}
<!-- END main_include -->

<form action="{S_ACTION}" method="post" name="post" {S_FORM_HTML}>
{NAVIGATION_BOX}
<table cellpadding="0" cellspacing="2" border="0" width="100%">
<tr>
	<td width="200" valign="top"><!-- BEGIN cp_menus -->{cp_menus.BOX}<br style="font-size: 2px" /><!-- END cp_menus--></td>
	<td valign="top"><!-- BEGIN cp_content -->{cp_content.BOX}<br style="font-size: 2px" /><!-- END cp_content --><!-- BEGINGLOBAL form --><table cellpadding="4" cellspacing="1" border="0" width="100%" class="forumline">
	<!-- BEGIN free_size --><!-- BEGINELSE free_size -->
	<colgroup>
		<col width="40%">
		<col width="60%">
	</colgroup>
	<!-- END free_size -->
	<tr>
		<th class="thHead" colspan="2">{L_FORM}</th>
	</tr>
	{FORM}
	<!-- BEGIN empty -->
	<tr>
		<td class="row1" colspan="2" height="30" align="center"><span class="gen">
			{L_EMPTY}
		</span></td>
	</tr>
	<!-- END empty -->
	<tr>
		<td class="catBottom" colspan="2" align="center"><span class="gensmall">&nbsp;
			<!-- BEGIN buttons --><input type="image" src="{buttons.I_BUTTON}" name="{buttons.BUTTON}" title="{buttons.L_BUTTON}" <!-- BEGIN accesskey -->accesskey="{buttons.S_BUTTON}"<!-- END accesskey --> />&nbsp;<!-- END buttons -->
		</span></td>
	</tr>
	</table><!-- ENDGLOBAL form --></td>
</tr>
</table>{S_HIDDEN_FIELDS}</form>

<br clear="all" />
