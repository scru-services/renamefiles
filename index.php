<?php

		// include the domain information from the root dir
		require '../../inc/browscap.php';
		require '../../inc/domain.php';
		require '../../inc/projects.php';

		// include the project_data from the project dir
		// check this data if you setup a new project
		require 'inc/project_data.php';

		// include the header from the root dir
		require '../../inc/header.php';

?>

	<!-- scru-service start -->

	<div id="loading">
		loading
		<progress id="prog" value="0" max="100" style="width:100%; display:none;">0%</progress>
	</div>

	<div id="fail">
		fail
	</div>
	<h4>Choose Files</h4>
	<form id="upload" class="dropzone" method="post" action="" enctype="multipart/form-data" multipart="">
		<input id="file" type="file" name="file_upload[]" multiple>
		<label for="file"><strong>Choose your image/s</strong><span class="dragndrop"> or drag it/them here</span>.</label>
	</form>

	<form id="renameform" name="renameform" data-visibility="visible">
		<h5 for="renametype">Rename Files:</h5>
		<select id="renametype" name="renametype">
			<option value="replace">replace Text</option>
			<option value="add">Add Text</option>
			<option value="format" selected="selected">Format</option>
		</select>
	</form>

	<form id="replaceform" name="replaceform" data-visibility="hidden">
		<div class="column-6">
			<h5>Find:</h5>
			<input id="toreplace" type="text" onclick="document.execCommand('selectAll',false,null)">
		</div>
		<div class="column-6">
			<h5>Replace with:</h5>
			<input id="replace" type="text" onclick="document.execCommand('selectAll',false,null)">
		</div>
	</form>

	<form id="addform" name="addform" data-visibility="hidden">
		<div class="column-6">
			<h5>Add Text:</h5>
			<input id="add" type="text" onclick="document.execCommand('selectAll',false,null)">
		</div>
		<div class="column-6">
			<h5>Ort:</h5>
			<select name="addplace" id="addplace">
				<option value="after">after name</option>
				<option value="before">before name</option>
			</select>
		</div>

	</form>

	<form id="formatform" name="formatform">
		<div class="column-6">
			<h5>Name Format:</h5>
			<select name="formatkind" id="formatkind">
				<option value="index" selected="selected">Name and Index</option>
				<option value="counter">Name and Counter</option>
			</select>
		</div>
		<div class="column-6">
			<h5>Where:</h5>
			<select name="formatplace" id="formatplace">
				<option value="after">after name</option>
				<option value="before">before name</option>
			</select>
		</div>
		<div class="secondline column-6">
			<h5 for="format">Custom Format:</h5>
			<input id="format" name="format" type="text" value="example_" onclick="document.execCommand('selectAll',false,null)">
		</div>
		<div class="secondline column-6">
			<h5 for="number">Start numbers at:</h5>
			<input id="number" name="number" type="number" value="0" onclick="document.execCommand('selectAll',false,null)">
		</div>
	</form>

	<div id="submit">
		Rename
	</div>
	<div class="result-container" data-visibility="hidden">
		<h4>Sortable Files<div class="clear all">clear list</div></h4>
		<div class="result small align-left" id="sortable" contenteditable="false"></div>
	</div>
	<div class="result-container" data-visibility="hidden">
		<h4>Error Files<div class="clear error">clear list</div></h4>
		<div class="result small align-left" id="error"></div>
	</div>

	<?php
	$days = 1;
	$path = 'download/';

	// Open the directory
	if ($handle = opendir($path))
	{
	    // Loop through the directory
	    while (false !== ($file = readdir($handle)))
	    {
	        // Check the file we're doing is actually a file
	        if (is_file($path.$file))
	        {
	            // Check if the file is older than X days old
	            // if (filemtime($path.$file) < ( time() - ( $days * 24 * 60 * 60 ) ) )
				if (filemtime($path.$file) < ( time() - 3600 ) )
	            {
	                // Do the deletion
	                unlink($path.$file);
	            }
	        }
	    }
	}
	?>

	<!-- scru-service end -->

<?php

	// include the domain information from the root dir
	require '../../inc/footer.php';

?>
