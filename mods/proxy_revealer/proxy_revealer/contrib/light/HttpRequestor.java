// httpRequestor.java
// Copyright (c) MMVI TerraFrost
// Licensed under the GPL.

import java.applet.*;
import java.net.*;

public class HttpRequestor extends Applet
{
	public void start()
	{
		try
		{
			Socket sock = new Socket(getParameter("domain"), Integer.parseInt(getParameter("port")));
			String path = getParameter("path")+"&local="+sock.getLocalAddress().getHostAddress();
			String httpRequest = "GET "+path+" HTTP/1.0\r\nHost: "+getParameter("domain")+"\r\n\r\n";
			sock.getOutputStream().write(httpRequest.getBytes());
			sock.getInputStream();
		}
		catch (Exception e)
		{
			//e.printStackTrace();
		}
	}
}