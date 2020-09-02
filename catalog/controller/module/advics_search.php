<?php

class ControllerModuleAdvicsSearch extends Controller {

    private $error = array();

    public function index() {
        $this->load->language('module/advics_search');
        $this->document->setTitle($this->config->get('config_meta_title'));

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            
        }
        $this->document->addStyle('catalog/view/theme/default/stylesheet/advics_search.css');
        $this->document->addScript('catalog/view/javascript/module/advics_search.js');
        $this->load->model('module/advics_search');
        $this->model_module_advics_search->createTable();
        $this->document->setDescription($this->config->get('config_meta_description'));
        $this->document->setKeywords($this->config->get('config_meta_keyword'));

        $data['title'] = $this->language->get('title');
        $data['text'] = $this->language->get('text');
        $data['my_var'] = $this->language->get('my_var');

        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'href' => $this->url->link('common/home'),
            'text' => $this->language->get('text_home')
        );

        $data['breadcrumbs'][] = array(
            'href' => $this->url->link('module/advics_search'),
            'text' => $this->language->get('text')
        );


        $data['text_location'] = $this->language->get('text_location');
        $data['text_store'] = $this->language->get('text_store');
        $data['text_vin'] = $this->language->get('text_vin');
        $data['text_address'] = $this->language->get('text_address');
        $data['text_telephone'] = $this->language->get('text_telephone');
        $data['text_fax'] = $this->language->get('text_fax');
        $data['text_open'] = $this->language->get('text_open');
        $data['text_comment'] = $this->language->get('text_comment');

        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_email'] = $this->language->get('entry_email');
        $data['entry_enquiry'] = $this->language->get('entry_enquiry');
        $data['entry_captcha'] = $this->language->get('entry_captcha');
        $data['entry_vin'] = $this->language->get('entry_vin');
        $data['entry_phone'] = $this->language->get('entry_phone');

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }

        if (isset($this->error['email'])) {
            $data['error_email'] = $this->error['email'];
        } else {
            $data['error_email'] = '';
        }
        if (isset($this->error['vin'])) {
            $data['error_vin'] = $this->error['vin'];
        } else {
            $data['error_vin'] = '';
        }

        if (isset($this->error['enquiry'])) {
            $data['error_enquiry'] = $this->error['enquiry'];
        } else {
            $data['error_enquiry'] = '';
        }

        if (isset($this->error['captcha'])) {
            $data['error_captcha'] = $this->error['captcha'];
        } else {
            $data['error_captcha'] = '';
        }


        $data['button_submit'] = $this->language->get('button_submit');

        $data['action'] = $this->url->link('information/contact');



        if (isset($this->request->get['route'])) {
            $this->document->addLink(HTTP_SERVER, 'canonical');
        }


        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/advics_search.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/module/advics_search.tpl', $data));
        } else {
            $this->response->setOutput($this->load->view('module/advics_search.tpl', $data));
        }
    }

    public function success() {
        $this->load->language('module/advics_search');
        $this->document->setTitle($this->language->get('title'));
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('title'),
            'href' => $this->url->link('module/advics_search')
        );

        $data['title'] = $this->language->get('title');
        $data['text_message'] = $this->language->get('text_success');
        $data['button_continue'] = $this->language->get('button_continue');
        $data['continue'] = $this->url->link('common/home');

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/success.tpl', $data));
        } else {
            $this->response->setOutput($this->load->view('default/template/common/success.tpl', $data));
        }
    }
    
    public function getInputFromView(){
        $this->response->addHeader('Content-Type: application/json');
        $this->load->model('module/advics_search');
        $modelArray = $this->model_module_advics_search->getInfoByType($_POST['id'], $_POST['type']);
        $this->response->setOutput(json_encode($modelArray)); 
    }
    
    public function getPrice(){
        $this->response->addHeader('Content-Type: application/json');
        $this->load->model('module/advics_search');
       $this->response->setOutput(json_encode($this->model_module_advics_search->getPrice($_POST['maker'], $_POST['model'], $_POST['chassis'])));
        
    }

}
