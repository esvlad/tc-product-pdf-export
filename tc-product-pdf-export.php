<?
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @wordpress-plugin
 * Plugin Name:       TCP PDF Export
 * Plugin URI:        https://github.com/esvlad/tc-product-pdf-export
 * Description:       Экспорт товаров TC Product в PDF.
 * Version:           1.0.0
 * Author:            Старцев Владислав
 * Author URI:        https://es.vlad
 * License:           GNU GPL
 */
 
define ('TCPP_PLUGIN_DIR', plugin_dir_path( __FILE__ ));
define ('DIR_TEMPLATE_ADMIN', plugin_dir_path( __FILE__ ) . 'admin/view/');
define ('TCPP_PLUGIN_URL', plugins_url('', __FILE__));

$tpl = plugin_dir_path( __FILE__ );
$tpl .= 'admin/view/';
define ('TCPP_ADMIN_TPL', $tpl);



require_once TCPP_PLUGIN_DIR . 'config.php';

if ( ! defined( 'WPINC' ) ) {
	die;
}

register_activation_hook( __FILE__, array('TCP_PDF_Config','activate') );
register_deactivation_hook( __FILE__, array('TCP_PDF_Config','deactivate') );
register_uninstall_hook(__FILE__, array('TCP_PDF_Config','uninstall'));

define('FPDF_FONTPATH', TCPP_PLUGIN_DIR . 'includes/fpdf/font');

require_once TCPP_PLUGIN_DIR . 'tcp-pdf.php';
require TCPP_PLUGIN_DIR . 'includes/fpdf/fpdf.php';

function run_tcp_pdf_app() {
	try{
		$plugin = new TCP_PDF();
		$plugin->run();
	} catch(Exception $e){
		$e->getMessage();
	}
}

/*add_action('wp_ajax_export_pdf', 'export_pdf');

function export_pdf(){}*/

run_tcp_pdf_app();
?>