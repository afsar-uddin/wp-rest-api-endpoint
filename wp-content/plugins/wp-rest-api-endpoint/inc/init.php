<?php
defined( 'ABSPATH' ) || exit;

/**
 * Auto loading all custom widgets
 * @since 1.0.0
 * @author ITclanbd
 */
foreach ( glob( plugin_dir_path( __FILE__ ) . "theme-widgets/*.php" ) as $file ) {
	include_once $file;
}

/**
 * Loading Elementor Extension
 * @since 1.0
 * @author ITclanbd
 */
if ( did_action( 'elementor/loaded' ) ) {
	require_once( NWT_INC_DIR . '/elementor-extensions/elementor-init.php' );
}

/**
 * Loading plugin functions
 * @since 1.0.0
 * @author ITclanbd
 */
require_once( NWT_INC_DIR . '/functions.php' );
require_once( NWT_INC_DIR . '/ajax-functions.php' );

/** Load all kirki settings files*/
if ( class_exists( 'Kirki' ) ) {
	require_once( NWT_INC_DIR . '/kirki-options/add-settings.php' );
}

// api
require_once( NWT_INC_DIR . '/api/api-init.php' );


/**
 * Auto loading all classes
 * @since 1.0.0
 * @author ITclanbd
 */
foreach ( glob( plugin_dir_path( __FILE__ ) . "classes/*.php" ) as $file ) {
	require_once $file;
}

/** metabox tabs*/
// if ( ! class_exists( 'MB_Tabs' ) ) {
// 	if ( file_exists( NWT_INC_DIR . '/extensions/meta-box/addons/meta-box-tabs/meta-box-tabs.php' ) ) {
// 		include_once( NWT_INC_DIR . '/extensions/meta-box/addons/meta-box-tabs/meta-box-tabs.php' );
// 	}
// }

function ic_var_dump( $var ) {
	echo '<pre>';
	var_dump( $var );
	echo '</pre>';
}

