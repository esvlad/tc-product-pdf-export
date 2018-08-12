<?
set_time_limit(0);
ini_set('memory_limit', '-1');

class Export extends TCP_PDF_Admin{
	private $pdf;

	public function get_export($params = array()){
		$args = array();
		$uploads_folder = '../wp-content/uploads/';

		$args['post_type'] = 'tcpc';
		$args['no_found_rows'] = true;
		$args['nopaging'] = true;

		#ORDER
		$args['orderby'] = 'ID';
		$args['order'] = 'ASC';

		if(is_array($params['category'])){
			$args['tax_query'] = array(
				array(
					'taxonomy' 	=> 'tcpc_category',
					'field'		=> 'id',
					'terms'		=> $params['category']
				)
			);
		}

		if($params['bestseller'] == 1){
			$args['meta_key'] = 'bestseller';
			$args['meta_value'] = 1;
		}

		$query = new WP_Query($args);

		$this->pdf = new FPDF('L', 'pt', 'A4');

		$cat_list = array();
		while ($query->have_posts()){
			$query->the_post();

			$post_id = get_the_ID();
			$title = get_the_title();
			$category = get_the_terms($post_id, 'tcpc_category');
			$product_fields = get_post_meta($post_id);
			$product_image_id = get_post_thumbnail_id($post_id);

			if(!empty($product_image_id)){
				$product_image_url = wp_get_attachment_image_url($product_image_id);
			} else {
				$product_image_url = 'http://pols/wp-content/uploads/nophoto.jpg';
			}

			$this->export_pdf($post_id, $title, $category, $product_fields, $product_image_url);
			#usleep(500000);
		}

		$file_pdf = $uploads_folder . 'pdf/catalog.pdf';
		$this->pdf->Output($file_pdf, 'F');

		return array('success' => true, 'file_export_url' => $file_pdf);
	}

	private function export_pdf($post_id, $title, $category, $product_fields, $product_image_url = false){
		$this->pdf->AddPage();

		$this->pdf->AddFont('Tahoma','','tahoma.php');

		$category_list = $this->product_category_sort_list($category);
		$category_list = iconv('utf-8', 'cp1251', $category_list);
		$this->pdf->SetFont('Tahoma', '', 15);
		$this->pdf->Text(33, 32, $category_list);

		$this->pdf->Image($product_image_url, 33, 53, 350);
			
		$this->pdf->SetLeftMargin(418);
		$this->pdf->SetY(47);
			
		$this->pdf->SetFont('Tahoma', '', 24);
		$title = iconv('utf-8', 'cp1251', $title);
		$this->pdf->MultiCell(300, 30, $title, 0, 'L');
			
		#$this->pdf->SetY(90);
		$this->pdf->Ln(15);

		$this->pdf->SetFont('Tahoma', '', 13);

		foreach($product_fields as $key => $value){
			$key_name = $this->search_name_key($key);

			if($key_name && !empty($value[0]) && $value[0] != 'no'){
				switch ($value[0]) {
					case 'on':
						$value_name = 'Да';
						break;
					case 'out':
						$value_name = 'Нет';
						break;
					default:
						$value_name = $value[0];
						break;
				}

				$key_name = iconv('utf-8', 'cp1251', $key_name);
				$value_name = iconv('utf-8', 'cp1251', $value_name);
				
				$this->pdf->Cell(180, 13, $key_name, 0, 0, 'L');
				$this->pdf->Cell(120, 13, $value_name, 0, 1, 'L');
				$this->pdf->Ln(7);
			}
		}

		$price = $product_fields['tcpc_fields_regular_price'][0];

		foreach($category as $cat){
			if($cat->parent == 0){
				$slug = $cat->slug;
			}
		}

		if(!empty($price)){
			$this->pdf->Ln(7);

			if($slug != 'aksesuari'){
				$price .= ' руб / м2';
			} else {
				$price .= ' руб';
			}

			$price = iconv('utf-8', 'cp1251', $price);
				
			$this->pdf->SetFont('Tahoma', '', 24);
			$this->pdf->Cell(180, 24, '', 0, 0, 'L');
			$this->pdf->Cell(100, 24, $price, 0, 1, 'L');
		}
	}

	private function product_category_sort_list($category){
		$cat_list = array();

		foreach($category as $key => $value){
			$cat_list[$value->parent] = $value->name;
		}

		ksort($cat_list);

		$new_array = implode(' / ', $cat_list);

		return $new_array;
	}

	private function search_name_key($key){
		$keys = array(
			'Вес упаковки' => 'ves_up',
			'Вес м2' => 'ves_m2',
			'Размер' => 'size',
			'Тип' => 'type',
			'Производитель' => 'manufacturer',
			'Коллекция' => 'collection',
			'Страна производства' => 'country_of_production',
			'Толщина верхнего слоя' => 'thickness',
			'Наличие фаски' => 'chamfer',
			'Тип соединения' => 'connection',
			'Покрытие' => 'coating',
			'Тип поверхности' => 'type_surface',
			'Класс нагрузки' => 'class_load',
			'Влагостойкая пропитка' => 'moisture_proof_impregnation',
			'Наличие подложки' => 'presence_substrate',
			'Оттенок' => 'shade',
			'м2 в упаковке' => 'm2_package',
			'Досок в упаковке' => 'board_package',
			'Номер по каталогу' => 'catalog_number',
			'Порода дерева' => 'tree_species',
			'Тип рисунка' => 'picture_type',
			'Подходит для теплого пола' => 'underfloor_heating',
			'Селекция' => 'selection',
			'Твердость по Бринеллю' => 'brinell_hardness',
			'Поверхность' => 'surface',
			'Термообработка древесины' => 'heat_treatment',
			'Наличие полос' => 'presence_bands',
			'Вид обработки' => 'type_treatment',
			'Напольная/настенная' => 'floor_wall',
		);

		return array_search($key, $keys);
	}
}
?>