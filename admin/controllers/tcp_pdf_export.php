<?

class TCP_PDF_Export extends TCP_PDF_Admin{
	public function view(){
		$data = array();

		$data['form_action'] = $this->get_action_link('export');

		$categoryes = array(
			'taxonomy' => 'tcpc_category',
			'checked_ontop' => false,
			'echo' => false,
		);

		$data['cat'] = wp_terms_checklist(0, $categoryes);

		$data['ajax_url'] = admin_url('admin-ajax.php');

		$data['script_js'] = TCPP_PLUGIN_URL . '/admin/view/js/tcp_pdf.js';

		echo $this->render(TCPP_ADMIN_TPL . 'page/export/view.tpl', $data);
	}
}
?>