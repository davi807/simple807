<?php

function indexAction(){
  include_once "index.html";
}

function homeAction(){
  echo "Home sweet home";
    echo "<br><a href='".mklink()."'>Go to start page</a>";
}