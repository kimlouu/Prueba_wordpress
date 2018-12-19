<?php
if ( !function_exists( 'bc_hp_team' ) ) :
	function bc_hp_team(){
		$disable_team   = get_theme_mod( 'hotelone_team_hide', 0 );
		$team_title    = get_theme_mod( 'hotelone_team_title', wp_kses_post('Our <span>Experts</span>','britetechs-companion') );
		$team_subtitle    = get_theme_mod( 'hotelone_team_subtitle', wp_kses_post('Our best staff team members','britetechs-companion') );
		$column   = absint( get_theme_mod( 'hotelone_team_layout', '4' ) );
		$team_data =  bc_get_section_team_data();
		
		if(empty( $team_data )){
			$team_data = bc_team_default_data();
		}
		
		if( ! $disable_team ){
		?>
		<div id="team" class="team_section section">
			
			<?php do_action('hotelone_section_before_inner', 'team'); ?>
			
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<?php if( !empty($team_title) ){ ?>
						<h2 class="section-title wow animated fadeInDown"><?php echo wp_kses_post($team_title); ?></h2>
						<?php } ?>
						<?php if( !empty($team_subtitle) ){ ?>
						<div class="seprator wow animated slideInLeft"></div>
						<p class="section-desc wow animated fadeInUp"><?php echo wp_kses_post($team_subtitle); ?></p>
						<?php } ?>
					</div>
				</div>
				
				<div class="row">
					
					<?php foreach( $team_data as $key => $t ){ ?>
					<div class="col-md-<?php echo esc_attr( $column ); ?> col-sm-6 wow animated rollIn">
						<div class="team">
							
							<?php 
							  if( $t['image'] ){
								$url = hotelone_get_media_url( $t['image'] );
							  ?>
							<div class="team_thumbnial">								
								<img src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr( $t['name'] ); ?>">
							</div>
							<?php } ?>
							
							<div class="team_body text-center">
								<a class="team_title" href="<?php echo esc_url( $t['link'] ); ?>"><h3><?php echo esc_html( $t['name'] ); ?></h3></a>							
								<div class="team_content">
									<p><?php echo esc_html( $t['designation'] ); ?></p>
								</div>							
							</div>
						</div><!-- .team -->
					</div>	
					<?php } ?>
					
					
				</div><!-- .row -->			
			</div><!-- .container -->
			
			<?php do_action('hotelone_section_after_inner', 'team'); ?>
			
		</div><!-- .team_section -->

		<?php }
	}
endif;
if ( function_exists( 'bc_hp_team' ) ) {
	$section_priority = apply_filters( 'hotelone_section_priority', 6, 'bc_hp_team' );
	add_action( 'hotelone_sections', 'bc_hp_team', absint( $section_priority ) );
}