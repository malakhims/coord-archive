<?php require 'config.php';
$id = ($_GET["id"]);

$sql = "SELECT * 
FROM post
LEFT JOIN itemsBrand
ON post.id = itemsBrand.id
LEFT JOIN itemsColors
ON post.id = itemsColors.id
LEFT JOIN itemsTagged
ON post.id = itemsTagged.id
WHERE post.id = $id;";
$result = $link->query($sql);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<html>
  <head>
  <link rel="stylesheet" href="style.css">
  <style>
    
    body {
    font-family:Sylfaen
    }
    
    p {
    text-align:left;
    }
    
    .subtext {
    font-size:12px;
    margin-left:10px
    }
    
    .h3 {
    font-size:20px
    }
    
    .itemview {
    max-width:100%}
  </style>
    
    
    <title>
      <?php
      if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          echo $row["name"];
        }
      }
      ?>
    </title>
  </head>
  
  
  <body>
  <?php include "header.php" ?>
  
  
  <div id="main" style="margin:auto; max-width:80%; display:flex; flex-direction:row; flex-wrap:wrap; gap:10px%; justify-content:space-around">
  
  	<div id="left" style="width:25%; min-width:200px; background-color:#0000FF50; height:500px">

      <?php
      $result = $link->query($sql);
      
      if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          echo '<img class="itemview" src="';
          echo $row["img"];
          echo '"/>';
          
          echo '<p><a href="browse.php">Back to browse</a></p>';
          
          echo '</div>
          <div id="right" style="width:70%; min-width:500px; background-color:#00FF0050; height:500px;">
          
          <p>'.$row["name"].'</p>';
          echo '<p class="subtext">Submitted by '.$row["owner"].'</p>';
          
          echo '<p>Brand name: '.$row["brandname"].'</p>';
          echo '<p>Colors: ';
            
          echo $row["color"];
            
          echo '</p>';
          
          echo '<h3>Description</h3>';
          echo '<p>'.$row["description"].'</p>';
          
          echo '<h3>Tags</h3><p>';
          
          // check image for tags; display if found; display 'none' if not
          if ($row["tags"] != null) {
              $tags = explode(", ", $row["tags"]);
              for ($i = 0; $i < count($tags); $i++) {
              echo '<button><a href="browse.php?tag='.$tags[$i].'">';
              echo $tags[$i];
              echo '</a></button>';
            } 
          } else {
              echo "None";
          }
          
          
          
          
          echo '</p><h3>Offsite Link</h3>';

	  // If no offsite link, show 'None' or just keep blank

	  if (is_null($row["link"])) {
		echo "None.";
	  } else {
       		echo '<p><a href="'.$row["link"].'">Click here</a></p>';
	  }
          

	// add a delete button ONLY IF the current logged in username = username of person who uploaded post

	echo "<p style='text-align:right'>";
   	 if(isset($_SESSION["loggedin"]) ?? 'false' || $_SESSION["loggedin"] == true){
		if (($_SESSION["username"]) == $row["owner"]) {
   		 echo "delete me!<br/>";
		 echo '<button>Delete post</button.';

		// delete function needs to remove post from database,
		// all info from related tables (tags, etc),
		// and also remove both image and thumbnail from storage.
		// Also include an 'are you sure?' message.


		}
   	 } else {
		echo "not yours! (replace with empty when finished)";
	 }

	echo "</p>";

        }
      }
      ?>

      
    </div>
    
    
  </div>
  </body>
  
</html>