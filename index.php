<?php
session_start();

// if(!isset($_SESSION['page'])){
//     $_SESSION['page'] = 'Accueil';
// }
  
require_once 'config/config.php';
require_once 'functions/autoloaders.php';
// session_start(); 
require_once 'inc/head.php';

// $pageWithoutSidebar = ['Accueil', 'Inscription', 'Connexion']; 
// function loadSidebar($page, $pageWithoutSidebar) {
//   return in_array($page, $pageWithoutSidebar);
// }

// if (!loadSidebar($_SESSION['page'], $pageWithoutSidebar)) {
// require_once 'inc/sidebar.php';
// }




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