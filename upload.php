<?php
		
   $max_filesize = 2097152; // Maximum filesize in BYTES.
	 $allowed_filetypes = array('.jpg','.jpeg','.gif','.png'); // These will be the types of file that will pass the validation.
	 $filename = $_FILES['userfile']['name']; // Get the name of the file (including file extension).
	 $ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // Get the extension from the filename.
	 $file_strip = str_replace(" ","_",$filename); //Strip out spaces in filename
	 //$upload_path = '/path/to/uploads/'; //Set upload path
	 $upload_path = '/home/gfclubne/public_html/perevozki/images/transport/'; //Set upload path
	 
	 // Check if the filetype is allowed, if not DIE and inform the user.
	if(!in_array($ext,$allowed_filetypes)) {
	 		die('<div class="error">The file you attempted to upload is not allowed.</div>');
	}
   // Now check the filesize, if it is too large then DIE and inform the user.
   if(filesize($_FILES['userfile']['tmp_name']) > $max_filesize) {
      die('<div class="error">The file you attempted to upload is too large.</div>');
 	}
   // Check if we can upload to the specified path, if not DIE and inform the user.
   if(!is_writable($upload_path)) {
      //die('<div class="error">You cannot upload to the /uploads/ folder. The permissions must be changed.</div>');
      die('<div class="error">You cannot upload to the '.$upload_path.' folder. The permissions must be changed.</div>');
	}
	$new_filename = md5(time).$ext;
	 // Move the file if eveything checks out.
	 if(move_uploaded_file($_FILES['userfile']['tmp_name'],$upload_path . $new_filename)) {
      echo '<div class="success">'. $file_strip .' uploaded successfully</div>'; // It worked.
    } else {
      echo '<div class="error">'. $file_strip .' was not uploaded.  Please try again.</div>'; // It failed :(.
 }
?>
