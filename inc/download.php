<?php

	$path_parts = pathinfo($_GET['file']);
	$file_name  = $path_parts['basename'];
	$file_path  = __DIR__ . '/../../../../uploads/' . $file_name;

	if (file_exists($file_path)) {
	    header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename="'.basename($file_path).'"');
	    // header('Expires: 0');
	    // header('Cache-Control: must-revalidate');
	    // header('Pragma: public');
	    // header('Content-Length: ' . filesize($file_path));
		set_time_limit(0);
	    readfile($file_path);
	    exit;
	}
?>
