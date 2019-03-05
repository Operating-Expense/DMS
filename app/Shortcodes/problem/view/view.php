<?php

use DMS\Helper\Media;

$atts = $data['atts'];

$attributes = $classes = array();

$classes[] = 'shortcode-problem';
if ( ! empty( $atts['el_classes'] ) ) {
	$classes[] = esc_html( $atts['el_classes'] );
}

$attributes[] = ! empty( $atts['el_id'] ) ? 'id="' . $atts['el_id'] . '"' : '';
$attributes[] = ! empty( $classes ) ? 'class="' . implode( ' ', $classes ) . '"' : '';

?>
<section <?php echo implode( ' ', $attributes ); ?>>
	
	
	<?php if ( ! empty( $atts['title'] ) ) { ?>
		<div class="row">
			<div class="col-12">
				<h2 class="s-problem-title">
					<?php echo $atts['title'] ?>
				</h2>
			</div>
		</div>
	<?php } ?>
	
	<?php if ( ! empty( $atts['items_arr'] ) ) { ?>
		
		<div class="row justify-content-center">
			
			<?php
			foreach ( $atts['items_arr'] as $item ) {
				
				$item_text     = ! empty( $item['item_text'] ) ? esc_html( $item['item_text'] ) : '';
				$item_image_id  = (int) $item['item_image'];
				$item_image_url = wp_get_attachment_url( $item_image_id );
				$item_class     = ! empty( $item['item_el_classes'] ) ? ' ' . esc_attr( $item['item_el_classes'] ) : '';
				$item_class     .= ! $item_image_url ? ' s-problem-wo-img' : '';
				
				?>
				
				
				<div class="col-md-6 col-lg-6 col-xl-4">
					
					<div class="s-problem <?php echo $item_class ?>">
						
						<?php
						if ( $item_image_url ) { ?>
							
							<?php
							Media::the_img(
								array( 'data-width' => 70, 'class' => 's-problem__img' ),
								array( 'attachment_id' => $item_image_id )
							);
							?>
						
						<?php } ?>
						
						<div class="s-problem__text">
							<?php echo $item_text ?>
						</div>
					
					</div>
				
				</div>
			
			<?php } ?>
		
		</div>
	
	<?php } ?>

</section>
