<?php
class ModelExtensionModuleTopautoBenefit extends Model {
	public function getTopautoBenefit($topautobenefit_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "topautobenefit b LEFT JOIN " . DB_PREFIX . "topautobenefit_image bi ON (b.topautobenefit_id = bi.topautobenefit_id) WHERE b.topautobenefit_id = '" . (int)$topautobenefit_id . "' AND b.status = '1' AND bi.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY bi.sort_order ASC");
		return $query->rows;
	}
}
