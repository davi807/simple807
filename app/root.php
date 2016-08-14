<?php
require_once "defines.php";
set_include_path(
  get_include_path().PATH_SEPARATOR.
  CTRL.PATH_SEPARATOR.
  MOD.PATH_SEPARATOR.
  TPL.PATH_SEPARATOR.
  LIB);
mb_internal_encoding('UTF-8');
ini_set('session.use_only_cookies','1');
$ctrl_error =  null;
require_once "func.php";
require_once "route.php";
require_once "autoload.php";
require_once "src/require.php";

if(!file_exists($controller)):
    to_page(mklink('error/not_found'));
endif;