<?php
/*
Plugin Name: EP_Tools (Eros Pedrini Tools) - Thickbox CSS Fix
Plugin URI: http://www.contezero.net/sites/contezero/index.php/2008/12/14/thickbox-fix-plugin/
Description: This plugin makes Thickbox CSS compliant
Author: Eros Pedrini
Version: 1.2
Author URI: http://www.contezero.net/


Copyright 2008  Eros Pedrini  (email : contezero74@yahoo.it)


This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define( 'EP_TOOLS_GUI_DIR', get_option('ep_tools_plugins_gui_dir') );

require_once(EP_TOOLS_GUI_DIR . '/lib/wordpress_pre2.6.inc');


class ep_tools_thickbox_fix {
    function ep_tools_thickbox_fix() {        
        add_action('init', array(&$this,'addThickboxCssFix_JS'));
        add_action('wp_head', array(&$this,'addThickboxCssFix_CSS'));		
    }
    
    function addThickboxCssFix_CSS(){
        $ThickboxURL    = get_option( 'siteurl' ) . '/' . WPINC . '/js/thickbox';
        $ThickBoxFixURL = WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__)) . '/Thickbox';
        
        if (  !$this->isAdminArea &&  get_option('ep_tools_plugin_Thickbox_CSS_Fix_Enable') == 'true' ) {                
            if ( get_option('ep_tools_plugin_Thickbox_CSS_Fix_Enable_GS') == 'true' ) {
                $ThickBoxFixURL = $ThickBoxFixURL . '/thickbox.css';
            } else {
                $ThickBoxFixURL = $ThickBoxFixURL . '/thickbox_wogs.css';
            }
            
            echo '<link rel="stylesheet" href="' . $ThickBoxFixURL . '" type="text/css" media="screen" />' . "\n";
	   
    		echo "<!-- fix Thickbox path -->\n";
    		echo '<script type="text/javascript">' . "\n";
    		echo "\t// <![CDATA[ \n";
    		echo "\t" . 'var tb_pathToImage = "' . $ThickboxURL . '/loadingAnimation.gif";' . "\n";
    		echo "\t" . 'var tb_closeImage  = "' . $ThickboxURL . '/tb-close.png";' . "\n";
    		echo "\t// ]]> \n";
    		echo "</script>\n";
    	}
    }
    
    function addThickboxCssFix_JS() {
        if ( !is_admin() &&  get_option('ep_tools_plugin_Thickbox_CSS_Fix_Enable') == 'true' ) { 
            $ThickBoxFixURL = WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__)) . '/Thickbox';
        
            wp_enqueue_script('ep_tools_thickbox_fix', $ThickBoxFixURL . '/tb_css_fix.js', array('jquery','thickbox'));
            
            $this->isAdminArea = false;
        }
    }
}

/*
This function registers/unregisters the GUI for this plugin
*/
function ept_thickbox_fix_install() {
    global $wpdb;
    
    $plugin_name    = 'ep_tools_thickbox_css_fix_gui';
    $plugin_dir     = mysql_real_escape_string(dirname(__FILE__) . '/ep_tools_thickbox_css_fix.gui');
    
    $table_name     = $wpdb->prefix . "ept_registered_plugins";
    
    $sql =  'INSERT INTO ' . $table_name . '(PluginName, PluginDir) ' .
            "VALUES('" . $plugin_name . "', '" . $plugin_dir . "');";
                
    $wpdb->query($sql);
    
    
    if( false == get_option('ep_tools_plugin_Thickbox_CSS_Fix_Enable') ) {
        add_option('ep_tools_plugin_Thickbox_CSS_Fix_Enable', 'true');
	}
	
	if( false == get_option('ep_tools_plugin_Thickbox_CSS_Fix_Enable_GS') ) {
        add_option('ep_tools_plugin_Thickbox_CSS_Fix_Enable_GS', 'false');
	}
}

function ept_thickbox_fix_uninstall() {
    global $wpdb;
    
    $plugin_name    = 'ep_tools_thickbox_css_fix_gui';
        
    $table_name     = $wpdb->prefix . "ept_registered_plugins";
    
    $sql =  'DELETE FROM ' . $table_name . ' ' .
            "WHERE PluginName = '" . $plugin_name . "';";
                
    $wpdb->query($sql);
    
    if( false != get_option('ep_tools_plugin_Thickbox_CSS_Fix_Enable') ) {
        delete_option('ep_tools_plugin_Thickbox_CSS_Fix_Enable');
	}
	
	if( false != get_option('ep_tools_plugin_Thickbox_CSS_Fix_Enable_GS') ) {
        delete_option('ep_tools_plugin_Thickbox_CSS_Fix_Enable_GS');
	}
}


register_activation_hook(__FILE__, 'ept_thickbox_fix_install');
register_deactivation_hook(__FILE__, 'ept_thickbox_fix_uninstall');

$ep_tools_ThickboxFixInstance = new ep_tools_thickbox_fix();

?>