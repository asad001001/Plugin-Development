<?php
/**
 * Plugin Name:       PDF Line Card Generator
 * Description:       Generates a branded "line card" PDF (manufacturers grouped by category) from ACF fields on a page, with in-editor preview and a copyable public link.
 * Version:           2.0.0
 * Author:            Asad Ali
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * License:           GPL-2.0-or-later
 *
 * @package PdfLineCard
 */

defined( 'ABSPATH' ) || exit;

use Dompdf\Dompdf;

define( 'PLC_DIR', plugin_dir_path( __FILE__ ) );
define( 'PLC_URL', plugin_dir_url( __FILE__ ) );
define( 'PLC_FILENAME', 'line-card.pdf' );

if ( file_exists( PLC_DIR . 'vendor/autoload.php' ) ) {
	require_once PLC_DIR . 'vendor/autoload.php';
} else {
	add_action( 'admin_notices', static function () {
		echo '<div class="notice notice-error"><p><strong>PDF Line Card:</strong> run <code>composer install</code> in the plugin folder to install Dompdf.</p></div>';
	} );
}

/**
 * ID of the page that holds the line card data.
 * Change it with: add_filter( 'plc_page_id', fn() => 123 );
 */
function plc_page_id() {
	return (int) apply_filters( 'plc_page_id', 6067 );
}

/** Where the generated PDF lives. */
function plc_pdf_location() {
	$uploads = wp_upload_dir();

	return [
		'dir'  => trailingslashit( $uploads['basedir'] ) . 'pdfs',
		'path' => trailingslashit( $uploads['basedir'] ) . 'pdfs/' . PLC_FILENAME,
		'url'  => trailingslashit( $uploads['baseurl'] ) . 'pdfs/' . PLC_FILENAME,
	];
}

/* -------------------------------------------------------------------------
 * Meta box
 * ---------------------------------------------------------------------- */

add_action( 'add_meta_boxes_page', static function ( $post ) {
	if ( (int) $post->ID === plc_page_id() ) {
		add_meta_box( 'plc_meta_box', 'PDF Preview & Update', 'plc_render_meta_box', 'page', 'side', 'high' );
	}
} );

function plc_render_meta_box( $post ) {
	$pdf = plc_pdf_location();
	?>
	<p>
		<button type="button" id="plc-generate" class="button button-primary">Generate &amp; Preview PDF</button>
		<button type="button" id="plc-copy" class="button" data-url="<?php echo esc_url( $pdf['url'] ); ?>"<?php echo file_exists( $pdf['path'] ) ? '' : ' style="display:none"'; ?>>📋 Copy URL</button>
	</p>
	<p id="plc-status" class="description"></p>
	<div id="plc-preview" style="margin-top:12px;"></div>

	<script>
	jQuery(function ($) {
		$('#plc-generate').on('click', function () {
			var $btn = $(this).prop('disabled', true);
			$('#plc-status').text('Generating…');

			$.post(ajaxurl, {
				action: 'plc_generate_pdf',
				post_id: <?php echo (int) $post->ID; ?>,
				nonce: '<?php echo esc_js( wp_create_nonce( 'plc_generate_pdf' ) ); ?>'
			}).done(function (res) {
				if (!res.success) {
					$('#plc-status').text(res.data || 'Could not generate the PDF.');
					return;
				}
				$('#plc-status').text('PDF updated.');
				$('#plc-preview').html($('<iframe>', { src: res.data.preview_url, width: '100%', height: 500 }));
				$('#plc-copy').show();
			}).fail(function () {
				$('#plc-status').text('Request failed.');
			}).always(function () {
				$btn.prop('disabled', false);
			});
		});

		$('#plc-copy').on('click', function () {
			var url = $(this).data('url');
			navigator.clipboard.writeText(url).then(function () {
				$('#plc-status').text('Copied: ' + url);
			});
		});
	});
	</script>
	<?php
}

/* -------------------------------------------------------------------------
 * AJAX: generate the PDF
 * ---------------------------------------------------------------------- */

add_action( 'wp_ajax_plc_generate_pdf', 'plc_ajax_generate_pdf' );

function plc_ajax_generate_pdf() {
	check_ajax_referer( 'plc_generate_pdf', 'nonce' );

	$post_id = absint( $_POST['post_id'] ?? 0 );

	if ( ! $post_id || ! current_user_can( 'edit_post', $post_id ) ) {
		wp_send_json_error( 'You are not allowed to do this.', 403 );
	}

	if ( ! class_exists( Dompdf::class ) ) {
		wp_send_json_error( 'Dompdf is not installed. Run composer install in the plugin folder.' );
	}

	$result = plc_generate_pdf( $post_id );

	if ( is_wp_error( $result ) ) {
		wp_send_json_error( $result->get_error_message() );
	}

	wp_send_json_success( [
		'pdf_url'     => $result,
		'preview_url' => add_query_arg( 'v', time(), $result ), // Bust the browser cache.
	] );
}

/**
 * Render the template to a PDF in uploads/pdfs/.
 *
 * @param int $post_id Page holding the ACF data.
 * @return string|WP_Error Public URL of the PDF.
 */
function plc_generate_pdf( $post_id ) {
	$font_dir = PLC_DIR . 'fonts/Raleway/static';
	$pdf      = plc_pdf_location();
	$cache    = $pdf['dir'] . '/font-cache';

	if ( ! wp_mkdir_p( $cache ) ) {
		return new WP_Error( 'plc_dir', 'Could not create ' . $pdf['dir'] );
	}

	$dompdf = new Dompdf( [
		'fontDir'         => $font_dir,
		'fontCache'       => $cache,
		'tempDir'         => get_temp_dir(),
		'chroot'          => [ PLC_DIR ],
		'isRemoteEnabled' => true,
	] );

	$vars = [
		'post_id'      => $post_id,
		'font_regular' => $font_dir . '/Raleway-Regular.ttf',
		'font_medium'  => $font_dir . '/Raleway-Medium.ttf',
		'font_bold'    => $font_dir . '/Raleway-Bold.ttf',
		'logo_url'     => apply_filters( 'plc_logo_url', 'https://wp.hashe.com/sk/wp-content/uploads/2025/07/image3.png' ),
	];

	ob_start();
	extract( $vars ); // phpcs:ignore WordPress.PHP.DontExtract -- template variables.
	include PLC_DIR . 'templates/line-card.php';
	$html = ob_get_clean();

	$dompdf->loadHtml( $html );
	$dompdf->setPaper( 'letter', 'portrait' );
	$dompdf->render();

	if ( false === file_put_contents( $pdf['path'], $dompdf->output() ) ) { // phpcs:ignore WordPress.WP.AlternativeFunctions
		return new WP_Error( 'plc_write', 'Could not write ' . $pdf['path'] );
	}

	return $pdf['url'];
}
