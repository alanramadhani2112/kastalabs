<?php
/**
 * FAQ item component (details/summary accordion).
 *
 * @package KastaLabs
 * @param array $args {
 *     @type string $question   FAQ question.
 *     @type string $answer     FAQ answer.
 *     @type bool   $open       Whether to start open (default: false).
 *     @type string $class      Additional CSS classes.
 *     @type int    $index      Optional index for reveal stagger.
 * }
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'question' => '',
		'answer'   => '',
		'open'     => false,
		'class'    => '',
		'index'    => 0,
	)
);
?>
<div class="group" data-faq-item>
	<button
		class="type-body flex w-full cursor-pointer items-center justify-between gap-6 border-b border-hairline py-5 text-left"
		data-faq-toggle
		aria-expanded="<?php echo $args['open'] ? 'true' : 'false'; ?>"
	>
		<span><?php echo esc_html( $args['question'] ); ?></span>
		<span class="grid h-7 w-7 flex-none place-items-center rounded-full bg-surface text-primary-600 transition-transform duration-200 group-[.is-open]:rotate-45" aria-hidden="true">+</span>
	</button>
	<div
		class="overflow-hidden"
		data-faq-panel
		style="height: <?php echo $args['open'] ? 'auto' : '0'; ?>; display: <?php echo $args['open'] ? '' : 'none'; ?>"
		<?php echo $args['open'] ? '' : 'aria-hidden="true"'; ?>
	>
		<p class="type-body pt-4 pb-5 text-muted">
			<?php echo esc_html( $args['answer'] ); ?>
		</p>
	</div>
</div>
