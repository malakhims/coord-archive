<?php
	
	// config
	require 'config.php';
    
	// show errors
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);   

	// checking if files were uploaded and displays note for user
    $uploaded_filenames = '';
	if ($_FILES != null) {
      if ($_FILES['files']['name'] != null) { 
          // TODO: Process uploaded files.
          // Easy to do yourself with a little help from Google: 
		  // https://www.google.com/search?q=php+upload+multiple+files+with+single+file+input
        
        
        


          // upload image to folder
        
        	// directory for fullsize img
            $target_dir = "items/";
        	$filenoext = explode('.', $_FILES['files']['name']);
            $target_file = $target_dir . basename($_FILES['files']['name']);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
            // Check if image file is a actual image or fake image
             
            if(isset($_POST["submit"])) {
              $check = getimagesize($_FILES['files']['name']);
              if($check !== false) {
                echo "File is an image.";
                $uploadOk = 1;
              } else {
                echo "File is not an image.";
                $uploadOk = 0;
              }
            }
            
        
        	// Check if file already exists
            if (file_exists($target_file)) {
              echo "Sorry, file already exists.";
              $uploadOk = 0;
             }
        
        	// Check file size; current max 500KB (500 x 1000 = 500000)
            if ($_FILES['files']["size"] > 500000) {
              echo "Sorry, your file is too large.";
              $uploadOk = 0;
            }
        
        	// Allow certain file formats: only jpg, png, gif
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
              echo "Sorry, only JPG, JPEG, PNG, & GIF files are allowed.";
              $uploadOk = 0;
            }
        
        	// Check if $uploadOk is set to 0 by an error
            if ($uploadOk != 1) {
              echo "Sorry, your file was not uploaded due to a file error.";
            // if everything is ok, try to upload file
            } else {
              
              
          // create thumb and save
          // add text to database
              
              
            // actual moving of file
              if (move_uploaded_file($_FILES['files']['tmp_name'], $target_file) != false) {
                
                
                //thumb after upload
                           
                /**
                * Resize an image and keep the proportions
                * @author Allison Beckwith <allison@planetargon.com>
                * @param string $filename
                * @param integer $max_width
                * @param integer $max_height
                * @return image
                */
                
                function resizeImage($filename, $max_width, $max_height)
                {
                    list($orig_width, $orig_height) = getimagesize($filename);

                    $width = $orig_width;
                    $height = $orig_height;

                    /*# taller
                    if ($height > $max_height) {
                        $width = ($max_height / $height) * $width;
                        $height = $max_height;
                    }

                    # wider
                    if ($width > $max_width) {
                        $height = ($max_width / $width) * $height;
                        $width = $max_width;
                    }
                    */
                  
                    $image_p = imagecreatetruecolor( intval($width), intval($height));                                    

                    switch(mime_content_type($filename)) {
                      case 'image/png':
                        $img = imagecreatefrompng($filename);
                        break;
                      case 'image/gif':
                        $img = imagecreatefromgif($filename);
                        break;
                      case 'image/jpeg':
                        $img = imagecreatefromjpeg($filename);
                        break;
                      case 'image/bmp':
                        $img = imagecreatefrombmp($filename);
                        break;
                      default:
                        $img = null; 
                      }
                      return $img;                

                    imagecopyresampled($image_p, $img, 0, 0, 0, 0, 
                                                     $width, $height, $orig_width, $orig_height);
                    return $image_p;
                }
                
                // saving thumb as JPEG in the thumb folder
                $thumb = resizeImage($target_file, 150, 150);
                $thumb = imagescale($thumb, 150);
                $thumbdir = 'items/thumb/';
                $target_thumb = $thumbdir . $filenoext[0] . '.jpg';
                imagejpeg($thumb, $target_thumb);
                
                // test what output looks like, remove later
                // echo '<img src="'.$target_thumb.'">';
                

                // success message
                $uploaded_filenames = 'Successfully uploaded; view your new post here [link].<br/><br/>';
              } else {
                echo "Sorry, there was an error moving your file.";
              }
            }
       
      } else {
      }
 	}

	// define variables for form and set to empty values
	// isset check for each variable to prevent error
    $file = $tile = $notes = $tags = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (isset($_POST["files[]"])) {
      	$file = test_input($_POST["files[]"]);
      }
      if (isset($_POST["posttitle"])) {
      	$title = test_input($_POST["posttitle"]);
      }
      if (isset($_POST["postnotes"])) {
      	$notes = test_input($_POST["postnotes"]);
      }
      if (isset($_POST["posttags"])) {
      	$tags = test_input($_POST["posttags"]);
      }
    }

	// function to clean submitted data IF data is defined
    function test_input($data) {
      if ($data != null) {
      	$data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload Mockup</title>
    
    <style>
        input {
            border:2px solid #CCC;
            background-color:#fafafa;
            width:90%;
            padding:8px;
            border-radius:15px;
        }
      
      input[type="text"] {
      height:120px
      }
      
      input[type="submit"] {
      padding:5px;
      border:2px solid black;
      cursor:pointer
      }
      
    </style>
    
</head>

<body>
    
    
      <?php echo $uploaded_filenames; ?>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
      <div id="uploadMain" style="display:flex; flex-direction:row; margin:auto; text-align:center; justify-content:space-around; width:90%; flex-wrap:wrap">
        <div id="uploadLeft" style="width:33%">
          <div id="uploadPreview" style="width:90%; border-radius:25px; background-color:#CCC; padding:10px; min-height:500px; min-width:250px; display:flex; flex-direction:column; justify-content:space-around">              
            <div class="box">
                <label>
                  <strong>*Choose a file</strong>
                  <span>or drag it here</span>
                  <br/>
                  <br/>
                  <img id="preview" alt="Preview the file you're uploading." src="glyphs/addphoto.png" style="max-width:200px; max-height:200px" />
                  <br/>
                  <br/>
                  <input onchange="loadFile(event)" id="fileInp" class="box__file" type="file" name="files" accept="image/*" />
                </label>
                <div class="file-list"></div>
                <br/>
                <div id="mult"></div>
                <br/>
              </div>
              <input type="submit">
          </div>
        </div>
        
        
        <div id="uploadRight" style="width:66%; min-width:500px">
          <p>
            *Title
          </p>
          <input type="text" id="posttitle">

          <p>
            Notes
          </p>
          <input type="text" id="postnotes">


          <p>
            Tags (drop down? comma separated?)
          </p>
          <input type="text" id="posttags">

        </div>
        
        
      </div>  
      </form>
                
         


        
    
    
    
    
    <script>

        const box = document.querySelector('.box');
        const fileInput = document.querySelector('[name="files"');
        const selectButton = document.querySelector('label strong');
        const fileList = document.querySelector('.file-list');

        let droppedFiles = [];

      	// draggable
        [ 'drag', 'dragstart', 'dragend', 'dragover', 'dragenter', 'dragleave', 'drop' ].forEach( event => box.addEventListener(event, function(e) {
            e.preventDefault();
            e.stopPropagation();
        }), false );

        [ 'dragover', 'dragenter' ].forEach( event => box.addEventListener(event, function(e) {
            box.classList.add('is-dragover');
        }), false );

        [ 'dragleave', 'dragend', 'drop' ].forEach( event => box.addEventListener(event, function(e) {
            box.classList.remove('is-dragover');
        }), false );

        box.addEventListener('drop', function(e) {
            droppedFiles = e.dataTransfer.files;
            fileInput.files = droppedFiles;
            updateFileList();
        }, false );

        fileInput.addEventListener( 'change', updateFileList );
        fileInput.addEventListener( 'change', loadFile );
		
      
      	// previews selected file for user + warn for mult files
        function updateFileList() {
            const filesArray = Array.from(fileInput.files);
            if (filesArray.length > 1) {
                fileList.innerHTML = `<p>Selected file: ${filesArray[0].name}</p>`;
                document.getElementById('preview').src = window.URL.createObjectURL(filesArray[0]);
                document.getElementById('mult').innerHTML = "If you have selected multiple files, only the image previewed above will be uploaded.";
            } else if (filesArray.length == 1) {
                fileList.innerHTML = `<p>Selected file: ${filesArray[0].name}</p>`;
                document.getElementById('preview').src = window.URL.createObjectURL(filesArray[0]);
            } else {
                fileList.innerHTML = '';
            }
        }
      
      			
        
        
        


    </script>
    
</body>
</html>