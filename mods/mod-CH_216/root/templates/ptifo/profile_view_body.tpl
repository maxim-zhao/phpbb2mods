
{NAVIGATION_BOX}

<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0" align="center">
<colgroup>
	<col width="40%">
	<col width="60%">
</colgroup>
<tr>
	<th class="thHead" colspan="2" height="25" nowrap="nowrap">{L_VIEWING_PROFILE}</th>
</tr>
<tr>
	<td class="catLeft" height="28" align="center"><b><span class="gen">{L_AVATAR}</span></b></td>
	<td class="catRight"><b><span class="gen">{L_ABOUT_USER}</span></b></td>
</tr>
<tr>
	<td class="row1" height="6" align="center">{AVATAR_IMG}<br /><span class="postdetails">{POSTER_RANK}</span><!-- BEGIN rank --><!-- BEGIN img --><br />{RANK_IMAGE}<!-- END img --><!-- END rank --></td>
	<td class="row1" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3">
	<tr>
		<td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_JOINED}:&nbsp;</span></td>
		<td width="100%"><!-- BEGIN poster_joined --><b><span class="gen">{JOINED}</span></b><!-- BEGINELSE poster_joined -->&nbsp;<!-- END poster_joined --></td>
	</tr>
	<tr>
		<td valign="top" align="right" nowrap="nowrap"><span class="gen">{L_TOTAL_POSTS}:&nbsp;</span></td>
		<td valign="top"><!-- BEGIN poster_posts --><b><span class="gen">{POSTS}</span></b><br /><span class="genmed">[{POST_PERCENT_STATS} / {POST_DAY_STATS}]</span> <br /><span class="genmed"><a href="{U_SEARCH_USER}" class="genmed">{L_SEARCH_USER_POSTS}</a></span><!-- BEGINELSE poster_posts -->&nbsp;<!-- END poster_posts --></td>
	</tr>
	<tr>
		<td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_LOCATION}:&nbsp;</span></td>
		<td><!-- BEGIN poster_from --><b><span class="gen">{LOCATION}</span></b><!-- BEGINELSE poster_from -->&nbsp;<!-- END poster_from --></td>
	</tr>
	<tr>
		<td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_WEBSITE}:&nbsp;</span></td>
		<td><!-- BEGIN www --><span class="gen"><b>{WWW}</b></span><!-- BEGINELSE www -->&nbsp;<!-- END www --></td>
	</tr>
	<tr>
		<td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_OCCUPATION}:&nbsp;</span></td>
		<td><!-- BEGIN poster_occ --><b><span class="gen">{OCCUPATION}</span></b><!-- BEGINELSE poster_occ -->&nbsp;<!-- END poster_occ --></td>
	</tr>
	<tr>
		<td valign="top" align="right" nowrap="nowrap"><span class="gen">{L_INTERESTS}:</span></td>
		<td><!-- BEGIN poster_interests --><b><span class="gen">{INTERESTS}</span></b><!-- BEGINELSE poster_interests -->&nbsp;<!-- END poster_interests --></td>
	</tr>
	</table></td>
</tr>
<tr>
	<td class="catLeft" align="center" height="28"><b><span class="gen">{L_CONTACT} {USERNAME} </span></b></td>
	<td class="catRight"><b><span class="gen">{L_POSTER_SIGNATURE}</span></b></td>
</tr>
<tr>
	<td class="row1" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3">
	<tr>
		<td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_EMAIL_ADDRESS}:</span></td>
		<td class="row1" valign="middle" width="100%"><!-- BEGIN email --><b><span class="gen">{EMAIL_IMG}</span></b><!-- BEGINELSE email -->&nbsp;<!-- END email --></td>
	</tr>
	<tr>
		<td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_PM}:</span></td>
		<td class="row1" valign="middle"><!-- BEGIN pm --><b><span class="gen">{PM_IMG}</span></b><!-- BEGINELSE pm -->&nbsp;<!-- END pm --></td>
	</tr>
	<tr>
		<td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_MESSENGER}:</span></td>
		<td class="row1" valign="middle"><!-- BEGIN msn --><span class="gen">{MSN}</span><!-- BEGINELSE msn -->&nbsp;<!-- END msn --></td>
	</tr>
	<tr>
		<td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_YAHOO}:</span></td>
		<td class="row1" valign="middle"><!-- BEGIN yim --><span class="gen">{YIM_IMG}</span><!-- BEGINELSE yim -->&nbsp;<!-- END yim --></td>
	</tr>
	<tr>
		<td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_AIM}:</span></td>
		<td class="row1" valign="middle"><!-- BEGIN aim --><span class="gen">{AIM_IMG}</span><!-- BEGINELSE aim -->&nbsp;<!-- END aim --></td>
	</tr>
	<tr>
		<td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_ICQ_NUMBER}:</span></td>
		<td class="row1"><!-- BEGIN icq --><table cellspacing="0" cellpadding="0" border="0"><tr><td height="18" valign="top" nowrap="nowrap">
			<div style="position:relative"><a href="{U_ICQ}" title="{L_POSTER_ICQ}"><img src="{I_POSTER_ICQ}" border="0" alt="{L_POSTER_ICQ}" /></a>&nbsp;<div id="icq_status_user" style="position:absolute; left:3px; top:-1px; display:none"><a href="{U_ICQ_STATUS}" title=""><img src="{I_ICQ_STATUS}" width="18" height="18" border="0" alt="" /></a></div></div>
		</td></tr></table><!-- BEGINELSE icq -->&nbsp;<!-- END icq --></td>
	</tr>
	</table></td>
	<td class="row1" valign="top"><!-- BEGIN signature --><span class="postbody">{SIGNATURE}</span><!-- BEGINELSE signature -->&nbsp;<!-- END signature --></td>
</tr>
<tr>
	<td class="catBottom" colspan="2" nowrap="nowrap" align="center"><span class="genmed">&nbsp;
		<!-- BEGIN buttons --><a href="{buttons.U_BUTTON}" title="{buttons.L_BUTTON}" accesskey="{buttons.S_BUTTON}"><img src="{buttons.I_BUTTON}" border="0" alt="{buttons.L_BUTTON}" /></a>&nbsp;<!-- END buttons -->
	</span></td>
</tr>
</table>

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