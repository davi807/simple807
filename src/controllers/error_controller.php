<?php

function indexAction(){
  echo "Some ERROR \n";
}

function not_foundAction(){
  http_response_code(404);
  echo "404 not found \n";
}

function paramsAction(){
  http_response_code(400);
  echo "400 bad query \n";
}