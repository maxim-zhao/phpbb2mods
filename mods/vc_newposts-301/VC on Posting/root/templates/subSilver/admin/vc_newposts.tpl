<tr>
	<th class="thHead" colspan="2">{L_VCNP_TITLE}</th>
</tr>
<tr>
	<td class="row1">
		{L_VCNP_USER_TYPE}
	</td>
	<td class="row2">
		{USER_SELECT}
	</td>
</tr>
<tr>
	<td class="row1">
		{L_VCNP_TYPE}
	</td>
	<td class="row2">
		{TYPE_SELECT}
	</td>
</tr>
<tr>
	<td class="row1">
		{L_VCNP_POSTS}<br />
		<span class="gensmall">{L_VCNP_POSTS_EXPLAIN}</span>
	</td>
	<td class="row2">
		<input class="post" type="text" name="vcnewposts_max_posts" value="{VCNEWPOSTS_MAX_POSTS}" size="25" maxlength="255" />
	</td>
</tr>
<tr>
	<td class="row1">
		{L_VCNP_WEB}<br />
		<span class="gensmall">{L_VCNP_WEB_EXPLAIN}</span>
	</td>
	<td class="row2">
		<input type="radio" name="vcnewposts_webcheck" value="1" {WEBCHECK_YES} /> {L_YES}&nbsp;&nbsp;
		<input type="radio" name="vcnewposts_webcheck" value="0" {WEBCHECK_NO} /> {L_NO}
	</td>
</tr>
<tr>
	<td class="row2" colspan="2">
		{L_VCNP_RANDOMS}
		<br /><span class="gensmall">{L_VCNP_RANDOMS_EXPLAIN}</span>
	</td>
</tr>
<tr>
	<td class="row1">
		{L_VCNP_RAND1-2}
	</td>
	<td class="row2">
		<input class="post" type="text" name="vcnewposts_rand1" value="{VCNEWPOSTS_RAND1}" size="6" maxlength="5" />
		{L_VCNP_MIN_TO}
		<input class="post" type="text" name="vcnewposts_rand2" value="{VCNEWPOSTS_RAND2}" size="6" maxlength="5" />
		{L_VCNP_MAX}
	</td>
</tr>
<tr>
	<td class="row1">
		{L_VCNP_RAND3-4}
	</td>
	<td class="row2">
		<input class="post" type="text" name="vcnewposts_rand3" value="{VCNEWPOSTS_RAND3}" size="6" maxlength="6" />
		{L_VCNP_MIN_TO}
		<input class="post" type="text" name="vcnewposts_rand4" value="{VCNEWPOSTS_RAND4}" size="6" maxlength="6" />
		{L_VCNP_MAX}
	</td>
</tr>
<tr>
	<td class="row1">
		{L_VCNP_RAND5}
	</td>
	<td class="row2">
		<input class="post" type="text" name="vcnewposts_rand5" value="{VCNEWPOSTS_RAND5}" size="5" maxlength="5" />
	</td>
</tr>
