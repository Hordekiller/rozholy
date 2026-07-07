<?php
defined( 'ABSPATH' ) || exit;

if ( class_exists( 'WP_Customize_Control' ) ) :

	class Rozholy_Range_Control extends WP_Customize_Control {
		public $type = 'rozholy_range';

		public function enqueue() {
			wp_add_inline_style(
				'customize-controls',
				'
            .rozholy-range-wrap { display:flex; align-items:center; gap:8px; }
            .rozholy-range-wrap input[type="range"] { flex:1; }
            .rozholy-range-value { min-width:48px; text-align:center; font-weight:600; }
        '
			);
		}

		public function render_content() {
			if ( empty( $this->input_attrs['min'] ) || empty( $this->input_attrs['max'] ) ) {
				return;
			}
			$min  = $this->input_attrs['min'];
			$max  = $this->input_attrs['max'];
			$step = $this->input_attrs['step'] ?? 1;
			?>
		<label>
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>
			<div class="rozholy-range-wrap">
				<input type="range"
						min="<?php echo esc_attr( $min ); ?>"
						max="<?php echo esc_attr( $max ); ?>"
						step="<?php echo esc_attr( $step ); ?>"
						data-reset-value="<?php echo esc_attr( $this->settings['default']->default ?? $min ); ?>"
						<?php $this->link(); ?>
						value="<?php echo esc_attr( $this->value() ); ?>">
				<span class="rozholy-range-value"><?php echo esc_html( $this->value() ); ?></span>
			</div>
		</label>
		<script>
		(function(){ var input = document.getElementById('<?php echo esc_js( $this->id ); ?>');
		if(input){ input.addEventListener('input',function(){ var s=this.nextElementSibling;
		if(s) s.textContent=this.value; }); } })();
		</script>
			<?php
		}
	}

endif;
