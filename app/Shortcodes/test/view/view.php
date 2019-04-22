<?php

use DMS\Helper\Media;
use DMS\Helper\Utils;

$atts = $data['atts'];

$attributes = $classes = array();

$classes[] = 'shortcode-test';
if ( ! empty( $atts['el_classes'] ) ) {
	$classes[] = esc_html( $atts['el_classes'] );
}

$attributes[] = ! empty( $atts['el_id'] ) ? 'id="' . $atts['el_id'] . '"' : '';
$attributes[] = ! empty( $classes ) ? 'class="' . implode( ' ', $classes ) . '"' : '';

$title = $atts['title'];

?>
<section <?php echo implode( ' ', $attributes ); ?>>
	
	<?php if ( $title ) { ?>
		<div class="row">
			<div class="col-12">
				<h2 class="s-test-title">
					<?php echo $title ?>
				</h2>
			</div>
		</div>
	<?php } ?>
	
	<div class="row justify-content-center">
		
		<div class="col-xl-7 order-1 order-xl-1 s-test__left">
			
			<form id="s-test__try_form" class="s-test__try_form form-color-gray" autocomplete="off" role="presentation">
				
				<div class="form-group row" data-sbname="first">
					<label for="try_first" class="col-sm-3 col-form-label">
						<?php echo __( 'Имя', 'dms' ) ?>
					</label>
					<div class="col-sm-9 s-test__input_rel">
						<input class="form-control" id="try_first" name="first" autocomplete="new-password">
						<div class="s-test__input_result search_result_ext_box"></div>
						<div class="search_result_box"></div>
					</div>
				</div>
				
				<div class="form-group row" data-sbname="middle">
					<label for="try_middle" class="col-sm-3 col-form-label">
						<?php echo __( 'Отчество', 'dms' ) ?>
					</label>
					<div class="col-sm-9 s-test__input_rel">
						<input class="form-control" id="try_middle" name="middle" autocomplete="new-password">
						<div class="s-test__input_result search_result_ext_box"></div>
						<div class="search_result_box"></div>
					</div>
				</div>
				
				<div class="form-group row" data-sbname="city">
					<label for="try_city" class="col-sm-3 col-form-label">
						<?php echo __( 'Населенный пункт', 'dms' ) ?>
					</label>
					<div class="col-sm-9 s-test__input_rel">
						<input class="form-control" id="try_city" name="city" autocomplete="new-password">
						<div class="s-test__input_result search_result_ext_box"></div>
						<div class="search_result_box"></div>
					</div>
				</div>
				
				<div class="form-group row" data-sbname="street">
					<label for="try_street" class="col-sm-3 col-form-label">
						<?php echo __( 'Улица', 'dms' ) ?>
					</label>
					<div class="col-sm-9 s-test__input_rel">
						<input class="form-control" id="try_street" name="street" autocomplete="new-password">
						<div class="s-test__input_result search_result_ext_box"></div>
						<div class="search_result_box"></div>
					</div>
				</div>
				
				<div class="form-group row" data-sbname="house">
					<label for="try_house" class="col-sm-3 col-form-label">
						<?php echo __( 'Дом', 'dms' ) ?>
					</label>
					<div class="col-sm-9 s-test__input_rel">
						<input class="form-control" id="try_house" name="house" autocomplete="new-password">
						<div class="s-test__input_result search_result_ext_box"></div>
						<div class="search_result_box"></div>
					</div>
				</div>
			
			</form>
		
		</div>
		
		<div class="col-xl-5 order-2 order-xl-2 justify-content-center align-items-center s-test__right">
			
			<div class="extra_info_box"></div>
		
		</div>
	
	</div>

</section>
