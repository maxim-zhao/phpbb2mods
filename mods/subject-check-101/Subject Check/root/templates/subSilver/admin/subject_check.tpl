	<tr>
		<th class="thHead" colspan="2">{L_SUBCHK_TITLE}</th>
	</tr>
	<tr>
		<td class="row1">
			{L_SUBCHK_FORUM}<br />
			<span class="gensmall">{L_SUBCHK_FORUM_EXPLAIN}</span>
		</td>
		<td class="row2">
			<input type="radio" name="subchk_enable" value="1" {SUBCHK_ENABLE_YES} /> {L_YES}&nbsp;&nbsp;
			<input type="radio" name="subchk_enable" value="0" {SUBCHK_ENABLE_NO} /> {L_NO}
		</td>
	</tr>
	<tr>
		<td class="row1">
			{L_SUBCHK_LOCKED}
		</td>
		<td class="row2">
			<input type="radio" name="subchk_locked" value="1" {SUBCHK_LOCKED_YES} /> {L_YES}&nbsp;&nbsp;
			<input type="radio" name="subchk_locked" value="0" {SUBCHK_LOCKED_NO} /> {L_NO}
		</td>
	</tr>
	<tr>
		<td class="row1">
			{L_SUBCHK_STRICT}<br />
			<span class="gensmall">{L_SUBCHK_STRICT_EXPLAIN}</span>
		</td>
		<td class="row2">
			<input type="radio" name="subchk_strict" value="1" {SUBCHK_STRICT_YES} /> {L_YES}&nbsp;&nbsp;
			<input type="radio" name="subchk_strict" value="0" {SUBCHK_STRICT_NO} /> {L_NO}
		</td>
	</tr>
	<tr>
		<td class="row1">
			{L_SUBCHK_BYPASS}<br />
			<span class="gensmall">{L_SUBCHK_BYPASS_EXPLAIN}</span>
		</td>
		<td class="row2">
			<input type="radio" name="subchk_bypass" value="1" {SUBCHK_BYPASS_YES} /> {L_YES}&nbsp;&nbsp;
			<input type="radio" name="subchk_bypass" value="0" {SUBCHK_BYPASS_NO} /> {L_NO}
		</td>
	</tr>
	<tr>
		<td class="row1">
			{L_SUBCHK_ADMIN}
		</td>
		<td class="row2">
			<input type="radio" name="subchk_admin" value="1" {SUBCHK_ADMIN_YES} /> {L_YES}&nbsp;&nbsp;
			<input type="radio" name="subchk_admin" value="0" {SUBCHK_ADMIN_NO} /> {L_NO}
		</td>
	</tr>
	<tr>
		<td class="row1">
			{L_SUBCHK_MOD}
		</td>
		<td class="row2">
			<input type="radio" name="subchk_mod" value="1" {SUBCHK_MOD_YES} /> {L_YES}&nbsp;&nbsp;
			<input type="radio" name="subchk_mod" value="0" {SUBCHK_MOD_NO} /> {L_NO}
		</td>
	</tr>
	<tr>
		<td class="row1">
			{L_SUBCHK_LIMIT}<br />
			<span class="gensmall">{L_SUBCHK_LIMIT_EXPLAIN}</span>
		</td>
		<td class="row2">
			<input type="text" name="subchk_limit" class="post" value="{SUBCHK_LIMIT}" />
		</td>
	</tr>
	<tr>
		<td class="row1">
			{L_SUBCHK_COUNT}<br />
			<span class="gensmall">{L_SUBCHK_COUNT_EXPLAIN}</span>
		</td>
		<td class="row2">
			<input type="text" name="subchk_postcount" class="post" value="{SUBCHK_POSTCOUNT}" />
		</td>
	</tr>
