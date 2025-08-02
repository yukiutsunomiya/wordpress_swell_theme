<?php
namespace SWELL_Theme\Gutenberg;

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * FAQブロック
 */
add_filter( 'render_block_loos/faq', __NAMESPACE__ . '\render_faq', 10, 2 );
function render_faq( $block_content, $block ) {

	$atts         = $block['attrs'] ?? [];
	$outputJsonLd = $atts['outputJsonLd'] ?? false;

	if ( ! $outputJsonLd ) return $block_content;

	$is_matched = preg_match_all( '/<dt class="faq_q">.+?<\/dt>/s', $block_content, $questions );
	if ( ! $is_matched ) return $block_content;

	$is_matched = preg_match_all( '/<dd class="faq_a">.+?<\/dd>/s', $block_content, $answers );
	if ( ! $is_matched ) return $block_content;

	$faqs = [];
	foreach ( $questions[0] as $i => $question ) {

		if ( ! isset( $answers[0][ $i ] ) ) break;
		$question = wp_strip_all_tags( do_shortcode( $question ), true );

		// Answerは一部HTMLが許可されている: https://developers.google.com/search/docs/data-types/faqpage?hl=ja#answer
		$answer = strip_tags(
			do_shortcode( $answers[0][ $i ] ),
			'<h1><h2><h3><h4><h5><h6><br><ol><ul><li><a><p><div><b><strong><em>' // <i>は除外
		);
		$answer = str_replace( "\n", '', $answer );

		$faqs[] = [
			'@type'           => 'Question',
			'name'            => $question,
			'acceptedAnswer'  => [
				'@type' => 'Answer',
				'text'  => $answer,
			],
		];
	}

	$json_ld_data = [
		'@context'   => 'https://schema.org',
		'@id'        => '#FAQContents',
		'@type'      => 'FAQPage',
		'mainEntity' => $faqs,
	];

	$block_content .= '<script type="application/ld+json">' . wp_json_encode( $json_ld_data, JSON_UNESCAPED_UNICODE ) . '</script>' . PHP_EOL;

	return $block_content;
}
