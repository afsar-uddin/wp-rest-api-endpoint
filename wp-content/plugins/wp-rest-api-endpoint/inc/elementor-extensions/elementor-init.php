<?php

/**
 * Loading Elementor Widgets
 * @since 1.0.0
 * @author ITclanbd
 */
if ( ! function_exists( 'nwt_elementor_elements' ) ) {
	function nwt_elementor_elements() {

		foreach ( glob( plugin_dir_path( __FILE__ ) . "widgets/*.php" ) as $file ) {
			include_once $file;
		}

	}
}
add_filter( 'elementor/widgets/widgets_registered', 'nwt_elementor_elements' );

/**
 * Add Widget Category
 * @since 1.0.0
 * @author ITclanbd
 */
require_once( NWT_INC_DIR . '/elementor-extensions/elementor-section.php' );

/** Icofont Icons Class Array File*/
require_once( NWT_INC_DIR . '/elementor-extensions/icons/icofont-icons.php' );


/** Adding custom icon to icon control in Elementor*/
add_filter( 'elementor/icons_manager/additional_tabs', 'nwt_core_add_custom_icons_tab' );
function nwt_core_add_custom_icons_tab( $tabs = array() ) {

	$tabs['icofont']  = array(
		'name'          => 'icofont',
		'label'         => esc_html__( 'Icofonts', 'nwt-core' ),
		'labelIcon'     => 'icofont-brand-icofont',
		'prefix'        => 'icofont-',
		'displayPrefix' => 'icofont',
		'url'           => NWT_CORE_URL . '/assets/css/icofont.min.css',
		'icons'         => icoFont_icon(),
		'ver'           => '1.0.0',
	);
	return $tabs;
}

/** Elementor editor scripts*/
add_action( 'elementor/editor/before_enqueue_scripts', 'enqueue_editor_scripts' );
function enqueue_editor_scripts() {
	wp_enqueue_style(
		'nwt-core-icofont',
		NWT_CORE_URL . '/assets/css/icofont.min.css',
		null,
		NWT_CORE_VERSION
	);

	wp_enqueue_style(
		'nwt-core-elementor-editor',
		NWT_CORE_URL . '/admin/css/nwt-editor.css',
		null,
		NWT_CORE_VERSION
	);

}