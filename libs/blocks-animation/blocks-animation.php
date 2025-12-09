<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'BLOCKS_ANIMATION_URL', plugins_url( '/', __FILE__ ) );
define( 'BLOCKS_ANIMATION_PATH', dirname( __FILE__ ) );

add_action(
	'plugins_loaded',
	function () {
		// call this only if Gutenberg is active.
		if ( function_exists( 'register_block_type' ) ) {
			require_once dirname( __FILE__ ) . '/class-blocks-animation.php';

			if ( class_exists( '\ThemeIsle\GutenbergBlocks\Blocks_Animation' ) ) {
				\ThemeIsle\GutenbergBlocks\Blocks_Animation::instance();
			}
		}
	}
);
