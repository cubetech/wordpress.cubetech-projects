jQuery(function(jQuery) {
	
	jQuery('.cubetech-upload-project-button').click(function(e) {
		
		var cubetechPreviewImage = jQuery(this).siblings('.cubetech-preview-image');
		var cubetechUploadField = jQuery(this).siblings('.cubetech-upload-image');
		
		e.preventDefault();
		frame = wp.media({
			frame: 'post',
			multiple : true, // set to false if you want only one image
			library : { type : 'image'},
		});
		frame.on('close',function(data) {
			var imageArray = [];
			images = frame.state().get('selection');
			images.each(function(image) {
				cubetechPreviewImage.attr('src', image.attributes.url).fadeIn();
				cubetechUploadField.attr('value', image.attributes.id);
			});
			
			jQuery("#imageurls").val(imageArray.join(",")); // Adds all image URL's comma seperated to a text input
		});
		
		frame.open()
		
	});
	
	jQuery('.cubetech-clear-image-button').click(function() {
		jQuery(this).parent().siblings('.cubetech-upload-image').val('');
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
	jQuery('#content-maximize').click(function(){
		jQuery('.content-overlay').css('display','block'); 
		jQuery('#maximize').animate({ opacity: "0" }, 200);
		jQuery('.content-overlay').animate({ opacity: "1" }, 500, function() { jQuery('#maximize').css('z-index','999') });
		return false;
	});
	jQuery('#content-minimize').click(function(){
		jQuery('.content-overlay').animate({ opacity: "0" }, 500, function() { jQuery('#maximize').css('z-index','1001'); jQuery('.content-overlay').css('display','none'); jQuery('#maximize').animate({ opacity: "1" }, 200); });
		return false;
	});
	
    
	jQuery(function() {
	    jQuery( "#datepicker" ).datepicker({
	        inline:true,            
	        showOtherMonths: true,
	        altField: "#date-start-value",
	        altFormat: "dd. MM yy",
	        dateFormat: "dd. MM yy",
	        onSelect: function(dateText){
           		jQuery('#date-start-output').html(dateText);
		   	}
		});
	});  
});
