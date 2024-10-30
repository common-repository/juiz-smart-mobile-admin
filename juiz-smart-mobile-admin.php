<?php
/*
Plugin Name: Juiz Smart Mobile Admin
Plugin URI: http://www.creativejuiz.fr/blog/ressources-telechargements/wordpress-plugin-adapter-ladministration-de-wordpress-a-votre-smartphone
Description: Add a support of mobile Browser like Safari, Opera or others smartphone browsers for your administration. This plugin can't be perfect because of multiplicity of other plugins which use their own styles. The setting page is located in <strong>Appearance</strong> submenu. <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=P39NJPCWVXGDY&lc=FR&item_name=Juiz%20Smart%20Mobile%20Admin%20%2d%20WordPress%20Plugin&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted" title="Thank you!">Donate to contribute</a>
Author: Geoffrey Crofte
Version: 1.1.10
Author URI: http://crofte.fr
License: GPLv2 or later 
*/

/*

Copyright 2011  Geoffrey Crofte  (email : support@creativejuiz.com)

    
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

*/

define( 'JUIZ_SMA_PLUGIN_NAME',	 'Juiz Smart Mobile Admin' );
define( 'JUIZ_SMA_VERSION',		 '1.1.10' );
define( 'JUIZ_SMA_DIRNAME',		 basename( dirname( __FILE__ ) ) );
define( 'JUIZ_SMA_PLUGIN_URL',	 trailingslashit( WP_PLUGIN_URL ) . JUIZ_SMA_DIRNAME );
define( 'JUIZ_SMA_SLUG',		 'juiz-smart-mobile-admin' );
define( 'JUIZ_SMA_SETTING_NAME', 'juiz_sma_settings' );


	
// multilingue

add_action( 'init', 'make_juiz_sma_multilang' );
function make_juiz_sma_multilang() {
	load_plugin_textdomain( 'jsma_lang', false, JUIZ_SMA_DIRNAME.'/languages' );
}

// uninstall hook

register_uninstall_hook( __FILE__, 'juiz_sma_uninstaller' );
function juiz_sma_uninstaller() {
	delete_option( JUIZ_SMA_SETTING_NAME );
}

// activation hook
register_activation_hook( __FILE__, 'juiz_sma_activation' );
function juiz_sma_activation() {
	$juiz_sma_options = get_option ( JUIZ_SMA_SETTING_NAME );
	if ( !is_array($juiz_sma_options) ) {
		
		$default_array = array(
			'juiz_sma_footer' 	=> 1,
			'juiz_sma_adminbar' 	=> 1
		);
		
		update_option( JUIZ_SMA_SETTING_NAME , $default_array);
	}
}

if ( is_admin() ) {

	// support device width meta and styles
	add_action( 'admin_head', 'juiz_sma_custom_admin_header');
	add_action( 'login_head', 'juiz_sma_custom_admin_header');
	function juiz_sma_custom_admin_header() {
		$metaviewport = get_bloginfo('version') == '3.4' ? '' : '<meta name="viewport" content="width=device-width" />';
		echo '
			<!-- Juiz Smart Mobile Admin plugin -->
			'.$metaviewport.'
			<link rel="apple-touch-icon-precomposed" href="'.JUIZ_SMA_PLUGIN_URL.'/img/apple-touch-icon.png" />
			<!-- // Juiz Smart Mobile Admin plugin -->
			<style type="text/css">
				<!--
					.juiz_goto_header { display:none; }
					.juiz_bottom_links em {display:block; margin-bottom: .5em; font-style:italic; color:#777;}
					.juiz_bottom_links {margin-bottom:0;border-top: 1px solid #ddd; background: #f2f2f2; padding: 10px 45px; }
					.juiz_paypal, .juiz_twitter, .juiz_rate {display: inline-block; margin-right: 10px; padding: 3px 12px; text-decoration: none; border-radius: 3px;
						background-color: #e48e07; background-image: -webkit-linear-gradient(#e7a439, #e48e07); background-image: linear-gradient(to bottom, #e7a439, #e48e07); border-width:1px; border-style:solid; border-color: #e7a439 #e7a439 #ba7604; box-shadow: 0 1px 0 rgba(230, 192, 120, 0.5) inset; color: #FFFFFF; text-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);}
					.juiz_twitter {background-color: #1094bf; background-image: -webkit-linear-gradient(#2aadd8, #1094bf); background-image: linear-gradient(to bottom, #2aadd8, #1094bf); border-color: #10a1d1 #10a1d1 #0e80a5; box-shadow: 0 1px 0 rgba(120, 203, 230, 0.5) inset;}
					.juiz_rate {background-color: #999; background-image: -webkit-linear-gradient(#888, #666); background-image: linear-gradient(to bottom, #888, #666); border-color: #777 #777 #444; box-shadow: 0 1px 0 rgba(180, 180, 180, 0.5) inset;}
					.juiz_paypal:hover { color: #fff; background: #e48e07;}
					.juiz_twitter:hover { color: #fff; background: #1094bf;}
					.juiz_rate:hover { color: #fff; background: #666;}

/* find CSS file in '.JUIZ_SMA_PLUGIN_URL.'/css/juiz-smart-mobile-admin.css */
@media only screen and (max-width:640px){
	html,body,div,table,blockquote,p{width:auto !important;min-width:10px !important;line-height:1.8em !important}object{max-width:95%}html.wp-toolbar{padding-top:0}.add_and_go_to_bottom,.juiz_goto_menu,.juiz_goto_header{display:inline-block;width:30px;margin-bottom:5px;text-indent:-9999px;background:#999 url('.JUIZ_SMA_PLUGIN_URL.'/img/jUIz_icons.png) 5px 50% no-repeat;-webkit-border-radius:5px;-moz-border-radius:5px;border-radius:5px}.juiz_goto_menu,.juiz_goto_header{position:absolute;top:-5px;right:5px;width:24px;background-position:-24px 50%}body.admin-bar .juiz_goto_menu{top:42px}body.admin-bar.branch-3-5 .juiz_goto_menu{top:16px}li#collapse-menu,div#screen-meta,div#adminmenuback,a#content_resize,#update-nag,.update-nag{display:none !important}#screen-meta-links{display:none}div#wpcontent{height:auto}div#wpwrap{width:auto}div#wpcontent{margin-left:0}div#wpbody-content{float:none;height:auto;width:auto}div#wpbody-content{padding-bottom:2em}div.wrap{margin:0 15px}div.postbox-container,#col-right{float:none;padding-right:0}.auto-fold #wpcontent,.auto-fold #wpfooter{margin-left:0;margin-right:0}.auto-fold #wpfooter{position:static;padding:15px;text-align:center}.folded #wpcontent,.folded #footer{margin-left:0}body.admin-bar.branch-3-3 #adminmenu,body.admin-bar.branch-3-4 #adminmenu,body.admin-bar.branch-3-5 #adminmenu{padding-top:0}img#header-logo,#wphead #site-heading{float:none;display:inline-block;vertical-align:middle;padding:0}div#wphead{position:relative;height:auto;margin-left:0;margin-right:0;padding:1em;text-align:center}div#wpcontent{position:relative}div#user_info{float:none;height:auto;width:auto}.wrap a.add-new-h2{padding:5px 10px;background:#eee}#user_info .hide-if-no-js #user_info_links{position:static;width:100% !important}#user_info_links_wrap{right:0;left:0}body.admin-bar #adminmenu{padding-top:3em}body.admin-bar #wphead{padding:3em}#wpadminbar{height:2.5em;right:0;padding:0 10px}#wpadminbar form{padding:3px}#wpadminbar img{border:2px solid #aaa;margin-right:5px}#wpadminbar select{max-width:90px;vertical-align:top;-webkit-box-shadow:2px 2px 1px #CDCDCD inset;-moz-box-shadow:2px 2px 1px #CDCDCD inset;box-shadow:2px 2px 1px #CDCDCD inset;border:1px solid #626262;color:#555!important;background:#ddd}#wpadminbar option,#wpadminbar optgroup{color:#555!important;text-shadow:0 0 0}#wpadminbar .adminbar-button{width:auto;height:auto;margin:0;padding:1px 3px;border:1px solid #626262;cursor:pointer;font:bold 12px Arial,Helvetica,sans-serif;background:-webkit-linear-gradient(center bottom,#AAA,#CECECE) repeat scroll 0 0 transparent;background:-moz-linear-gradient(center bottom,#AAA,#CECECE) repeat scroll 0 0 transparent;background:-o-linear-gradient(center bottom,#AAA,#CECECE) repeat scroll 0 0 transparent;background:linear-gradient(center bottom,#AAA,#CECECE) repeat scroll 0 0 transparent;text-shadow:0 1px 0 #EEE;color:#444;-webkit-border-radius:10px;-moz-border-radius:10px;border-radius:10px}#wpadminbar #adminbarsearch .adminbar-input{width:90px!important}#wpadminbar #adminbarsearch .adminbar-button{text-indent:-9999px;background:url('.JUIZ_SMA_PLUGIN_URL.'/img/jUIz_table_icons.png) no-repeat 8px -552px,-webkit-linear-gradient(center bottom,#AAA,#CECECE) repeat scroll 0 0 transparent!important;background:url('.JUIZ_SMA_PLUGIN_URL.'/img/jUIz_table_icons.png) no-repeat 8px -552px,-moz-linear-gradient(center bottom,#AAA,#CECECE) repeat scroll 0 0 transparent!important;background:url('.JUIZ_SMA_PLUGIN_URL.'/img/jUIz_table_icons.png) no-repeat 8px -552px,-o-linear-gradient(center bottom,#AAA,#CECECE) repeat scroll 0 0 transparent!important;background:url('.JUIZ_SMA_PLUGIN_URL.'/img/jUIz_table_icons.png) no-repeat 8px -552px,linear-gradient(center bottom,#AAA,#CECECE) repeat scroll 0 0 transparent!important}#wpadminbar input[type=\'submit\']{vertical-align:top}#wpadminbar .quicklinks{float:left}#adminbarsearch-wrap{float:right}.branch-3-3 #wp-admin-bar-my-account >.ab-item,.branch-3-4 #wp-admin-bar-my-account >.ab-item,.branch-3-5 #wp-admin-bar-my-account >.ab-item{min-width:10px}.branch-3-3 #wp-admin-bar-my-account >.ab-item .hide_if_smart,.branch-3-4 #wp-admin-bar-my-account >.ab-item .hide_if_smart,.branch-3-5 #wp-admin-bar-my-account >.ab-item .hide_if_smart{display:none}.branch-3-3 #wp-admin-bar-my-account >.ab-item img,.branch-3-4 #wp-admin-bar-my-account >.ab-item img,.branch-3-5 #wp-admin-bar-my-account >.ab-item img{position:absolute;right:5px;top:7px}.branch-3-3 #wpadminbar,.branch-3-4 #wpadminbar,.branch-3-5 #wpadminbar{position:static;height:auto}.branch-3-3 #wpadminbar .quicklinks,.branch-3-4 #wpadminbar .quicklinks,.branch-3-5 #wpadminbar .quicklinks{float:none;position:relative;padding-right:45px}.branch-3-3 #wpadminbar li,.branch-3-3 #wp-admin-bar-root-default,.branch-3-3 #wp-admin-bar-top-secondary,.branch-3-4 #wpadminbar li,.branch-3-4 #wp-admin-bar-root-default,.branch-3-4 #wp-admin-bar-top-secondary,.branch-3-5 #wpadminbar li,.branch-3-5 #wp-admin-bar-root-default,.branch-3-5 #wp-admin-bar-top-secondary{float:none;display:inline-block;vertical-align:middle}.branch-3-3 li#wp-admin-bar-wp-logo,.branch-3-3 #wp-admin-bar-new-content .ab-label,.branch-3-3 #wp-admin-bar-user-info .avatar,.branch-3-4 li#wp-admin-bar-wp-logo,.branch-3-4 #wp-admin-bar-new-content .ab-label,.branch-3-4 #wp-admin-bar-user-info .avatar,.branch-3-5 li#wp-admin-bar-wp-logo,.branch-3-5 #wp-admin-bar-new-content .ab-label,.branch-3-5 #wp-admin-bar-user-info .avatar{display:none}.branch-3-3 #wp-admin-bar-root-default ul,.branch-3-4 #wp-admin-bar-root-default ul,.branch-3-5 #wp-admin-bar-root-default ul{z-index:20}.branch-3-3 #wpadminbar .ab-top-secondary,.branch-3-4 #wpadminbar .ab-top-secondary,.branch-3-5 #wpadminbar .ab-top-secondary{position:absolute;right:0;top:2px;z-index:10}.branch-3-3 #wpadminbar .ab-top-secondary .menupop .ab-sub-wrapper,.branch-3-4 #wpadminbar .ab-top-secondary .menupop .ab-sub-wrapper,.branch-3-5 #wpadminbar .ab-top-secondary .menupop .ab-sub-wrapper{left:auto;right:0}.branch-3-3 #wpadminbar .quicklinks a,.branch-3-3 #wpadminbar .quicklinks .ab-empty-item,.branch-3-3 #wpadminbar .shortlink-input,.branch-3-4 #wpadminbar .quicklinks a,.branch-3-4 #wpadminbar .quicklinks .ab-empty-item,.branch-3-4 #wpadminbar .shortlink-input,.branch-3-5 #wpadminbar .quicklinks a,.branch-3-5 #wpadminbar .quicklinks .ab-empty-item,.branch-3-5 #wpadminbar .shortlink-input{padding:0 10px}.branch-3-3 #wpadminbar #wp-admin-bar-my-account.with-avatar #wp-admin-bar-user-actions >li,.branch-3-4 #wpadminbar #wp-admin-bar-my-account.with-avatar #wp-admin-bar-user-actions >li,.branch-3-5 #wpadminbar #wp-admin-bar-my-account.with-avatar #wp-admin-bar-user-actions >li{margin-left:16px}.wrap .add-new-h2{top:1px}div#adminmenuback,div#adminmenuwrap{float:none;border:0}#adminmenushadow,#adminmenuback{background:url('.JUIZ_SMA_PLUGIN_URL.'/img/menu-shadow-rtl.png) 0 0 repeat-y !important;right:0.65em !important;z-index:0}#adminmenushadow_left{position:absolute;background:url('.JUIZ_SMA_PLUGIN_URL.'/img/menu-shadow.png) 0 0 repeat-y;top:0;bottom:0;left:0.89em}#adminmenuback,#adminmenuwrap,#adminmenu,.js.folded #adminmenu .wp-submenu.sub-open,.js.folded #adminmenu .wp-submenu-wrap{width:auto}.js #adminmenu .wp-submenu.sub-open,.folded #adminmenu .wp-has-current-submenu .wp-submenu.sub-open,.no-js #adminmenu .wp-has-submenu:hover .wp-submenu,#adminmenu .wp-has-current-submenu .wp-submenu,#adminmenu li.focused .wp-submenu{display:block!important}#adminmenu .wp-has-current-submenu .wp-submenu,.branch-3-5 #adminmenu .wp-has-current-submenu .wp-submenu{position:static!important}body.branch-3-5 #adminmenu .wp-has-current-submenu .wp-submenu{display:block!important;width:auto;box-shadow:0 0 0}#adminmenu{margin:0 1.5em}#adminmenu a.menu-top,#adminmenu div.wp-menu-toggle{display:block}#adminmenu li.wp-has-current-submenu .wp-menu-arrow,#adminmenu li.menu-top.current .wp-menu-arrow{display:none}#adminmenu li.menu-top,.auto-fold #adminmenuback,.auto-fold #adminmenuwrap,.auto-fold #adminmenu,.auto-fold #adminmenu li.menu-top{width:auto!important}.auto-fold #adminmenu li.menu-top{margin-top:1px;margin-bottom:1px}.auto-fold #adminmenu a.menu-top{height:1.6em}.auto-fold #adminmenu .wp-menu-name{display:inline-block;padding:0 5px}#adminmenu .awaiting-mod,#adminmenu span.update-plugins,#sidemenu li a span.update-plugins{top:24%;right:-56%}#adminmenu li,#adminmenu li .wp-menu-name{position:relative}#adminmenu a.wp-has-submenu{margin-left:0}#adminmenu div.wp-menu-image{float:none;position:absolute;    top:2px;left:3px;float:none}#adminmenu .wp-menu-toggle{float:none;position:absolute;top:3px;right:5px;width:30px !important;height:38px}#adminmenu a{display:inline-block}#adminmenu a.menu-top{width:79%;padding:3% 8% 3% 13%}#adminmenu .wp-has-submenu .wp-menu-toggle{background:url('.JUIZ_SMA_PLUGIN_URL.'/img/arrows.png) no-repeat scroll 50% -10% transparent}#adminmenu li.wp-has-current-submenu .wp-menu-toggle{background:url('.JUIZ_SMA_PLUGIN_URL.'/img/arrows-dark.png) no-repeat scroll 50% -10% transparent}#adminmenu .wp-menu-open .wp-menu-toggle{background-position:50% 27% !important}#adminmenu li.wp-has-current-submenu.wp-menu-open .wp-menu-toggle{background-position:50% 29% !important}#adminmenu .wp-has-submenu:hover .wp-menu-toggle{background-position:50% -10% !important}#adminmenu .wp-submenu a{display:block;padding:6px 12px}.tablenav .actions+.actions{margin:1.6em 0}.folded #adminmenuback,.folded #adminmenuwrap,.folded #adminmenu,.folded #adminmenu li.menu-top{width:auto !important}.folded #adminmenu a.menu-top,body.no-js #adminmenu .wp-menu-toggle,.folded #adminmenu div.wp-menu-toggle{display:block}.folded #adminmenu a.wp-has-submenu{margin-left:0}.folded #adminmenu .wp-has-current-submenu .wp-submenu{display:block;position:static}.js #adminmenu .wp-submenu.sub-open,.folded #adminmenu .wp-has-current-submenu .wp-submenu.sub-open,.no-js #adminmenu .wp-has-submenu:hover .wp-submenu,#adminmenu .wp-has-current-submenu .wp-submenu,#adminmenu li.focused .wp-submenu{display:none}#adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head{display:none}.folded #adminmenu .wp-has-current-submenu .wp-submenu-wrap{margin-top:0}#adminmenu .wp-submenu.sub-open,#adminmenu li.focused.wp-not-current-submenu .wp-submenu,.folded #adminmenu li.focused.wp-has-current-submenu .wp-submenu,.folded #adminmenu .wp-has-current-submenu .wp-submenu.sub-open,.no-js #adminmenu .wp-has-submenu:hover .wp-submenu,.no-js.folded #adminmenu .wp-has-current-submenu:hover .wp-submenu{padding:0}#dashboard_recent_drafts ul,#dashboard_recent_drafts p{word-wrap:break-word}#dashboard_right_now .table_discussion,#dashboard_right_now .table_content{float:none;width:auto}#dashboard_right_now .table_discussion{margin-top:40px}#post-body-content,.postbox-container{float:none !important}.inner-sidebar{float:none}.has-right-sidebar #post-body,.has-left-sidebar #post-body,.has-right-sidebar #post-body-content,.has-left-sidebar #post-body-content{float:none;margin-right:0;margin-left:0;width:auto}.categorydiv div.tabs-panel,.customlinkdiv div.tabs-panel,.posttypediv div.tabs-panel,.taxonomydiv div.tabs-panel,#linkcategorydiv div.tabs-panel{height:auto;min-height:100px;max-height:200px}.taghint{position:relative;margin-bottom:-40px;z-index:2}#new-tag-post_tag{z-index:1}#media-buttons a{margin:0 0.3em}#edButtonPreview,#edButtonHTML{padding:5px 15px 13px 15px}#media-buttons,#edButtonPreview,#edButtonHTML{position:relative;top:-12px}#media-buttons{margin-right:165px;padding-top:0;line-height:1.5em !important}#editorcontainer #content,#editorcontainer .wp_themeSkin .mceIframeContainer{height:300px}#content_parent.mceEditor.wp_themeSkin{display:block;width:100%}.wp_themeSkin table.mceLayout,.wp_themeSkin table.mceLayout tr,.wp_themeSkin table.mceLayout td,.wp_themeSkin table.mceLayout th,#post-status-info,#post-status-info tr,#post-status-info td{display:block}#content_toolbargroup{overflow:visible;width:auto}.wp_themeSkin tbody,.wp_themeSkin #content_toolbar1,.wp_themeSkin tr.mceFirst .mceToolbar tr,.wp_themeSkin tr.mceLast .mceToolbar tr{display:block;white-space:normal}.wp_themeSkin tr.mceFirst .mceToolbar tr td,.wp_themeSkin tr.mceLast .mceToolbar tr td{display:inline-block}.wp_themeSkin .mceStatusbar{height:auto!important}.wp_themeSkin .mceStatusbar div{float:none!important;padding-bottom:0}.media-new-php .upload-html-bypass{display:none}.link-add-php #linkxfndiv label{display:block}.link-add-php #linkadvanceddiv .form-table th{width:auto}.link-add-php #poststuff,.post-new-php #poststuff{display:-webkit-box;display:-moz-box;display:box;-webkit-box-orient:vertical;-moz-box-orient:vertical;box-orient:vertical}.link-add-php #side-info-column,.post-new-php #poststuff #side-info-column{-webkit-box-ordinal-group:2;-moz-box-ordinal-group:2;box-ordinal-group:2}.link-add-php #post-body,.post-new-php #poststuff #post-body{-webkit-box-ordinal-group:1;-moz-box-ordinal-group:1;box-ordinal-group:1}h2.nav-tab-wrapper .nav-tab{font-size:14px;padding:4px 4px 6px;margin-right:0}h2.nav-tab-wrapper .nav-tab+.nav-tab{margin-left:3px}.themes-php .filter-form #filter-click{display:block}table#availablethemes,table#availablethemes tr,table#availablethemes td{display:block;border:0 none;width:auto}table#availablethemes td.available-theme{text-align:center;border-bottom:1px solid #ddd}.available-theme a.screenshot img{display:inline-block;background:#fff;padding:2px;border:1px solid #ddd}.available-theme a.screenshot{position:relative;display:inline-block;z-index:10;overflow:visible}.available-theme a.screenshot:after{content:\' \';display:block;position:absolute;bottom:7px;right:10px;width:50%;height:35px;z-index:-1;background:red;-webkit-box-shadow:7px 10px 15px #555;-moz-box-shadow:7px 10px 15px #555;-ms-box-shadow:7px 10px 15px #555;box-shadow:7px 10px 15px #555;-webkit-transform:rotate(7deg);-moz-transform:rotate(7deg);-ms-transform:rotate(7deg);-o-transform:rotate(7deg);transform:rotate(7deg)}.available-theme .description{text-align:justify}.available-theme .action-links+p,.available-theme .action-links+p+p,.action-links .thickbox-preview,#current-theme .theme-options{display:none}#current-theme img{width:110px;height:auto}.theme-install-php .feature-filter .feature-name{display:block;width:auto;float:none;margin-bottom:1em;text-align:left;font-weight:bold;font-variant:small-caps;border-bottom:1px solid #ddd}.theme-install-php .clear+.feature-name{margin-top:2.2em}.theme-install-php .feature-filter .feature-group{float:none;width:auto}.widget-liquid-left{display:none}div.widget-liquid-right{float:none}.widget-liquid-right .sidebar-description{margin-left:10px}.widgets-holder-wrap .widget{margin:0 10px}body.menu-max-depth-0{width:auto !important;min-width:10px !important}#nav-menus-frame{margin-left:0;padding:25px 0 10px;display:-webkit-box;display:-moz-box;display:box;-webkit-box-orient:vertical;-moz-box-orient:vertical;box-orient:vertical}#wpbody-content #menu-settings-column{float:none;margin-left:0;-webkit-box-ordinal-group:2;-moz-box-ordinal-group:2;box-ordinal-group:2}#menu-management-liquid{float:none;min-width:10px;-webkit-box-ordinal-group:1;-moz-box-ordinal-group:1;box-ordinal-group:1}#menu-management{margin-right:0}#templateside{float:none;margin-right:10px}#template{margin-top:2em}#template textarea{max-height:200px}#templateside li{margin:1.4em 0.4em}#template div{width:auto;margin-right:0}#profile-page .form-table textarea{width:95%}.form-table th{width:auto}.options-permalink-php code{display:block;max-width:75%;overflow:auto}.icon32{display:inline-block !important;width:36px !important;float:none;vertical-align:bottom}.icon32+h2{display:inline-block;vertical-align:bottom}#adminmenu div.wp-menu-image{width:28px !important}.sidebar-name-arrow{width:26px !important}#message{margin-top:2em}div.postbox .handlediv{visibility:visible;width:27px !important}.meta-box-sortables div.postbox .handlediv{background:url('.JUIZ_SMA_PLUGIN_URL.'/img/arrows.png) no-repeat scroll 6px 7px transparent}.meta-box-sortables div.closed .handlediv{background:url('.JUIZ_SMA_PLUGIN_URL.'/img/arrows.png) no-repeat scroll 6px -29px transparent}.active #user_info_arrow{width:22px !important}#post-search-input{width:35%}#link_rel{width:80%}#createuser .form-field input,input.regular-text,#adduser .form-field input,.form-table select{width:auto;min-width:12em;max-width:16em}.form-table span.description,span#utc-time{display:block;padding-left:0}.form-table input.tog{float:none}.options-media-php input.small-text{width:10em}#edit-slug-box{height:auto;margin:1.5em 0 3em}ul.subsubsub{float:none;margin:1.5em 0;white-space:normal}form p.search-box{float:none;margin:1.2em 0}.tablenav.top{margin-top:2em}table.wp-list-table,table#update-themes-table{display:block;width:auto}.wrap table.fixed{table-layout:auto}.wrap table.wp-list-table thead tr,.wrap table.wp-list-table thead th,.wrap table.wp-list-table tfoot tr,.wrap table.wp-list-table tfoot th,.wrap table.wp-list-table thead,.wrap table.wp-list-table tfoot,.wrap table.fixed thead tr,.wrap table.fixed thead th,.wrap table.fixed tfoot tr,.wrap table.fixed tfoot th,.wrap table.fixed thead,.wrap table.fixed tfoot,table#update-themes-table thead,table#update-themes-table tfoot{display:block;height:1px;width:1px; overflow:hidden;padding:0;margin:0;line-height:1em !important}.wrap table.plugins thead,.wrap table.plugins thead th,.wrap table.plugins thead tr,.wrap table.comments thead,.wrap table.comments thead th,.wrap table.comments thead tr{width:auto;height:auto;line-height:1.5em !important}.wrap table.plugins thead th.check-column,.wrap table.comments thead th.check-column{padding:4px 0}.wrap table.plugins thead th.check-column:after,.wrap table.comments thead th.check-column:after{content:"<- Select All"}.wrap table.plugins thead th.check-column input,.wrap table.comments thead th.check-column input{margin-left:16px}.wrap table.plugins thead th+th,.wrap table.comments thead th+th{display:none}#the-list,#the-list tr,#the-list tr td,#the-list tr th,#the-comment-list,#the-comment-list tr,#the-comment-list tr td,#the-comment-list tr th,.wrap table.comment-ays tr,.wrap table.comment-ays td,.wrap table.comment-ays th,table#update-themes-table tr,table#update-themes-table td,table#update-themes-table th{display:block;width:auto}#update-themes-table .check-column{float:left}#update-themes-table .plugins .plugin-title,#update-themes-table .plugins .theme-title{white-space:normal}#the-list,#the-comment-list{padding:0 10px 10px 10px}#the-list .alternate,#the-comment-list .alternate{background:transparent}#the-list tr:first-child,#the-comment-list tr:first-child{padding:0 0 1em;border-bottom:1px solid #fff}#the-list tr+tr,#the-comment-list tr+tr{clear:left;padding:1em 0;border-top:1px solid #eee;border-bottom:1px solid #fff}#the-list tr:last-child,#the-comment-list tr:last-child{padding:1em 0 0 0;border-bottom:0 none}.wp-list-table #the-list td,.wp-list-table #the-list th,.wp-list-table #the-comment-list td,.wp-list-table #the-comment-list th,.fixed #the-list td,.fixed #the-list th,.fixed #the-comment-list td,.fixed #the-comment-list th{border:0 none}#the-list .check-column,#the-comment-list .check-column{float:left;width:25px;text-align:center}#the-list .check-column input,#the-comment-list .check-column input{margin-left:0}#the-list .check-column ~ td,#the-comment-list .check-column ~ td{margin-left:30px;min-width:25%}#the-list .column-author{clear:left}#the-list .column-author,#the-list .column-categories,.widefat #the-list .column-tags,#the-list .column-date,#the-list .column-slug,#the-list .column-posts,#the-list .column-visible,#the-list .column-rating,#the-list .column-links{background:transparent url('.JUIZ_SMA_PLUGIN_URL.'/img/jUIz_table_icons.png) 5px 7px no-repeat}#the-list .column-author,#the-list .column-categories{float:left;width:30%;padding-left:10%}#the-list .column-categories{background-position:5px -55px}.widefat #the-list .column-tags{clear:left;border:1px dashed #aaa;border-left:none;border-right:none;padding-left:30px;font-style:italic;background-position:5px -175px}#the-list .column-tags a{display:inline-block;margin-right:1.3em;padding:2px 6px;background:#eee;font-style:normal;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px}#the-list .column-comments{float:left;width:15%}#the-list .column-date{padding-left:30px;padding-top:0.7em;line-height:1.4em;background-position:5px -115px}#the-list .column-slug{float:left;width:33%;padding-left:10%;background-position:5px -240px;font-family:Consolas,Monaco,monospace}#the-list .column-posts,#the-list .column-links{background-position:5px -302px;padding-left:10%;text-align:left}tbody#the-list td.media-icon{float:left;width:80px;margin-left:0}.upload-php #the-list .column-comments{width:42%}#the-list .column-visible{float:left;width:30%;padding-left:10%;background-position:5px -359px}#the-list .column-rating{padding-left:10%;background-position:5px -426px}#the-list .column-links{background-position:5px -488px}#comment-search-input{width:115px}.fixed #the-comment-list{max-width:265px;overflow:hidden}.fixed #the-comment-list .column-author{width:auto;line-height:1.55em}.fixed #the-comment-list .comment a{word-wrap:break-word}.column-response .post-com-count{float:none;display:inline-block;margin-left:10px;vertical-align:middle}.column-response .post-com-count-wrapper+a{display:inline-block;vertical-align:middle;margin-left:10px}.row-actions{visibility:visible}.row-actions-visible{margin-top:0.4em}.row-actions-visible span a,.row-actions span a,.action-links a{display:inline-block;padding:0.15em 0.6em;margin:0.2em;border:1px solid #aaa;color:#666;background-image:-webkit-linear-gradient(rgba(255,255,255,0.1),rgba(0,0,0,0.1));background-image: -moz-linear-gradient(rgba(255,255,255,0.1),rgba(0,0,0,0.1));background-image: -ms-linear-gradient(rgba(255,255,255,0.1),rgba(0,0,0,0.1));background-image: -o-linear-gradient(rgba(255,255,255,0.1),rgba(0,0,0,0.1));background-image: linear-gradient(rgba(255,255,255,0.1),rgba(0,0,0,0.1));-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;box-shadow:0 1px 0 rgba(255,255,255,.45) inset,0 1px 1px rgba(0,0,0,.75)}.action-links a{font-weight:bold;text-decoration:none}.row-actions span a{margin:0.4em 0.2em}.row-actions-visible .activate a.edit,#the-comment-list .row-actions span.approve a,#the-comment-list .row-actions span.reply a{background-color:#50990e;border-color:#50990e;color:#fff}.row-actions-visible .edit a.edit,.row-actions span.view a,.row-actions span.edit a{background-color:#81857d;border-color:#81857d;color:#fff}.row-actions-visible .deactivate a,#the-comment-list .row-actions .unapprove a{background-color:#ad6910;border-color:#ad6910;color:#fff}.row-actions span.inline a,.row-actions span.quickedit a{background-color:#21759B;border-color:#21759B;color:#fff}.row-actions-visible .delete a.delete,#the-list div.row-actions span.trash a,#the-list div.row-actions span.delete a,#the-comment-list div.row-actions span.trash a,#the-comment-list div.row-actions span.spam a,.action-links .submitdelete,#dashboard_recent_comments .row-actions .delete a,#dashboard_recent_comments .row-actions .spam a{background-color:#BC0B0B;border-color:#BC0B0B;color:#fff}.row-actions-visible .deactivate a:hover,.row-actions-visible .deactivate a:focus,.row-actions-visible .deactivate a:active{background-color:#ba7f32;border-color:#ba7f32;color:#fff}.row-actions-visible .edit a.edit:hover,.row-actions-visible .edit a.edit:focus,.row-actions-visible .edit a.edit:active{background-color:#a9a9a8;border-color:#a9a9a8;color:#fff}.row-actions-visible .activate a.edit:hover,.row-actions-visible .activate a.edit:focus,.row-actions-visible .activate a.edit:active,.action-links .activatelink{background-color:#79bf3a;border-color:#79bf3a;color:#fff}.row-actions-visible .delete a.delete:hover,.row-actions-visible .delete a.delete:focus,.row-actions-visible .delete a.delete:active,#dashboard_recent_comments .delete a:hover,#dashboard_recent_comments .delete a:focus,#dashboard_recent_comments .delete a:active,#dashboard_recent_comments .spam a:hover,#dashboard_recent_comments .spam a:focus,#dashboard_recent_comments .spam a:active{background-color:#dc4242;border-color:#dc4242;color:#fff}#wpbody-content .describe input[type="text"],#wpbody-content .describe textarea{width:auto}#wpbody-content table.describe th{width:112px}#wpbody-content .media-item .thumbnail{max-width:75px;height:auto}.fixed .column-icon{width:60px}.users-php .row-actions span{clear:left}#wpbody-content .quick-edit-row-post .inline-edit-col-left,#wpbody-content .inline-edit-row-post .inline-edit-col-center,#wpbody-content .quick-edit-row-post .inline-edit-col-right{width:auto;float:none}#wpbody-content .quick-edit-row fieldset .inline-edit-group label.alignleft:first-child{margin-right:1em}.inline-edit-row fieldset label,.inline-edit-row fieldset span.inline-edit-categories-label{margin:0.9em 0}.button{margin:0.9em 1em 0.9em 0}.button-primary+.button{margin-left:0}.button-primary{display:block;margin-bottom:1em}#com-reply,div.hidden{display:none !important}p.row-actions{visibility:visible}div#footer{position:static;margin-right:0;margin-left:0;margin-top:2em;padding:2em;background:#fff;text-align:center}span#footer-thankyou{display:block;position:relative}p#footer-left{float:none}#footer-upgrade{float:none;padding:1em}#icl-als-actions-label,#icl-als-actions,#icl-als-info{display:inline-block;float:none !important;vertical-align:middle}#icl-als-actions-label{display:block}#icl-als-toggle{width:28px !important}select[name="icl_user_admin_language"]{max-width:12em}.sitepress-multilingual-cms-menu-languages-php #icl_lang_sel_preview_wrap{float:none}.sitepress-multilingual-cms-menu-languages-php textarea{max-width:90%}#icl_strings_in_theme td+td+td+td,#icl_strings_in_theme th+th+th+th,#icl_strings_in_plugins td+td+td+td,#icl_strings_in_plugins th+th+th+th{display:none}.sitepress-multilingual-cms-menu-theme-localization-php .button-primary{display:block;width:50%}.sis th+th+th+th+th,.sis td+td+td+td+td{display:none}#add_size{white-space:normal;width:75%}.toplevel_page_wpcf7 div.wpcf7 div.cf7com-links{margin-top:10px;text-align:center}.wpcf7 #wpcf7-title,.wpcf7 #contact-form-anchor-text,.wpcf7 #wpcf7-form{width:90%}.wpcf7 input.wide{max-width:90%}.galerie_page_nggallery-add-gallery input,.galerie_page_nggallery-tags input{max-width:50%}.galerie_page_nggallery-add-gallery #slider{margin:0 10px}.galerie_page_nggallery-manage-album #wrap{display:none}.galerie_page_nggallery-manage-album #wpbody-content:after{content:"Can\'t be modified with a mobile"}#imagefiles{width:90%}#imagefiles_wrap{overflow:auto;width:90%}#donator_message{display:none}#juiz_cuf_table .technical_help_col{display:none}#juiz-custom-user .juiz_support .pp{float:none;margin-left:0}.toplevel_page_WP-Optimize table.toplevel_page_WP-Optimize tr,.toplevel_page_WP-Optimize td,.toplevel_page_WP-Optimize th{display:block}.toplevel_page_WP-Optimize img{width:100%;height:auto}.toplevel_page_WP-Optimize table iframe{width:100%!important}.toplevel_page_WP-Optimize table.widefat{width:auto;display:block}
	}
				-->
			</style>
		';
	}

	// JS optimisation
	add_action( 'admin_footer', 'juiz_sma_custom_admin_footer');
	if (!function_exists('juiz_sma_custom_admin_footer')) {
		function juiz_sma_custom_admin_footer(){
			echo '<!-- find JS file in '.JUIZ_SMA_PLUGIN_URL.'/js/juiz-smart-mobile-admin.js -->
				<script type="text/javascript">
				function Hammer(a,b,l){function g(e){e=e||window.event;if(H){for(var c=[],a=0<e.touches.length?e.touches:e.changedTouches,b=0,d=a.length;b<d;b++)e=a[b],c.push({x:e.pageX,y:e.pageY});return c}c=document;a=c.body;return[{x:e.pageX||e.clientX+(c&&c.scrollLeft||a&&a.scrollLeft||0)-(c&&c.clientLeft||a&&c.clientLeft||0),y:e.pageY||e.clientY+(c&&c.scrollTop||a&&a.scrollTop||0)-(c&&c.clientTop||a&&c.clientTop||0)}]}function h(e,a){if(2==e.length&&2==a.length){var b,d;b=e[0].x-e[1].x;d=e[0].y-e[1].y;var f= Math.sqrt(b*b+d*d);b=a[0].x-a[1].x;d=a[0].y-a[1].y;return Math.sqrt(b*b+d*d)/f}return 0}function I(a,c){if(2==a.length&&2==c.length){var b,d;b=a[0].x-a[1].x;d=a[0].y-a[1].y;var f=180*Math.atan2(d,b)/Math.PI;b=c[0].x-c[1].x;d=c[0].y-c[1].y;return 180*Math.atan2(d,b)/Math.PI-f}return 0}function k(a,c){c.touches=g(c.originalEvent);c.type=a;"[object Function]"==Object.prototype.toString.call(v["on"+a])&&v["on"+a].call(v,c)}function w(a){a=a||window.event;a.preventDefault?(a.preventDefault(),a.stopPropagation()): (a.returnValue=!1,a.cancelBubble=!0)}function E(e){switch(e.type){case "mousedown":case "touchstart":f=g(e);C=(new Date).getTime();t=!0;J=e;var c=a.getBoundingClientRect();x=c.top+(window.pageYOffset||a.scrollTop||document.body.scrollTop)-(a.clientTop||document.body.clientTop||0);y=c.left+(window.pageXOffset||a.scrollLeft||document.body.scrollLeft)-(a.clientLeft||document.body.clientLeft||0);D=!0;z.hold(e);b.prevent_default&&w(e);break;case "mousemove":case "touchmove":if(!D)return!1;d=g(e);z.transform(e)|| z.drag(e);break;case "mouseup":case "mouseout":case "touchcancel":case "touchend":if(!D||"transform"!=j&&e.touches&&0<e.touches.length)return!1;D=!1;c="drag"==j;z.swipe(e);c?k("dragend",{originalEvent:e,direction:r,distance:m,angle:p}):"transform"==j?k("transformend",{originalEvent:e,position:A,scale:h(f,d),rotation:I(f,d)}):z.tap(J);K=j;k("release",{originalEvent:e,gesture:j});A=d=f=void 0;t=!1;p=m=0;j=null}}function F(a,c,b){c=c.split(" ");for(var d=0,f=c.length;d<f;d++)a.addEventListener?a.addEventListener(c[d], b,!1):document.attachEvent&&a.attachEvent("on"+c[d],b)}var x,y,f,d,A,v=this;var s={prevent_default:!1,css_hacks:!0,swipe:!0,swipe_time:200,swipe_min_distance:20,drag:!0,drag_vertical:!0,drag_horizontal:!0,drag_min_distance:20,transform:!0,scale_treshold:0.1,rotation_treshold:15,tap:!0,tap_double:!0,tap_max_interval:300,tap_max_distance:10,tap_double_distance:20,hold:!0,hold_timeout:500},u=b,q={};if(u){for(var n in s)q[n]=n in u?u[n]:s[n];b=q}else b=s;if(b.css_hacks){s=["webkit","moz","ms","o",""]; u={userSelect:"none",touchCallout:"none",userDrag:"none",tapHighlightColor:"rgba(0,0,0,0)"};q="";for(n=0;n<s.length;n++)for(var L in u)q=L,s[n]&&(q=s[n]+q.substring(0,1).toUpperCase()+q.substring(1)),a.style[q]=u[L]}var m=0,p=0,r=0;A=d=f=void 0;var t=!1,j=null,K=null,C=null,B={x:0,y:0},G=null,M=null;y=x=void 0;var D=!1,J,H="ontouchstart"in window;this.option=function(a,c){c!=l&&(b[a]=c);return b[a]};this.getDirectionFromAngle=function(a){a={down:45<=a&&135>a,left:135<=a||-135>=a,up:-45>a&&-135<a, right:-45<=a&&45>=a};var c,b;for(b in a)if(a[b]){c=b;break}return c};var z={hold:function(a){b.hold&&(j="hold",clearTimeout(M),M=setTimeout(function(){"hold"==j&&k("hold",{originalEvent:a,position:f})},b.hold_timeout))},swipe:function(a){if(d){var c=d[0].x-f[0].x,h=d[0].y-f[0].y;m=Math.sqrt(c*c+h*h);var g=(new Date).getTime()-C;b.swipe&&b.swipe_time>g&&m>b.swipe_min_distance&&(p=180*Math.atan2(d[0].y-f[0].y,d[0].x-f[0].x)/Math.PI,r=v.getDirectionFromAngle(p),j="swipe",k("swipe",{originalEvent:a,position:{x:d[0].x- y,y:d[0].y-x},direction:r,distance:m,distanceX:c,distanceY:h,angle:p}))}},drag:function(a){var c=d[0].x-f[0].x,h=d[0].y-f[0].y;m=Math.sqrt(c*c+h*h);if(b.drag&&m>b.drag_min_distance||"drag"==j){p=180*Math.atan2(d[0].y-f[0].y,d[0].x-f[0].x)/Math.PI;r=v.getDirectionFromAngle(p);var g="up"==r||"down"==r;(g&&!b.drag_vertical||!g&&!b.drag_horizontal)&&m>b.drag_min_distance||(j="drag",c={originalEvent:a,position:{x:d[0].x-y,y:d[0].y-x},direction:r,distance:m,distanceX:c,distanceY:h,angle:p},t&&(k("dragstart", c),t=!1),k("drag",c),w(a))}},transform:function(a){if(b.transform){if(2!=(a.touches?a.touches.length:1))return!1;var c=I(f,d),g=h(f,d);if("drag"!=j&&("transform"==j||Math.abs(1-g)>b.scale_treshold||Math.abs(c)>b.rotation_treshold))return j="transform",A={x:(d[0].x+d[1].x)/2-y,y:(d[0].y+d[1].y)/2-x},c={originalEvent:a,position:A,scale:g,rotation:c},t&&(k("transformstart",c),t=!1),k("transform",c),w(a),!0}return!1},tap:function(a){var c=(new Date).getTime(),h=c-C;if(!b.hold||b.hold&&b.hold_timeout> h){if(B&&b.tap_double&&"tap"==K&&C-G<b.tap_max_interval)var h=Math.abs(B[0].x-f[0].x),g=Math.abs(B[0].y-f[0].y),h=B&&f&&Math.max(h,g)<b.tap_double_distance;else h=!1;h?(j="double_tap",G=null,k("doubletap",{originalEvent:a,position:f}),w(a)):(h=d?Math.abs(d[0].x-f[0].x):0,g=d?Math.abs(d[0].y-f[0].y):0,m=Math.max(h,g),m<b.tap_max_distance&&(j="tap",G=c,B=f,b.tap&&(k("tap",{originalEvent:a,position:f}),w(a))))}}};H?F(a,"touchstart touchmove touchend touchcancel",E):(F(a,"mouseup mousedown mousemove", E),F(a,"mouseout",function(b){var c;a:if(c=b.relatedTarget,!c&&window.event&&window.event.toElement&&(c=window.event.toElement),a===c)c=!0;else{if(c)for(c=c.parentNode;null!==c;){if(c===a){c=!0;break a}c=c.parentNode}c=!1}c||E(b)}))} (function(a){a.each("hold tap doubletap transformstart transform transformend dragstart drag dragend swipe release".split(" "),function(b,l){a.event.special[l]={setup:function(b){var h=a(this);h.hammer||h.data("hammerjs",new Hammer(this,b));h.data("hammerjs")["on"+l]=function(b){h.trigger(a.Event(l,b))}},teardown:function(){var b=a(this).data("hammerjs");b&&b["on"+l]&&delete b["on"+l]}}})})(jQuery); jQuery(document).ready(function(a){if(800>a(window).width()){var b=function(b,g){var k="html";a.browser.webkit&&(k="body");a(k).animate({scrollTop:b.offset().top},500,g||!1)};a(".row-actions span, .row-actions-visible span").each(function(){var b=a(this).find("a");a(this).html(b)});a(".column-date br").replaceWith(" - ");a(".response-links .post-com-count-wrapper br").replaceWith(" ");a(".column-tags").each(function(){var b=a(this).html(),b=b.replace(RegExp(",","gi")," ");a(this).html(b)});a("#adminmenushadow").after(\'<div id="adminmenushadow_left"></div>\'); a("#wpcontent").append(\'<a href="#adminmenu" class="juiz_goto_menu">Menu</a>\');a(".juiz_goto_menu").live("click",function(){b(a("#adminmenu"));return!1});a(".juiz_goto_header").css("display","block").live("click",function(){b(a("#wpcontent"))});document.location.href.match(".php")&&b(a("#wpcontent"));if(1==a("body.edit-tags-php").length||1==a("body.nav-menus-php").length)a("body.edit-tags-php").find(".icon32").next("h2").after(\'<a class="juiz_goto_tag add_and_go_to_bottom" href="#addtag"><em lang="en">Add</em> / <em lang="fr">Ajouter</em></a>\'), a("body.nav-menus-php").find(".icon32").next("h2").after(\'<a class="juiz_goto_menus add_and_go_to_bottom" href="#menu-management-liquid"><em lang="en">Add</em> / <em lang="fr">Ajouter</em></a>\'),a(".juiz_goto_tag").live("click",function(){b(a("#addtag"),function(){a("#tag-name").focus()});return!1}),a(".juiz_goto_menu").live("click",function(){b(a("#menu-management-liquid"),function(){a("#menu-name").focus()});return!1});a(".galerie_page_nggallery-add-gallery").find("#disable_flash").trigger("click"); a("body.media-new-php").find(".upload-flash-bypass > a").trigger("click");/iPhone/i.test(navigator.userAgent)&&!location.hash&&setTimeout(function(){pageYOffset||window.scrollTo(0,1)},1E3);if(0<a("#wpadminbar").length&&0==a(".branch-3-3, .branch-3-4, .branch-3-5").length){var l=a("#wpadminbar"),g=l.find(".quicklinks>ul");l.find("#adminbarsearch");l=a("#wpadminbar .avatar").attr("src");output_ab=\'<form id="juiz_admin_bar" action="#">\';output_ab+=\'<label for="juiz_goto"><img src="\'+l+\'" alt="Action :" width="16" height="16" /></label>\'; output_ab+=\'<select name="juiz_goto" id="juiz_goto">\';a(g).children("li").each(function(){var b=a(this).children("a").attr("href"),g=a(this).children("a").text();0<a(this).find("li").length?(output_ab+=\'<optgroup label="\'+g+\'">\',a(this).find("li").each(function(){var b=a(this).children("a").attr("href"),h=a(this).children("a").text();output_ab+=\'<option value="\'+b+\'">\'+h+"</option>"}),output_ab+="</optgroup>"):output_ab+=\'<option value="\'+b+\'">&gt;&gt; \'+g+"</option>"});output_ab+="</select>";output_ab+= \'<input type="submit" class="adminbar-button" value="Go" />\';output_ab+="</form>";a("#wpadminbar .quicklinks ul").remove();a("#wpadminbar .quicklinks").append(output_ab);a("#juiz_admin_bar").submit(function(){var b=a("#juiz_admin_bar option:selected").val();window.location.href=b;return!1})}else 0<a("#wpadminbar").length&&0<a(".branch-3-3, .branch-3-4, .branch-3-5").length&&(console.log("test"),a("#wpadminbar").insertBefore("#wpwrap"));a(".wp-submenu-wrap li, .wp-submenu-wrap li a, li.wp-has-submenu, li.wp-has-submenu a").unbind("release, tap, mouseenter, mouseleave, mousehover"); a(".wp-submenu-wrap li, .wp-submenu-wrap li a, li.wp-has-submenu, li.wp-has-submenu a").off("release, tap, mouseenter, mouseleave, mousehover");a(".wp-submenu-wrap li, .wp-submenu-wrap li a, li.wp-has-submenu, li.wp-has-submenu a").die("release, tap, mouseenter, mouseleave, mousehover");g=a("#adminmenu");a(\'li.menu-top:not(".wp-has-submenu")\',g).on("tap",function(b){b.stopPropagation();window.location.href=a(this).children.attr(href);return!1});a("li.wp-has-submenu>a",g).on("swipe",function(){return!1}); a("a.thickbox").each(function(){var b=a(this).attr("href"),g=a(this).text();a(this).after(\'<a class="juiz_sma_thickbox" target="_blank" href="\'+b+\'">\'+g+"</a>").remove()})}});
				</script>
			';
		}
	}

	// description setting page
	add_filter( 'plugin_action_links_'.plugin_basename( __FILE__ ), 'juiz_sma_plugin_action_links',  10, 2);
	function juiz_sma_plugin_action_links( $links, $file ) {
		$links[] = '<a href="'.admin_url('themes.php?page='.JUIZ_SMA_SLUG).'">' . __('Settings') .'</a>';
		return $links;
	}


	// custom howdy
	add_filter( 'admin_bar_menu', 'juiz_update_howdy' );
	function juiz_update_howdy( $wp_admin_bar ) {
		global $current_user;
		$my_account = $wp_admin_bar -> get_node('my-account');
		$howdy = sprintf( __('Howdy, %1$s'), $current_user -> display_name );
		$title = str_replace( $howdy, '<span class="hide_if_smart">'.$howdy.'</span>', $my_account -> title );
		$wp_admin_bar -> add_node( array(
			'id' => 'my-account',
			'title' => $title,
			'meta' => array()
		) );
	}
	
	// custom footer
	add_filter( 'admin_footer_text', 'juiz_sma_footer_admin', 10, 1);
	function juiz_sma_footer_admin($default) {
		$options = get_option( JUIZ_SMA_SETTING_NAME );
		if(isset($options['juiz_sma_footer']) AND $options['juiz_sma_footer'] == 1) {
			echo '<span id="footer-thankyou">';
			echo '<a href="http://www.wordpress-fr.net/">WordPress</a> • <a href="'.admin_url('credits.php').'">'.__('Credits', 'jsma_lang').'</a><br />';
			echo __('Mobile Admin support by <a href="http://wordpress.org/extend/plugins/juiz-smart-mobile-admin">Juiz SMA</a>', 'jsma_lang');
			echo '<a href="#wpcontent" class="juiz_goto_header"> '.__('Top of page', 'jsma_lang').'</a></span>';
		}
		else return $default;
	}
	
	add_filter( 'admin_head', 'juiz_sma_hide_shortcuts');
	function juiz_sma_hide_shortcuts() {
		$options = get_option( JUIZ_SMA_SETTING_NAME );
		if(isset($options['juiz_sma_adminbar']) AND $options['juiz_sma_adminbar'] == 0) {
			echo '<!-- Juiz Smart Mobile Admin plugin -->
			<style type="text/css" media="screen and (max-width: 640px)">
				<!--
				#wp-admin-bar-new-content + li {
					display: none!important;
				}
				-->
			</style>
			<!-- Juiz Smart Mobile Admin plugin -->';
		}
	}

	if ( get_bloginfo('version') == '3.8' || get_bloginfo('version') == '3.8-src'  || get_bloginfo('version') == '3.8.1' || get_bloginfo('version') == '3.8.2'  || get_bloginfo('version') == '3.8.3') {

		add_action('admin_notices', 'juiz_sma_admin_notices');
		function juiz_sma_admin_notices() {
			echo '<div class="error">
						<h3>'.__("Don't worry!",'juiz_sma').'</h3>
						<p>'.__('You are using Juiz Smart Mobile Admin in WordPress 3.8. WP3.8 is fully responsive, you can deactivate and uninstall Juiz Smart Mobile Admin forever.<br> Thank you.<br />Geoffrey','juiz_sma').'</p>
					</div>';
		}

	}

	// Enqueue & deregister
	add_action( 'init', 'juiz_sma_style_and_script');
	function juiz_sma_style_and_script() {
		
		global $is_iphone;
		
		// hope this deregistration works
		if ( function_exists('wp_is_mobile') AND wp_is_mobile() ) {
			wp_deregister_script( 'jquery-ui-resizable');
			wp_deregister_script( 'jquery-ui-draggable');
			wp_deregister_script( 'jquery-ui-droppable');
		}
	
	}
		
	/*
	 * Options page
	 */
	 	 
	// Settings page in admin menu

	add_action('admin_menu', 'add_juiz_sma_settings_page');
	function add_juiz_sma_settings_page() {
		add_submenu_page( 
			'themes.php', 
			__('Admin Mobile Appearance', 'jsma_lang'),
			__('Admin Mobile Appearance', 'jsma_lang'),
			'edit_posts',
			JUIZ_SMA_SLUG ,
			'juiz_sma_settings_page' 
		);
	}
	
	// adds sections and fields
	
	function add_juiz_sma_plugin_options() {
		// all options in single registration as array
		register_setting( JUIZ_SMA_SETTING_NAME, JUIZ_SMA_SETTING_NAME, 'juiz_sma_sanitize' );
		add_settings_section('juiz_sma_plugin_main', __('Main settings','jsma_lang'), 'juiz_sma_section_text', JUIZ_SMA_SLUG);
		add_settings_field('juiz_sma_adminbar', __('Show plugins shortcuts in adminbar?', 'jsma_lang'), 'juiz_sma_setting_radio_adminbar', JUIZ_SMA_SLUG, 'juiz_sma_plugin_main');
		add_settings_field('juiz_sma_footer', __('Show custom WP admin footer ?', 'jsma_lang') , 'juiz_sma_setting_radio_footer', JUIZ_SMA_SLUG, 'juiz_sma_plugin_main');
	}
	add_filter('admin_init','add_juiz_sma_plugin_options');

	
	// sanitize posted data
	
	function juiz_sma_sanitize($options) {
		
		$newoptions['juiz_sma_footer'] = preg_match('#[1|0]#', $options['juiz_sma_footer']) ? intval($options['juiz_sma_footer']) : 0;
		$newoptions['juiz_sma_adminbar'] = preg_match('#[1|0]#', $options['juiz_sma_adminbar']) ? intval($options['juiz_sma_adminbar']) : 0;
		
		return $newoptions;
	}
	
	// first section text
	function juiz_sma_section_text() {
		echo '<p>'. __('Here, you can modify default settings of the SMA plugin', 'jsma_lang') .'</p>';
		if (isset($_GET['settings-updated']) AND $_GET['settings-updated'] == 'true')
			echo '<div class="updated settings-error below-h2">
					<p>'.__('Settings saved','jsma_lang').'</p>
				  </div>';
	}
	
	// radio fields for footer
	function juiz_sma_setting_radio_footer() {
		$y = $n = '';
		$options = get_option( JUIZ_SMA_SETTING_NAME );
		if ( is_array($options) )
			(isset($options['juiz_sma_footer']) AND $options['juiz_sma_footer']==1) ? $y = " checked='checked'" : $n = " checked='checked'";
		
			echo "	<input id='jsma_footer_y' value='1' name='".JUIZ_SMA_SETTING_NAME."[juiz_sma_footer]' type='radio' ".$y." />
					<label for='jsma_footer_y'> ". __('Yes', 'jsma_lang') . "</label>
					&nbsp;&nbsp;
					<input id='jsma_footer_n' value='0' name='".JUIZ_SMA_SETTING_NAME."[juiz_sma_footer]' type='radio' ".$n." />
					<label for='jsma_footer_n'> ". __('No', 'jsma_lang') . "</label>";
	}
	
	// radio fields for adminbar
	function juiz_sma_setting_radio_adminbar() {
		$y = $n = '';
		$options = get_option( JUIZ_SMA_SETTING_NAME );
		if ( is_array($options) )
			(isset($options['juiz_sma_adminbar']) AND $options['juiz_sma_adminbar']==1) ? $y = " checked='checked'" : $n = " checked='checked'";
		
			echo "	<input id='jsma_adminbar_y' value='1' name='".JUIZ_SMA_SETTING_NAME."[juiz_sma_adminbar]' type='radio' ".$y." />
					<label for='jsma_adminbar_y'> ". __('Yes', 'jsma_lang') . "</label>
					&nbsp;&nbsp;
					<input id='jsma_adminbar_n' value='0' name='".JUIZ_SMA_SETTING_NAME."[juiz_sma_adminbar]' type='radio' ".$n." />
					<label for='jsma_adminbar_n'> ". __('No', 'jsma_lang') . "</label>";
	}
	
	


	// The page layout/form

	function juiz_sma_settings_page() {
		?>
		<div id="juiz-sma" class="wrap">
			<div id="icon-themes" class="icon32">&nbsp;</div>
			<h2><?php _e('Manage Juiz Smart Mobile Admin', 'jsma_lang') ?></h2>

			<form method="post" action="options.php">
				<?php
					settings_fields( JUIZ_SMA_SETTING_NAME );
					do_settings_sections( JUIZ_SMA_SLUG );
					submit_button();
				?>
			</form>

			<p class="juiz_bottom_links">
				<em><?php _e('Like it? Support this plugin! Thank you.', 'jsma_lang') ?></em>
				<a class="juiz_paypal" target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=P39NJPCWVXGDY&lc=FR&item_name=Juiz%20Smart%20Mobile%20Admin%20%2d%20WordPress%20Plugin&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted"><?php _e('Donate', 'jsma_lang') ?></a>
				<a class="juiz_twitter" target="_blank" href="https://twitter.com/intent/tweet?source=webclient&amp;hastags=WordPress,Plugin&amp;text=Juiz%20Smart%20Mobile%20Admin%20is%20an%20awesome%20WordPress%20plugin%20to%20have%20a%20responsive%20admin!%20Try%20it!&amp;url=http://wordpress.org/extend/plugins/juiz-smart-mobile-admin/&amp;related=geoffrey_crofte&amp;via=geoffrey_crofte"><?php _e('Tweet it', 'jsma_lang') ?></a>
				<a class="juiz_rate" target="_blank" href="http://wordpress.org/support/view/plugin-reviews/juiz-smart-mobile-admin"><?php _e('Rate it', 'jsma_lang') ?></a>
			</p>
		</div>
		<?php
	}

}

