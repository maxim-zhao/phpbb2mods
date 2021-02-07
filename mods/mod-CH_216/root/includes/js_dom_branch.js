function _dom_branch(varname)
{
	this.items = new Array();
	this.keys = new Array();
	this.build(varname);
	return this;
}
	_dom_branch.prototype.get_id = function(i, varname)
	{
		var idx = (document.post.elements[i].name).substring(varname.length + 1, document.post.elements[i].name.length - 1);
		if ( idx != '' )
		{
			return idx;
		}
		else
		{
			return document.post.elements[i].value;
		}
	}
	_dom_branch.prototype.build = function(varname)
	{
		// find elements ids
		idx = -1;
		for ( i = 0; i < document.post.elements.length; i++ )
		{
			if ( (document.post.elements[i].name).substring(0, varname.length + 1) == varname + '[' )
			{
				idx = idx + 1;
				this.items[ this.get_id(i, varname) ] = idx;
				this.keys[idx] = i;
			}
		}
	}
	_dom_branch.prototype.set = function(cur_id, last_id)
	{
		for ( idx = this.items[cur_id] + 1; idx <= this.items[last_id]; idx++ )
		{
			if ( document.post.elements[ this.keys[ this.items[cur_id] ] ].type == 'checkbox' )
			{
				document.post.elements[ this.keys[idx] ].checked = document.post.elements[ this.keys[ this.items[cur_id] ] ].checked;
			}
			else if ( document.post.elements[ this.keys[ this.items[cur_id] ] ].type == 'select-one' )
			{
				document.post.elements[ this.keys[idx] ].selectedIndex = document.post.elements[ this.keys[ this.items[cur_id] ] ].selectedIndex;
			}
			else
			{
				document.post.elements[ this.keys[idx] ].value = document.post.elements[ this.keys[ this.items[cur_id] ] ].value;
			}
		}
	}
