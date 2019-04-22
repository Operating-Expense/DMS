<?php

use DMS\Helper\Media;
use DMS\Helper\Utils;

$atts = $data['atts'];

$attributes = $classes = array();

$classes[] = 'shortcode-intro';
if ( ! empty( $atts['el_classes'] ) ) {
	$classes[] = esc_html( $atts['el_classes'] );
}

$attributes[] = ! empty( $atts['el_id'] ) ? 'id="' . $atts['el_id'] . '"' : '';
$attributes[] = ! empty( $classes ) ? 'class="' . implode( ' ', $classes ) . '"' : '';

$header_title_l = esc_html( $atts['header_title_l'] );
$header_title_r = esc_html( $atts['header_title_r'] );

$title = $atts['title'];
$text  = ! empty( $data['content'] )
	? apply_filters( 'the_content', $data['content'] )
	: '';

$btn_try_text = esc_html( $atts['btn_try_text'] );
$btn_try_url  = esc_url( $atts['btn_try_url'] );

$btn_about_text = esc_html( $atts['btn_about_text'] );
$btn_about_url  = esc_url( $atts['btn_about_url'] );

$btn_how_text = esc_html( $atts['btn_how_text'] );
$btn_how_url  = esc_url( $atts['btn_how_url'] );


$account_url = class_exists( 'WPGlobus_Utils' )
	? \WPGlobus_Utils::localize_url( get_permalink( get_page_by_path( 'account' ) ) )
	: get_permalink( get_page_by_path( 'account' ) );



?>
<section <?php echo implode( ' ',$attributes ); ?>>
	
	
	<div class="row justify-content-center">
		
		<div class="col-sm-12 col-md-6 s-intro__left">
			
			<?php if ( $header_title_l ) { ?>
				<h5 class="s-intro__header_title_l">
					<?php echo $header_title_l ?>
				</h5>
			<?php } ?>
			
			<?php if ( $title ) { ?>
				<h3 class="s-intro__title">
					<?php echo $title ?>
				</h3>
			<?php } ?>
			
			<?php if ( $text ) { ?>
				<div class="s-intro__text">
					<?php echo $text ?>
				</div>
			<?php } ?>
			
			<div class="s-intro__btns_group">
				<?php if ( $btn_how_text ) { ?>
					<a href="<?php echo $btn_how_url ?>" class="s-intro__btn_how">
						<div class="btn-play-box"></div>
						<?php echo $btn_how_text ?>
					</a>
				<?php } ?>
				
				<div class="s-intro__btns">
					<?php if ( $btn_try_text ) {
						?>
						<a href="<?php echo $account_url ?>" class="s-intro__btn_try btn-arrow <?php if ( ! is_user_logged_in() ) echo ' js-dms-account' ?>">
							<?php echo $btn_try_text ?>
							<div class="arrow-box">
								<i class="arrow-right"></i>
							</div>
						</a>
					<?php } ?>
					
					<?php if ( $btn_about_text ) { ?>
						<a href="<?php echo $btn_about_url ?>" class="s-intro__btn_about">
							<?php echo $btn_about_text ?>
							<div class="arrow-box">
								<i class="arrow-right"></i>
							</div>
						</a>
					<?php } ?>
				</div>
			</div>
		
		</div>
		
		<div class="col-md-6 d-none d-md-block s-intro__right">
			
			<?php if ( $header_title_r ) { ?>
				<h5 class="s-intro__header_title_r">
					<?php echo $header_title_r ?>
				</h5>
			<?php } ?>
			
			<form class="s-intro__try_form form-color-inv">
				
				<div class="form-group row">
					<label for="how_first" class="col-sm-3 col-form-label">
						<?php echo __( 'Имя', 'dms' ) ?>
					</label>
					<div class="col-sm-9 s-intro__input_rel">
						<input class="form-control" id="how_first" placeholder="" value="<?php _ex('Сергей', 'example', 'dms') ?>" readonly>
						<div class="s-intro__input_result">
							<div class="result_row"></div>
							<div class="result_row"></div>
						</div>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="how_middle" class="col-sm-3 col-form-label">
						<?php echo __( 'Отчество', 'dms' ) ?>
					</label>
					<div class="col-sm-9 s-intro__input_rel">
						<input class="form-control" id="how_middle" placeholder="" value="<?php _ex('Сергеевич', 'example', 'dms') ?>" readonly>
						<div class="s-intro__input_result">
							<!--							<div class="result_row">♀</div>-->
							<div class="result_row result_row_gender">♂</div>
						</div>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="how_city" class="col-sm-3 col-form-label">
						<?php echo __( 'Населенный пункт', 'dms' ) ?>
					</label>
					<div class="col-sm-9 s-intro__input_rel">
						<input class="form-control" id="how_city" placeholder="" value="<?php _ex('Киев', 'example', 'dms') ?>" readonly>
						<div class="s-intro__input_result">
							<div class="result_row"><?php _ex('Киевский район', 'example', 'dms') ?></div>
							<div class="result_row"><?php _ex('Киевская область', 'example','dms') ?></div>
						</div>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="how_street" class="col-sm-3 col-form-label">
						<?php echo __( 'Улица', 'dms' ) ?>
					</label>
					<div class="col-sm-9 s-intro__input_rel">
						<input class="form-control" id="how_street" placeholder="" value="<?php _ex('Новоконстантиновская', 'example','dms') ?>" readonly>
						<div class="s-intro__input_result">
							<div class="result_row"></div>
							<div class="result_row"></div>
						</div>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="how_house" class="col-sm-3 col-form-label">
						<?php echo __( 'Дом', 'dms' ) ?>
					</label>
					<div class="col-sm-9 s-intro__input_rel">
						<input class="form-control" id="how_house" placeholder="" value="15/15" readonly>
						<div class="s-intro__input_result">
							<div class="result_row">50.483931, 30.484841</div>
							<div class="result_row">04655</div>
						</div>
					</div>
				</div>
			
			</form>
		
		
		</div>
	
	</div>
	
	<div class="row no-gutters s-intro__footer">
		<div class="col-12 d-md-none">
			
			<div class="row no-gutters">
				
				<div class="col-3 s-intro__footer_item">
					<a href="<?php echo home_url() ?>">
						<i class="s-intro__footer_icon s-intro__footer_icon1"></i>
					</a>
				</div>
				
				<div class="col-3 s-intro__footer_item">
					<a href="tel:+<?php echo Utils::get_option( 'dms_phone', '' ) ?>">
						<i class="s-intro__footer_icon s-intro__footer_icon2"></i>
					</a>
				
				</div>
				
				<div class="col-3 s-intro__footer_item">
					<a href="<?php echo $account_url ?>" class="<?php if ( ! is_user_logged_in() ) echo ' js-dms-account' ?>">
						<i class="s-intro__footer_icon s-intro__footer_icon3"></i>
					</a>
				</div>
				<div class="col-3 s-intro__footer_item">
					<a href="#" class="s-intro__menu_caller menu-button">
						<i class="s-intro__footer_icon s-intro__footer_icon4"></i>
					</a>
				</div>
			
			</div>
		
		</div>
	</div>


</section>
