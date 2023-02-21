<?php
namespace Elementor;
	class My_Widget extends Widget_Base {

		public function get_name() {
			return 'testi-grid';
		}

		public function get_title() {
			return esc_html__( 'Testimonial Grid', 'arg' );
		}

		public function get_icon() {
			return 'eicon-testimonial';
		}

		public function get_categories() {
			return [ 'basic' ];
		}
		public function get_script_depends() {
			return [
				'arg-main',
				'arg-main',
			];
		}
		public function get_style_depends() {
			return [
				'arg-style',
				'css2'
			];
		}
		protected function _register_controls() {
			$this->start_controls_section(
				'section_title',
				[
					'label' => __( 'Content', 'testimonial' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'total_testimonials',
				[
					'label' => __( 'Total Testimonial Count', 'text-domain' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'default' => 3,
					'min' => 1,
					'max' => 10,
					'step' => 1,
				]
			);

			$this->add_control(
				'testimonial_columns',
				[
					'label' => __( 'Testimonial Columns', 'text-domain' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'1' => __( '1 Column', 'text-domain' ),
						'2' => __( '2 Columns', 'text-domain' ),
						'3' => __( '3 Columns', 'text-domain' ),
						'4' => __( '4 Columns', 'text-domain' ),
					],
					'default' => '2',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'section_style',
				[
					'label' => __( 'Style', 'testimonial' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'name_color',
				[
					'label' => __( 'Name Color', 'text-domain' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .profile-name' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'name_typography',
					'label' => __( 'Name Typography', 'text-domain' ),	
					'selector' => '{{WRAPPER}} .profile-name'
				]
			);

			$this->add_control(
				'designation_color',
				[
					'label' => __( 'Designation Color', 'text-domain' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .profile-title' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'designation_typography',
					'label' => __( 'Designation Typography', 'text-domain' ),
					'selector' => '{{WRAPPER}} .profile-title',
				]
			);
			$this->add_control(
				'test_bg_color',
				[
					'label' => __( 'Card Background Color', 'your-text-domain' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .card-grid .card' => 'background-color: {{VALUE}};',
					],
				]
			);


			$this->end_controls_section();
		}

		protected function render() {
			$settings 			= $this->get_settings_for_display();
			$title_color 		= $this->get_settings('name_color');
			$title_typo 		= $this->get_settings('name_typography');
			$designation_color 	= $this->get_settings('designation_color');
			$column_count 		= $settings['testimonial_columns'];

			$query_args = array(
				'post_type' 		=> 'arg',
				'posts_per_page' 	=> $settings['total_testimonials'],
				'order' 			=> 'DESC',
			);
			$query = new \WP_Query( $query_args );

			if ( $query->have_posts() ) {?>
				<main class="container card-grid">
				<?php
				while ( $query->have_posts() ) {
					$query->the_post();
					?>
					<article class="card grey">
						<figure class="profile">
							<div>
								<img
								class="avatar"
								src="<?php echo get_the_post_thumbnail_url( get_the_ID(),'full' ); ?>"
								alt="jonathan's image"
								/>
							</div>
							<figcaption class="profile-info">
								<h2 class="profile-name"><?php echo get_post_meta( get_the_ID(), 'testmonial_name', true ); ?></h2>
								<p class="profile-title"><?php echo get_post_meta( get_the_ID(), 'test_designation', true ); ?></p>
							</figcaption>
						</figure>
						<div class="testimonials">
							<h1 class="heading">
								<?php the_title(); ?>
							</h1>
							<blockquote>
								“ <?php the_excerpt(); ?> ”
							</blockquote>
						</div>
					</article>
					<?php
				}
				wp_reset_postdata();?>
			</main>
			<?php
			}
		}
		protected function _content_template() {

		}
	}
Plugin::instance()->widgets_manager->register_widget_type( new My_Widget());
