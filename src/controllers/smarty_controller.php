<?php

function indexAction(){
  $smarty = new Smarty();
  $smarty->assign('name','Ned');
  $smarty->display('smarty/simple.tpl');
}