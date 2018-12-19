<?php
function bc_customizer_testimonial( $wp_customize ){
	$wp_customize->add_panel( 'hotelone_testimonial_panel' ,
		array(
			'priority'        => 35,
			'title'           => esc_html__( 'Section: Testimonial', 'britetechs-companion' ),
			'description'     => '',
			'active_callback' => 'hotelone_showon_frontpage'
		)
	);
	
		$wp_customize->add_section( 'hotelone_testimonial_section' ,
			array(
				'priority'    => 3,
				'title'       => esc_html__( 'Section Settings', 'britetechs-companion' ),
				'description' => '',
				'panel'       => 'hotelone_testimonial_panel',
			)
		);
		
			$wp_customize->add_setting( 'hotelone_testimonial_hide',
				array(
					'sanitize_callback' => 'hotelone_sanitize_checkbox',
					'default'           => get_theme_mod('hotelone_testimonial_hide',false),
				)
			);
			$wp_customize->add_control( 'hotelone_testimonial_hide',
				array(
					'type'        => 'checkbox',
					'label'       => esc_html__('Hide this section?', 'britetechs-companion'),
					'section'     => 'hotelone_testimonial_section',
					'description' => esc_html__('Check this box to hide this section.', 'britetechs-companion'),
				)
			);
			
			$wp_customize->add_setting( 'hotelone_testimonial_title',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => get_theme_mod('hotelone_testimonial_title',esc_html__('Client`s Testimonials', 'britetechs-companion')),
				)
			);
			$wp_customize->add_control( 'hotelone_testimonial_title',
				array(
					'label'    		=> esc_html__('Section Title', 'britetechs-companion'),
					'section' 		=> 'hotelone_testimonial_section',
					'description'   => '',
				)
			);
			
			$wp_customize->add_setting( 'hotelone_testimonial_subtitle',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => get_theme_mod('hotelone_testimonial_subtitle',esc_html__('Section subtitle', 'britetechs-companion')),
				)
			);
			$wp_customize->add_control( 'hotelone_testimonial_subtitle',
				array(
					'label'     => esc_html__('Section Subtitle', 'britetechs-companion'),
					'section' 		=> 'hotelone_testimonial_section',
					'description'   => '',
				)
			);
			
		$wp_customize->add_section( 'hotelone_testimonial_content' ,
			array(
				'priority'    => 6,
				'title'       => esc_html__( 'Section Content', 'britetechs-companion' ),
				'description' => '',
				'panel'       => 'hotelone_testimonial_panel',
			)
		);
		
			$wp_customize->add_setting(
				'hotelone_testimonial_items',
				array(
					'sanitize_callback' => 'hotelone_sanitize_repeatable_data_field',
					'transport' => 'refresh', // refresh or postMessage
				) );


			$wp_customize->add_control(
				new HotelOne_Customize_Repeatable_Control(
					$wp_customize,
					'hotelone_testimonial_items',
					array(
						'label'     => esc_html__('Testimonial', 'britetechs-companion'),
						'description'   => '',
						'section'       => 'hotelone_testimonial_content',
						'live_title_id' => 'name', // apply for unput text and textarea only
						'title_format'  => esc_html__( '[live_title]', 'britetechs-companion'), // [live_title]
						'max_item'      => 1,
						'limited_msg' 	=> wp_kses_post( __( 'Upgrade to <a target="_blank" href="https://www.britetechs.com/free-hotelone-wordpress-theme/">Hotelone Pro</a> to be able to add more items and unlock other premium features!', 'britetechs-companion' ) ),
						'fields'    => array(
							'photo' => array(
								'title' => esc_html__('Client Photo', 'britetechs-companion'),
								'type'  =>'media',
								'desc'  => '',
							),
							'name' => array(
								'title' => esc_html__('Client Name', 'britetechs-companion'),
								'type'  =>'text',
								'desc'  => '',
							),
							'review' => array(
								'title' => esc_html__('Review Content', 'britetechs-companion'),
								'type'  =>'textarea',
								'desc'  => '',
							),
							'designation' => array(
								'title' => esc_html__('Designation', 'britetechs-companion'),
								'type'  =>'text',
								'desc'  => '',
							),
							'link' => array(
								'title' => esc_html__('Custom Link', 'britetechs-companion'),
								'type'  =>'text',
								'desc'  => '',
							),
						),

					)
				)
			);
		
		$wp_customize->add_section( 'hotelone_testimonialbg_section' , array(
			'title'      => __('Section Background', 'britetechs-companion'),
			'panel'  => 'hotelone_testimonial_panel',
		) );
			$wp_customize->add_setting( 'hotelone_testimonial_bgcolor', array(
                'sanitize_callback' => 'sanitize_text_field',
                'default' => get_theme_mod('hotelone_testimonial_subtitle','#333'),
                'transport' => 'postMessage',
            ) );
            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 
			'hotelone_testimonial_bgcolor',
                array(
                    'label'       => esc_html__( 'Background Color', 'britetechs-companion' ),
                    'section'     => 'hotelone_testimonialbg_section',
                    'description' => esc_html__( 'Change the background color of this section.', 'britetechs-companion' ),
                )
            ));
			$wp_customize->add_setting( 'hotelone_testimonial_bgimage',
				array(
					'sanitize_callback' => 'esc_url_raw',
					'default'           => get_theme_mod('hotelone_testimonial_bgimage',''),
				)
			);
			$wp_customize->add_control( new WP_Customize_Image_Control(
				$wp_customize,
				'hotelone_testimonial_bgimage',
				array(
					'label' 		=> esc_html__('Background image', 'britetechs-companion'),
					'section' 		=> 'hotelone_testimonialbg_section',
					'description' => esc_html__('Upload the background image for this section.', 'britetechs-companion' ),
				)
			));
}
add_action('customize_register','bc_customizer_testimonial');