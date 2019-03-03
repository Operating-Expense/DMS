<?php

use DMS\Helper\Media;

$atts = $data['atts'];

$attributes = $classes = array();

$classes[] = 'shortcode-target';
if ( ! empty( $atts['el_classes'] ) ) {
	$classes[] = esc_html( $atts['el_classes'] );
}

$attributes[] = ! empty( $atts['el_id'] ) ? 'id="' . $atts['el_id'] . '"' : '';
$attributes[] = ! empty( $classes ) ? 'class="' . implode( ' ', $classes ) . '"' : '';

?>
<section <?php echo implode( $attributes ); ?>>
	
	
	<?php if ( ! empty( $atts['title'] ) ) { ?>
		<div class="row">
			<div class="col-12">
				<h2 class="s-target-title">
					<?php echo $atts['title'] ?>
				</h2>
			</div>
		</div>
	<?php } ?>
	
	<?php if ( ! empty( $atts['items_arr'] ) ) { ?>
		
		<div class="row justify-content-center">
			
			<?php
			foreach ( $atts['items_arr'] as $item ) {
				
				$item_title     = ! empty( $item['item_title'] ) ? esc_html( $item['item_title'] ) : '';
				$item_image_id  = (int) $item['item_image'];
				$item_image_url = wp_get_attachment_url( $item_image_id );
				$item_class     = ! empty( $item['item_el_classes'] ) ? ' ' . esc_attr( $item['item_el_classes'] ) : '';
				$item_class     .= ! $item_image_url ? ' s-target-wo-img' : '';
				
				?>
				
				
				<div class="col-sm-6 col-md-6 col-lg-3">
					
					<div class="s-target <?php echo $item_class ?>">
						
						<?php
						if ( $item_image_url ) { ?>
							
							<?php
							Media::the_img(
								array( 'data-width' => 96, 'data-height' => 96, 'class' => 's-target__img' ),
								array( 'attachment_id' => $item_image_id )
							);
							?>
						
						<?php } ?>
						
						<div class="s-target__title">
							<?php echo $item_title ?>
						</div>
					
					</div>
				
				</div>
			
			<?php } ?>
		
		</div>
	
	<?php } ?>

</section>
