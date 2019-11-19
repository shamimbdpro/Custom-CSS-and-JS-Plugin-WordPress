<?php
/*
Plugin Name: Write Custom CSS And JS
Plugin URI: http://www.wordpress.org/plugins/write-custom-css-and-js
Description: Write Custom CSS and Js Plugin will help you add Custom CSS And JS assets. Its will be very useful plugin for WordPress users
Version: 1.0.0
Author: CodePopular
Author URI: http://www.codepopular.com
Text Domain: wccj
License: GPL2
*/
if (!defined('ABSPATH')) die ('No direct access allowed');
    class Wccj
    {
		private $options;
// -------------------------------- Autoload Action & Filter ----------------------------------------
		public function __construct() {	
		// Add new admin page
		 add_action('admin_menu', array($this, 'add_menu'));
		 // Admin init
		 add_action( 'admin_init', array( $this, 'init_settings' ) );
		 // Load admin js and css
		 add_action('admin_enqueue_scripts',array($this, 'admin_script_load'));
		 // Get input data
		add_filter('query_vars', array($this, 'add_wp_var'));
		// Show Custom CSS
		add_action( 'wp_enqueue_scripts', array($this, 'add_custom_css'), 9999 );
		  // Add setting option in plugin list
		 add_filter('plugin_action_links_'.plugin_basename(__FILE__), array($this, 'wccj_setting_links'));
		}

// -------------------------------- Add New Page in Admin Menu ----------------------------------------

		public function add_menu(){
		global $wccj_settings_page;
		 add_menu_page(
		        __( 'Write Custom CSS And JS', 'wccj' ),
		        __( 'Write CSS And JS','wccj' ),
		        'manage_options',
		        'write-custom-css-and-js',
		        array($this, 'create_settings_page'),
		        'dashicons-editor-code',90
		    );

		}
   // -------------------------------- NEW METHOD ----------------------------------------
		public function create_settings_page() {
			$this->options = get_option( 'wccj_settings' ); ?>

			<div class="wrap">
			<form id="worpress_custom_css_form" method="post" action="options.php">
			        <?php settings_fields( 'wccj_group' ); ?>
			       <?php do_settings_sections( 'wccj-add-custom-css-js-settings' ); ?>
					<?php submit_button( __('Save', 'wccj') ); ?>
			</form>
			
			</div>

		<?php
		}


// -------------------------------- NEW METHOD ----------------------------------------
		public function main_css_input() {
    	$css_ruls = isset( $this->options['wccj_main_custom_style'] ) ? esc_attr( $this->options['wccj_main_custom_style'] ) : '';
      		
?>

	       <div class="editor_tab">
			  <a href="javascript:void(0)" class="tablinks active" onclick="openCity(event, 'css_editor')">
			  	<?php esc_html_e( 'Write Css', 'wccj' );?>
			  </a>
			  <a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'js_editor')">
			  	<?php esc_html_e( 'Write JS', 'wccj' );?>
			  </a>
			</div>
			 <!-- ache editor for css-->
			<div id="css_editor" class="editor_tabcontent" style="display: block">
			    <div class="wccj_csseditor_container">
				 	<textarea id="single_custom_css" name="wccj_settings[wccj_main_custom_style]"><?php echo $css_ruls;?></textarea>
					<div id="single_custom_css_ace" class="custom_css_ace"></div>
				</div>
			</div>
			<!-- ace editor for javascript -->
			<div id="js_editor" class="editor_tabcontent">
                  <div class="wccj_jsseditor_container">

					<textarea disabled id="single_custom_js" name="name">Still doing work with js area. as soon as possible will be publish js code editor</textarea>
				    <!--  <div id="single_custom_js_ace" class="custom_js_ace"></div> -->
				 </div>
				

			</div>


<?php

    	}


// -------------------------------- Load Admin Script ----------------------------------------
	    public function admin_script_load() {
		    $wp_scripts = wp_scripts();
		    wp_enqueue_style('jquery-ui-theme-smoothness',
					      sprintf('//ajax.googleapis.com/ajax/libs/jqueryui/%s/themes/smoothness/jquery-ui.css',
					        $wp_scripts->registered['jquery-ui-core']->ver
					      )
					    );
			wp_enqueue_style( 'wccj_ace', plugin_dir_url( __FILE__ ) . 'lib/ace/ace-custom.css' );
			wp_enqueue_script( 'wccj_ace', plugin_dir_url( __FILE__ ) . 'lib/ace/ace.js');
			wp_enqueue_script( 'wccj_scripts_ace', plugin_dir_url( __FILE__ ) . 'js/scripts-ace.js', array('jquery', 'jquery-ui-resizable', 'wccj_ace') );
			wp_enqueue_style('tab_design', plugin_dir_url(__FILE__).'css/tab-style.css');
			wp_enqueue_script('tab_js', plugin_dir_url(__FILE__).'js/custom-tab.js');
	        
	    }




// -------------------------------- NEW METHOD ----------------------------------------

   public function wccj_setting_links( $links ) {
		$links[] = '<a href="' .
			admin_url( 'admin.php?page=write-custom-css-and-js' ) .
			'">' . __('Settings') . '</a>';
		return $links;
   }

// -------------------------------- NEW METHOD ----------------------------------------
		public static function add_wp_var($public_query_vars) {
    		$public_query_vars[] = 'display_custom_css';
    		return $public_query_vars;
		}
// -------------------------------- NEW METHOD ----------------------------------------
		public static function display_custom_css(){
	    	$display_css = get_query_var('display_custom_css');
	    	if ($display_css == 'css'){
					include_once (plugin_dir_path( __FILE__ ) . '/css/custom-css.php');
	      	exit;
	    	}
		}
// -------------------------------- NEW METHOD ----------------------------------------

		public function add_custom_css() {
			$this->options = get_option( 'wccj_settings' );
			if ( isset($this->options['wccj_main_custom_style']) && $this->options['wccj_main_custom_style'] != '') {
				if ( function_exists('icl_object_id') ) {
					$css_base_url = site_url();
					if ( is_ssl() ) {
						$css_base_url = site_url('/', 'https');
					}
				} else {
					$css_base_url = get_bloginfo('url');
					if ( is_ssl() ) {
						$css_base_url = str_replace('http://', 'https://', $css_base_url);
					}
				}
				wp_register_style( 'wccj-add-custom-css', $css_base_url . '?display_custom_css=css' );
				wp_enqueue_style( 'wccj-add-custom-css' );
			}
		}

// -------------------------------- NEW METHOD ----------------------------------------

public function init_settings() {
			register_setting(
				'wccj_group',
				'wccj_settings'
			);
			add_settings_section(
					'wccj_main_custom_style',
					__('Write Below Custom CSS and JS Code', 'wccj'),
					array( $this, 'main_css_input' ),
					'wccj-add-custom-css-js-settings'
			);
		
		}




    }

// ------------------------------ MAKE OBJECT | CALL CLASS -------------------------------

if(class_exists('Wccj')) {
	add_action('template_redirect', array('Wccj', 'display_custom_css'));
	$Wccj = new Wccj();
}

?>