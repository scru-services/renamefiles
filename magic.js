$(document).bind("ajaxSend", function(){
	$("#loading").show();
}).bind("ajaxComplete", function(){
	$("#loading").hide();
 }).bind("ajaxError", function(){
 	$("#fail").show();
});


(function( $ ) {

    var tmp_files = new Array();
	var error_files = new Array();
    var sort_files = new Array();
    var form_data = new FormData();
	var allowed_extensions = new Array("jpg","png", "jpeg", "gif", "m4a");
	var delete_id = 0;


	var list_type = function() {
		if ($('#renametype').val() == 'replace') {
			return false;
		} else if ($('#renametype').val() == 'add') {
			return false;
		} else if ($('#renametype').val() == 'format') {
			return true;
		}
	}


	// List with handle sortable.js
	var list = $('#sortable')[0];
	Sortable.create(list, {
		handle: '.glyphicon-move',
		animation: 100,
		onEnd: function (evt) {
			var new_index = evt['newIndex'];
			var old_index = evt['oldIndex'];
			sort_files.splice(new_index, 0, sort_files.splice(old_index, 1)[0]);
			example();
		},
	});


	$('#renametype, #toreplace, #replace, #add, #addplace, #format, #number, #formatkind, #formatplace, #sortable').on('keyup change', function() {

		example();

	});

	var zeroes = function(number, length) {

		var str = '' + number;
		while (str.length < length) {
			str = '0' + str;
		}

		return str;

	}

	var example = function() {

			if ($('#renametype').val() == 'replace') {

				var to_replace = $('#toreplace').val();

				var replace = $('#replace').val();

				$('.filename').each(function() {

					var name = $(this).attr('filename');

					var file_extension = '.' + name.split('.').pop();

					var name_without_extension = name.slice(0, -file_extension.length);

					$(this).text(name_without_extension.replace(to_replace, replace) + file_extension);

				});

			} else if ($('#renametype').val() == 'add') {

				var add = $('#add').val();

				$('.filename').each(function() {

					var name = $(this).attr('filename');

					var file_extension = '.' + name.split('.').pop();

					if ($('#addplace').val() == 'after') {

						var name_without_extension = name.slice(0, -file_extension.length);

						$(this).text(name_without_extension + add + file_extension);

					} else {

						$(this).text(add + name);

					}

				});

			} else if ($('#renametype').val() == 'format') {

				var formatexample = $('#format').val();

				var numberexample = $('#number').val();

				$('.filename').each(function() {

					var file_extension = '.' + $(this).attr('filename').split('.').pop();

					if ($('#formatkind').val() == 'counter') {

						numberexample = zeroes(numberexample, 5);

					}

					if ($('#formatplace').val() == 'after') {

						$( this ).text(formatexample + numberexample + file_extension);
						// $('.example span').text(formatexample + numberexample + file_extension);

					} else {

						$( this ).text(numberexample + formatexample + file_extension);
						// $('.example span').text(numberexample + formatexample + file_extension);

					}

					numberexample++;

				});

			}

	}


    function validate_fileupload(fileName) {
        var file_extension = fileName.split('.').pop().toLowerCase();

        for(var i = 0; i <= allowed_extensions.length; i++){

            if(allowed_extensions[i]==file_extension){

                return true; // valid file extension
            }
        }

        return false;
    }


	var error = function(index, error) {
		var files = $('#file').prop("files")[index]['name'];

		error_files.push($('#file')[0].files[index]);

		$('#error').parent().attr('data-visibility', 'visible');

		$('#error').append('<div class="file fail">' + files + ' '+error+'</div>');
	}


	var tmp_push = function(){

		var amount = $('#file')[0].files.length;

		for (var i = 0; i < amount; i++) {

			var tmp_length = tmp_files.length;

			var files = $('#file').prop("files")[i]['name'];

			var size = $('#file')[0].files[i].size;

			if (validate_fileupload(files) == true) {

				if (size >= 100000000) {

					error(i, 'ist too big');

				} else if (size == 0) {

					error(i, 'has Zero byte');

				} else {

					tmp_files.push($('#file')[0].files[i]);

					sort_files.push($('#file')[0].files[i]);

					tmp_files[tmp_length]['delete_id'] = delete_id;

					sort_files[tmp_length]['delete_id'] = delete_id;

				}

			} else {

				error(i, 'wrong filetype');

			}

			delete_id++;

		}

	}


	var show_tmp = function() {

		if (tmp_files.length !== 0) {
			$('#sortable').html('').parent().attr('data-visibility', 'visible');
		}

		for (var i = 0; i < tmp_files.length; i++) {

			if (list_type() == true) {
				$('#sortable').append('<div class="file success" delete_id="'+sort_files[i]['delete_id']+'"><div class="glyphicon glyphicon-move" aria-hidden="true"><p>:::</p></div><img src="'+URL.createObjectURL(sort_files[i])+'" style="margin-left: 20px" alt="' + sort_files[i]['name'] + '"><div class="filename sortable" filename="' + sort_files[i]['name'] + '">' + sort_files[i]['name'] + '</div><div class="delete" data-status="off"><p>X</p></div></div>');
			} else {
				$('#sortable').append('<div class="file success" delete_id="'+tmp_files[i]['delete_id']+'"><img src="'+URL.createObjectURL(tmp_files[i])+'" alt="' + tmp_files[i]['name'] + '"><div class="filename" filename="' + tmp_files[i]['name'] + '">' + tmp_files[i]['name'] + '</div><div class="delete" data-status="off"><p>X</p></div></div>');
			}

		}

		example();

	}


	var list_visibility = function(list) {
		if (list.text() !== '') {

			list.parent().attr('data-visibility', 'visible');

		} else {

			list.parent().attr('data-visibility', 'hidden');

		}
	}


	var tmp_delete = function(){

		$('.delete').off().on('click', function() {

			var file_id = parseInt($(this).parent().attr('delete_id'));

			tmp_files = tmp_files.filter(function(el) {
				return el.delete_id !== file_id;
			});

			sort_files = sort_files.filter(function(el) {
				return el.delete_id !== file_id;
			});

			$(this).parent().remove();

			$('#file')[0].value = "";

			example();

			list_visibility($('#sortable'));

		});

	}


	$('.clear.all').on('click', function() {

		tmp_files = new Array();

		sort_files = new Array();

		$('.file.success').remove();

		$('.file.fail').remove();

		$('#file')[0].value = "";

		list_visibility($('#sortable'));

		list_visibility($('#error'));

	});

	$('.clear.error').on('click', function() {

		$('.file.fail').remove();

		list_visibility($('#error'));

	});


    var rename_tmp = function(){

		if (list_type() == true) {
			tmp_files = sort_files;
		}

		for (var i = 0; i < tmp_files.length; i++) {

			new_name = $('[delete_id='+ tmp_files[i]['delete_id'] +']').children('.filename').text();

			form_data.append("file_upload[]", tmp_files[i], new_name);

        }

    }


    $('#upload').change(function() {

        tmp_push();

		show_tmp();

        tmp_delete();

		example();

    });


	$('#renametype').change(function(){
		if (this.value == 'replace') {
			$('[name="addform"], [name="formatform"]').attr('data-visibility', 'hidden');
			$('[name="replaceform"]').attr('data-visibility', 'visible');
		} else if (this.value == 'add') {
			$('[name="replaceform"], [name="formatform"]').attr('data-visibility', 'hidden');
			$('[name="addform"]').attr('data-visibility', 'visible');
		} else if (this.value == 'format') {
			$('[name="replaceform"], [name="addform"]').attr('data-visibility', 'hidden');
			$('[name="formatform"]').attr('data-visibility', 'visible');
		}

		show_tmp();

		tmp_delete();

		example();

	});


    $('#submit').on('click', function(event) {

        event.preventDefault();

        rename_tmp();

        $.ajax({
            url: 'inc/upload.php', // point to server-side PHP script
            dataType: 'html',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
			beforeSend:function()
			{
				$('#prog').show();
				$('#prog').attr('value','0');
				alert('beforeSend');
			},
			xhr: function() {
				var xhr = new window.XMLHttpRequest();
				// Upload progress
				xhr.upload.addEventListener("progress", function(evt){
					if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total * 100;
						//Do something with upload progress
						console.log(percentComplete);
						$('#prog').attr('value',percentComplete);
					}
				}, false);
				return xhr;
			},
            success: function(php_script_response){
				// window.location.href = "download/" + php_script_response;
				$('#loader-icon').hide();
				// alert(php_script_response);
				console.log(php_script_response);
            },
            error: function(php_script_response){
                $('#error').html(php_script_response);
				// console.log(php_script_response);
            }
         });

         // tmp_files = new Array();
         //
         // sort_files = new Array();

		 form_data = new FormData();

    });

}(jQuery));
