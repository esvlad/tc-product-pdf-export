<?

class TCP_PDF_Admin extends TCP_PDF{
	const TCPP_ADMIN_JS = TCPP_PLUGIN_URL . '/admin/view/js/';
	const TCPP_ADMIN_CSS = TCPP_PLUGIN_URL . '/admin/view/css/';
	
	public function get_page(){
		$class = ($_GET['page'] != 'tcp_pdf_export') ? $_GET['page'] : 'tcp_pdf_export';
		
		require_once TCPP_PLUGIN_DIR . '/admin/controllers/' . $class . '.php';
		
		$page = new $class();
		$action = (isset($_GET['action'])) ? $_GET['action'] : 'view';

		$data = array();
		$data['atts'] = $atts;
		$data['content'] = $content;
		$data['tag'] = $tag;
		
		return $page->$action($data);
	}
	
	protected function get_action_link($action, $element = false){
		$url = 'edit.php?post_type=tcpc&page=tcp_pdf_export&action=' . $action;
		
		if(!empty($element)){
			foreach($element as $key => $value){
				$url .= '&' . $key . '=' . $value;
			}
		}
		
		return admin_url($url);
	}
}
?>