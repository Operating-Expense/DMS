<?php

use DMS\Helper\Media;
use DMS\Helper\Utils;

$atts = $data['atts'];

$attributes = $classes = array();

$classes[] = 'shortcode-about';
if ( ! empty( $atts['el_classes'] ) ) {
	$classes[] = esc_html( $atts['el_classes'] );
}

$attributes[] = ! empty( $atts['el_id'] ) ? 'id="' . $atts['el_id'] . '"' : '';
$attributes[] = ! empty( $classes ) ? 'class="' . implode( ' ', $classes ) . '"' : '';

$title = $atts['title'];
$text  = ! empty( $data['content'] )
	? apply_filters( 'the_content', $data['content'] )
	: '';

$image_id  = (int) $atts['image'];
$image_url = wp_get_attachment_url( $image_id );


?>
<section <?php echo implode( $attributes ); ?>>
	
	
	<div class="row">
		
		<div class="col-md-6 d-none d-md-flex s-about__left">
			<?php
			if ( $image_url ) { ?>
				<?php
				Media::the_img(
					array( 'data-width' => 309, 'data-height' => 108, 'class' => 's-about__brand s-about__brand_l' ),
					array( 'attachment_id' => $image_id )
				);
				?>
			<?php } ?>
		</div>
		
		<div class="col-md-6 s-about__right">
			
				<?php
			if ( $image_url ) { ?>
				<?php
				Media::the_img(
					array( 'data-width' => 309, 'data-height' => 108, 'class' => 's-about__brand s-about__brand_r d-md-none d-lg-none' ),
					array( 'attachment_id' => $image_id )
				);
				?>
			<?php } ?>
			
			<?php if ( $title ) { ?>
				<h2 class="s-about__title">
					<?php echo $title ?>
				</h2>
			<?php } ?>
			
			<?php if ( $text ) { ?>
				<div class="s-about__text">
					<?php echo $text ?>
				</div>
			<?php } ?>
		
		
		</div>
	
	</div>


</section>
