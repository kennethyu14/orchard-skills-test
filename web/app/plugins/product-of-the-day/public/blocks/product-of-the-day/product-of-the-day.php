<?php

    $classname = 'product-of-the-day';

    if ( ! empty( $block['className'] ) ) {
        $classname .= ' ' . $block['className'];
    }

    if ( ! empty( $block['align'] ) ) {
        $classname .= ' align' . $block['align'];
    }


    $args = array(
        'post_type'      => 'products',
        'posts_per_page' => 1,
        'meta_query'     => array(
            array(
                'key'    => '_featured',
                'value'  => true
            ),
        ),
        'orderby'        => 'rand'
    );
    
    $featured_products = new WP_Query( $args );

?>



<?php if ( $featured_products->have_posts() ) : ?>
    
    <?php while( $featured_products->have_posts() ) : $featured_products->the_post() ?>

        <div class="<?= $classname ?>" style="background-image: url(<?php echo get_the_post_thumbnail_url() ?>)">
    
            <div class="wrapper">
                <h2><?php the_title() ?></h2>
                <div class="product-summary"><?php the_excerpt() ?></div>
                <a
                    href="<?= get_the_permalink() ?>"
                    class="button product-cta" 
                    data-cta-id="<?= get_the_ID() ?>">
                    <?= get_field( 'cta_label', 'option' ) ?: __( 'See Details' ) ?>
                </a>
            </div>
            
        </div>
    
    <?php endwhile; ?>
        
    <?php wp_reset_postdata() ?>


<?php else : ?>

    <div class="<?= $classname ?>" style="background-image: url()">
        
        <h2>No featured products</h2>
    
    </div>
        
<?php endif; ?>