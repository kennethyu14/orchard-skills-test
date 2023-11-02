<?php get_header(); ?>

<main id="site-content">

	<?php

	if ( have_posts() ) {

		$i = 0;

		while ( have_posts() ) {
			$i++;
			if ( $i > 1 ) {
				echo '<hr class="post-separator styled-separator is-style-wide section-inner" aria-hidden="true" />';
			}
			the_post();

			get_template_part( 'template-parts/banner' );
			get_template_part( 'template-parts/content', get_post_type() );

		}
	}
    
	?>

</main><!-- #site-content -->

<?php get_footer(); ?>