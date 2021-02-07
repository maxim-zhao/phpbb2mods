/*

   "Resize Avatars Based on Max Width and Height" 1.0.1
   A phpBB MOD originally created by Christian Fecteau.

   This MOD is copyright (c) Christian Fecteau 2005

   This MOD is released under the Creative Commons licence:
   http://creativecommons.org/licenses/by-nc-sa/2.0/
   Read carefully this licence before making any use of my code.

   Credits must be given with my full name (Christian Fecteau)
   and a link to my portfolio: http://portfolio.christianfecteau.com/

   Removal or alteration of this notice is strongly prohibited.

*/

// don't change anything below
if (document.getElementsByTagName && document.createElement) // W3C DOM browsers
{
	rmwa_pop_features = 'top=0,left=0,width=' + String(window.screen.width-80) + ',height=' + String(window.screen.height-190) + ',scrollbars=1,resizable=1';
	rmwa_count = 1;
	if (!window.opera)
	{
		rmwa_pop = new Object();
		rmwa_pop.closed = true;
		rmwa_old_onunload = window.onunload;
		window.onunload = function()
		{
			if (rmwa_old_onunload)
			{
				rmwa_old_onunload();
				rmwa_old_onunload = null;
			}
			if (!rmwa_pop.closed)
			{
				rmwa_pop.close();
			}
		}
	}
}
function rmwa_img_loaded(rmwa_obj, rmwa_max_width, rmwa_max_height)
{
	if (!document.getElementsByTagName || !document.createElement)
	{
		return;
	}
	var rmwa_real_width = rmwa_real_height = rmwa_offset_width = rmwa_offset_height = false;
	if (rmwa_obj.width && rmwa_obj.height)
	{
		rmwa_real_width = rmwa_obj.width;
		rmwa_real_height = rmwa_obj.height;
	}
	if (!rmwa_real_width || isNaN(rmwa_real_width) || (rmwa_real_width <= 0) || !rmwa_real_height || isNaN(rmwa_real_height) || (rmwa_real_height <= 0))
	{
		var rmwa_rand1 = String(rmwa_count++);
		eval("rmwa_retry" + rmwa_rand1 + " = rmwa_obj;");
		eval("rmwa_x" + rmwa_rand1 + " = rmwa_max_width;");
		eval("rmwa_y" + rmwa_rand1 + " = rmwa_max_height;");
		eval("window.setTimeout('rmwa_img_loaded(rmwa_retry" + rmwa_rand1 + ",rmwa_x" + rmwa_rand1 + ",rmwa_y" + rmwa_rand1 + ")',1000);");
		return;
	}
	if (rmwa_real_width > rmwa_max_width)          { rmwa_offset_width = rmwa_real_width - rmwa_max_width; }
	if (rmwa_real_height > rmwa_max_height)        { rmwa_offset_height = rmwa_real_height - rmwa_max_height; }
	if (!rmwa_offset_width && !rmwa_offset_height) { return; }

	if (rmwa_offset_width > rmwa_offset_height)    { rmwa_make_pop(rmwa_obj, rmwa_max_width, null); }
	else                                           { rmwa_make_pop(rmwa_obj, null, rmwa_max_height); }
}
function rmwa_make_pop(rmwa_ref, rmwa_x, rmwa_y)
{
	(rmwa_x == null) ? rmwa_ref.style.height = String(rmwa_y) + 'px' : rmwa_ref.style.width = String(rmwa_x) + 'px';
	if (!window.opera)
	{
		rmwa_ref.onclick = function()
		{
			if (!rmwa_pop.closed)
			{
				rmwa_pop.close();
			}
			rmwa_pop = window.open('about:blank','spooky2280',rmwa_pop_features);
			rmwa_pop.resizeTo(window.screen.availWidth,window.screen.availHeight);
			rmwa_pop.moveTo(0,0);
			rmwa_pop.focus();
			rmwa_pop.location.href = this.src;
		}
	}
	else
	{
		var rmwa_rand2 = String(rmwa_count++);
		eval("rmwa_pop" + rmwa_rand2 + " = new Function(\"rmwa_pop = window.open('" + rmwa_ref.src + "','christianfecteaudotcom','" + rmwa_pop_features + "'); if (rmwa_pop) {rmwa_pop.focus();}\")");
		eval("rmwa_ref.onclick = rmwa_pop" + rmwa_rand2 + ";");
	}
	document.all ? rmwa_ref.style.cursor = 'hand' : rmwa_ref.style.cursor = 'pointer';
}
