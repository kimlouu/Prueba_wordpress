<?php 
if ( !function_exists( 'bc_hp_testimonial' ) ) :
	function bc_hp_testimonial(){
		$disable_testimonial   = get_theme_mod( 'hotelone_testimonial_hide', 0 );
		$testimonial_title    = get_theme_mod( 'hotelone_testimonial_title', wp_kses_post('Testimonials','britetechs-companion') );
		$testimonial_subtitle    = get_theme_mod( 'hotelone_testimonial_subtitle', wp_kses_post('Our customers latest reviews','britetechs-companion') );
		$testimonial_data =  bc_get_section_testimonial_data();
		
		if(empty($testimonial_data)){
			$testimonial_data = bc_testimonial_default_data();
		}

		$bgcolor    = get_theme_mod( 'hotelone_testimonial_bgcolor', '#333');
		$bgimage    = get_theme_mod( 'hotelone_testimonial_bgimage', bc_plugin_url . '/inc/hotelone/img/testimonial.jpg');

		$class = '';
		if( !empty( $bgimage ) ){
			$class = 'section-overlay';
		}

		if( ! $disable_testimonial ){
		?>
		<div id="testimonial" class="testimonial_section section <?php echo esc_attr( $class ); ?>" style="background-color: <?php echo esc_attr( $bgcolor ); ?>; background-image: url(<?php echo esc_url( $bgimage ); ?>);">
			
			<?php do_action('hotelone_section_before_inner', 'testimonial'); ?>
			
			<?php if( !empty( $bgimage ) ){ ?>
			<div class="sectionOverlay">
			<?php } ?>
			
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<?php if( !empty($testimonial_title) ){ ?>
						<h2 class="section-title wow animated fadeInDown"><?php echo wp_kses_post($testimonial_title); ?></h2>
						<?php } ?>
						<?php if( !empty($testimonial_subtitle) ){ ?>
						<div class="seprator wow animated slideInLeft"></div>
						<p class="section-desc wow animated fadeInUp"><?php echo wp_kses_post($testimonial_subtitle); ?></p>
						<?php } ?>
					</div>
				</div>
				
				<div class="row">
				
					<div class="col-md-12">
						<div class="testimonial">
						<div id="testimonial_carousel" class="carousel slide " data-ride="carousel" data-interval="6000">
							
							<?php $p_active = 1; ?>
							<ol class="carousel-indicators"> 
							<?php if( count($testimonial_data) > 1){ foreach( $testimonial_data as $key => $t ){ ?>
								<li data-target="#testimonial_carousel" data-slide-to="<?php echo esc_attr($key); ?>" class="<?php if( $p_active == 1){ echo 'active'; } ?>"></li>
							<?php $p_active++; } } ?>
							</ol>
							<div class="carousel-inner" role="listbox">
								
								<?php $p_active = 1; ?>
								<?php foreach( $testimonial_data as $key => $t ){ ?>
								<div class="item <?php if( $p_active == 1){ echo 'active'; } ?>">
									<div class="media">
									  
									  <?php 
									  if( $t['photo'] ){
										$url = hotelone_get_media_url( $t['photo'] );
									  ?>
									  <div class="media-left">
										<img class="animated zoomIn" src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr( $t['name'] ); ?>">
									  </div>
									  <?php } ?>
									  <div class="media-body">	
										<?php if( $t['review'] ){ ?>
										<p class="testimonial_desc animated zoomIn"><?php echo wp_kses_post( $t['review'] ); ?></p>
										<?php } ?>
										<?php if( $t['name'] ){ ?>
										<h4 class="testimonial_title animated zoomIn"><?php echo wp_kses_post( $t['name'] ); ?></h4>
										<?php } ?>
										<?php if( $t['designation'] ){ ?>
										<span class="testimonial_designation animated zoomIn"><?php echo wp_kses_post( $t['designation'] ); ?></span>
										<?php } ?>
									  </div>
									</div>
								</div>
								<?php $p_active++; }  ?>
							
							</div>
						</div>
						</div><!-- .testimonial -->
					</div>	
					
				</div><!-- .row -->			
			</div><!-- .container -->
			
			<?php if( !empty( $bgimage ) ){ ?>
			</div><!-- .sectionOverlay -->
			<?php } ?>
			
			<?php do_action('hotelone_section_after_inner', 'testimonial'); ?>
			
		</div><!-- .testimonial_section -->
			
		<?php } 
	}
endif;
if ( function_exists( 'bc_hp_testimonial' ) ) {
	$section_priority = apply_filters( 'hotelone_section_priority', 5, 'bc_hp_testimonial' );
	add_action( 'hotelone_sections', 'bc_hp_testimonial', absint( $section_priority ) );
}