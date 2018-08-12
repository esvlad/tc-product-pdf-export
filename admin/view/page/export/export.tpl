<div class="wrap">
	<h3>Экспорт PDF</h3>
	<div class="postbox postbox_plugin">
		<div class="inside">
			<p><a href="<?#=$parser_file;?>" target="_blank">Скачать каталог!</a></p>
			<p>Или сгенерируйте новый.</p>
		</div>
		<div class="inside">
			<pre><?print_r($params);?></pre>
		</div>
	</div>
	<div class="postbox postbox_plugin">
		<form id="export_pdf" action="" method="_GET">
			<div class="inside">
				<h3>Фильтр категорий</h3>
				<p>Выберите категории, которые нужно экспортировать в PDF</p>
				<div class="categorydiv">
					<ul class="categorychecklist">
						<li>
							<label class="selectit"><input value="9" type="checkbox" name="all_category" id="all_category">Выбрать все категории</label>
						</li>
					</ul>
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
	</div>
</div>
<script src="<?=$script_js;?>"></script>