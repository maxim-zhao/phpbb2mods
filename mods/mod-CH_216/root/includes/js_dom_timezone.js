function _timezone()
{
	return this;
}
	_timezone.prototype.suggest = function(tz, dst)
	{
		var obj_tz = eval('document.post.' + tz);
		var obj_dst_on = eval('document.post.' + dst + '[1]');
		var obj_dst_off = eval('document.post.' + dst + '[0]');
		var dst_in_action = obj_dst_on.checked;

		var date = new Date();
		var tz_ofs = 0 - (date.getTimezoneOffset() / 60);
		var tz_ofs_dst = tz_ofs - 1;

		// search for the closest value without dst activated
		var delta_dst_off = 9999;
		var delta_dst_on = 9999;
		var i_dst_off = 0;
		var i_dst_on = 0;
		var i_selected = 0;
		for (i = 0; i < obj_tz.length; i++ )
		{
			w_delta_dst_off = Math.abs(parseFloat(obj_tz.options[i].value) - parseFloat(tz_ofs));
			w_delta_dst_on = Math.abs(parseFloat(obj_tz.options[i].value) - parseFloat(tz_ofs) + 1);
			if ( w_delta_dst_off < delta_dst_off )
			{
				delta_dst_off = w_delta_dst_off;
				i_dst_off = i;
			}
			if ( w_delta_dst_on < delta_dst_off )
			{
				delta_dst_on = w_delta_dst_on;
				i_dst_on = i;
			}
		}

		// compare dst off & on delta and retain the best
		i_new = ((dst_in_action == 0) || (delta_dst_off < delta_dst_on) || ((delta_dst_off == delta_dst_on) && obj_dst_off.checked)) ? i_dst_off : i_dst_on;

		// finaly update fields
		obj_tz.selectedIndex = i_new;
		obj_dst_on.checked = (i_new == i_dst_on);
		obj_dst_off.checked = !obj_dst_on.checked;
	}

// instantiate
timezone = new _timezone();
