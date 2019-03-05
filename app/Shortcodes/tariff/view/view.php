<?php

use DMS\Helper\Media;

$atts = $data['atts'];

$attributes = $classes = array();

$classes[] = 'shortcode-tariff';
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
				<h2 class="s-tariff-title">
					<?php echo $atts['title'] ?>
				</h2>
			</div>
		</div>
	<?php } ?>
	
	<?php if ( ! empty( $atts['items_arr'] ) ) { ?>
		
		<div class="row justify-content-center align-items-stretch align-content-stretch">
			
			<?php
			foreach ( $atts['items_arr'] as $item ) {
				
				$item_title     = ! empty( $item['item_title'] ) ? esc_html( $item['item_title'] ) : '';
				$item_image_id  = (int) $item['item_image'];
				$item_image_url = wp_get_attachment_url( $item_image_id );
				
				$item_text1_value  = ! empty( $item['item_text1_value'] ) ? esc_html( $item['item_text1_value'] ) : '';
				$item_text1_prefix = ! empty( $item['item_text1_prefix'] ) ? esc_html( $item['item_text1_prefix'] ) : '';
				$item_text1_suffix = ! empty( $item['item_text1_suffix'] ) ? esc_html( $item['item_text1_suffix'] ) : '';
				
				$item_text2_value  = ! empty( $item['item_text2_value'] ) ? esc_html( $item['item_text2_value'] ) : '';
				$item_text2_prefix = ! empty( $item['item_text2_prefix'] ) ? esc_html( $item['item_text2_prefix'] ) : '';
				$item_text2_suffix = ! empty( $item['item_text2_suffix'] ) ? esc_html( $item['item_text2_suffix'] ) : '';
				
				$item_text3_value  = ! empty( $item['item_text3_value'] ) ? esc_html( $item['item_text3_value'] ) : '';
				$item_text3_prefix = ! empty( $item['item_text3_prefix'] ) ? esc_html( $item['item_text3_prefix'] ) : '';
				$item_text3_suffix = ! empty( $item['item_text3_suffix'] ) ? esc_html( $item['item_text3_suffix'] ) : '';
				
				$item_link_url  = ! empty( $item['item_link_url'] ) ? esc_url( $item['item_link_url'] ) : '#';
				$item_link_text = ! empty( $item['item_link_text'] ) ? esc_html( $item['item_link_text'] ) : '';
				
				$item_class = ! empty( $item['item_el_classes'] ) ? ' ' . esc_attr( $item['item_el_classes'] ) : '';
				$item_class .= ! $item_image_url ? ' s-tariff-wo-img' : '';
				
				?>
				
				
				<div class="col-sm-12 col-md-6 col-lg-3">
					
					<div class="s-tariff <?php echo $item_class ?>">
						
						
						<div class="s-tariff__body d-sm-flex align-items-sm-start">
							
							<div class="s-tariff__mob-img d-md-none">
								<?php
								if ( $item_image_url ) { ?>
									
									<?php
									Media::the_img(
										array( 'data-width' => 160, 'data-height' => 160, 'class' => 's-tariff__img' ),
										array( 'attachment_id' => $item_image_id )
									);
									?>
								
								<?php } ?>
							</div>
							
							<div class="s-tariff__card">
								
								<div class="s-tariff__title">
									<?php echo $item_title ?>
								</div>
								
								<?php
								if ( $item_image_url ) { ?>
									
									<?php
									Media::the_img(
										array( 'data-width' => 61, 'data-height' => 61, 'class' => 's-tariff__img d-none d-md-block' ),
										array( 'attachment_id' => $item_image_id )
									);
									?>
								
								<?php } ?>
								
								<div class="s-tariff__text">
									
									<!--   text 1   -->
									<div class="s-tariff__text1">
										<span class="s-tariff__text1_prefix">
											<?php echo $item_text1_prefix ?>
										</span>
											
											<span class="s-tariff__text1_value dms-accent-text">
											<?php echo $item_text1_value ?>
										</span>
											
											<span class="s-tariff__text1_suffix">
											<?php echo $item_text1_suffix ?>
										</span>
									</div>
									
									<!--   text 2   -->
									<div class="s-tariff__text2">
										<span class="s-tariff__text2_prefix">
											<?php echo $item_text2_prefix ?>
										</span>
											
											<span class="s-tariff__text2_value">
											<?php echo $item_text2_value ?>
										</span>
											
											<span class="s-tariff__text2_suffix">
											<?php echo $item_text2_suffix ?>
										</span>
									</div>
									
									<!--   text 3   -->
									<div class="s-tariff__text3">
										<span class="s-tariff__text3_prefix">
											<?php echo $item_text3_prefix ?>
										</span>
											
											<span class="s-tariff__text3_value">
											<?php echo $item_text3_value ?>
										</span>
										
										<span class="s-tariff__text3_suffix">
										<?php echo $item_text3_suffix ?>
										</span>
									</div>
								
								</div>
							</div>
						
						
						</div>
						
						<div class="s-tariff__footer">
							<a href="<?php echo $item_link_url ?>" class="s-tariff__link" target="_blank">
								<?php echo $item_link_text ?>
							</a>
							<div class="arrow-box">
								<i class="arrow-right"></i>
							</div>
						</div>
					
					</div>
				
				</div>
			
			<?php } ?>
		
		</div>
	
	<?php } ?>

</section>
