<?php
session_start();
require_once("facebook.php");
require_once("fbConfig.php");

$facebook = unserialize($_SESSION['fbobject']);
$_SESSION['fbobject'] = serialize($facebook);
$user = $facebook->getUser();
$access_token = $facebook->getAccessToken();

if ($user)
{
	// Proceed knowing you have a logged in user who's authenticated.
	try {
		$logoutUrl = $facebook->getLogoutUrl(array(
			'next'=>'http://alpeshfbapprtcamp.comuv.com/Facebook/Logout.php'
		));		
		$user_profile = $facebook->api('/me'); // get All user data
	}catch (FacebookApiException $e) {
		error_log($e);
		$user = null;
	}
}

$albums = $facebook->api('/me/albums');
$ArrayOfPhotoCountOfAlbum = array(); // To store total number of photos of each Album

foreach($albums['data'] as $album)
{
	$count = 0;
  	$photos = $facebook->api("/{$album['id']}/photos");
	
	foreach($photos['data'] as $photo)
		$count = $count + 1;
		
	$ArrayOfPhotoCountOfAlbum[] = $count; // store no. of photos in array of an album
}
?>

<html>	
<head>
	<title>Albums Page</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!--Loading Bootstrap JS Files-->
	<script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
		
	<!-- Add jQuery library For FancyBox -->
	<script type="text/javascript" src="http://alpeshfbapprtcamp.comuv.com/Facebook/fancyBox/lib/jquery-1.9.0.min.js"></script>		
	<script type="text/javascript" src="http://alpeshfbapprtcamp.comuv.com/Facebook/fancyBox/source/jquery.fancybox.pack.js"></script>
	<script type="text/javascript" src="http://alpeshfbapprtcamp.comuv.com/Facebook/fancyBox/source/jquery.fancybox.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.fancybox').fancybox();					
		});	
	</script>
    
	<!--Loading CSS Files (FancyBox, BootStrap)-->
	<link rel="stylesheet" type="text/css" href="http://alpeshfbapprtcamp.comuv.com/Facebook/fancyBox/source/jquery.fancybox.css?v=2.1.4" media="screen" />
	<link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">	
	<link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="bootstrap/css/myBootstrap.css" rel="stylesheet">
</head>
<body>
<div id="mainDiv">
	<div class="navbar" id="navbar">
            <div class="navbar-inner">
                <div class="container" style="width: auto;">                    
                    <a class="brand" href="#">Facebook Album Slideshow & Download</a>                    
                </div>
            </div><!-- /navbar-inner -->
   	</div>
	
	<!--Logout Link-->
	<div id="logout"><a href="<?php echo $logoutUrl;?>">Logout</a></div>
	
	<!--User Logged in Name-->
	<div id="divName">Name : <?php echo $user_profile['name'];?></div>
        
    <div id="container" class="container-fluid">

	    <div class="row-fluid">
		
	    	<div class="span2"></div>
		
		    <div class="span8">
		     
				<div class="row-fluid">
				
		        	<ul class="thumbnails">
					
						<?php 
		             		$index=0;
					
		        		    foreach($albums['data'] as $album)
					 		{ 
		                ?>    						
								  	<li class="span3">
								    	<a href="http://alpeshfbapprtcamp.comuv.com/Facebook/albumphoto.php?album_id=<?php echo $album['id']?>"  class="thumbnail fancybox fancybox.iframe">
								      		<!--Album Cover Photo-->
											<img src="https://graph.facebook.com/<?=$album['id']?>/picture?access_token=<?=$access_token?>" alt="Image">
								    	</a>
											<!--Album Name-->
											<h4><a class="fancybox fancybox.iframe" href="http://alpeshfbapprtcamp.comuv.com/Facebook/albumphoto.php?album_id=<?php echo $album['id']?>"><?php echo $album['name'];?></a></h4>
						      				
											<!--Album Total Photos-->
											<p><?php echo $ArrayOfPhotoCountOfAlbum[$index]." Photos ";$index += 1; ?></p>
											
											<!--Download Album Button-->
											<a class="btn btn-danger download" href="http://alpeshfbapprtcamp.comuv.com/Facebook/downloadAlbum.php?album_id=<?php echo $album['id']?>" >Download Album</a>
								  	</li>						  
						<?php
		                     }
						?>
						
		            </ul>
					
				</div>

		    </div>
	    	
			<div class="span2"></div>
			
		</div>
		
    </div>

</div>
</body>
</html>