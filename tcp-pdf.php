<?

class TCP_PDF{
	protected $db;
	protected $plugin_dir;
	protected $prefix;
	
	public function __construct(){
		global $wpdb;
		
		$this->db = $wpdb;
		$this->plugin_dir = plugin_dir_url( __FILE__ );
		$this->prefix = $wpdb->prefix;
	}
	
	public function run(){
		if(is_admin()){
			require_once TCPP_PLUGIN_DIR . '/admin/tcp-pdf_admin.php';
			
			$this->run_admin();
			wp_enqueue_style('tcp_pdf_style_admin_css', TCPP_PLUGIN_URL . '/admin/view/css/tcp_pdf.css');
		} else {
			return new WP_Error('no_admin','Пользователь не является админом');
		}
	}
	
	public function run_admin(){
		add_action('admin_menu', array($this, 'add_menu_admin'));
		add_action('wp_ajax_export', array($this, 'export'));
		
		return true;
	}
	
	public function add_menu_admin(){
		$admin_class = new TCP_PDF_Admin();
		
		add_submenu_page('edit.php?post_type=tcpc','Экспорт PDF','Экспорт PDF', 5,'tcp_pdf_export',array('TCP_PDF_Admin', 'get_page'));
	}
	
	protected function render($template, $data = null){
		$file = $template;
		
		if (file_exists($file)) {
			if(isset($data)) extract($data);
			
			ob_start();

			require($file);

			$output = ob_get_contents();

			ob_end_clean();
		} else {
			echo '<h3>Отсутствует файл шаблона - <b>' . $file . '</b>!</h3>';
			exit();
		}

		return $output;
	}

	protected function get_model($model){
		require_once TCPP_PLUGIN_DIR . '/admin/models/' . $model . '.php';
		
		return new $model();
	}

	protected function pre_print($data){
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}

	public function export(){
		$export = $this->get_model('export');

		echo json_encode($export->get_export($_POST['data']));

		wp_die();
	}
}