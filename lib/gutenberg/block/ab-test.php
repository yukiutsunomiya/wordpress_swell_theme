<?php
namespace SWELL_Theme\Block\Ab_Test;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ABテストブロック
 */
\SWELL_Theme::register_block( 'ab-test', [
	'render_callback' => __NAMESPACE__ . '\cb',
] );

function cb( $attrs, $content, $block ) {

	$flag_num = rand( 1, 100 ); // phpcs:ignore WordPress.WP.AlternativeFunctions.rand_rand
	$rate_A   = $attrs['rate'] ?? 50; // 0 ~ 100
	$show_A   = $rate_A >= $flag_num;

	// AとBのブロックがちゃんとあるかチェック。なければ1つ目のブロック(A) を表示
	if ( count( $block->parsed_block['innerBlocks'] ) < 2 ) {
		$show_A = true;
	}

	if ( $show_A ) {
		// Aを表示
		$blocks = $block->parsed_block['innerBlocks'][0]['innerBlocks'];
	} else {
		// Bを表示
		$blocks = $block->parsed_block['innerBlocks'][1]['innerBlocks'];
	}

	return do_blocks( serialize_blocks( $blocks ) );
}
