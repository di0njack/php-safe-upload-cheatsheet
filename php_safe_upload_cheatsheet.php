<!--------------------------------------------------------------------
# DEVELOPED BY Di0nJ@ck - August 2018
--------------------------------------------------------------------->

<?php 
  
   $min_size = '500'; // Minimum size of the file in bytes
   $max_size = '5000'; // Max size of the file in bytes


   if(isset($_FILES['file'])){ 
   
      $file_name = strtolower($_FILES['file']['name']); // FILE NAME
      $file_size = $_FILES['file']['size']; // FILE SIZE
      $file_type = strtolower($_FILES['file']['type']);  // FILE TYPE
      $file_tmp =$_FILES['file']['tmp_name']; // TEMPORAL FILE NAME ON SERVER
      $file_ext = strtolower(end(explode('.',$_FILES['file']['name']))); //FILE EXTENSION
               
     //1 - CHECK THE FILE SIZE
     if ($file['size'] <= $max_size || $file['size'] >= $min_size){ 

            //2 - GENERATE A RANDOM NAME FOR THE FILE
            $length = 10
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                  $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $new_file_name = $randomString

            //3 - WHITE LIST OF ACCEPTED FILE EXTENSIONS
            $whitelist = array(".jpg",".jpeg",".gif",".png", ".bmp"); #IN CASE OF PHOTO UPLOADING, IN OTHER CASE, CUSTOMIZE THIS
            if (!(in_array($file_ext, $whitelist))) {
               die('Please, upload only image files!');
            }

            // 4 - CHECK MIME TYPE
            $pos = strpos($filetype,'image');
            if($pos === false) { 
             die('error 1');
            }
            $imageinfo = getimagesize($_FILES['my_files']['tmp_name']);
            if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg'&& $imageinfo['mime']      != 'image/jpg'&& $imageinfo['mime'] != 'image/png') {
              die('error 2');
            }

            // 5 - MAGIC BYTES Check for magic numbers in the header (first 10-20 bytes of the file)
            
            $handle = @fopen($file_name, 'r');
            if (!$handle)
                throw new Exception('File Open Error');
        
            $types = array('jpeg' => "\xFF\xD8\xFF", 'gif' => 'GIF', 'png' => "\x89\x50\x4e\x47\x0d\x0a", 'bmp' => 'BM', 'psd' => '8BPS', 'swf' => 'FWS');
            $bytes = fgets($handle, 8);
            $found = 'other';
        
            foreach ($types as $type => $header) {
                if (strpos($bytes, $header) === 0) {
                    $found = $type;
                    break;
                }
            }
            fclose($handle);

            // 6 -  STORE THE UPLOAD FILE IN AN ONLY READ FOLDER
            
            move_uploaded_file($file_tmp,'some directoy of your choice');
 
            $uploaddir = 'upload/'.date("Y-m-d").'/' ;

            if (file_exists($uploaddir)) {  
            } else {  
            mkdir( $uploaddir, 0777);  
            }        
      }     
      
}
?>