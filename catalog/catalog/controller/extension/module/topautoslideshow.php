<?php
class ControllerExtensionModuleTopautoslideshow extends Controller {
	public function index($setting) {
		static $module = 0;		

		$this->load->model('design/banner');
		$this->load->model('tool/image');

		$this->document->addStyle('catalog/view/theme/topauto/js/slick/slick.css');
		$this->document->addStyle('catalog/view/theme/topauto/js/slick/slick-theme.css');
		$this->document->addScript('catalog/view/theme/topauto/js/slick/slick.min.js');
		
		$data['banners'] = array();

		$results = $this->model_design_banner->getBanner($setting['banner_id']);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$data['banners'][] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					'image' => 'image/' . $result['image']
				);
			}
		}

		$data['module'] = $module++;

		return $this->load->view('extension/module/topautoslideshow', $data);
	}
}