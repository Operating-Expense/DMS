<?php

use DMS\Helper\Media;

$atts = $data['atts'];

$attributes = $classes = $attributes_carousel = array();

$classes[] = 'shortcode-image_slider';
if ( ! empty( $atts['el_classes'] ) ) {
	$classes[] = esc_html( $atts['el_classes'] );
}

$attributes[] = ! empty( $atts['el_id'] ) ? 'id="' . $atts['el_id'] . '"' : '';
$attributes[] = ! empty( $classes ) ? 'class="' . implode( ' ', $classes ) . '"' : '';

$attributes_carousel[] = 'data-num="' . $atts['num'] . '"';
$attributes_carousel[] = 'data-num-medium="' . $atts['num_medium'] . '"';
$attributes_carousel[] = 'data-num-small="' . $atts['num_small'] . '"';
$attributes_carousel[] = 'data-autoplay="' . $atts['autoplay'] . '"';
$attributes_carousel[] = 'data-autoplay-speed="' . $atts['autoplay_speed'] . '"';


?>
<div <?php echo implode( ' ', $attributes ); ?>>
	
	
	<?php if ( ! empty( $atts['title'] ) ) { ?>
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h2 class="s-is-title">
						<?php echo $atts['title'] ?>
					</h2>
				</div>
			</div>
		</div>
	<?php } ?>
	
	
	<?php if ( ! empty( $atts['items_arr'] ) ) { ?>
		
		<div class="s-is-carousel" <?php echo implode( ' ', $attributes_carousel ); ?>>
			
			<?php
			foreach ( $atts['items_arr'] as $item ) {
				
				$item_image_id  = (int) $item['item_image'];
				$item_image_url = wp_get_attachment_url( $item_image_id );
				$item_url       = ! empty( $item['item_url'] ) ? esc_url( $item['item_url'] ) : '';
				$item_class     = ! empty( $item['item_el_classes'] ) ? ' ' . esc_attr( $item['item_el_classes'] ) : '';
				
				?>
				
				<div class="s-is-carousel-item"> <!-- slick change styles here -->
					
					<div class="s-is-inside <?php echo $item_class ?> ">
						
						<div class="s-is__item">
							
							<?php
							if ( $item_image_url ) { ?>
								
								<?php if ( $item_url ) { ?>
									<a href="<?php echo $item_url ?>" target="_blank" rel="nofollow">
								<?php } ?>
								
								<?php
								Media::the_img(
									array( 'data-width' => 280, 'data-height' => 100, 'class' => 's-is__img skip-lazy' ),
									array( 'attachment_id' => $item_image_id )
								);
								?>
								
								<?php if ( $item_url ) { ?>
									</a>
								<?php } ?>
							
							<?php } ?>
						
						
						</div>
					
					</div>
				
				</div>
			
			<?php } ?>
		</div>
		<?php
	} ?>

</div>