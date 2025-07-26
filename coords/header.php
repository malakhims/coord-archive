<?php
// Initialize the session
session_start();
?>

<div id="header" style="">
<p style="text-align:left; padding:10px; padding-bottom:10px">
    <a href="browse.php">[logo here]</a>
    <br/>
    
    <?php 
    
    // only show if LOGGED OUT
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo '<a href="login.php">Log In</a>';
    }
    
    // only show if LOGGED IN
    if(isset($_SESSION["loggedin"]) ?? 'false' || $_SESSION["loggedin"] == true){
    echo 'Currently signed in as <b>';
    echo htmlspecialchars($_SESSION["username"]);
    echo '</b> | <a href="logout.php">Logout</a>';
    echo '</b> | <a href="upload.php">Upload</a>';
    }

    // ALWAYS show
    echo ' | <a href="info.php">About</a> | <a href="browse.php">Browse</a>';
	
    ?>

                                                                                                                
  </p>
</div>