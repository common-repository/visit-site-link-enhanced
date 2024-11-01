<?php
/*
Plugin Name: "Visit Site" Link Enhanced WP Plugin
Plugin URI: http://blog.fifteenpeas.com/vsle/
Description: Customize the Wordpress Visit Site link behaviour and enables to add a new link just next to it.
Version: 1.0
Author: X Villamuera
Author URI: http://blog.fifteenpeas.com 
*/

/*  Copyright 2010  X.Villamuera for fifteenpeas.com  (email : gzav@sio4.net)

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




function xvp_vsl_menu ()
{
// add new entry in the settings option
add_options_page('Visit Site Link Enhanced','Visit Site Link Enhanced','administrator','xvp_vsle', 'xvp_vsl_settings');	

}

/*
// Create the entry in the Settings menu
*/
add_action('admin_menu', 'xvp_vsl_menu');


/*
// Check config and initialize
*/
function xvp_vsl_check_config() {
	if ( !$config = get_option('xvp_vsl_config') ) {
		$config['xvp_vsl']		 		= 0 ; //The target option for the "visit site" link
		$config['xvp_nvsl1']		 		= '' ; //The url of the new vsl like link
		$config['xvp_nvsln1']		 		= '' ; //The name displayed
		$config['xvp_nvslt1']		 		= 0 ; //The target option of the new link
		
		update_option('xvp_vsl_config', $config);
	}
}

// trigger the check config option
xvp_vsl_check_config();

//update posted
if(isset($_POST['vsl_submit'])) {
	add_action('init', 'vsl_options_update');
}

/*
// Sets the config
*/
function vsl_options_update() {
	// Prepare Tracker settings
	if(isset($_POST['xvp_vsl'])) $config['xvp_vsl'] = 1;
	if(isset($_POST['xvp_nvsl1'])) $config['xvp_nvsl1'] = $_POST['xvp_nvsl1'];
	if(isset($_POST['xvp_nvsln1'])) $config['xvp_nvsln1'] = $_POST['xvp_nvsln1'];
	if(isset($_POST['xvp_nvslt1'])) $config['xvp_nvslt1'] = $_POST['xvp_nvslt1'];
	
		else $config['credits'] = 0;

	update_option('xvp_vsl_config', $config);
}


/*
// Define the settings
*/
function xvp_vsl_settings() {
$xvp_vsl_config = get_option('xvp_vsl_config');
?>
<div class="wrap">
	  	<h2>"Visit Site" Link Enhanced (options)</h2>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>&amp;updated=true">
	<input type="hidden" name="vsl_submit" value="true" />	
	
	<table>
	<tr>
		<td><strong>Change "Visite Site" link behaviour to</strong></td>
	</tr>
	<tr>	<td><label for="xvp_vsl">
		<input name="xvp_vsl" type="checkbox" id="xvp_vsl" value="1" <?php if($xvp_vsl_config['xvp_vsl'] == 1) echo "checked"; ?> /> Open the visited site in a blank window (tab). 
		</label></td>
	</tr>
	<tr>
		<td ><br/><strong>Add a new link of your choice next to the "Visit Site link</strong></td></tr>
	<tr>	
		<td><label for="xvp_nvsl1">
		<input name="xvp_nvsl1" type="text" id="xvp_nvsl1" value="<?php if($xvp_vsl_config['xvp_nvsl1'] != '') echo $xvp_vsl_config['xvp_nvsl1']; ?>" size="25"/>   Enter the full URL (with http://). Ex: <em>http://yourUrl.something</em>.
		</label></td>
	</tr>
	<tr>
		<td><label for="xvp_nvsln1">
		<input name="xvp_nvsln1" type="text" id="xvp_nvsln1" value="<?php if($xvp_vsl_config['xvp_nvsln1'] != '') echo $xvp_vsl_config['xvp_nvsln1']; ?>" size="25"/>   Enter the name of your link.
		</label></td>
	</tr>
	<tr>
		<td><label for="xvp_nvst1">
		<input name="xvp_nvslt1" type="checkbox" id="xvp_nvslt1" value="1" <?php if($xvp_vsl_config['xvp_nvslt1'] == 1) echo "checked"; ?> /> Whether or not to open your link in a new window.
		</label></td>
	</tr></table>
	 <p class="submit">
		      	<input type="submit" name="Submit" class="button-primary" value="Update Options &raquo;" />
		    </p>
	</form>
</div>
<br/>
<table style="margin-top: 0.5em;" class="widefat">
<thead><tr valign="top">	
<th>"<em>Visit Site</em>" Link Enhanced - from fifteenpeas</th></tr></thead>
<tbody>
<tr><td>Find me on <a target="_blank" href="http://fifteenpeas.com">fifteenpeas.com</a>.<br/>
The plugin homepage is at <a target="_blank" href="http://www.fifteenpeas.com/vsle/">http://www.fifteenpeas.com/vsle/</a>. 
For information and usage on "<em>Visit Site</em>" Link Enhanced!<br/>	
Like the software? Did it make your life easier ? Show your appreciation and <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input name="cmd" type="hidden" value="_s-xclick" />
<input name="hosted_button_id" type="hidden" value="XLYUHPVQ57YZ2" />
<input alt="PayPal - The safer, easier way to pay online!" name="submit" src="https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif" type="image" /> <img src="https://www.paypal.com/en_US/i/scr/pixel.gif" border="0" alt="" width="1" height="1" /><br />
</form>
 Thanks!</td></tr>
</tbody></table>
<? }

//
// Perform vsl action upon the settings
//	
function xvp_vsl_action() {
$xvp_vsl_config = get_option('xvp_vsl_config');
    // If setted, adds =>target="_blank"<= to the "visit site" link
	if($xvp_vsl_config['xvp_vsl'] == 1)  {
		echo '<script type="text/javascript">
		//<![CDATA[
		jQuery(\'#site-heading a\').attr(\'target\', \'_blank\');
		//]]>';
	}
	
	// if setted, creates a new link just next to the "visit site" link
	if( ($xvp_vsl_config['xvp_nvsl1'] != '') && ($xvp_vsl_config['xvp_nvsln1'] != '') ) {
		$nurl = '<em id="site-visit-button"><a href="'.$xvp_vsl_config['xvp_nvsl1'].'"';
		if( $xvp_vsl_config['xvp_nvslt1'] == 1 ) $nurl .= ' target="_blank"'; 
		$nurl .= '>'.$xvp_vsl_config['xvp_nvsln1'].'</a></em>';
		echo '<script type="text/javascript">
			//<![CDATA[
			jQuery(\'#site-heading\').append(\''.$nurl.'\');
			//]]>';	
	}

}

// triggers the plugIn action when admin_footer is displayed
add_action('admin_footer', 'xvp_vsl_action');
?>