<?php
/**
 * Form field wrapper component.
 *
 * Membungkus label + input/select/textarea dengan markup yang konsisten.
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $label        Field label text.
 *     @type string $name         Field name attribute.
 *     @type string $type         'text' | 'email' | 'textarea' | 'select' | 'tel' | 'url' (default: 'text').
 *     @type string $value        Field value.
 *     @type string $placeholder  Placeholder text.
 *     @type bool   $required     Required attribute (default: false).
 *     @type string $autocomplete Autocomplete hint.
 *     @type array  $options      Array of value => label pairs (for select type).
 *     @type string $class        Additional CSS classes on wrapper.
 *     @type string $input_class  Additional CSS classes on input.
 *     @type string $help         Optional help text below field.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'label'        => '',
		'name'         => '',
		'type'         => 'text',
		'value'        => '',
		'placeholder'  => '',
		'required'     => false,
		'autocomplete' => '',
		'options'      => array(),
		'class'        => '',
		'input_class'  => '',
		'help'         => '',
	)
);

$required_attr = $args['required'] ? ' required' : '';
$auto_attr     = $args['autocomplete'] ? ' autocomplete="' . esc_attr( $args['autocomplete'] ) . '"' : '';
$input_class   = 'form-control' . ( $args['input_class'] ? ' ' . $args['input_class'] : '' );
?>
<label class="form-field<?php echo $args['class'] ? ' ' . esc_attr( $args['class'] ) : ''; ?>">
	<span><?php echo esc_html( $args['label'] ); ?></span>
	<?php if ( 'textarea' === $args['type'] ) : ?>
		<textarea
			class="<?php echo esc_attr( $input_class ); ?> min-h-48"
			name="<?php echo esc_attr( $args['name'] ); ?>"
			placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>"
			<?php echo $required_attr; // phpcs:ignore ?>
			<?php echo $auto_attr; // phpcs:ignore ?>
		><?php echo esc_textarea( $args['value'] ); ?></textarea>
	<?php elseif ( 'select' === $args['type'] ) : ?>
		<select
			class="<?php echo esc_attr( $input_class ); ?>"
			name="<?php echo esc_attr( $args['name'] ); ?>"
			<?php echo $required_attr; // phpcs:ignore ?>
			<?php echo $auto_attr; // phpcs:ignore ?>
		>
			<?php foreach ( $args['options'] as $opt_value => $opt_label ) : ?>
				<option value="<?php echo esc_attr( (string) $opt_value ); ?>" <?php selected( $args['value'], (string) $opt_value ); ?>><?php echo esc_html( $opt_label ); ?></option>
			<?php endforeach; ?>
		</select>
	<?php else : ?>
		<input
			class="<?php echo esc_attr( $input_class ); ?>"
			name="<?php echo esc_attr( $args['name'] ); ?>"
			type="<?php echo esc_attr( $args['type'] ); ?>"
			value="<?php echo esc_attr( $args['value'] ); ?>"
			placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>"
			<?php echo $required_attr; // phpcs:ignore ?>
			<?php echo $auto_attr; // phpcs:ignore ?>
		>
	<?php endif; ?>
	<?php if ( $args['help'] ) : ?>
		<span class="type-caption mt-1 block text-muted"><?php echo esc_html( $args['help'] ); ?></span>
	<?php endif; ?>
</label>
