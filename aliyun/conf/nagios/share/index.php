<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Web Interface Monitoring - Theme design by Eduardo L. Arana</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="Content-Language" content="en" />
	<meta name="robots" content="noindex, nofollow" />
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
</head>
	<frameset frameborder="0" framespacing="0" rows="60,*">
		<frame src="top.html" name="top" />
		<frameset frameborder="0" framespacing="0" cols="200,*">
			<frame src="menu.html" name="menu" target="main" />
			<frameset frameborder="0" framespacing="0" rows="26,*">
				<frame src="sidebar.html" name="navigation" />
				<frame src="nagios/cgi-bin/status.cgi?host=all" name="main" />
			</frameset>
		</frameset>
	</frameset>
	<noframes>
		<body>
			<p>These pages require a browser which supports frames.</p>
		</body>
	</noframes>
</html>
