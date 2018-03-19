<?php

// print_r($_FILES);

// if (isset($_FILES['file_upload']) && !empty($_FILES['file_upload'])) {
//
//     $uploads_dir = "uploads";
//     $validextensions = array("jpeg", "jpg", "png");
//     $temporary = explode(".", $_FILES["file_upload"]["name"]);
//     print_r($temporary);
//     $file_extension = end($temporary);
//     foreach ($_FILES["file_upload"]["error"] as $key => $error) {
//         if ($error == UPLOAD_ERR_OK) {
//
//             $tmp_name = $_FILES["file_upload"]["tmp_name"][$key];
//             // basename() may prevent filesystem traversal attacks;
//             $name = basename($_FILES["file_upload"]["name"][$key]);
//
//             if(($_FILES['file_upload']['type'][$key] == "image/png") || ($_FILES['file_upload']['type'][$key] == "image/jpeg") || ($_FILES['file_upload']['type'][$key] == "image/jpg") && in_array($file_extension, $validextensions)){
//
//                 if($_FILES['file_upload']['size'][$key] < 1000000){
//
//                     move_uploaded_file($tmp_name, "$uploads_dir/$name");
//                     echo $name . " = Successfully Uploaded<br>";
//
//                 } else {
//
//                     echo $name . " = Exceeds maximum upload size<br>";
//
//                 }
//
//             } else {
//
//                 echo $name . " = Unsupported filetype<br>";
//
//             }
//         }
//     }
// } else {
//     echo 'Please choose at least one file';
// }

// if (isset($_FILES['file_upload']) && !empty($_FILES['file_upload'])) {
//
//     $uploads_dir = "uploads";
//     $validextensions = array("jpeg", "jpg", "png");
//     $temporary = explode(".", $_FILES["file_upload"]["name"]);
//     print_r($temporary);
//     $file_extension = end($temporary);
//     foreach ($_FILES["file_upload"]["error"] as $key => $error) {
//         if ($error == UPLOAD_ERR_OK) {
//
//             $tmp_name = $_FILES["file_upload"]["tmp_name"][$key];
//             // basename() may prevent filesystem traversal attacks;
//             $filename = basename($_FILES["file_upload"]["name"][$key]);
//
//             if(($_FILES['file_upload']['type'][$key] == "image/png") || ($_FILES['file_upload']['type'][$key] == "image/jpeg") || ($_FILES['file_upload']['type'][$key] == "image/jpg") && in_array($file_extension, $validextensions)){
//
//                 if($_FILES['file_upload']['size'][$key] < 1000000){
//
//                     move_uploaded_file($tmp_name, "$uploads_dir/$name");
//                     echo $name . " = Successfully Uploaded<br>";
//
//                 } else {
//
//                     echo $name . " = Exceeds maximum upload size<br>";
//
//                 }
//
//             } else {
//
//                 echo $name . " = Unsupported filetype<br>";
//
//             }
//         }
//     }
// } else {
//     echo 'Please choose at least one file';
// }
//
// //Сheck that we have a file
// if((!empty($_FILES["uploaded_file"])) && ($_FILES['uploaded_file']['error'] == 0)) {
//   //Check if the file is JPEG image and it's size is less than 350Kb
//   $filename = basename($_FILES['uploaded_file']['name']);
//   $ext = substr($filename, strrpos($filename, '.') + 1);
//   if (($ext == "jpg") && ($_FILES["uploaded_file"]["type"] == "image/jpeg") &&
//     ($_FILES["uploaded_file"]["size"] < 350000)) {
//     //Determine the path to which we want to save this file
//       $newname = dirname(__FILE__).'/upload/'.$filename;
//       //Check if the file with the same name is already exists on the server
//       if (!file_exists($newname)) {
//         //Attempt to move the uploaded file to it's new place
//         if ((move_uploaded_file($_FILES['uploaded_file']['tmp_name'],$newname))) {
//            echo "It's done! The file has been saved as: ".$newname;
//         } else {
//            echo "Error: A problem occurred during file upload!";
//         }
//       } else {
//          echo "Error: File ".$_FILES["uploaded_file"]["name"]." already exists";
//       }
//   } else {
//      echo "Error: Only .jpg images under 350Kb are accepted for upload";
//   }
// } else {
//  echo "Error: No file uploaded";
// }

// die(json_encode(array('message' => 'ERROR', 'code' => 1337)));

// $tmpName = $_FILES['file_upload']['tmp_name'];
// $mircotime = round(microtime(true));
// $name = basename($_FILES['file_upload']['name']);
// mkdir(__DIR__ . "/../../../../uploads/$mircotime");
// move_uploaded_file($tmpName, __DIR__ . "/../../../../uploads/$mircotime/$name");

$id = 1;
$allowed_types = ['image/jpg', 'image/png', 'image/jpeg', 'audio/x-m4a'];
$allowed_file_extensions = array('.jpg', '.jpeg', '.gif', '.png', '.m4a');
$mircotime = round(microtime(true));
$dir_name = __DIR__ . '/../../../../../uploads/' . $mircotime;
$zip_name = 'renamedfiles_' . $mircotime . '.zip';
mkdir($dir_name);

foreach ($_FILES['file_upload']['error'] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {

		$tmp_name = $_FILES['file_upload']['tmp_name'][$key];

		$name = basename($_FILES['file_upload']['name'][$key]);

		$uploaded_name = $_FILES['file_upload']['name'][$key];

		$size = $_FILES['file_upload']['size'][$key];

		$type = $_FILES['file_upload']['type'][$key];

		$file_extension = strtolower(strrchr($uploaded_name, "."));

		$new_name = $id . '-' . mt_rand() . $file_extension;

		if  (!is_uploaded_file($tmp_name))   {
			array_map('unlink', glob("$dir_name/*.*"));
			rmdir($dir_name);
			die("ERROR: Not a valid file upload");
		}

		if  ($size == 0)  {
			array_map('unlink', glob("$dir_name/*.*"));
			rmdir($dir_name);
			die("ERROR: Zero byte file not allowed");
		}
		if  ($size > 3)  {
			array_map('unlink', glob("$dir_name/*.*"));
			rmdir($dir_name);
			die("ERROR: File too big");
		}
		// Be sure we're dealing with an upload
		// if (is_uploaded_file($_FILES['upload']['tmp_file']) === false) {
		// 	throw new \Exception('Error on upload: Invalid file definition');
		// }
		if  (!in_array($type, $allowed_types)) {
			array_map('unlink', glob("$dir_name/*.*"));
			rmdir($dir_name);
			die("ERROR: Not allowed file type");
		}

		// Check that the uploaded file is actually an image
		if (!in_array($file_extension, $allowed_file_extensions)) {
			array_map('unlink', glob("$dir_name/*.*"));
			rmdir($dir_name);
			die("ERROR: Not allowed extension");
		}

		move_uploaded_file($tmp_name, "$dir_name/$name");

		$id++;
    } else {
		echo $_FILES['file_upload']['error'][$key];
	}
}

// Create ZipArchive
$zip = new ZipArchive();
$ret = $zip->open('../download/' . $zip_name, ZipArchive::OVERWRITE | ZipArchive::CREATE);
if ($ret !== TRUE) {
    printf('Failed with code %d', $ret);
} else {
    $options = array('add_path' => 'renamedfiles/', 'remove_all_path' => TRUE);
    $zip->addGlob($dir_name . '/*', GLOB_BRACE, $options);
    $zip->close();
	echo $zip_name;
}

array_map('unlink', glob("$dir_name/*.*"));
rmdir($dir_name);

?>
