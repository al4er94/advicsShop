<?php
class ModelExtensionModuleTopautoBenefit extends Model {
	public function addTopautoBenefit($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "topautobenefit SET name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "'");

		$topautobenefit_id = $this->db->getLastId();

		if (isset($data['topautobenefit_image'])) {
			foreach ($data['topautobenefit_image'] as $language_id => $value) {
				foreach ($value as $topautobenefit_image) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "topautobenefit_image SET topautobenefit_id = '" . (int)$topautobenefit_id . "', language_id = '" . (int)$language_id . "', title = '" .  $this->db->escape($topautobenefit_image['title']) . "', text = '" .  $this->db->escape($topautobenefit_image['text']) . "', link = '" .  $this->db->escape($topautobenefit_image['link']) . "', btntext = '" .  $this->db->escape($topautobenefit_image['btntext']) . "', image = '" .  $this->db->escape($topautobenefit_image['image']) . "', sort_order = '" .  (int)$topautobenefit_image['sort_order'] . "'");
				}
			}
		}

		return $topautobenefit_id;
	}

	public function editTopautoBenefit($topautobenefit_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "topautobenefit SET name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "' WHERE topautobenefit_id = '" . (int)$topautobenefit_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "topautobenefit_image WHERE topautobenefit_id = '" . (int)$topautobenefit_id . "'");

		if (isset($data['topautobenefit_image'])) {
			foreach ($data['topautobenefit_image'] as $language_id => $value) {
				foreach ($value as $topautobenefit_image) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "topautobenefit_image SET topautobenefit_id = '" . (int)$topautobenefit_id . "', language_id = '" . (int)$language_id . "', title = '" .  $this->db->escape($topautobenefit_image['title']) . "', text = '" .  $this->db->escape($topautobenefit_image['text']) . "', link = '" .  $this->db->escape($topautobenefit_image['link']) . "', btntext = '" .  $this->db->escape($topautobenefit_image['btntext']) . "', image = '" .  $this->db->escape($topautobenefit_image['image']) . "', sort_order = '" . (int)$topautobenefit_image['sort_order'] . "'");
				}
			}
		}
	}

	public function deleteTopautoBenefit($topautobenefit_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "topautobenefit WHERE topautobenefit_id = '" . (int)$topautobenefit_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "topautobenefit_image WHERE topautobenefit_id = '" . (int)$topautobenefit_id . "'");
	}

	public function getTopautoBenefit($topautobenefit_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "topautobenefit WHERE topautobenefit_id = '" . (int)$topautobenefit_id . "'");

		return $query->row;
	}

	public function getTopautoBenefits($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "topautobenefit";

		$sort_data = array(
			'name',
			'status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTopautoBenefitImages($topautobenefit_id) {
		$topautobenefit_image_data = array();

		$topautobenefit_image_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "topautobenefit_image WHERE topautobenefit_id = '" . (int)$topautobenefit_id . "' ORDER BY sort_order ASC");

		foreach ($topautobenefit_image_query->rows as $topautobenefit_image) {
			$topautobenefit_image_data[$topautobenefit_image['language_id']][] = array(
				'title'      => $topautobenefit_image['title'],
				'text'      => $topautobenefit_image['text'],
				'link'       => $topautobenefit_image['link'],
				'btntext'       => $topautobenefit_image['btntext'],
				'image'      => $topautobenefit_image['image'],
				'sort_order' => $topautobenefit_image['sort_order']
			);
		}

		return $topautobenefit_image_data;
	}

	public function getTotalTopautoBenefits() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "topautobenefit");

		return $query->row['total'];
	}
}
