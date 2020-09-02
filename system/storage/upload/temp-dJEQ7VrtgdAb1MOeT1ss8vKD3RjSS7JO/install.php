<?php
// install wrapper for OC 2.3
if (version_compare(VERSION, '2.3', '>=')) {
  $_ext_code = 'universal_import';

  $this->load->model('extension/extension');

  if (!in_array($_ext_code, $this->model_extension_extension->getInstalled('module'))) {
    $this->load->controller('module/'.$_ext_code.'/install');
  }
}