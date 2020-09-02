<?php
class ControllerExtensionModuleTopautoBenefits extends Controller {
	public function index($setting) {
		static $module = 0;		

		$this->load->model('extension/module/topautobenefit');
		$this->load->model('tool/image');

		$data['topautobenefits'] = array();

		$results = $this->model_extension_module_topautobenefit->getTopautoBenefit($setting['topautobenefit_id']);

		foreach ($results as $result) {
				$data['topautobenefits'][] = array(
					'title' => $result['title'],
					'btntext' => $result['btntext'],
					'text' => html_entity_decode($result['text'], ENT_QUOTES, 'UTF-8'),
					'link'  => $result['link'],
					'image' => $this->model_tool_image->resize($result['image'], 133, 133)
				);
			
		}

		$data['module'] = $module++;

		return $this->load->view('extension/module/topautobenefits', $data);
	}
}
