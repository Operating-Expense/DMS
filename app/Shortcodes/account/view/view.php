<?php

use DMS\Helper\Media;
use DMS\Helper\Utils;

$atts = $data['atts'];

$attributes = $classes = array();

$classes[] = 'shortcode-account';
if ( ! empty( $atts['el_classes'] ) ) {
	$classes[] = esc_html( $atts['el_classes'] );
}

$attributes[] = ! empty( $atts['el_id'] ) ? 'id="' . $atts['el_id'] . '"' : '';
$attributes[] = ! empty( $classes ) ? 'class="' . implode( ' ', $classes ) . '"' : '';

$current_user = wp_get_current_user();
$user_id      = $current_user->ID;

if ( 0 === $user_id ) {
	_e( 'NO USER LOGGED IN', 'dms' );
	
	return;
}


// get all user data
$user_email = $current_user->user_email;
$user_fio   = $current_user->user_firstname;

$user_position        = esc_html( Utils::get_user_meta( $user_id, 'dms--user_position', '' ) );
$user_company_name    = esc_html( Utils::get_user_meta( $user_id, 'dms--user_company_name', '' ) );
$user_company_address = esc_html( Utils::get_user_meta( $user_id, 'dms--user_company_address', '' ) );
$user_phone           = esc_html( Utils::get_user_meta( $user_id, 'dms--user_phone', '' ) ) ;
$user_reg_code        = esc_html( Utils::get_user_meta( $user_id, 'dms--user_reg_code', '' ) );
$user_photo_id        = esc_html( Utils::get_user_meta( $user_id, 'dms--user_ava', 0 ) );

$user_tariff_plan = esc_html( Utils::get_user_meta( $user_id, 'dms--user_api_data__tariff', __( 'Нет', 'dms' ) ) );
$user_balance     = esc_html( Utils::get_user_meta( $user_id, 'dms--user_api_data__balance', 0 ) );


?>
<section <?php echo implode( ' ', $attributes ); ?>>
	
	<div class="header-group">
		
		<div class="container">
			
			<div class="row header_row">
				<div class="d-md-none col-2">
					<div class="link_to_home_box">
						<a href="<?php echo home_url() ?>"> < </a>
					</div>
				</div>
				<div class="col-md-12 col-8">
					<h3 class="user_company_name">
						<?php echo $user_company_name ?>
					</h3>
				</div>
				<div class="d-md-none col-2">
					<div class="mb_link_to_contact_box">
						<a href="#contact"> <i class="fa fa-envelope-o"></i> </a>
					</div>
				</div>
			</div>
			
			
			<div class="row subheader_row">
				<div class="col-12 d-flex justify-content-start align-items-center flex-column flex-md-row">
					<div class="user_balance">
						<?php _e( 'Баланс:', 'dms' ) ?>
						<span>
							<?php echo $user_balance ?>
						</span>
					</div>
					<div class="user_tariff_plan">
						<?php _e( 'Тарифный план:', 'dms' ) ?>
						<span>
					<?php echo $user_tariff_plan ?>
				</span>
					</div>
					<div class="link_to_replenish_box">
						<a href="#contact"> <?php _e( 'Пополнить', 'dms' ) ?> </a>
					</div>
					<div class="link_to_contact_box d-none d-md-block">
						<i class="fa fa-envelope-o"></i>
						<a href="#contact">
							<?php _e( 'Написать нам', 'dms' ) ?>
						</a>
					</div>
				</div>
			</div>
		
		</div>
	
	</div>
	
	<form action="" id="dms_user_profile" class="dms_user_profile" enctype="multipart/form-data">
		<div class="container">
			<div class="row user_data_row">
				
				<div class="col-lg-2">
					<div class="row user_ava_row d-flex align-items-center justify-content-center  justify-content-lg-start">
						<div class="profile-ava-wrapper">
							<div class="profile-ava">
								<?php
								if ( $user_photo_id ) {
									Media::the_img(
										array( 'data-width' => 138, 'data-height' => 138, 'class' => 'profile-ava-img' ),
										array( 'attachment_id' => $user_photo_id )
									);
								}
								?>
							</div>
							<label class="pf_ava_label" for="pf_ava">
								<?php _e( 'Сменить фото', 'dms' ) ?>
							</label>
							<input id="pf_ava" class="pf_ava" name="pf_ava" type="file" accept="image/jpeg,image/jpg,image/png">
						</div>
					</div>
				</div>
				
				<div class="col-lg-10">
					<div class="user_table">
						<div class="row user_table_row">
							
							<div class="col-md-4 user_table_item">
								<div class="item_title"><?php _e( 'E-mail', 'dms' ); ?></div>
								<div class="item_value"><?php echo $user_email ?></div>
							</div>
							
							<div class="col-md-4 user_table_item item_editable">
								<div class="item_title"><?php _e( 'ФИО', 'dms' ); ?></div>
								<div class="item_value"><?php echo $user_fio ?></div>
								<textarea name="pf_fio" class="pf_control pf_fio"></textarea>
							</div>
							
							<div class="col-md-4 user_table_item item_editable">
								<div class="item_title"><?php _e( 'Должность', 'dms' ); ?></div>
								<div class="item_value"><?php echo $user_position ?></div>
								<textarea name="pf_position" class="pf_control pf_position"></textarea>
							</div>
							
							<div class="col-md-4 user_table_item item_editable">
								<div class="item_title"><?php _e( 'Юр. назв. предприятия', 'dms' ); ?></div>
								<div class="item_value"><?php echo $user_company_name ?></div>
								<textarea name="pf_company_name" class="pf_control pf_company_name"></textarea>
							</div>
							
							<div class="col-md-4 user_table_item item_editable">
								<div class="item_title"><?php _e( 'Юр. адрес', 'dms' ); ?></div>
								<div class="item_value"><?php echo $user_company_address ?></div>
								<textarea name="pf_company_address" class="pf_control pf_company_address"></textarea>
							</div>
							
							<div class="col-md-4 user_table_item item_editable">
								<div class="item_title"><?php _e( 'ЕГРПОУ', 'dms' ); ?></div>
								<div class="item_value"><?php echo $user_reg_code ?></div>
								<textarea name="pf_reg_code" class="pf_control pf_reg_code"></textarea>
							</div>
							
							<div class="col-md-4 user_table_item item_editable">
								<div class="item_title"><?php _e( 'Телефон', 'dms' ); ?></div>
								<div class="item_value"><?php echo $user_phone ?></div>
								<textarea name="pf_phone" class="pf_control pf_phone"></textarea>
							</div>
						
						</div>
					</div>
				</div>
				
				<div class="col-12">
					<div class="pf_error_box"></div>
					<div class="user_profile_actions">
						<a href="#" class="user_profile_action_link pf_action_edit" data-profile_action="edit" role="button">
							<?php _e( 'Редактировать', 'dms' ) ?>
						</a>
						<a href="#" class="user_profile_action_link pf_action_save" data-profile_action="save" role="button">
							<?php _e( 'Сохранить', 'dms' ) ?>
						</a>
					</div>
				</div>
			
			</div>
		</div>
	</form>

</section>
