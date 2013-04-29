<!--/**
* 
*	Short description for file : Album Page
*
*	Long description for file : It pulls out logged user's albums.
*
*/-->

<?php
	session_start();
	require_once("facebook.php");
	require_once("fbConfig.php");
	
	//Session Object
	$facebook = unserialize($_SESSION['fbobject']);
	$_SESSION['fbobject'] = serialize($facebook);
	
	$user = $facebook->getUser();	
	$access_token = $facebook->getAccessToken();

	if ($user){	// Proceed knowing you have a logged in user who's authenticated.
	
		try{
			
			$logoutUrl = $facebook->getLogoutUrl(array(
				'next'=>'http://alpeshfbapprtcamp.comuv.com/Facebook/Logout.php'
			));	
				
			$user_profile = $facebook->api('/me'); // get All user data
			
		}catch (FacebookApiException $e){
			error_log($e);
			$user = null;
		}
	}

	$albums = $facebook->api('/me/albums');
	$totalPhotoOfAlbum = array(); // To store total number of photos of each Album

	/* Counting Total photos of each Album and storing in an array*/
	foreach($albums['data'] as $album){
		
		$count = 0;
	  	$photos = $facebook->api("/{$album['id']}/photos");
		
		foreach($photos['data'] as $photo)
			$count = $count + 1;
			
		$totalPhotoOfAlbum[] = $count; // store no. of photos in array of an album
		
	}
?>

<html>	
	<head>
	
		<title>Albums Page</title>
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!--Loading Bootstrap JS Files-->
		<script src="http://code.jquery.com/jquery.js"></script>
	    <script src="lib/bootstrap.min.js"></script>
		
		
		<!-- Add jQuery library For FancyBox -->
		<script type="text/javascript" src="http://alpeshfbapprtcamp.comuv.com/Facebook/lib/jquery-1.9.0.min.js"></script>		
		<script type="text/javascript" src="http://alpeshfbapprtcamp.comuv.com/Facebook/lib/jquery.fancybox.pack.js"></script>
		<script type="text/javascript" src="http://alpeshfbapprtcamp.comuv.com/Facebook/lib/jquery.fancybox.js"></script>
			    
		<!--Loading CSS Files (FancyBox, BootStrap)-->
		<link rel="stylesheet" type="text/css" href="http://alpeshfbapprtcamp.comuv.com/Facebook/css/jquery.fancybox.css?v=2.1.4" media="screen" />
		<link href="css/bootstrap.css" rel="stylesheet" media="screen">
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">	
		<link href="css/bootstrap-responsive.css" rel="stylesheet">
		<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
		<link href="css/myBootstrap.css" rel="stylesheet">
		
	</head>
	
	<body>
		<div>
			
			<!--Application Description-->
			<div class="navbar" id="navbar">
		            <div class="navbar-inner">
		                <div class="container" style="width: auto;">                    
		                    <a class="brand" href="#">Facebook Album Slideshow & Download</a>                    
		                </div>
		            </div><!-- /navbar-inner -->
		   	</div>
			
			<!--Logout Link-->
			<div id="logout"><a href="<?php echo $logoutUrl;?>">Logout</a></div>
			
			<div id="container" class="container-fluid">
				
				<!--User Logged in Name-->
				<div id="divName">Name : <?php echo $user_profile['name'];?></div>
		    
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
										    	<a href="http://alpeshfbapprtcamp.comuv.com/Facebook/albumphoto.php?albumId=<?php echo $album['id']?>"  class="thumbnail fancybox fancybox.iframe">
										      		<!--Album Cover Photo-->
													<img src="https://graph.facebook.com/<?=$album['id']?>/picture?access_token=<?=$access_token?>" alt="Image">
										    	</a>
													<!--Album Name-->
													<h4><a class="fancybox fancybox.iframe" href="http://alpeshfbapprtcamp.comuv.com/Facebook/albumphoto.php?albumId=<?php echo $album['id']?>"><?php echo $album['name'];?></a></h4>
								      				
													<!--Album Total Photos-->
													<p><?php echo $totalPhotoOfAlbum[$index]." Photos ";$index += 1; ?></p>
													
													<!--Download Album Button-->
													<a class="btn btn-danger download" href="http://alpeshfbapprtcamp.comuv.com/Facebook/downloadAlbum.php?albumId=<?php echo $album['id']?>" >Download Album</a>
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
		
		<script type="text/javascript">
			$(document).ready(function() {
				$('.fancybox').fancybox();					
			});	
		</script>
		
	</body>
</html>
