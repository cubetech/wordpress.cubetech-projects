jQuery(document).ready(function(){
	jQuery('.form-table > tbody > tr:nth-last-child(2)').addClass('notdraggable');
	jQuery('.form-table > tbody > tr:last-child').addClass('notdraggable');

	
	if (typeof jQuery.ui !== 'undefined')
		jQuery('#cubetech_projects_meta_box .form-table > tbody').sortable({
			items: "tr:not(.notdraggable)"
		});
});