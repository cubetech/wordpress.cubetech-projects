jQuery(function(jQuery) {
	
	jQuery('.cubetech-upload-project-button').click(function(e) {

		e.preventDefault();
		frame = wp.media({
			frame: 'post',
			multiple : true, // set to false if you want only one image
			library : { type : 'image'},
		});
		frame.on('close',function(data) {
			var imageArray = [];
			var counter = 1;
			if ( jQuery('.cubetech-preview-image').size() >= 1 ) {
				counter = jQuery('.cubetech-preview-image').size()+1;
			}
			images = frame.state().get('selection');
			images.each(function(image) {
	
				var emptyPreviewImageExist =  jQuery('.cubetech-preview-image[src=""]').size();
				var emptyUploadImageExist =  jQuery('.cubetech-upload-image[src=""]').size();
				var lastPreviewImage = jQuery('.cubetech-preview-image').last();
				var lastUploadImage = jQuery('.cubetech-upload-image').last();
				
				if ( emptyUploadImageExist == 0 && emptyPreviewImageExist == 0 ) {
					jQuery('#cubetech_projects_movie').parent('td').parent('tr').before('<tr><th><label for="cubetech_projects_image">Bild'+counter+'</label></th><td><input name="cubetech_projects_image-'+counter+'" type="hidden" class="cubetech-upload-image cubetech-upload-image-'+counter+'" value="" /><img src="" class="cubetech-preview-image cubetech-preview-image-'+counter+' cubetech_projects_image-'+counter+'" alt="" style="max-height: 100px;" /><br /><small><a href="#" class="cubetech-clear-image-button">Bild entfernen</a></small><br clear="all" /><span class="description" style="display: inline-block; margin-top: 5px;"></span></td></tr>');
				}		
					
				var cubetechPreviewImage = jQuery('.cubetech-preview-image[src=""]').first();
				var cubetechUploadField = jQuery('.cubetech-upload-image[value=""]').first();					
											
				cubetechPreviewImage.attr('src', image.attributes.url).fadeIn();
				cubetechUploadField.attr('value', image.attributes.id);		
				
				counter++;
			});
			
			jQuery("#imageurls").val(imageArray.join(",")); // Adds all image URL's comma seperated to a text input
			
				jQuery('.cubetech-clear-image-button').on("click",function() {
				jQuery(this).parent().siblings('.cubetech-upload-image').val('');
				jQuery(this).parent().siblings('.cubetech-preview-image').attr('src','');		
				jQuery(this).parent().siblings('.cubetech-preview-image').fadeOut();
				return false;
			});
			
		});
		
		frame.open()
		
	});
	
	
	jQuery('.cubetech-clear-image-button').on("click",function() {
		jQuery(this).parent().siblings('.cubetech-upload-image').val('');
		jQuery(this).parent().siblings('.cubetech-preview-image').attr('src','');		
		jQuery(this).parent().siblings('.cubetech-preview-image').fadeOut();
		return false;
	});

});


jQuery(document).ready(function(){
	/*Content Buttons Mobile*/

	var contentwidth = jQuery('.content-box').width();
	var imgcount = jQuery(".cubetech-projects > li").size();
	var contentpart = contentwidth / imgcount;	
	
	jQuery('.cubetech-project-progress').width(contentpart);

	jQuery('.cubetech-projects > li').first().addClass('aktiv');
	jQuery('.cubetech-projects > li').hide();    
	jQuery('.cubetech-projects > li.aktiv').show();
	
	jQuery('.button-right-mobile').click(function(){
    	indeximage = jQuery('.cubetech-projects > li.aktiv').index();	
	    jQuery('.cubetech-projects > li.aktiv').removeClass('aktiv').addClass('oldaktiv');    
	    if ( jQuery('.oldaktiv').is(':last-child')) {
			jQuery('.cubetech-projects > li').first().addClass('aktiv');
			position = 0;
	    	jQuery('.cubetech-project-progress').animate({'left': position}, 200);
	    } else{
	        jQuery('.oldaktiv').next().addClass('aktiv');
	        indeximage = jQuery('.cubetech-projects > li.aktiv').index();
	        position = contentpart * indeximage;
	        jQuery('.cubetech-project-progress').animate({'left': position}, 200);
		}
	    jQuery('.oldaktiv').removeClass('oldaktiv');
	    jQuery('.cubetech-projects > li').fadeOut();
	    jQuery('.cubetech-projects > li.aktiv').fadeIn();		        
	});
    jQuery('#right_arrow_projects').click(function(){
    	indeximage = jQuery('.cubetech-projects > li.aktiv').index();	
	    jQuery('.cubetech-projects > li.aktiv').removeClass('aktiv').addClass('oldaktiv');    
	    if ( jQuery('.oldaktiv').is(':last-child')) {
			jQuery('.cubetech-projects > li').first().addClass('aktiv');
			position = 0;
	    	jQuery('.cubetech-project-progress').animate({'left': position}, 200);

	    } else{
	        jQuery('.oldaktiv').next().addClass('aktiv');
	        indeximage = jQuery('.cubetech-projects > li.aktiv').index();
	        position = contentpart * indeximage;
	        jQuery('.cubetech-project-progress').animate({'left': position}, 200);
	        
		}
	    jQuery('.oldaktiv').removeClass('oldaktiv');
	    jQuery('.cubetech-projects > li').fadeOut();
	    jQuery('.cubetech-projects > li.aktiv').fadeIn();	        
	});
		  
	jQuery('#left_arrow_projects').click(function(){
		indeximage = jQuery('.cubetech-projects > li.aktiv').index();	
	    jQuery('.cubetech-projects > li.aktiv').removeClass('aktiv').addClass('oldaktiv');    
	    if ( jQuery('.oldaktiv').is(':first-child')) {
	    	jQuery('.cubetech-projects > li').last().addClass('aktiv');
	    	position = contentpart * (imgcount - 1);
	    	jQuery('.cubetech-project-progress').animate({'left': position}, 200);
	    } else{
		    jQuery('.oldaktiv').prev().addClass('aktiv');
		    indeximage = jQuery('.cubetech-projects > li.aktiv').index();
	        position = contentpart * indeximage;
		    jQuery('.cubetech-project-progress').animate({'left': position}, 200);
	    }
	    jQuery('.oldaktiv').removeClass('oldaktiv');
	    jQuery('.cubetech-projects > li').fadeOut();
	    jQuery('.cubetech-projects > li.aktiv').fadeIn();
    });
    /* Content einblenden */
	jQuery('#projectsmaximize').click(function(){
		jQuery('.content-overlay').css('display','block'); 
		jQuery('#projectsmaximize').animate({ opacity: "0" }, 200);
		jQuery('.content-overlay').animate({ opacity: "1" }, 500, function() { jQuery('#projectsmaximize').css('z-index','999') });
		return false;
	});
	jQuery('#projectsminimize').click(function(){
		jQuery('.content-overlay').animate({ opacity: "0" }, 500, function() { jQuery('#projectsmaximize').css('z-index','1001'); jQuery('.content-overlay').css('display','none'); jQuery('#projectsmaximize').animate({ opacity: "1" }, 200); });
		return false;
	}); 
});
