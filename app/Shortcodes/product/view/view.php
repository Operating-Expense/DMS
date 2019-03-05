<?php

use DMS\Helper\Media;
use DMS\Helper\Utils;

$atts = $data['atts'];

$attributes = $classes = array();

$classes[] = 'shortcode-product';
if ( ! empty( $atts['el_classes'] ) ) {
	$classes[] = esc_html( $atts['el_classes'] );
}

$attributes[] = ! empty( $atts['el_id'] ) ? 'id="' . $atts['el_id'] . '"' : '';
$attributes[] = ! empty( $classes ) ? 'class="' . implode( ' ', $classes ) . '"' : '';

//$attributes_carousel[] = 'data-num="' . $atts['num'] . '"';
//$attributes_carousel[] = 'data-num-medium="' . $atts['num_medium'] . '"';
//$attributes_carousel[] = 'data-num-small="' . $atts['num_small'] . '"';
$attributes_carousel[] = 'data-autoplay="' . $atts['autoplay'] . '"';
$attributes_carousel[] = 'data-autoplay-speed="' . $atts['autoplay_speed'] . '"';


$title = esc_html( $atts['title'] );
$text  = ! empty( $data['content'] )
	? apply_filters( 'the_content', $data['content'] )
	: '';


?>
<section <?php echo implode( ' ', $attributes ); ?>>
	
	
	<div class="row">
		
		<div class="col-md-12 col-lg-6 s-product__left">
			
			
			<?php if ( $title ) { ?>
				<h2 class="s-product--title">
					<?php echo $title ?>
				</h2>
			<?php } ?>
			
			<?php if ( $text ) { ?>
				<div class="s-product--text">
					<?php echo $text ?>
				</div>
			<?php } ?>
		
		
		</div>
		
		<div class="col-md-12 col-lg-6 s-product__right">
			
			<div class="s-product__monitor">
				<?php if ( ! empty( $atts['items_arr'] ) ) { ?>
					
					<div class="s-product-carousel" <?php echo implode( ' ', $attributes_carousel ); ?>>
						
						<?php
						foreach ( $atts['items_arr'] as $item ) {
							
							$item_title     = ! empty( $item['item_title'] ) ? esc_html( $item['item_title'] ) : '';
							$item_text      = ! empty( $item['item_text'] ) ? esc_html( $item['item_text'] ) : '';
							$item_image_id  = (int) $item['item_image'];
							$item_image_url = wp_get_attachment_url( $item_image_id );
							$item_class     = ! empty( $item['item_el_classes'] ) ? ' ' . esc_attr( $item['item_el_classes'] ) : '';
							
							?>
							
							<div class="s-product-carousel-item"> <!-- slick change styles here -->
								
								<div class="s-product-inside <?php echo $item_class ?> ">
									
									<div class="s-product__item">
										
										<?php
										if ( $item_image_url ) { ?>
											<div class="s-product__img_wrap">
												<?php
												Media::the_img(
													array( 'data-width' => 60, 'class' => 's-product__img skip-lazy' ),
													array( 'attachment_id' => $item_image_id )
												);
												?>
											</div>
										<?php } ?>
										
										<div class="s-product__body">
											<div class="s-product__title">
												<?php echo $item_title ?>
											</div>
											<div class="s-product__text">
												<?php echo $item_text ?>
											</div>
										</div>
									
									
									</div>
								
								</div>
							
							</div>
						
						<?php } ?>
					</div>
					<?php
				} ?>
			
			</div>
		
		
		</div>
	
	</div>


</section>
