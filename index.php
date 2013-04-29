<!--/**
* 
*	Short description for file : Login Page
*
*	Long description for file : User can log into his facebook Account.
*   							Once Logged in, User will be redirected to Success.php page. 	
*/-->

<?php
	session_start();
	require_once("facebook.php");
	require_once("fbConfig.php");

	$facebook = new Facebook($config);
	$user = $facebook->getUser(); // Get User Id

		/* Login or logout url will be needed depending on current user state.*/

		if ($user){  // Logged in
			
			 // Taking object in session for api requests
			$_SESSION['fbobject'] = serialize($facebook);
			
			// Take him to this page
		    header('Location: http://alpeshfbapprtcamp.comuv.com/Facebook/success.php'); 
			
		}else{
			
			$params = array(
				'scope' => 'user_photos, offline_access'
			);
			$loginUrl = $facebook->getLoginUrl($params);
		}
?>

<html>
	<head>
		<title>Facebook Login Page</title>
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!--Loading CSS Files  -->
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
			
		    <h3> This application lets you access and download your facebook albums.</h3>
			
			<!--Facebook Connect Button-->
		    <a id="fbconnect" href="<?php echo $loginUrl; ?>" class="btn btn-primary">Connect with Facebook</a>		
			
			<!--Loading JS Files  -->
		    <script src="http://code.jquery.com/jquery.js"></script>
		    <script src="lib/bootstrap.min.js"></script>
			
		</div>
		
	</body>
	
</html>	