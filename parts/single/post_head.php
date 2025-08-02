<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 投稿ページのタイトル部分
 */
$SETTING       = SWELL_Theme::get_setting();
$the_id        = get_the_ID();
$posted_time   = get_post_datetime( $the_id, 'date' );
$modified_time = get_post_datetime( $the_id, 'modified' );
?>
<div class="p-articleHead c-postTitle">
	<h1 class="c-postTitle__ttl"><?php the_title(); ?></h1>
	<?php
		// タイトル横に表示する日付
		\SWELL_Theme::pluggable_parts( 'title_date', [
			'time' => 'modified' === SWELL_Theme::get_setting( 'title_date_type' ) ? $modified_time : $posted_time,
		] );
	?>
</div>
<div class="p-articleMetas -top">
	<?php
		// ターム
		SWELL_Theme::get_parts( 'parts/single/item/term_list', [
			'show_cat' => $SETTING['show_meta_cat'],
			'show_tag' => $SETTING['show_meta_tag'],
			'show_tax' => $SETTING['show_meta_tax'],
		] );

		// 公開日・更新日
		SWELL_Theme::get_parts( 'parts/single/item/times', [
			'posted_time'   => $SETTING['show_meta_posted'] ? $posted_time : null,
			'modified_time' => $SETTING['show_meta_modified'] ? $modified_time : null,
		] );

		// 著者
		if ( $SETTING['show_meta_author'] ) :
			$post_data = get_post( $the_id );
			\SWELL_Theme::pluggable_parts( 'the_post_author', [ 'author_id' => $post_data->post_author ] );
		endif;
	?>
</div>
