<?php
session_start();
require_once("facebook.php");
require_once("fbConfig.php");

$facebook = unserialize($_SESSION['fbobject']);
$_SESSION['fbobject'] = serialize($facebook);
$album_id = $_GET['album_id']; // get that one album
$photos = $facebook->api("/{$album_id}/photos");  //All photos of that album
?>

<html>	
<head>
	<title>Album Slideshow</title>	
	<!-- Add FancyBox jQuery library -->
	<script type="text/javascript" src="http://alpeshfbapprtcamp.comuv.com/Facebook/fancyBox/lib/jquery-1.9.0.min.js"></script>		
	<script type="text/javascript" src="http://alpeshfbapprtcamp.comuv.com/Facebook/fancyBox/source/jquery.fancybox.pack.js"></script>
	<script type="text/javascript" src="http://alpeshfbapprtcamp.comuv.com/Facebook/fancyBox/source/jquery.fancybox.js"></script>	
	<script type="text/javascript">				
		$(document).ready(function() {
			$.fancybox([
				<?php
					foreach($photos['data'] as $photo)
						echo "'{$photo['source']}',\n";				
				?>
				], {
					'padding'	: 0,
					'transitionIn'	: 'elastic',
					'transitionOut'	: 'elastic',
					'type'          : 'image',
					'scrolling'     : 'auto',
					'width' 	: 'auto',
					'height' 	: 'auto',
					'easingIn'	: 'swing',
					'autoResize'	: true,
					'nextClick' 	: true,
					'closeBtn'      : false,
					'changeFade'    : 0
				})
			});			
	</script>    
	<link rel="stylesheet" type="text/css" href="http://alpeshfbapprtcamp.comuv.com/Facebook/fancyBox/source/jquery.fancybox.css?v=2.1.4" media="screen" />
</head>
<body>
</body>
</html>