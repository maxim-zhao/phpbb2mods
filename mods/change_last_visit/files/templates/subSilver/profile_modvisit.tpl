<!-- time en(de)coding & Calendar -->
<script language="JavaScript" type="text/javascript" src="./js/calend_t.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
/* ============================================== *\
    Calendar
\* ============================================== */
////////////////
//  Settings
//////////////
var kal_days_holders_bgcolor_hover = '#BBB';
var kal_days_holders_bgcolor_mark = '#088';

var months = new Array("{L_JAN}", "{L_FEB}", "{L_MAR}", "{L_APR}", "{L_MAY}", "{L_JUN}", "{L_JUL}", "{L_AUG}", "{L_SEP}", "{L_OCT}", "{L_NOV}", "{L_DEC}");
var err_parse_time = '{L_TIME_INVALID}';
var lastvis_hours		= "{CUR_GODZ}";
var lastvis_minutes	= "{CUR_MIN}";
var lastvis_seconds	= "{CUR_SEK}";
var lastvis_day		= "{CUR_DAY}";
var lastvis_month		= "{CUR_MONTH}"-1;
var lastvis_year		= "{CUR_YEAR}";
//\\\\\\\\\\\\
//  Settings
//\\\\\\\\\\\\\\
// -->
</script>
<style>
	.clickable {
		cursor: pointer;
	}
	
	.img_btn {
		border: 2px outset #FFFFFF;
		cursor: pointer;
	}
	
	/* zegarek przy kalendarzu */
	.time_holder {
		text-align: right;
		margin: 2px 0px;
		width: 220px;
	}
	.time_holder input {
		text-align: center;
		border: 1px solid black;
		background-color: silver;
		color: #153;
		font-weight:bold;
		font-size: 14px;
	}
	
	/* kalendarz */
	#kal_days {
		cursor: pointer;
	}
	div.kalendarz_holder {
		text-align: center;
		
		width: 217px;
		/* height: 242px; */
		
		border: 1px solid black;
		
		background-color: white;
	}
	div.kalendarz_holder h1 {
		font-size: 11px;
		text-align: center;
		
		margin: 3px;
	}
	div.kalendarz_holder table {
		text-align: center;
		vertical-align: top;
		font-size: 10px;
		
		/* width: 245px; */
		/* height: 210px; */
		
		margin: 3px;
		padding: 0px;
		
		background-color: black;
	}
	div.kalendarz_holder table th,div.kalendarz_holder table td {
		vertical-align: middle;
		
		width: 29px;
		height: 28px;
		
		margin: 0px;
		padding: 0px;
		
		background-color: #DDD;
	}
	
	/* ulozenie elementow menu */
	div.kal_back_menu {
		float: left;
	}
	div.kal_fwd_menu {
		float: right;
	}
	div.kal_back_menu,div.kal_fwd_menu {
		position: relative;
		z-index: 1;
	}
	div.kal_back_menu img,div.kal_fwd_menu img {
		position: absolute;
		width: 100%;
		height: 100%;
		z-index: 2;
	}
	
	/* others */
	p#date_title {
		margin: 2px 5px 5px;
	}
	p#date_explain,p#close_window_link {
		margin: 5px 5px 15px;
	}
</style>
<form method="post" name="frm" action="{S_MODVISIT_ACTION}">
<table width="100%" border="0" cellspacing="0" cellpadding="10" id="in_js_shown_holder" style="display:none">
	<tr>
		<td>
			<span class="gensmall">{LAST_VISIT_DATE}<br />{CURRENT_TIME}<br /></span>
			<table width="100%" class="forumline" cellpadding="4" cellspacing="1" border="0">
			<tr> 
				<th class="thHead" height="25">{L_MODVISIT}</th>
			</tr>
			<tr> 
				<td valign="top" class="row1" align="center">
					<p id="date_title" class="gen">{L_DATE_TITLE}</p>
					<div class="kalendarz_holder">
						<h1 id="kal_menu"><div class="kal_back_menu"><span class="clickable" id="kal_fbckwrd" onClick="decYear()">&lt;&lt;</span>&nbsp;<span class="clickable" id="kal_bckwrd" onClick="decMonth()">&lt;</span></div><div class="kal_fwd_menu"><span class="clickable" id="kal_fwd" onClick="incMonth()">&gt;</span>&nbsp;<span class="clickable" id="kal_ffwd" onClick="incYear()">&gt;&gt;</span></div>&nbsp;<span id="kal_dateMY">jan&nbsp;2006</span>&nbsp;</h1>
						<table cellspacing="1" cellpadding="0" border="0"><tbody>
							<!-- weekdays - shortcuts -->
							<tr><th>{L_MON}</th><th>{L_TUE}</th><th>{L_WED}</th><th>{L_THU}</th><th>{L_FRI}</th><th>{L_SAT}</th><th>{L_SUN}</th></tr>
							<!-- 7x6 (id is for Exploder) -->
							<tr><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td></tr>
							<tr><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td></tr>
							<tr><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td></tr>
							<tr><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td></tr>
							<tr><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td></tr>
							<tr><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td><td name="kal_days" id="kal_days"></td></tr>
						</tbody></table>
					</div>
					<div class="time_holder"><input name="time" type="text" size="7" /></div>
					<input type="submit" class="liteoption" name="visit_modified" value="{L_SUBMIT}" />
					<p id="date_explain" class="gensmall">{L_EXPLAIN}</p>
					<p id="close_window_link" class="genmed"><a href="javascript:window.close();" class="genmed">{L_CLOSE_WINDOW}</a></p>
				</td>
			</tr>
		</table></td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="10" id="in_js_hidden_holder">
	<tr>
		<td>
			<span class="gensmall">{LAST_VISIT_DATE}<br />{CURRENT_TIME}<br /></span>
			<table width="100%" class="forumline" cellpadding="4" cellspacing="1" border="0">
			<tr> 
				<th class="thHead" height="25">{L_MODVISIT}</th>
			</tr>
			<tr> 
				<td valign="top" class="row1" align="center">
					<p id="date_title" class="gen">{L_DATE_TITLE}</p>
					<input
						name="hours"	value="{CUR_GODZ}"	type="text" size="2" />:<input 
						name="minutes"	value="{CUR_MIN}"	type="text" size="2" />:<input 
						name="seconds"	value="{CUR_SEK}"	type="text" size="2" />&nbsp;<input 
						name="dzien"	value="{CUR_DAY}"	type="text" size="2" />.<input 
						name="miesiac"	value="{CUR_MONTH}"	type="text" size="2" />.<input 
						name="rok"		value="{CUR_YEAR}"	type="text" size="4" />&nbsp;&nbsp;<input 
						type="submit" class="liteoption" name="visit_modified" value="{L_SUBMIT}" 
					/>
					<p id="date_explain" class="gensmall">{L_EXPLAIN}</p>
				</td>
			</tr>
		</table></td>
	</tr>
</table>
</form>

<img src="templates/subSilver/images/spacer.gif" onLoad="initKalendarz(); initTimeToday();" />
