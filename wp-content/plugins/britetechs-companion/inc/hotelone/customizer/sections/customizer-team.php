<?php
function bc_customizer_team( $wp_customize ){
	$wp_customize->add_panel( 'hotelone_team_panel' ,
		array(
			'priority'        => 38,
			'title'           => esc_html__( 'Section: Team', 'britetechs-companion' ),
			'description'     => '',
			'active_callback' => 'hotelone_showon_frontpage'
		)
	);
	
		$wp_customize->add_section( 'hotelone_team_section' ,
			array(
				'priority'    => 1,
				'title'       => esc_html__( 'Section Settings', 'britetechs-companion' ),
				'description' => '',
				'panel'       => 'hotelone_team_panel',
			)
		);
		
			$wp_customize->add_setting( 'hotelone_team_hide',
				array(
					'sanitize_callback' => 'hotelone_sanitize_checkbox',
					'default'           => '',
				)
			);
			$wp_customize->add_control( 'hotelone_team_hide',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Hide this section?', 'britetechs-companion'),
					'section'     => 'hotelone_team_section',
					'description' => esc_html__('Check this box to hide this section.', 'britetechs-companion'),
				)
			);
			
			$wp_customize->add_setting( 'hotelone_team_title',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => esc_html__('Our Team', 'britetechs-companion'),
				)
			);
			$wp_customize->add_control( 'hotelone_team_title',
				array(
					'label'    		=> esc_html__('Section Title', 'britetechs-companion'),
					'section' 		=> 'hotelone_team_section',
					'description'   => '',
				)
			);
			
			$wp_customize->add_setting( 'hotelone_team_subtitle',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => esc_html__('Section subtitle', 'britetechs-companion'),
				)
			);
			$wp_customize->add_control( 'hotelone_team_subtitle',
				array(
					'label'     => esc_html__('Section Subtitle', 'britetechs-companion'),
					'section' 		=> 'hotelone_team_section',
					'description'   => '',
				)
			);
			
			$wp_customize->add_setting( 'hotelone_team_layout',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => '3',
				)
			);

			$wp_customize->add_control( 'hotelone_team_layout',
				array(
					'label' 		=> esc_html__('Team Layout Settings', 'britetechs-companion'),
					'section' 		=> 'hotelone_team_section',
					'description'   => '',
					'type'          => 'select',
					'choices'       => array(
						'3' => esc_html__( '4 Columns', 'britetechs-companion' ),
						'4' => esc_html__( '3 Columns', 'britetechs-companion' ),
						'6' => esc_html__( '2 Columns', 'britetechs-companion' ),
					),
				)
			);
			
		$wp_customize->add_section( 'hotelone_team_content' ,
			array(
				'priority'    => 6,
				'title'       => esc_html__( 'Section Content', 'britetechs-companion' ),
				'description' => '',
				'panel'       => 'hotelone_team_panel',
			)
		);
		
			$wp_customize->add_setting(
				'hotelone_team_members',
				array(
					'sanitize_callback' => 'hotelone_sanitize_repeatable_data_field',
					'transport' => 'refresh', // refresh or postMessage
				) );


			$wp_customize->add_control(
				new HotelOne_Customize_Repeatable_Control(
					$wp_customize,
					'hotelone_team_members',
					array(
						'label'     => esc_html__('Team members', 'britetechs-companion'),
						'description'   => '',
						'section'       => 'hotelone_team_content',
						'live_title_id' => 'name', // apply for unput text and textarea only
						'title_format'  => esc_html__( '[live_title]', 'britetechs-companion'), // [live_title]
						'max_item'      => 3,
						'limited_msg' 	=> wp_kses_post( __( 'Upgrade to <a target="_blank" href="https://www.britetechs.com/free-hotelone-wordpress-theme/">Hotelone Pro</a> to be able to add more items and unlock other premium features!', 'britetechs-companion' ) ),
						'fields'    => array(
							'image' => array(
								'title' => esc_html__('User media', 'britetechs-companion'),
								'type'  =>'media',
								'desc'  => '',
							),
							'name' => array(
								'title' => esc_html__('Name', 'britetechs-companion'),
								'type'  =>'text',
								'desc'  => '',
							),
							'designation' => array(
								'title' => esc_html__('Designation', 'britetechs-companion'),
								'type'  =>'text',
								'desc'  => '',
							),
						),

					)
				)
			);
}
add_action('customize_register','bc_customizer_team');