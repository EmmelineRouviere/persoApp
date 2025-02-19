<?php
session_start();

require_once 'utils/utils.php';
require_once 'config/config.php';
require_once 'functions/autoloaders.php';
require_once 'inc/head.php';


$ctrl = 'PersoAppController';

if (isset($_GET['ctrl'])) 
{
  $ctrl = ucfirst(strtolower($_GET['ctrl'])) . 'Controller';
}

$method = 'index';
if (isset($_GET['action']))
{
  $method = $_GET['action'];
}



try {

  if (class_exists($ctrl)) 
  {
    $controller = new $ctrl();

    if (!empty($_POST)) 
    {

      if (method_exists($ctrl, $method)) 
      {
        if (!empty($_GET['id']) && ctype_digit($_GET['id'])) 
        {
          $controller->$method($_GET['id'], $_POST);
        } else 
        {
          $controller->$method($_POST);
        }
      }
    } else 
    {

      if (method_exists($ctrl, $method)) 
      {
        if (!empty($_GET['id']) && ctype_digit($_GET['id'])) 
        {
          $controller->$method($_GET['id']);
        } else 
        {
          $controller->$method();
        }
      }
    }
  }
} catch (Exception $e) 
{
  die($e->getMessage());
}

require_once 'inc/foot.php';