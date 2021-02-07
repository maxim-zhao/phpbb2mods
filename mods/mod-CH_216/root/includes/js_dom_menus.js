
function _dom_menu(menus)
{
	this.menus = menus;

	var left_part = this.objref('left_part');
	if ( left_part && left_part.style )
	{
		left_part.style.display = '';
	}
	this.pid = this.objref('pid');

	var menu = 0;
	if ( this.pid && this.pid.value && this.menus[this.pid.value] )
	{
		menu = this.pid.value;
	}
	this.set(this.menus[menu]);
	return this;
}
	_dom_menu.prototype.objref = function(id)
	{
		return document.getElementById ? document.getElementById(id) : (document.all ? document.all[id] : (document.layers ? document.layers[id] : null));
	}
	_dom_menu.prototype.cancel_event = function()
	{
		if ( window.event )
		{
			window.event.cancelBubble = true;
		}
	}

	_dom_menu.prototype.set = function(menu) {
		var object;
		var opt;
		var flag;

		for (i=0; i < this.menus.length; i++)
		{
			cur_menu = this.menus[i];
			if ( this.pid && (cur_menu == menu) )
			{
				this.pid.value = i;
			}
			object = this.objref(cur_menu);
			if ( object && object.style )
			{
				object.style.display = (cur_menu == menu) ? '' : 'none';
			}
			title = this.objref(cur_menu + '_title');
			if ( title && title.style )
			{
				title.style.display = (cur_menu == menu) ? '' : 'none';
			}
			opt = this.objref(cur_menu + '_opt');
			if ( opt && opt.style )
			{
				opt.style.fontWeight = (cur_menu == menu) ? 'bold' : '';
			}
			flag = this.objref(cur_menu + '_flag');
			if ( flag && flag.style )
			{
				flag.style.fontWeight = (cur_menu == menu) ? 'bold' : '';
			}
		}
		this.cancel_event();
	}
