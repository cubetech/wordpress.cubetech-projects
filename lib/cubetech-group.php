<?php
function cubetech_projects_create_taxonomy() {

	$labels = array(
		'name'                => __( 'Archiv'),
		'singular_name'       => __( 'Archiv' ),
		'search_items'        => __( 'Archive durchsuchen' ),
		'all_items'           => __( 'Alle Archive' ),
		'edit_item'           => __( 'Archiv bearbeiten' ), 
		'update_item'         => __( 'Archiv aktualisiseren' ),
		'add_new_item'        => __( 'Neues Archiv hinzufügen' ),
		'new_item_name'       => __( 'Archiv' ),
		'menu_name'           => __( 'Archiv' )
	);

	$args = array(
		'hierarchical'        => true,
		'labels'              => $labels,
		'show_ui'             => true,
		'show_admin_column'   => true,
		'query_var'           => true,
		'rewrite'             => array( 'slug' => 'cubetech_projects' )
	);

	register_taxonomy( 'cubetech_projects_group', array( 'cubetech_projects' ), $args );
	flush_rewrite_rules();
}
add_action('init', 'cubetech_projects_create_taxonomy');
?>