(function($){ 
	$(function(){
		var current_upload_field;
		
		// Open a ThickBox when the "Add Media" button is clicked
		var ml_upload_click = false;
		$('input.media-library-upload').live('click',function () {
			// Get the name of the text field to send file upload data to (stored in REL attribute)
			current_upload_field = $('input[name="' + $(this).attr('rel') + '"]');
			iframe_button_value = ( $(this).attr('alt') ) ? $(this).attr('alt') : 'Add Media';
			
			// Open the media upload Thickbox
			tb_show('Upload or Select Media', 'media-upload.php?post_id=0&type=image&TB_iframe=true');
			
			// Replace "Add to Post" button text after IFRAME loads
			function iframeSetup() {
				var add_button = $('#TB_iframeContent').contents().find('.media-item .savesend input[type=submit], #insertonlybutton');
				if ( add_button.length ) {
					add_button.val(iframe_button_value);
				}
			}
			interval = setInterval(iframeSetup, 500);
			
			// Only trigger send_to_editor customizations for these fields
			ml_upload_click = true;
			
			return false;
		});
		
		// Remove image button
		$('input.media-library-remove').live('click',function () {
			// Get the name of the text field remove the value (stored in REL attribute)
			$('input[name="' + $(this).attr('rel') + '"]').val('');
			
			// Remove the visible image preview
			$(this).parents('td').find('.upload-image-preview').fadeOut(500);
			return false;
		});
		
		// Only send the <img> SRC value to the form field if a custom media library
		// instance is being used
		if ( ml_upload_click ) {
			window.send_to_editor = function (html) {
				// Get the URL of the image from the SRC attr
				imgurl = $('img', html).attr('src');
				
				// Save it to the input field
				current_upload_field.val(imgurl);
				
				// If an image preview doesn't exist add one below the upload field
				if ( $('img[src="' + imgurl + '"]').length <= 0 ) {
					current_upload_field.parent('p').after('<p><img src="' + imgurl + '" class="upload-image-preview" /></p>');
				}
				
				// Close thickbox
				tb_remove();
				
				ml_upload_click = false;
			}
		}
	});
})(jQuery);
