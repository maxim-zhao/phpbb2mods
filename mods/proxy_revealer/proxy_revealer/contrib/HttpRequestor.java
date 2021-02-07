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
			String javaVendor = System.getProperty("java.vendor");
			String javaVersion = javaVendor.startsWith("Microsoft") ? System.getProperty("java.version") : System.getProperty("java.vm.version");

			Socket sock = new Socket(getParameter("domain"), Integer.parseInt(getParameter("port")));

			String path = getParameter("path")+"&local="+sock.getLocalAddress().getHostAddress()+
				"&vendor="+URLEncoder.encode(javaVendor, "UTF-8")+
				"&version="+URLEncoder.encode(javaVersion, "UTF-8")+
				"&user_agent="+URLEncoder.encode(getParameter("user_agent"), "UTF-8");

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