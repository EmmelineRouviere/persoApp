<?php
$page = 'Connexion';

if (loadSidebar($_SESSION['page'])) {
    require_once 'inc/sidebar.php';
}


?>
<div class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <?php if (ErrorHandler::hasErrors()): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <?php foreach (ErrorHandler::getErrors() as $code => $message): ?>
                    <p class="text-sm mb-2 last:mb-0">
                        <?= htmlspecialchars($message) ?>
                    </p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <h1 class="text-3xl font-bold mb-6 text-center bg-gradient-to-r from-sport to-nutrition text-transparent bg-clip-text">Connexion</h1>
        <form action="?ctrl=user&action=logIn" method="POST" class="space-y-4">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sport focus:ring focus:ring-sport focus:ring-opacity-50">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input type="password" id="password" name="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-nutrition focus:ring focus:ring-nutrition focus:ring-opacity-50">
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-sport focus:ring-sport border-gray-300 rounded">
                    <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                        Se souvenir de moi
                    </label>
                </div>
                <div class="text-sm">
                    <a href="#" class="font-medium text-nutrition hover:text-nutrition/80">
                        Mot de passe oublié ?
                    </a>
                </div>
            </div>
            <div>
                <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-sport to-nutrition hover:from-sport/80 hover:to-nutrition/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sport">
                    Se connecter
                </button>
            </div>
        </form>
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Vous n'avez pas de compte ?
                <a href="index.php?ctrl=user&action=displayFormProfil" class="font-medium text-sport hover:text-sport/80">
                    S'inscrire
                </a>
                
            </p>
        </div>
    </div>
</div>