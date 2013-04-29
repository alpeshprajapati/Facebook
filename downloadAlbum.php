<!--/**
* 
*	Short description for file : Album Downloading
*
*	Long description for file : This page downloads photos of an album user has clicked on.
*   							It received albumId from GET request. 	
*/
/*-->

<?php
	session_start();
	require_once("facebook.php");
	require_once("fbConfig.php");

	//Session Object
	$facebook = unserialize($_SESSION['fbobject']) ;
	$_SESSION['fbobject'] = serialize($facebook);
	
	// get the album User clicked on
	$albumId = $_GET['albumId'];
	
	//All photos of that album
	$photos = $facebook->api("/{$albumId}/photos"); // get that one album
	
	$error = ""; //error holder

	if(extension_loaded('zip')){
		
		$zip = new ZipArchive();
		$zipName = $albumId.".zip";
		
		
		if($zip->open($zipName, ZIPARCHIVE::CREATE)!==TRUE){
			
			$error .= "* Sorry ZIP creation failed at this time";
			echo $error;
		}
		
		/*Taking each photo, creating jpg file and adding in zip*/
		foreach($photos['data'] as $photo){
						
			$url=$photo['source'];
	        $ch = curl_init($url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        $download_file = curl_exec($ch);
			$file = fopen($photo['id'].".jpg","w");
			fwrite($file,$download_file);
			fclose($file);
			$zip->addFile($photo['id'].".jpg");
			
		}
		
		$zip->close();

		/*Deleting All jpg Files*/
		foreach($photos['data'] as $photo)
		    unlink($photo['id'].".jpg");
		
		/*File for Download*/
		if(file_exists($zipName)){
			
			header('Content-Description: File Transfer');
		    header('Content-Type: application/zip');
		    header('Content-Disposition: attachment; filename="'.$zipName.'"');
		    readfile($zipName);
			unlink($zipName);
			exit;
			
		}else{	
		
			$error .= "* Please select file to zip ";
			echo $error;
		}
	}else{
		
		$error .= "* You dont have ZIP extension";
		echo $error;
	} 
?>