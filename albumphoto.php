<!--/**
* 
*	Short description for file : Slideshow Page
*
*	Long description for file : This page contains slideshow for the album user has clicked on.
*   							It received albumId from GET request. 	
*/
/*-->

<?php
	session_start();
	require_once("facebook.php");
	require_once("fbConfig.php");

	//Session Object
	$facebook = unserialize($_SESSION['fbobject']);
	$_SESSION['fbobject'] = serialize($facebook);
	
	// get the album User clicked on
	$albumId = $_GET['albumId']; // get that one album
	
	//All photos of that album
	$photos = $facebook->api("/{$albumId}/photos"); 
?>

<html>	
	<head>
		<title>Album Slideshow</title>	
		
		<!-- Add FancyBox jQuery library -->
		<script type="text/javascript" src="http://alpeshfbapprtcamp.comuv.com/Facebook/lib/jquery-1.9.0.min.js"></script>		
		<script type="text/javascript" src="http://alpeshfbapprtcamp.comuv.com/Facebook/lib/jquery.fancybox.pack.js"></script>
		<script type="text/javascript" src="http://alpeshfbapprtcamp.comuv.com/Facebook/lib/jquery.fancybox.js"></script>			    
		
		<link rel="stylesheet" type="text/css" href="http://alpeshfbapprtcamp.comuv.com/Facebook/css/jquery.fancybox.css?v=2.1.4" media="screen" />
		
	</head>
	
	<body>
		
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
		
	</body>
	
</html>