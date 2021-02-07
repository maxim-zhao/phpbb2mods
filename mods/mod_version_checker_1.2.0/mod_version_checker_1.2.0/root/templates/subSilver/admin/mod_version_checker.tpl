<!-- $Id: mod_version_checker.tpl,v 1.2.0.0 2006/07/22 19:32:23 chatasos Exp $ -->

<style type="text/css">
<!--

.mvc_error { color: red; font-weight: bold; }

/* You can change the values here if you don't like the colors*/

span.mvc_older { color: red; }
span.mvc_equal { color: green; }
span.mvc_newer { color: orange; }
span.mvc_other { color: purple; }
span.mvc_null  { color: black; }

div.mvc_older { width: 10px; height: 10px; background: red; }
div.mvc_equal { width: 10px; height: 10px; background: green; }
div.mvc_newer { width: 10px; height: 10px; background: orange; }
div.mvc_other { width: 10px; height: 10px; background: purple; }
div.mvc_null  { width: 10px; height: 10px; background: black; }

-->
</style>

<script language="JavaScript" type="text/javascript">
<!--

// check/uncheck all checkboxes
function check_all(myCheckbox, myForm, myName)
{
	// get the form id
	var formName = document.getElementById(myForm);

	// get a list of the input tags
	var formInputs = formName.getElementsByTagName('input');

	for (i = 0; i < formInputs.length; i++)
	{
		// check if we found our name between the checkboxes
		if ( formInputs[i].type == 'checkbox' && formInputs[i].getAttribute('name') == myName )
		{
			formInputs[i].checked = myCheckbox.checked;
		}
	}
}

//-->
</script>

<h1>{L_MOD_VERSION_CHECKER}</h1>

<p>{L_MOD_EXPLAIN}</p>

<!-- BEGIN mod -->
<form id="mod" name="mod" method="post" action="{S_MOD_ACTION}" >

<div align="center"><h3>{L_MODS}</h3></div>

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thCornerL" align="center">#</th>
		<th class="thTop" align="center">{L_MODIFICATION}</th>
		<th class="thTop" align="center" nowrap="nowrap">{L_CURRENT_VERSION}</th>
		<th class="thTop" align="center">{L_ACTION}</th>
		<th class="thTop" align="center" nowrap="nowrap">{L_MODDB_VERSION}</th>
		<th class="thTop" align="center">{L_MOD_DOWNLOAD_LINK}</th>
		<th class="thCornerR" align="center">{L_CHECK}</th>
	</tr>
	<!-- BEGIN details -->
	<tr>
		<td class="{mod.details.ROW_CLASS}" align="left" nowrap="nowrap">
			{mod.details.AA}
		</td>
		<td class="{mod.details.ROW_CLASS}">
			<span class="gen">{mod.details.NAME}</span><br />
			<span class="gensmall"><b>{L_MOD_AUTHOR}:</b> {mod.details.AUTHOR}</span>
		</td>
		<td class="{mod.details.ROW_CLASS}" align="center" nowrap="nowrap">
			<span class="gen"><b>{mod.details.VERSION}</b></span><br />
			<span class="copyright">{mod.details.DATE}</span>
		</td>
		<td class="{mod.details.ROW_CLASS}" align="center">
			<!-- BEGIN before_check -->
			<a href="{mod.details.before_check.U_EDIT}">{L_EDIT}</a><br />
			<a href="{mod.details.before_check.U_DELETE}">{L_DELETE}</a><br />
			<a href="{mod.details.before_check.U_UPDATE}">{mod.details.before_check.L_UPDATE}</a>
			<!-- END before_check -->
		</td>
		<td class="{mod.details.ROW_CLASS}" align="center" nowrap="nowrap">
			<span class="gen"><b>{mod.details.LATEST_VERSION}</b></span><br />
			<span class="copyright">{mod.details.LATEST_CHECK}</span>
		</td>
		<td class="{mod.details.ROW_CLASS}" align="center" width="200">
			{mod.details.DOWNLOAD_LINK}
		</td>
		<td class="{mod.details.ROW_CLASS}" align="center">
			<input type="checkbox" name="mods_check[]" value="{mod.details.ID}" {mod.details.CHECKED} />
		</td>
	</tr>
	<!-- END details -->
	<tr>
		<td class="row3" colspan="6" align="center">
			{L_MESSAGE}
		</td>
		<td class="row3" align="center">
	<!-- BEGIN before_check -->
			<input type="checkbox" name="global_check" {mod.before_check.S_CHECKED} {mod.before_check.S_DISABLED} onClick="check_all(this, 'mod', 'mods_check[]')" />
			<br />
			<span class="copyright">{L_SELECT_ALL}</span>
	<!-- END before_check -->
		</td>
	</tr>
	<tr>
		<td class="row3" colspan="7" align="center">
			<table cellspacing="1" cellpadding="3" border="0" align="center">
				<!-- BEGIN legend -->
				<td class="row3" align="center" width="14">
					<div class="{mod.legend.CLASS}"></div>
				</td>
				<td class="row3" align="left" nowrap="nowrap">
					{mod.legend.TEXT}
				</td>
				<!-- END legend -->
			</table>
		</td>
	</tr>
	<!-- BEGIN before_check -->
	<tr>
		<td class="catBottom" colspan="4" align="center">
			{S_HIDDEN_FIELDS}
			<input type="submit" name="add_mod" value="{L_ADD_MOD}" class="liteoption" />&nbsp;&nbsp;&nbsp;
			<!-- BEGIN easymod -->
			<input type="submit" name="add_easymod_mod" value="{L_ADD_EASYMOD}" class="liteoption" />
			<!-- END easymod -->
		</td>
		<td class="catBottom" colspan="3" align="center">
			<input type="submit" name="check_updates" value="{L_CHECK_UPDATES}" class="mainoption" {mod.before_check.S_DISABLED} />&nbsp;&nbsp;&nbsp;
			<input type="submit" name="reset_updates" value="{L_RESET_UPDATES}" class="liteoption" {mod.before_check.S_DISABLED} />
		</td>
	</tr>
	<!-- END before_check -->
	<!-- BEGIN after_check -->
	<tr>
		<td class="catBottom" colspan="7" align="center">
			<input type="submit" name="return" value="{L_RETURN}" class="mainoption" />
		</td>
	</tr>
	<!-- END after_check -->
</table>

</form>
<!-- END mod -->

<!-- BEGIN edit_mod -->
<form method="post" action="{S_MOD_ACTION}" enctype="multipart/form-data">

<table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center">
	<tr>
		<th class="thHead" colspan="2">{L_EDIT_MOD}</th>
	</tr>
	<tr>
		<td class="row2">{L_MOD_NAME}</td>
		<td class="row2"><input class="post" type="text" name="mod_name" value="{edit_mod.NAME}" size="60" /></td>
	</tr>
	<tr>
		<td class="row1">{L_MOD_AUTHOR}</td>
		<td class="row1"><input class="post" type="text" name="mod_author" value="{edit_mod.AUTHOR}" size="30" /></td>
	</tr>
	<tr>
		<td class="row2">{L_MOD_VERSION}</td>
		<td class="row2"><input class="post" type="text" name="mod_version" value="{edit_mod.VERSION}" size="10" /></td>
	</tr>
	<tr>
		<td class="row1">{L_PARSE_MOD_FILE}</td>
		<td class="row1">
			<input type="file" name="mod_filename" size="40"/>&nbsp;&nbsp;
			<input class="liteoption" type="submit" name="upload_mod" value="{L_PARSE}" />
		</td>
	</tr>
	<tr>
		<td class="row2">{L_MOD_CATEGORY}</td>
		<td class="row2">{edit_mod.CAT}</td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">
			{S_HIDDEN_FIELDS}
			<input class="mainoption" type="submit" name="submit_mod" value="{L_SUBMIT}" />
			&nbsp;&nbsp;&nbsp;
			<input class="liteoption" type="submit" name="cancel_mod" value="{L_CANCEL}" />
		</td>
	</tr>
</table>

</form>
<!-- END edit_mod -->

<!-- BEGIN easymods -->
<form id="easymods" name="easymods" method="post" action="{S_MOD_ACTION}">

<div align="center"><h3>{L_MODS}</h3></div>

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thCornerL" align="center">#</th>
		<th class="thTop" align="center">{L_MODIFICATION}</th>
		<th class="thTop" align="center">{L_EASYMOD_VERSION}</th>
		<th class="thTop" align="center">{L_CURRENT_VERSION}</th>
		<th class="thCornerR" align="center">{L_CHECK}</th>
	</tr>
	<!-- BEGIN details -->
	<tr>
		<td class="{easymods.details.ROW_CLASS}" align="right">
			{easymods.details.AA}
		</td>
		<td class="{easymods.details.ROW_CLASS}" width="300">
			<span class="gen">{easymods.details.EASY_NAME}</span><br />
			<span class="gensmall"><b>{L_MOD_AUTHOR}:</b> {easymods.details.EASY_AUTHOR}</span>
		</td>
		<td class="{easymods.details.ROW_CLASS}" align="center" nowrap="nowrap">
			<span class="gen"><b>{easymods.details.EASY_VERSION}</b></span><br />
			<span class="copyright">{easymods.details.EASY_DATE}</span>
		</td>
		<td class="{easymods.details.ROW_CLASS}" align="center" nowrap="nowrap">
			<span class="gen"><b>{easymods.details.VERSION}</b></span><br />
			<span class="copyright">{easymods.details.DATE}</span>
		</td>
		<td class="{easymods.details.ROW_CLASS}" align="left">
			<!-- BEGIN action -->
			<input type="checkbox" name="easymods_{easymods.details.action.ACTION}[]" value="{easymods.details.action.EASY_ID}" {easymods.details.action.CHECKED} />
			&nbsp;{easymods.details.action.L_ACTION}
			<!-- END action -->
		</td>
	</tr>
	<!-- END details -->
	<tr>
		<td class="row3" colspan="4" align="center">
			{L_MESSAGE}
		</td>
		<td class="row3" align="center">
			<!-- BEGIN global_check -->
			<input type="checkbox" name="global_check" onClick="check_all(this, 'easymods', 'easymods_update[]'); check_all(this, 'easymods', 'easymods_insert[]')" />
			<br />
			<span class="copyright">{L_SELECT_ALL}</span>
			<!-- END global_check -->
		</td>
	</tr>
	<tr>
		<td class="catBottom" colspan="5" align="center">
			<input class="mainoption" type="submit" name="easymods_submit" value="{L_SUBMIT}" />
			&nbsp;&nbsp;&nbsp;
			<input class="liteoption" type="submit" name="cancel" value="{L_CANCEL}" />
		</td>
	</tr>
</table>

</form>
<!-- END easymods -->

<div align="center"><span class="copyright">{L_MOD_VERSION_CHECKER} {MOD_VERSION_CHECKER_VERSION}</span></div>

<br clear="all" />

