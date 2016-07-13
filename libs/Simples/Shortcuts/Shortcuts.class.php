<?php

class Shortcuts{
  static function render($__file_for_render__,$__data_for_extract = array()){
    if(is_array($__data_for_extract)):
      extract($__data_for_extract, EXTR_SKIP);
    endif;
    
    include $__file_for_render__;
    return true;
  }
  static function tpl_render($f,$arg=array(),$debug=false){
    $tpl = new Smarty();
    if(!empty($arg) && is_array($arg))
      $tpl->assign($arg);
    if($debug)
      $tpl->force_compile = true;
    $tpl->display($f);
  }
}