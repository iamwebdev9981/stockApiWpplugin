<?php
global $wpdb,$table_prefix;


if(isset($_POST["submit"])){
		

		echo $filename=$_FILES["file"]["tmp_name"];
		

		 if($_FILES["file"]["size"] > 0)
		 {

		  	$file = fopen($filename, "r");
	         while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {

	         	echo "<pre>";
	         	print_r($emapData);
	         	echo "<pre>";
	    
	         //  //It wiil insert a row to our subject table from our csv file`
	         //   $sql = "INSERT into subject (`SUBJ_CODE`, `SUBJ_DESCRIPTION`, `UNIT`, `PRE_REQUISITE`,COURSE_ID, `AY`, `SEMESTER`) 
	         //    	values('$emapData[1]','$emapData[2]','$emapData[3]','$emapData[4]','$emapData[5]','$emapData[6]','$emapData[7]')";



	         // //we are using mysql_query function. it returns a resource on true else False on error
	         //  $result = mysqli_query( $conn, $sql );
			// 	if(! $result )
			// 	{
			// 		echo "<script type=\"text/javascript\">
			// 				alert(\"Invalid File:Please Upload CSV File.\");
			// 				window.location = \"index.php\"
			// 			</script>";
				
			// 	}

	         }
	         fclose($file);
	         //throws a message if data successfully imported to mysql database from excel file
	         echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"index.php\"
					</script>";
	        
			 

			 //close of connection
			mysqli_close($conn); 
				
		 	
			
		 }
	}	 
?>		 