<?

/**
* 
*/
class TCP_PDF_Config{
	public function activate(){
		$upload = wp_upload_dir();

		$upload_dir = $upload['basedir'];
		$upload_dir = $upload_dir . '/pdf';

		if (!wp_mkdir_p($upload_dir)){
			echo 'Директория существует!';
		}
	}

	public function deactivate(){}

	public function uninstall(){}
}

?>