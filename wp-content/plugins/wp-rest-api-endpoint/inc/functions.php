<?php
add_action( 'wp_enqueue_scripts', 'ic_core_scripts', 99 );
function ic_core_scripts() {

	wp_enqueue_script(
		'nwt-core',
		NWT_CORE_URL . '/assets/js/nwt-core.js',
		array( 'jquery' ),
		NWT_CORE_VERSION,
		true
	);
	wp_localize_script(
		'nwt-core',
		'nwt_core_ajax_object',
		array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
		)
	);
}