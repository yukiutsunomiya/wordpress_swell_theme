<?php
namespace SWELL_Theme\Block\Blog_Parts;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ブログパーツブロック
 */
\SWELL_Theme::register_block( 'blog-parts', [
	'render_callback' => function ( $attrs ) {
		$parts_id = $attrs['partsID'] ?: 0;
		$content  = \SWELL_Theme::get_blog_parts_content( [ 'id' => $parts_id ] );

		$bp_class = 'p-blogParts post_content';
		if ( $attrs['className'] ) {
			$bp_class .= ' ' . $attrs['className'];
		}

		$content = \SWELL_Theme::do_blog_parts( $content );
		return '<div class="' . esc_attr( $bp_class ) . '" data-partsID="' . esc_attr( $parts_id ) . '">' . $content . '</div>';
	},
] );
