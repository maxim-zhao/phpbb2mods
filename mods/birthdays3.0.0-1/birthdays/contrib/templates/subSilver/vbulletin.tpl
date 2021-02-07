<!-- BEGIN bday_start -->
		<table border="0" cellspacing="0" cellpadding="0">
		  <tr>
<!-- END bday_start -->
<!-- BEGIN bday_month -->
		    <td class="gensmall">{L_MONTH}:</td>
<!-- END bday_month -->
<!-- BEGIN bday_day -->
		    <td class="gensmall">{L_DAY}:</td>
<!-- END bday_day -->
<!-- BEGIN bday_year -->
		    <td class="gensmall">{L_YEAR}:</td>
<!-- END bday_year -->
<!-- BEGIN bday_glue -->
		  </tr>
		  <tr>
<!-- END bday_glue -->
<!-- BEGIN bday_month2 -->
		    <td>{BIRTHMONTH_SELECT} &nbsp;</td>
<!-- END bday_month2 -->
<!-- BEGIN bday_day2 -->
		    <td>{BIRTHDAY_SELECT} &nbsp;</td>
<!-- END bday_day2 -->
<!-- BEGIN bday_year2 -->
		    <td><input type="text" class="post" name="bday_year" size="4" maxlength="4" value="{BDAY_YEAR}" onfocus="this.select()" /></td>
<!-- END bday_year2 -->
<!-- BEGIN bday_end -->
		    <td rowspan="2">&nbsp; <input type="button" class="button" value="{L_CLEAR}" tabindex="-1" onclick="document.forms[0].bday_month.value=document.forms[0].bday_day.value=0; document.forms[0].bday_year.value=''" /></td>
		  </tr>
		</table>
<!-- END bday_end -->