<?php
$page= 'Inscription'; 

$pageWithoutSidebar = ['Accueil', 'Inscription', 'Connexion']; 

function loadSidebar($page, $pageWithoutSidebar) {
    return in_array($page, $pageWithoutSidebar);
}
if (!loadSidebar($_SESSION['page'], $pageWithoutSidebar)) {
  require_once 'inc/sidebar.php';
}

?>
<div class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-3xl font-bold mb-6 text-center bg-gradient-to-r from-sport to-nutrition text-transparent bg-clip-text">Inscription</h1>
        <form class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" id="nom" name="nom" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sport focus:ring focus:ring-sport focus:ring-opacity-50">
                </div>
                <div>
                    <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                    <input type="text" id="prenom" name="prenom" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sport focus:ring focus:ring-sport focus:ring-opacity-50">
                </div>
            </div>
            <div>
                <label for="age" class="block text-sm font-medium text-gray-700">Âge</label>
                <input type="number" id="age" name="age" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sport focus:ring focus:ring-sport focus:ring-opacity-50">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-nutrition focus:ring focus:ring-nutrition focus:ring-opacity-50">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input type="password" id="password" name="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-nutrition focus:ring focus:ring-nutrition focus:ring-opacity-50">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Sexe</label>
                <div class="mt-2 space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="sexe" value="homme" class="form-radio text-sport focus:ring-sport">
                        <span class="ml-2">Homme</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="sexe" value="femme" class="form-radio text-sport focus:ring-sport">
                        <span class="ml-2">Femme</span>
                    </label>
                </div>
            </div>
            <div>
                <label for="objectif" class="block text-sm font-medium text-gray-700">Objectif</label>
                <select id="objectif" name="objectif" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-nutrition focus:ring focus:ring-nutrition focus:ring-opacity-50">
                    <option value="">Choisissez un objectif</option>
                        <?php foreach($objectives as $objectif) :?>
                            <option value="<?=$objectif->getId()?>"><?=$objectif->getLabel()?></option>
                        <?php endforeach?>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="poids" class="block text-sm font-medium text-gray-700">Poids actuel (kg)</label>
                    <input type="number" id="poids" name="poids" step="0.1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sport focus:ring focus:ring-sport focus:ring-opacity-50">
                </div>
                <div>
                    <label for="taille" class="block text-sm font-medium text-gray-700">Taille (cm)</label>
                    <input type="number" id="taille" name="taille" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sport focus:ring focus:ring-sport focus:ring-opacity-50">
                </div>
            </div>
            <div>
                
                    <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-sport to-nutrition hover:from-sport/80 hover:to-nutrition/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sport">
                        S'inscrire
                    </button>
                    <a href="index.php?ctrl=user&action=connected">Go page d'accueil</a>
            </div>
            <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Vous avez déjà un compte ?
                <a href="index.php?ctrl=user&action=displayFormConnexion" class="font-medium text-sport hover:text-sport/80">
                    Se connecter
                </a>
            </p>
        </div>
        </form>
    </div>
</div>
