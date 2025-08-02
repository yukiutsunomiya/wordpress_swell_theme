<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
if ( is_front_page() ) :
	SWELL_Theme::get_parts( 'tmp/front' );
else :
	while ( have_posts() ) :
		the_post();
		$the_id = get_the_ID();
	?>
		<main id="main_content" class="l-mainContent l-article">
			<div class="l-mainContent__inner" data-clarity-region="article">
				<?php SWELL_Theme::get_parts( 'parts/page_head' ); ?>
				<div class="<?=esc_attr( apply_filters( 'swell_post_content_class', 'post_content' ) )?>">
					<?php the_content(); ?>
				</div>
				<?php
					// 改ページナビゲーション
					$defaults = [
						'before'           => '<div class="c-pagination -post">',
						'after'            => '</div>',
						'next_or_number'   => 'number',
						// 'pagelink'      => '<span>%</span>',
					];
					wp_link_pages( $defaults );

					// ページ下部ウィジェット
					SWELL_Theme::outuput_content_widget( 'page', 'bottom' );
				?>
			</div>
			<?php if ( SWELL_Theme::is_show_comments( $the_id ) ) comments_template(); ?>
		</main>
	<?php
	endwhile; // End loop
endif;
get_footer();
