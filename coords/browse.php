<?php 
require 'config.php';
?>

<html>
  
<head>
<meta charset="ISO-8859-1"> 
<link rel="stylesheet" href="style.css">
<title>Browse</title>

<style>

	.card {
	width:200px;
	height:250px;
	border: 1px solid black;
	border-radius:3px;
    background:white;
}

	.cardtitle {
	text-align:center;
	height:36px;
	line-height:36px;
	margin:0px;
}

	.cardinfo {
	height:32px;
	line-height:32px;
	margin:0px
}
  
    .cardimg {
    width:150px; 
    height:150px; 
    margin:auto;
    text-align:center
    }

	.toitem {
	height:32px;
	line-height:32px;
	margin:0px

}

</style>

</head>

<body>
<?php include "header.php" ?>
  
  <div id="main" style="margin:auto; max-width:80%; display:flex; flex-direction:row; flex-wrap:wrap; gap:10px%; justify-content:space-around">
  	<div id="left" style="width:25%; min-width:200px; background-color:#0000FF50; height:500px">

	<p>
	Search info will go here
	</p>

	<p style="text-align:left">
	 <details>
 	 	<summary>Sort by date...</summary>
 	 	<p>
		<a href="?date=new">Latest first</a><br/>
		<a href="?date=old">Earliest first</a><br/>
		</p>
	</details> 
	- Search by date (most recent or oldest)<br/>
	- Search by item (?)<br/>
	- Search by color<br/>
	- Search by brand<br/>
	- Search by tag<br/>
	- User search? Probably not needed bc you will be able to click on ppl's user profile
	</p>


  	</div>
  	
  	
  	<div id="right" style="width:70%; min-width:500px; background-color:#00FF0050; height:500px; display:flex; flex-direction:row; flex-wrap:wrap">
      
      <?php
      
      /* Attempt to connect to MySQL database */
      $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

      // Check connection
      if($link === false){
          die("ERROR: Could not connect. " . mysqli_connect_error());
      } 
      
       // find out how many rows are in the table 
      $sql = "SELECT COUNT(*) FROM post";
      $result = $link->query($sql) or trigger_error("SQL", E_USER_ERROR);
      $r = mysqli_fetch_row($result);
      $numrows = $r[0];
      
// PAGINATION 
     
      // number of rows to show per page
      $rowsperpage = 20;
      // find out total pages
      $totalpages = ceil($numrows / $rowsperpage); 
      // echo $totalpages; ;; TEST

      // get the current page or set a default
      if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
         // cast var as int
         $currentpage = (int) $_GET['currentpage'];
      } else {
         // default page num
         $currentpage = 1;
      } // end if

      // if current page is greater than total pages...
      if ($currentpage > $totalpages) {
         // set current page to last page
         $currentpage = $totalpages;
      } // end if
      // if current page is less than first page...
      if ($currentpage < 1) {
         // set current page to first page
         $currentpage = 1;
      } // end if

      // the offset of the list, based on current page 
      $offset = ($currentpage - 1) * $rowsperpage;
      
// END PAGINATION
      
// BUILD ITEM LIST
      
      $sql = "SELECT * FROM post ORDER BY id DESC LIMIT $offset, $rowsperpage;";
		$result = $link->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
        
  echo '<div class="card">';
  echo '<p class="cardtitle">'.$row["name"].'</p>';
  echo '<div class="cardimg" style="">';
  echo '<img src="'.$row["thumb"].'" style="max-width:150px; max-height:150px;"/>
  			</div>
  			<p class="cardinfo">Info</p>
  			<p class="toitem">
  				<a href="item.php?id='.$row["id"].'">View Item</a>
  			</p>';
  echo '</div>';

  }
}
      
/******  build the pagination links ******/
// COPY THIS INFO FROM WEBRING MEM'S LIST WHEN OVER 20 ITEMS ADDED
    
    $link->close();
    
    ?> 
      
  	</div>
  	
  </div>
  
</body>
  
  
  
</html>