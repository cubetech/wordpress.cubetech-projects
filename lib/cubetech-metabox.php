<?php

// Add the Meta Box
function add_cubetech_projects_meta_box() {
	init_cubetech_projects_meta_box();
	add_meta_box(
		'cubetech_projects_meta_box', // $id
		'Details des Inhaltes', // $title 
		'show_cubetech_projects_meta_box', // $callback
		'post', // $page
		'normal', // $context
		'high'); // $priority
}

add_action('add_meta_boxes', 'add_cubetech_projects_meta_box');

// Field Array
$prefix = 'cubetech_projects_';

function init_cubetech_projects_meta_box() {

	$args = array( 'posts_per_page' => -1, 'numberposts' => -1, 'post_status' => 'publish', 'post_type' => 'post', 'order' => 'ASC', 'orderby' => 'title' ); 
	$postlist = get_posts( $args );
	
	$args = array( 'posts_per_page' => -1, 'numberposts' => -1, 'post_status' => 'publish', 'post_type' => 'page', 'order' => 'ASC', 'orderby' => 'title' ); 
	$pagelist = get_posts( $args );
	
	$options = array();
	array_push($options, array('label' => 'Keine interne Verlinkung', 'value' => 'nope'));
	array_push($options, array('label' => '', 'value' => false));
	
	array_push($options, array('label' => '----- Beiträge -----', 'value' => false));
	foreach($postlist as $p) {
		array_push($options, array('label' => $p->post_title, 'value' => $p->ID));
	}
	
	array_push($options, array('label' => '', 'value' => false));
	array_push($options, array('label' => '----- Seiten -----', 'value' => false));
	foreach($pagelist as $p) {
		array_push($options, array('label' => $p->post_title, 'value' => $p->ID));
	}
	
	$cubetech_projects_meta_fields = array();
	function getSizeOfImagesProjects() {
		global $post;
		global $cubetech_projects_meta_fields;
		$prefix = 'cubetech_projects_';
		$metaArray = array();
		$post_meta_data = get_post_meta($post->ID);
		for($i = 1; ;$i++)
		{
			
			if(isset($post_meta_data[$prefix.'image-'.$i]))
			{
				//$data = $post_meta_data[$prefix.'image-'.$i];
				$metaArray[] =  array(
					'label' => 'Bild '.$i,
					'desc' => '',
					'id' => $prefix.'image-'.$i,
					'type' => 'image',);
	
			}
			else
			{
				break;
			}
		}
		 
		 
		$cubetech_projects_meta_fields = array_merge($metaArray,array(array(  
		    'label'  => 'Youtube Video ID',  
		    'desc'  => 'Wenn Video Link vorhanden, werden keine Bilder geladen',  
		    'id'    => $prefix.'movie',  
		    'type'  => 'youtube'  
		),
		array(  
		    'label'  => 'PDF Format',  
		    'desc'  => '',  
		    'id'    => $prefix.'radio',  
		    'type'  => 'radio'  
		),
		));
		$cubetech_projects_meta_fields = $metaArray;
	}

}

// The Callback
function show_cubetech_projects_meta_box() {
$prefix = "cubetech_projects_";
getSizeOfImagesProjects();
global $cubetech_projects_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="cubetech_projects_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" /><input class="cubetech-upload-project-button button" type="button" value="Bild auswählen" />';
	
	// Begin the field table and loop
	echo '<table class="form-table">';
	echo '<tr style="display:none;">
				<th><label for="cubetech_projects_movie">Youtube Video ID</label></th>
				<td><input type="text" size="30" value="" id="cubetech_projects_movie" name="cubetech_projects_movie">
							<br><span class="description">Wenn Video Link vorhanden, werden keine Bilder geladen</span></td></tr>';
	
	
	
	$imgcounter = 1;
	foreach ($cubetech_projects_meta_fields as $field) {
		
		
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		
		echo '<tr>
				<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
				<td>';
				switch($field['type']) {
					// text
					case 'text':
						echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
							<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// youtube
					case 'youtube':
						echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
							<br /><span class="description">'.$field['desc'].'</span>';
					break;					
					// textarea
					case 'textarea':
						echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
							<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// select
					case 'select':
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
						foreach ($field['options'] as $option) {

							if($meta == $option['value'] && $option['value'] != '') {
								$selected = ' selected="selected"';
							} elseif ($option['value'] == 'nope') {
								$selected = ' selected="selected"';
							} else {
								$selected = '';
							}
							echo '<option' . $selected . ' value="'.$option['value'].'">'.$option['label'].'</option>';
						}
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
					// image
					case 'image':
						if ($meta) {
							$image = wp_get_attachment_image_src($meta, 'medium');
							$image = '<img src="' . $image[0] . '" class="cubetech-preview-image cubetech-preview-image-' . $imgcounter . ' ' . str_replace($prefix, '', $field['id']) . '" alt="' . $field['id'] . '" style="max-height: 100px;" /><br /><a href="#" class="cubetech-clear-image-button">Bild entfernen</a>';
						} else {
							$image = '<img src="" class="cubetech-preview-image cubetech-preview-image-' . $imgcounter . '" alt="" style="max-height: 100px;" /><br />';
						}
						
						echo '<div class="cubetech-projects-infosection">
						<input name="' . $field['id'] . '" type="hidden" class="cubetech-upload-image cubetech-upload-image-' . $imgcounter . '" value="' . $meta . '" />
						' . $image . '
						
						</div><div class="cubetech-projects-deletesection" style="display: none;" ><p>Bild entfernt</p></div>';
						$imgcounter++;
					break;
					case 'radio':/*
						echo '<div style="display:none;">';
						if($meta == 5)
						{
							echo '4 Bilder <input type="radio" name="'.$field['id'].'" id="'.$field['id'].'" value="4" />';
						    echo '5 Bilder <input type="radio" name="'.$field['id'].'" id="'.$field['id'].'" value="5" checked="checked" />
							<br /><span class="description">'.$field['desc'].'</span>';
						}
						else if($meta = 4)
						{
							echo '4 Bilder <input type="radio" name="'.$field['id'].'" id="'.$field['id'].'" value="4" checked="checked" />';
						    echo '5 Bilder <input type="radio" name="'.$field['id'].'" id="'.$field['id'].'" value="5" />
							<br /><span class="description">'.$field['desc'].'</span>';
						}
						else
						{
							echo '4 Bilder <input type="radio" name="'.$field['id'].'" id="'.$field['id'].'" checked="checked" value="4" />';
						    echo '5 Bilder <input type="radio" name="'.$field['id'].'" id="'.$field['id'].'" value="5" />
							<br /><span class="description">'.$field['desc'].'</span>';
						}
						echo "</div>";	*/
					break;
				} //end switch
		echo '</td></tr>';
	} // end foreach
	echo '</table>'; // end table
}

// Save the Data
function save_cubetech_projects_meta($post_id) {
    global $cubetech_projects_meta_fields;
    $prefix = "cubetech_projects_";
    
   
	// verify nonce
	if (!wp_verify_nonce($_POST['cubetech_projects_meta_box_nonce'], basename(__FILE__))) 
		return $post_id;
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
	}
	
	for($i = 1;; $i++)
	{ 
	
		if(!delete_post_meta($post_id,$prefix.'image-'.$i))
			break;
		
	}
	$savecounter = 1;
	for($i = 1;;$i++) {
	
		if (isset($_POST[$prefix.'image-'.$i])) {	
			
			if( $_POST[$prefix.'image-'.$i] == '' ) {
				continue;
			} else {	
				add_post_meta($post_id,$prefix.'image-'.$savecounter, $_POST[$prefix.'image-'.$i]);
				$savecounter++;		
			}	
		} else {
			break;
		}
	}
	
	if (isset($_POST[$prefix.'movie'])) {		
		update_post_meta($post_id,$prefix.'movie', $_POST[$prefix.'movie']);	
	}	
	if (isset($_POST[$prefix.'radio'])) {		
		update_post_meta($post_id,$prefix.'radio', $_POST[$prefix.'radio']);	
	}	
}
add_action('save_post', 'save_cubetech_projects_meta');  