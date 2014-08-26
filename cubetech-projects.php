<?php
/**
 * Plugin Name: cubetech Projects
 * Plugin URI: http://www.cubetech.ch
 * Description: cubetech Projects - simple Project view with images
 * Version: 1.0
 * Author: cubetech GmbH
 * Author URI: http://www.cubetech.ch
 */

include_once('lib/cubetech-install.php');
include_once('lib/cubetech-metabox.php');
include_once('lib/cubetech-post-type.php');
include_once('lib/cubetech-settings.php');
include_once('lib/cubetech-group.php');

add_image_size( 'cubetech-projects-icon', 855, 550, true );

add_action( 'admin_enqueue_scripts', 'load_cubetech_projects_admin_style' );
function load_cubetech_projects_admin_style()
{
	wp_register_style('cubetech-jqueryui-css', plugins_url('assets/css/jquery-ui.min.css', __FILE__) );
	wp_enqueue_style('cubetech-jqueryui-css');
	wp_register_style('cubetech-jqueryuistr-css', plugins_url('assets/css/jquery-ui.structure.min.css', __FILE__) );
	wp_enqueue_style('cubetech-jqueryuistr-css');
	wp_register_style('cubetech-projectsadmin-css', plugins_url('assets/css/cubetech-projectsadmin.css', __FILE__) );
	wp_enqueue_style('cubetech-projectsadmin-css');	
	wp_register_script('cubetech_jqueryui_js', plugins_url('assets/js/jquery-ui.min.js', __FILE__), 'jquery');
	wp_enqueue_script('cubetech_jqueryui_js');	
	wp_register_script('cubetech_projectsadmin_js', plugins_url('assets/js/cubetech-projectsadmin.js', __FILE__), 'jquery');
	wp_enqueue_script('cubetech_projectsadmin_js');	
}

add_action('init', 'cubetech_projects_add_styles');



function cubetech_projects_add_styles() {
	wp_register_style('cubetech-projects-css', plugins_url('assets/css/cubetech-projects.css', __FILE__) );
	wp_enqueue_style('cubetech-projects-css');

	wp_enqueue_script('jquery');

	wp_register_script('cubetech_projects_js', plugins_url('assets/js/cubetech-projects.js', __FILE__), 'jquery');
	wp_enqueue_script('cubetech_projects_js');
}


add_filter( 'template_include', 'cubetech_project_template', 1);
function cubetech_project_template($template_path) {
    if ( get_post_type() == 'cubetech_projects' ) {
        if ( is_single() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-project.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/templates/single.php';
            }
        }
    }
    return $template_path;
}

?>
