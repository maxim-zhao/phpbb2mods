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

<form method="post" action="{S_ACTION}" name="post" {S_FORM_HTML}>
{NAVIGATION_BOX}
<table cellspacing="1" cellpadding="4" border="0" width="100%" align="center" class="forumline">
<!-- BEGIN free_size --><!-- BEGINELSE free_size -->
<colgroup>
	<col width="40%">
	<col width="60%">
</colgroup>
<!-- END free_size -->
<tr>
	<th class="thHead" align="center" colspan="2">{L_FORM}</th>
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
	<td class="catBottom" align="center" colspan="2"><span class="gensmall">{S_HIDDEN_FIELDS}&nbsp;
		<!-- BEGIN buttons --><input type="image" name="{buttons.BUTTON}" src="{buttons.I_BUTTON}" alt="{buttons.L_BUTTON}" title="{buttons.L_BUTTON}" <!-- BEGIN accesskey -->accesskey="{buttons.S_BUTTON}"<!-- END accesskey --> />&nbsp;<!-- END buttons -->
	</span></td>
</tr>
</table>
</form>

<br clear="all" />
