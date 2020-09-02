<?php
class ControllerModuleAdvicsSearch extends Controller{
    public function index(){
        $this->load->language('module/advics_search');
        //Зададим заголовок страницы, мета-тег title из файла локализации
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/setting');
    }
    
}