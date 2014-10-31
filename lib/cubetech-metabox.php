<?php

// Add the Meta Box
function add_cubetech_projects_meta_box() {
	init_cubetech_projects_meta_box();
	add_meta_box(
		'cubetech_projects_meta_box', // $id
		'Details des Inhaltes', // $title 
		'show_cubetech_projects_meta_box', // $callback
		'cubetech_projects', // $page
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
		
		global $wpdb;

		$results = $wpdb->get_results( 'SELECT * FROM `wp_postmeta` WHERE `post_id` = '.$post->ID.' AND `meta_key` LIKE \'%cubetech_projects_image%\''  );
		
		$results = array_reverse($results);
		
		$i = 1;
		foreach($results as $result):

				$metaArray[] =  array(
					'label' => 'Bild '.$i,
					'desc' => '',
					'id' => $result->meta_key,
					'type' => 'image',);
			
				$i++;

		endforeach;	
		
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
	}

}

// The Callback
function show_cubetech_projects_meta_box() {

getSizeOfImagesProjects();
global $cubetech_projects_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="cubetech_projects_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" /><input class="cubetech-upload-project-button button" type="button" value="Bild auswählen" />';
	
	// Begin the field table and loop
	echo '<table class="form-table">';
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
							$meta = json_decode($meta, true);
							
							
							//var_dump($meta);exit;
							
							if(is_array($meta) == false)
							{
								$imageVal = $meta;
							} else {
								$imageVal = $meta['img'];
							}
							
							$image = wp_get_attachment_image_src($imageVal, 'medium');
							
							$image = '<img src="' . $image[0] . '" class="cubetech-preview-image cubetech-preview-image-' . $imgcounter . ' ' . str_replace($prefix, '', $field['id']) . '" alt="' . $field['id'] . '" style="max-height: 100px;" /><br />';
							
							if($meta['inpdf'] == 'on')
							{	
								$image .= '<input name="cubetech_projects-inpdf-'.$imgcounter.'" type="checkbox" checked="checked" class="cubetech-upload-inpdf cubetech-upload-inpdf-' . $imgcounter . '" /> In PDF<br />';
							} else {
								$image .= '<input name="cubetech_projects-inpdf-'.$imgcounter.'" type="checkbox" class="cubetech-upload-inpdf cubetech-upload-inpdf-' . $imgcounter . '" /> In PDF<br />';
							}
							
							if($meta['infrontend'] == 'on')
							{	
								$image .= '<input name="cubetech_projects-infrontend-'.$imgcounter.'" type="checkbox" checked="checked" class="cubetech-upload-infrontend cubetech-upload-infrontend-' . $imgcounter . '" /> Nicht in Frontend anzeigen<br /><a href="#" class="cubetech-clear-image-button">Bild entfernen</a>';
							} else {
								$image .= '<input name="cubetech_projects-infrontend-'.$imgcounter.'" type="checkbox" class="cubetech-upload-infrontend cubetech-upload-infrontend-' . $imgcounter . '" /> Nicht in Frontend anzeigen<br /><a href="#" class="cubetech-clear-image-button">Bild entfernen</a>';
							}
							
						} else {
							$image = '<img src="" class="cubetech-preview-image cubetech-preview-image-' . $imgcounter . '" alt="" style="max-height: 100px;" /><br />';
						}
						
						echo '<div class="cubetech-projects-infosection">
						<input name="' . $field['id'] . '" type="hidden" class="cubetech-upload-image cubetech-upload-image-' . $imgcounter . '" value="' . $imageVal . '" />
						' . $image . '
						
						</div><div class="cubetech-projects-deletesection" style="display: none;" ><p>Bild entfernt</p></div>';
						$imgcounter++;
					break;
					case 'radio':
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
    
	//var_dump($_POST);exit;
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
	
	global $wpdb;

	$results = $wpdb->get_results( 'SELECT * FROM `wp_postmeta` WHERE `post_id` = '.$post_id.' AND `meta_key` LIKE \'%cubetech_projects_image%\''  );

	foreach($results as $result):

		delete_post_meta($post_id,$result->meta_key);

	endforeach;	

	$cnt = 1;
	foreach($_POST as $key => $postimg)
	{
		
		//var_dump($postimg);
		if(strpos($key, 'image') == false)
			continue;
		else {
			if(!$_POST['cubetech_projects-inpdf-'.$cnt])
			{
				$_POST['cubetech_projects-inpdf-'.$cnt] = 'off';
			}
			
			if(!$_POST['cubetech_projects-infrontend-'.$cnt])
			{
				$_POST['cubetech_projects-infrontend-'.$cnt] = 'off';
			}
			
			$postimgs[$cnt]['img'] = $postimg;
			$postimgs[$cnt]['inpdf'] = $_POST['cubetech_projects-inpdf-'.$cnt];
			$postimgs[$cnt]['infrontend'] = $_POST['cubetech_projects-infrontend-'.$cnt];
			
			$cnt++;
		}
		
	}
	//var_dump($postimgs);exit;
	
	
	$i = 1;
	foreach($postimgs as $key => $img) {
		
		if($img['img'] == '')
			continue;
		
		$img = json_encode($img);

		add_post_meta($post_id,$prefix.'image-'.$i, $img);
		
		$i++;
	}
		
	
	
	//exit;
	
	if (isset($_POST[$prefix.'movie'])) {		
		update_post_meta($post_id,$prefix.'movie', $_POST[$prefix.'movie']);	
	}	
	if (isset($_POST[$prefix.'radio'])) {		
		update_post_meta($post_id,$prefix.'radio', $_POST[$prefix.'radio']);	
	}	
}
add_action('save_post', 'save_cubetech_projects_meta');  