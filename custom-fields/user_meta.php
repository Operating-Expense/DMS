<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'dms_user_meta' );

function dms_user_meta() {
	
	Container::make( 'user_meta', 'user_account', __( 'Данные аккаунта', 'dms' ) )
	         ->add_fields( array(
		         Field::make( 'text', 'dms--user_company_name', __( 'Юр. назв. предприятия', 'dms' ) ),
		         Field::make( 'text', 'dms--user_company_address', __( 'Юр. адрес предприятия', 'dms' ) ),
		         Field::make( 'text', 'dms--user_reg_code', __( 'ЕГРПОУ', 'dms' ) ),
		         Field::make( 'text', 'dms--user_phone', __( 'Телефон', 'dms' ) ),
		         Field::make( 'text', 'dms--user_position', __( 'Должность', 'dms' ) ),
		
		         Field::make( 'image', 'dms--user_ava', __( 'Фото' ) ),
		
		         Field::make( 'text', 'dms--user_api_data__tariff', __( 'Тариф', 'dms' ) ),
		         Field::make( 'text', 'dms--user_api_data__balance', __( 'Баланс', 'dms' ) )->set_attribute( 'readOnly', true ),
	
	         ) );
	
	
}
