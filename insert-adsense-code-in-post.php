<?php
/*
Plugin Name: Insert Adsense Code In Post
Plugin URI: http://deltasoft.tn/wordpress/en/plugins/insert-adsense-code-in-post-wordpress-plugin
Description: A sample Wordpress plugin for adding the Google Adsense JavaScript codes in your Wordpress Posts or Pages in the Right, Top and Bottom positions.
Version: 1.0.0
Author: DeltaSoft Solutions - M. Lamine JELLAD
Author Email: contact@deltasoft.com
License: GPLv2 or later

  Copyright 2015 DeltaSoft Solutions (contact@deltasoft.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

class DeltaAdsenseInPost {

	/*--------------------------------------------*
	 * Constants
	 *--------------------------------------------*/
	const name = 'Adsense In Post';
	const slug = 'delta-adsense-in-post';
	
	/**
	 * Constructor
	 */
	function __construct() {
		//register an activation hook for the plugin
		register_activation_hook( __FILE__, array( &$this, 'install_delta_adsense_in_post' ) );

		//Hook up to the init action
		add_action( 'init', array( &$this, 'init_delta_adsense_in_post' ) );
	 	add_action('admin_menu', array($this, 'add_menu'));
		  

	} 
	 public function add_menu() {

		 add_menu_page(null, 'Insert Adsense In Post', 'manage_options',  DeltaAdsenseInPost::slug ,
		 array($this, settings) , plugins_url() .'/insert-adsense-code-in-post/webroot/img/adsense-in-post-icon.png');
		 
	}
		
		
	function settings() {
		 
	 require_once dirname(__FILE__) .'/settings.php'; 
	}
	 
	/**
	 * Runs when the plugin is activated
	 */  
	function install_delta_adsense_in_post() {
		
		 
				   
				 

	}
  
	/**
	 * Runs when the plugin is initialized
	 */
	function init_delta_adsense_in_post() {
		// Setup localization
		load_plugin_textdomain( self::slug, false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
		// Load JavaScript and stylesheets
		$this->register_scripts_and_styles();

		// Register the shortcode [delta_adsense_in_post]
		add_shortcode( 'delta_adsense_in_post', array( &$this, 'render_shortcode' ) );
	
		if ( is_admin() ) {
			//this will run when in the WordPress admin
		} else {
			//this will run when on the frontend
		}

		/*
		 * TODO: Define custom functionality for your plugin here
		 *
		 * For more information: 
		 * http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		add_action( 'your_action_here', array( &$this, 'action_callback_method_name' ) );
		add_filter( 'your_filter_here', array( &$this, 'filter_callback_method_name' ) );    
	}

	function action_callback_method_name() {
		// TODO define your action method here
	}

	function filter_callback_method_name() {
		// TODO define your filter method here
	}

	function render_shortcode($atts) {
		// Extract the attributes
		extract(shortcode_atts(array(
			'attr1' => 'foo', //foo is a default value
			'attr2' => 'bar'
			), $atts));
		// you can now access the attribute values using $attr1 and $attr2
	}
  
	/**
	 * Registers and enqueues stylesheets for the administration panel and the
	 * public facing site.
	 */
	private function register_scripts_and_styles() {
		if ( is_admin() ) {
			$this->load_file( self::slug . '-admin-script', '/js/admin.js', true );
			$this->load_file( self::slug . '-admin-style', '/css/admin.css' );
		} else {
			$this->load_file( self::slug . '-script', '/js/widget.js', true );
			$this->load_file( self::slug . '-style', '/css/widget.css' );
		} // end if/else
	} // end register_scripts_and_styles
	
	/**
	 * Helper function for registering and enqueueing scripts and styles.
	 *
	 * @name	The 	ID to register with WordPress
	 * @file_path		The path to the actual file
	 * @is_script		Optional argument for if the incoming file_path is a JavaScript source file.
	 */
	private function load_file( $name, $file_path, $is_script = false ) {

		$url = plugins_url($file_path, __FILE__);
		$file = plugin_dir_path(__FILE__) . $file_path;

		if( file_exists( $file ) ) {
			if( $is_script ) {
				wp_register_script( $name, $url, array('jquery') ); //depends on jquery
				wp_enqueue_script( $name );
			} else {
				wp_register_style( $name, $url );
				wp_enqueue_style( $name );
			} // end if
		} // end if

	} // end load_file
  
} // end class

function change_the_bottom($content)
	{
		global $wpdb;
		$adsenseBloc = $wpdb->get_row( "SELECT * FROM ".  $wpdb->prefix . 'delta_adsense_in_post ' ."  WHERE wp_position = 'bottom' ; " );
		if(!empty($adsenseBloc->adsense_script) and $adsenseBloc->adsense_script !=='' and $adsenseBloc->adsense_script!=null)  
		 {
			$scriptads = $adsenseBloc->adsense_script;
			$scriptads = html_entity_decode($scriptads);
			$scriptads =   str_replace('\"','"',$scriptads); 
			return $content . '<div style=" width: auto;  margin-top: 5px; margin-bottom: 5px; margin-right: 5px; margin-left: 5px;">'.$scriptads.'</div>';
		 }
		 else //  no change if the script ads is empty
		 {
		 	return $content;
		 }

		 
	}

	function change_the_top($content)
	{
		global $wpdb;
		$adsenseBloc = $wpdb->get_row( "SELECT * FROM ".  $wpdb->prefix . 'delta_adsense_in_post ' ."  WHERE wp_position = 'top' ; " );
		if(!empty($adsenseBloc->adsense_script) and $adsenseBloc->adsense_script !=='' and $adsenseBloc->adsense_script!=null)  
		 {
			$scriptads = $adsenseBloc->adsense_script;
			$scriptads = html_entity_decode($scriptads);
			$scriptads =   str_replace('\"','"',$scriptads);
			return '<div style=" width: auto;  margin-top: 5px; margin-bottom: 10px; margin-right: 5px; margin-left: 5px;">'.$scriptads.'</div>' . $content ;
		 }
		 else //  no change if the script ads is empty
		 {
		 	return $content;
		 }
	}

	function change_the_right($content)
	{
			global $wpdb;
		$adsenseBloc = $wpdb->get_row( "SELECT * FROM ".  $wpdb->prefix . 'delta_adsense_in_post ' ."  WHERE wp_position = 'right' ; " );
		if(!empty($adsenseBloc->adsense_script) and $adsenseBloc->adsense_script !=='' and $adsenseBloc->adsense_script!=null)  
		 {
			$scriptads = $adsenseBloc->adsense_script;
			$scriptads = html_entity_decode($scriptads);
			$scriptads =   str_replace('\"','"',$scriptads);
			return '<div style=" float: right; width: 340px; margin:5px; ">'.$scriptads.'</div>' . $content ;
		 }
		 else //  no change if the script ads is empty
		 {
		 	return $content;
		 }
	}

function DeltaAdsenseInPost_shortcode($params)
 {
			
	 $form_id = 0 ;
	 $result = shortcode_atts(array('position'=>'right'),$params) ;
	 $ads_place = $result['position']; 
	if($ads_place==null or $ads_place==='')
     $ads_place = 'right' ;
       if( is_single() or is_page())  {
      
	  		
							
							if($ads_place==='bottom')
							{
							   add_filter('the_content', 'change_the_bottom', 1);
							}
							elseif($ads_place==='top')
							{
							   add_filter('the_content', 'change_the_top', 1);
							}
							else
							{
								add_filter('the_content', 'change_the_right',9);
							}

							  	
							  
							 		
							 	 
 
								
    }
     //require_once dirname(__FILE__) .'/show_ads.php'; 
 }
 
add_shortcode('ads','DeltaAdsenseInPost_shortcode'); 

global $jal_db_version;
$jal_db_version = '1.0';
  


function jal_install() {
	global $wpdb;
	global $jal_db_version;

	$table_name = $wpdb->prefix . 'delta_adsense_in_post';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `adsense_script` text NOT NULL,
					  `wp_position` varchar(30) NOT NULL,
					  `shortcode` varchar(255) DEFAULT NULL,
					  `public` bit(1) DEFAULT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );
}

function jal_install_data() {
	global $wpdb;
	
	 
	$table_name = $wpdb->prefix . 'delta_adsense_in_post';
	
	$wpdb->insert( 
		$table_name, 
		array( 
			'adsense_script' => '', 
			'wp_position' => 'top', 
			'shortcode' => '[ads position=\"top\"]', 
			'public' => 1
		) 
	);

	$wpdb->insert( 
		$table_name, 
		array( 
			'adsense_script' => '', 
			'wp_position' => 'right', 
			'shortcode' => '[ads]', 
			'public' => 1
		) 
	);

	$wpdb->insert( 
		$table_name, 
		array( 
			'adsense_script' => '', 
			'wp_position' => 'bottom', 
			'shortcode' => '[ads position=\"bottom\"]', 
			'public' => 1
		) 
	);
	 
}

register_activation_hook( __FILE__, 'jal_install' );
register_activation_hook( __FILE__, 'jal_install_data' );

new DeltaAdsenseInPost();
	

	 
 
?>
