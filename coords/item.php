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
  <div id="header" style="width:auto; border-bottom:1px solid black; margin:10px">
  	<p></p>
  </div>
  
  
  <div id="main" style="margin:auto; max-width:80%; display:flex; flex-direction:row; flex-wrap:wrap; gap:10px%; justify-content:space-around">
  
  	<div id="left" style="width:25%; min-width:200px; background-color:#0000FF50; height:500px">

      <?php
      $result = $link->query($sql);
      
      if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          echo '<img class="itemview" src="items/';
          echo $row["img"];
          echo '"/>';
          
          echo '<p><a href="browse.php">Back to browse</a></p>';
          
          echo '</div>
          <div id="right" style="width:70%; min-width:500px; background-color:#00FF0050; height:500px;">
          
          <p>'.$row["name"].'</p>';
          echo '<p class="subtext">Submitted by '.$row["owner"].'</p>';
          
          echo '<p>Brand name: '.$row["brandname"].'</p>';
          echo '<p>Release year: '.$row["year"].'</p>';
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
          echo '<p><a href="'.$row["link"].'">Click here</a></p>';
          
        }
      }
      ?>

      
    </div>
    
    
  </div>
  </body>
  
</html>