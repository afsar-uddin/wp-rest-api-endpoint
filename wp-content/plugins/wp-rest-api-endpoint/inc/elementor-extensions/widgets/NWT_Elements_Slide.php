<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class NWT_Elements_Slide extends Widget_Base {

	public function get_name() {
		return 'ic-slider';
	}

	public function get_title() {
		return __( 'Slider', 'ic-core' );
	}

	public function get_icon() {
		return 'ic icofont-simple-smile';
	}

	public function get_categories() {
		return [ 'nwt_elements' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_banner',
			[
				'label' => __( 'Slider', 'ic-core' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title', [
				'label'       => __( 'Title', 'ic-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'subtitle', [
				'label'       => __( 'Subtitle', 'ic-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'desc', [
				'label'       => __( 'Description', 'ic-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'slide_img', [
				'label'       => __( 'Slider Image', 'ic-core' ),
				'type'        => Controls_Manager::MEDIA,
				'label_block' => true,
			]
		);

		$this->add_control(
			'slides',
			[
				'label' => esc_html__( 'Slide List', 'nwt-core' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
			]
		);


		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>

<div class="nwt-slide-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="nwt-slides">
					<?php
						$slides = $settings['slides'];
						foreach($slides as $slide) :
							// var_dump($slide);
					?>
					<div class="nwt-slide">
						<div class="nwt-slide-content">
							<?php if($slide['title']): ?>
								<h2><?php echo esc_html($slide['title']); ?></h2>
							<?php endif; ?>

							<?php if($slide['title']): ?>
								<h3><?php echo esc_html($slide['subtitle']); ?></h3>
							<?php endif; ?>

							<?php if($slide['title']): ?>
								<p><?php echo esc_html($slide['desc']); ?></p>
							<?php endif; ?>
						</div>
						<?php if($slide['slide_img']['url']) : ?>
							<div class="nwt-slide-fig">
								<img src="<?php echo esc_url($slide['slide_img']['url']); ?>">
							</div>
						<?php endif; ?>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	}
}

Plugin::instance()->widgets_manager->register( new NWT_Elements_Slide() );