<?php 

define('PAGES_WITHOUT_SIDEBAR', ['Accueil', 'Inscription', 'Connexion']);

function loadSidebar($page)
{
    return !in_array($page, PAGES_WITHOUT_SIDEBAR);
}
