<div class="wrap">
	<h3>Экспорт PDF</h3>
	<div class="postbox postbox_plugin">
		<form id="form_export_pdf" action="" method="_POST">
			<div class="inside">
				<h3>Фильтр категорий</h3>
				<p>Выберите категории, которые нужно экспортировать в PDF</p>
				<div class="categorydiv">
					<ul class="categorychecklist">
						<li>
							<label class="selectit"><input value="9" type="checkbox" name="all_category" id="all_category">Выбрать все категории</label>
						</li>
					</ul>
					<div class="categoryes_show_box">Показать / скрыть категории</div>
					<ul class="categorychecklist categoryes_list"><?=$cat;?></ul>
				</div>
				<h3>Прочие фильтры</h3>
				<div class="categorydiv">
					<ul class="categorychecklist">
						<li>
							<label class="selectit"><input value="1" type="checkbox" name="bestseller" id="bestseller">Выбрать хиты продаж</label>
						</li>
					</ul>
				</div>
				<br />
				<input id="export_pdf" class="button button_default" type="submit" value="Экспортировать" />
			</div>
		</form>
		<div class="inside">
			<div class="cssload-loader">
				<div class="cssload-inner cssload-one"></div>
				<div class="cssload-inner cssload-two"></div>
				<div class="cssload-inner cssload-three"></div>
			</div>
			<div class="export_pdf_result">
				<p><a class="button button_default export_download_file" href="#" target="_blank">Скачать PDF файл!</a></p>
			</div>
		</div>
	</div>
</div>
<script>
	var ajax_url = '<?=$ajax_url;?>';
</script>
<script src="<?=$script_js;?>"></script>