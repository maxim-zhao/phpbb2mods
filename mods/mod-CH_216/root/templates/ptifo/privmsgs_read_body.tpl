
<table cellspacing="2" cellpadding="2" border="0" align="center">
  <tr> 
	<td valign="middle">{INBOX_IMG}</td>
	<td valign="middle"><span class="cattitle">{INBOX} &nbsp;</span></td>
	<td valign="middle">{SENTBOX_IMG}</td>
	<td valign="middle"><span class="cattitle">{SENTBOX} &nbsp;</span></td>
	<td valign="middle">{OUTBOX_IMG}</td>
	<td valign="middle"><span class="cattitle">{OUTBOX} &nbsp;</span></td>
	<td valign="middle">{SAVEBOX_IMG}</td>
	<td valign="middle"><span class="cattitle">{SAVEBOX}</span></td>
  </tr>
</table>

<br clear="all" />

<form method="post" action="{S_PRIVMSGS_ACTION}">
{NAVIGATION_BOX}
<table width="100%" cellspacing="2" cellpadding="2" border="0">
  <tr>
	  <td valign="middle">{REPLY_PM_IMG}</td>
  </tr>
</table>

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr> 
	  <th colspan="3" class="thHead" nowrap="nowrap">{BOX_NAME} :: {L_MESSAGE}</th>
	</tr>
	<tr> 
	  <td class="row2"><span class="genmed">{L_FROM}:</span></td>
	  <td width="100%" class="row2" colspan="2"><span class="genmed">{MESSAGE_FROM}</span></td>
	</tr>
	<tr> 
	  <td class="row2"><span class="genmed">{L_TO}:</span></td>
	  <td width="100%" class="row2" colspan="2"><span class="genmed">{MESSAGE_TO}</span></td>
	</tr>
	<tr> 
	  <td class="row2"><span class="genmed">{L_POSTED}:</span></td>
	  <td width="100%" class="row2" colspan="2"><span class="genmed">{POST_DATE}</span></td>
	</tr>
	<tr> 
	  <td class="row2"><span class="genmed">{L_SUBJECT}:</span></td>
	  <td width="100%" class="row2"><span class="genmed">{POST_SUBJECT}</span></td>
	  <td nowrap="nowrap" class="row2" align="right"> {QUOTE_PM_IMG} {EDIT_PM_IMG}</td>
	</tr>
	<tr> 
		<td valign="top" colspan="3" class="row1">
			<span class="postbody">{MESSAGE}</span>
			{ATTACHMENTS}
			<span class="postbody"><br /><!-- BEGIN signature -->_________________<br />{SIGNATURE}<br /><!-- END signature --></span>
		</td>
	</tr>
<tr>
	<td style="padding: 0px" colspan="3"><table style="width: 100%; border: 0px" cellspacing="0">
	<tr>
		<td style="padding: 0px; width: 1px"><img src="{I_SPACER}" alt="" width="1" border="0" /></td>
		<td class="catlight" style="padding-top: 4px; vertical-align: middle; white-space: nowrap">
			<div style="float: left; text-align: left">
				<!-- BEGIN profile -->&nbsp;<a href="{U_PROFILE}"><img src="{I_POSTER_PROFILE}" alt="{L_POSTER_PROFILE}" title="{L_POSTER_PROFILE}" border="0" /></a><!-- END profile -->
				<!-- BEGIN pm -->&nbsp;<a href="{U_PM}"><img src="{I_POSTER_PM}" alt="{L_POSTER_PM}" title="{L_POSTER_PM}" border="0" /></a><!-- END pm -->
				<!-- BEGIN email -->&nbsp;<a href="{U_EMAIL}"><img src="{I_POSTER_EMAIL}" alt="{L_POSTER_EMAIL}" title="{L_POSTER_EMAIL}" border="0" /></a><!-- END email -->
				<!-- BEGIN www -->&nbsp;<a href="{U_WWW}" target="userwww"><img src="{I_POSTER_WWW}" alt="{L_POSTER_WWW}" title="{L_POSTER_WWW}" border="0" /></a><!-- END www -->
				<!-- BEGIN aim -->&nbsp;<a href="{U_AIM}"><img src="{I_POSTER_AIM}" alt="{L_POSTER_AIM}" title="{L_POSTER_AIM}" border="0" /></a><!-- END aim -->
				<!-- BEGIN yim -->&nbsp;<a href="{U_YIM}"><img src="{I_POSTER_YIM}" alt="{L_POSTER_YIM}" title="{L_POSTER_YIM}" border="0" /></a><!-- END yim -->
				<!-- BEGIN msn -->&nbsp;<a href="{U_MSN}"><img src="{I_POSTER_MSN}" alt="{L_POSTER_MSN}" title="{L_POSTER_MSN}" border="0" /></a><!-- END msn -->
			</div>
			<!-- BEGIN icq -->
			<div style="float: left; text-align: left; position: relative">&nbsp;<a href="{U_ICQ}"><img src="{I_POSTER_ICQ}" alt="{L_POSTER_ICQ}" title="{L_POSTER_ICQ}" border="0" /></a>&nbsp;<div id="icq_status_user" style="position: absolute; left: 7px; top: -1px; display: none"><a href="{U_ICQ_STATUS}" title=""><img src="{I_ICQ_STATUS}" width="18" height="18" alt="" border="0" /></a></div></div>
			<!-- END icq -->
		</td>
		<td style="padding: 0px; width: 1px"><img src="{I_SPACER}" alt="" width="1" border="0" /></td>
	</tr>
	</table></td>
</tr>
	<tr>
	  <td class="catBottom" colspan="3" height="28" align="right"> {S_HIDDEN_FIELDS} 
		<input type="submit" name="save" value="{L_SAVE_MSG}" class="liteoption" />
		&nbsp; 
		<input type="submit" name="delete" value="{L_DELETE_MSG}" class="liteoption" />
		<!-- BEGIN switch_attachments -->
		&nbsp;<input type="submit" name="pm_delete_attach" value="{L_DELETE_ATTACHMENTS}" class="liteoption" />
		<!-- END switch_attachments -->
	  </td>
	</tr>
  </table>
  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
	  <td>{REPLY_PM_IMG}</td>
	</tr>
  </table>
</form>

<br clear="all" />

<script language="JavaScript" type="text/javascript"><!--//
function _icq()
{
	this.ids = new Array();
	return this;
}
	_icq.prototype.objref = function(id)
	{
		return document.getElementById ? document.getElementById(id) : (document.all ? document.all[id] : (document.layers ? document.layers[id] : null));
	}
	_icq.prototype.display_status = function()
	{
		if ( (navigator.userAgent.toLowerCase().indexOf('mozilla') == -1) || (navigator.userAgent.indexOf('5.') != -1) || (navigator.userAgent.indexOf('6.') != -1) )
		{
			for ( i = 1; i < this.ids.length; i++ )
			{
				icq_status = this.objref(this.ids[i]);
				if ( icq_status && icq_status.style )
				{
					icq_status.style.display = '';
				}
			}
		}
	}

icq_status = new _icq();
icq_status.ids = Array('', 'icq_status_user');
icq_status.display_status();
//--></script>