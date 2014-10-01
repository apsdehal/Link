<?php

class View 
{
  public function __construct( $view, $data = array() ){
  	$this->view = $view;
  	$this->data = $data;
  }

  public function with($data) {
  	$this->data = array_merge($this->data, $data);	
  	return $this;
  }

  public function render() {
  	extract($this->data);
    require_once("./views/" .  $view . '.php');
  }
}