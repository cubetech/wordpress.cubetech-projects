<?php

function cubetech_projects_create_post_type() {
	register_post_type('cubetech_projects',
		array(
			'labels' => array(
				'name' => __('Projekte'),
				'singular_name' => __('Projekt'),
				'add_new' => __('Projekt hinzufügen'),
				'add_new_item' => __('Neues Projekt hinzufügen'),
				'edit_item' => __('Projekt bearbeiten'),
				'new_item' => __('Neues Projekt'),
				'view_item' => __('Projekt betrachten'),
				'search_items' => __('Projekt durchsuchen'),
				'not_found' => __('Keine Projekte gefunden.'),
				'not_found_in_trash' => __('Keine Projekte gefunden.')
			),
			'capability_type' => 'post',
			'taxonomies' => array('cubetech_projects_group'),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array('slug' => 'Projekte', 'with_front' => false),
			'show_ui' => true,
			'menu_position' => '20',
			'menu_icon' => null,
			'hierarchical' => true,
			'supports' => array('title', 'editor')
		)
	);
	flush_rewrite_rules();
}

add_action('init', 'cubetech_projects_create_post_type');

?>
