jQuery(function(jQuery) {
	
	function removeImage() {
		jQuery(this).siblings('.cubetech-upload-image').val('');
		jQuery(this).siblings('img').attr('src' , '');
		jQuery(this).parent('.cubetech-projects-infosection').css('display' , 'none');
		jQuery(this).parent().siblings('.cubetech-projects-deletesection').css('display' , 'block');
		return false;
	}
	
	jQuery('.cubetech-upload-project-button').click(function(e) {

		e.preventDefault();
		frame = wp.media({
			frame: 'post',
			multiple : true, // set to false if you want only one image
			library : { type : 'image'},
		});
		frame.on('close',function(data) {
			var counter = 1;
			if ( jQuery('.cubetech-preview-image').size() >= 1 ) {
				counter = jQuery('.cubetech-preview-image').size()+1;
			}
			images = frame.state().get('selection');
			images.each(function(image) {
			
				var emptyUploadImageExist =  jQuery('.cubetech-upload-image[value=""]').size();

				if ( emptyUploadImageExist == 0 ) {
					jQuery('#cubetech_projects_movie').parent('td').parent('tr').before('<tr><th><label for="cubetech_projects_image">Bild '+counter+'</label></th><td><div class="cubetech-projects-infosection"><input name="cubetech_projects_image-'+counter+'" type="hidden" class="cubetech-upload-image cubetech-upload-image-'+counter+'" value="'+image.attributes.id+'" /><img src="'+image.attributes.url+'" class="cubetech-preview-image cubetech-preview-image-'+counter+' cubetech_projects_image-'+counter+'" alt="" style="max-height: 100px;" /><br /><a href="#" class="cubetech-clear-image-button">Bild entfernen</a></div><div class="cubetech-projects-deletesection" style="display: none" ><p>Bild entfernt</p></div></td></tr>');
					counter++;

				} else if ( emptyUploadImageExist >= 1 )
				{
					jQuery('.cubetech-upload-image[value=""]').first().siblings('img').attr('src' , image.attributes.url);
					jQuery('.cubetech-upload-image[value=""]').first().parent('.cubetech-projects-infosection').css('display' , 'block');
					jQuery('.cubetech-upload-image[value=""]').first().parent().siblings('.cubetech-projects-deletesection').css('display' , 'none');
					jQuery('.cubetech-upload-image[value=""]').first().val(image.attributes.id);
				}		
					

				
			

			});
			jQuery('.cubetech-clear-image-button').on("click", removeImage);	
			
		});
		
		frame.open()
	});
	
	jQuery('.cubetech-clear-image-button').on("click", removeImage);	
	
});


jQuery(document).ready(function(){
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
