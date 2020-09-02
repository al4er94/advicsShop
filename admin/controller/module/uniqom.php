<?php
class ControllerModuleUniqom extends Controller{
   private $error = array(); //  используется для установки ошибки, если таковая возникла.
 
   public function index() {   // функция по умолчанию 
        $this->language->load('module/uniqom'); // Загрузка файла языка uniqom 
        $this->document->setTitle($this->language->get('heading_title')); // Устанавливаем заголовок страницы  в шапке файла языка, то есть Hello World 
        $this->load->model('setting/setting'); // Загружаем Setting Model (все модели и общие настройки в OpenCart сохраняются с помощью этой модели) 
        $this->load->model('module/uniqom');
        $this->model_module_uniqom->createTable();
        //var_dump($_POST);
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate() && isset($_POST['update_prod_id'])) { //    Начало If : валидация и проверка данных если они переданы с помощью безопасного метода (POST)
            self::getProductId($_POST['id_values']);
            $this->model_setting_setting->editSetting('uniqom', $this->request->post);      //Анализ и передача входящих данных в Setting Model для сохранения в  базе данных.
            $this->session->data['success'] = $this->language->get('text_success'); // Для вывода текста о том что данные успешно сохранены
           // $this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')); // редирект в Module Listing
        } // окончание If
        
        if(isset($_POST['update_prod_bd'])){
            $res = self::unpdateProdAPI();
        }
        

        /* Назначаем данные языка для анализа и передачи их в представление */
        $data['heading_title'] = $this->language->get('heading_title');
        
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_content_top'] = $this->language->get('text_content_top');
        $data['text_content_bottom'] = $this->language->get('text_content_bottom');
        $data['text_column_left'] = $this->language->get('text_column_left');
        $data['text_column_right'] = $this->language->get('text_column_right');

        $data['entry_code'] = $this->language->get('entry_code');
        $data['entry_layout'] = $this->language->get('entry_layout');
        $data['entry_position'] = $this->language->get('entry_position');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_add_module'] = $this->language->get('button_add_module');
        $data['button_remove'] = $this->language->get('button_remove');
        $data['productArray'] = $this->model_module_uniqom->getAllProduct();
        /* Этот блок возвращает предупреждение */
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        /* Конец блока */

        /* Этот блок возвращает код ошибки, если таковая возникла */
        if (isset($this->error['code'])) {
            $data['error_code'] = $this->error['code'];
        } else {
            $data['error_code'] = '';
        }
        /* Конец блока */

        /* Создание хлебных крошек для вывода их на сайте */
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/uniqom', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        /* Конец блока хлебных крошек */

        $data['action'] = $this->url->link('module/uniqom', 'token=' . $this->session->data['token'], 'SSL'); // URL to be directed when the save button is pressed

        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'); // URL to be redirected when cancel button is pressed


        /* Этот блок проверяет, задано ли текстовое поле hello world, если да, анализирует его и передает в представление, в противном случае получает значение текстового поля hello world по умолчанию из базы данных и анализирует и передает его */

        if (isset($this->request->post['uniqom_text_field'])) {
            $data['uniqom_text_field'] = $this->request->post['uniqom_text_field'];
        } else {
            $data['uniqom_text_field'] = $this->config->get('uniqom_text_field');
        }
        /* конец блока */

        $data['modules'] = array();

        /* Этот блок анализирует и передает в представление такие настройки модуля как Макет,Позиция,Порядок */
        if (isset($this->request->post['uniqom_module'])) {
            $data['modules'] = $this->request->post['uniqom_module'];
        } elseif ($this->config->get('uniqom_module')) {
            $data['modules'] = $this->config->get('uniqom_module');
        }
        /* конец блока */

        $this->load->model('design/layout'); // Загружаем модель макета дизайна

        $data['layouts'] = $this->model_design_layout->getLayouts(); // Получение макета доступного в системе

        $this->template = 'module/uniqom.tpl'; //Загрузка шаблона uniqom.tpl 
        $this->children = array(
            'common/header',
            'common/footer'
        );  // Добавление дочерних элементов для нашего шаблона по умолчанию, т.е. uniqom.tpl 

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('module/uniqom.tpl', $data));
    }
    
    protected function validate(){
        return true;
    }
    
    public function getProductId($dataProd){
        $prodArr = explode(',', $dataProd);
        $this->model_module_uniqom->createOrUpdateProduct($prodArr);
    }

    public function unpdateProdAPI(){
        $prodArray= $this->model_module_uniqom->getAllProduct();
        foreach ($prodArray as $product){
            $res = self::getProductByApi($product['produc']);
        }
        return true;
    }
    
    public function getProductByApi($produc){
        //$urlUniqom = "http://uniqom.ru/api/v2.1/good.json/".$productId;
        $url = "https://reqres.in/api/users/".$produc;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        return json_decode($res);
    }
} 