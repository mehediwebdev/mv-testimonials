<?php
/** 
* Plugin Name: MV Testimonials
* Plugin URI: https://wordpress.org/plugins/mv-testimonials/
* Description: MV Slider is a fully responsive and mobile friendly Coupon generator plugin.
* Version: 1.0.0
* Requires at least: 5.5
* Requires PHP: 5.6
* Author: Mehedi Hasan
* Author URI: www.mehediwebdev.com
* License: GPL3
* License URI: http://www.gnu.org/licenses/gpl.html
* Text Domain: mv-testimonials
* Domain Path: /languages
*/

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}


if( ! class_exists( 'MV_Testimonials' )){
	 class MV_Testimonials{
        function __construct(){
         $this->define_constants();
	      
		 require_once( MV_TESTIMONIALS_PATH . 'post-types/class.mv-testimonials-cpt.php' );
		 $MV_Testimonials_Post_Type = new MV_Testimonials_Post_Type();

		 require_once( MV_TESTIMONIALS_PATH . 'widgets/class.mv-testimonials-widget.php' );
		 $MV_Testimonials_Widget = new MV_Testimonials_Widget();

		 add_filter( 'archive_template', array( $this, 'load_custom_archive_template' ) );
		 add_filter( 'single_template', array( $this, 'load_custom_single_template' ) );

		}

		public function define_constants(){
		
			define( 'MV_TESTIMONIALS_VERSION', '1.0.0' );
			define( 'MV_TESTIMONIALS_PATH', plugin_dir_path(__FILE__) );
			define( 'MV_TESTIMONIALS_URL', plugin_dir_url(__FILE__ ) );
			define( 'MV_TESTIMONIALS_LANGUAGE_PATH', dirname( plugin_basename( __FILE__ ) ) . '/languages' );
			define( 'MV_TESTIMONIALS_OVERRIDE_PATH_DIR', get_stylesheet_directory() . '/mv-testimonials/' );
		 }

		 public function load_custom_archive_template( $tpl ){
		  if( current_theme_supports( 'mv-testimonials' ) ){
			if( is_post_type_archive( 'mv-testimonials' )){
				$tpl = $this->get_template_part_location( 'archive-mv-testimonials.php' );
			}
		  }
			
			return $tpl;
		 }

		 public function load_custom_single_template( $tpl ){
			if( current_theme_supports( 'mv-testimonials' ) ){
			  if( is_singular( 'mv-testimonials' )){
				  $tpl = $this->get_template_part_location( 'single-mv-testimonials.php' );
			  }
			}
			  
			  return $tpl;
		   }

		public function get_template_part_location( $file ){
           if( file_exists( MV_TESTIMONIALS_OVERRIDE_PATH_DIR . $file ) ){
              $file = MV_TESTIMONIALS_OVERRIDE_PATH_DIR . $file;
		   }else{
			$file = MV_TESTIMONIALS_PATH . 'views/templates/' . $file;
		   }
		   return $file;
		}

		 public function activate(){
          update_option( 'rewrite_rules', '');
		 }

		 public function deactivate(){
          flush_rewrite_rules();
		  
		 }
		 public function uninstall(){
               

		 }	 
	 }
}



if(  class_exists( 'MV_Testimonials' )){

	register_activation_hook( __FILE__, array( 'MV_Testimonials', 'activate' ) );
	register_deactivation_hook( __FILE__, array( 'MV_Testimonials', 'deactivate' ) );
	register_uninstall_hook( __FILE__, array( 'MV_Testimonials', 'uninstall' ) );
	$MV_Testimonials_obj = new MV_Testimonials();
}







