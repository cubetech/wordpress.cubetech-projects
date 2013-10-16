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

wp_enqueue_script('jquery');
wp_register_script('cubetech_projects_js', plugins_url('assets/js/cubetech-projects.js', __FILE__), 'jquery');
wp_enqueue_script('cubetech_projects_js');

add_action('wp_enqueue_scripts', 'cubetech_projects_add_styles');

function cubetech_projects_add_styles() {
	wp_register_style('cubetech-projects-css', plugins_url('assets/css/cubetech-projects.css', __FILE__) );
	wp_enqueue_style('cubetech-projects-css');

}

add_filter( 'template_include', 'cubetech_project_template', 1 );
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
