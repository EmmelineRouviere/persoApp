<?php
if (isset($user)) {
    $page = 'EditProfil';
} else {
    $page = 'Inscription';
}

if (loadSidebar($_SESSION['page'])) {
    require_once 'inc/sidebar.php';
}

?>

<div class="bg-gray-100 min-h-screen flex items-center justify-center mx-auto">
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
        <h1 class="text-3xl font-bold mb-6 text-center bg-gradient-to-r from-sport to-nutrition text-transparent bg-clip-text"><?= isset($user) ? 'Modification du profil' : 'Inscription' ?></h1>
        <form action="?ctrl=user&action=<?= isset($user) ? 'update' : 'create' ?>" method="POST" class="space-y-4">

            <?php if (isset($user)) : ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($user->getId()) ?>">
            <?php endif ?>

            <?php if (isset($_SESSION[APP_TAG]['connected']['role']) && $_SESSION[APP_TAG]['connected']['role'] == 2) : ?>
                <label for="roleId" class="block text-sm font-medium text-gray-700">Role du user</label>
                <select id="roleId" name="roleId" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-nutrition focus:ring focus:ring-nutrition focus:ring-opacity-50">
                    <option value="">Choisissez un role</option>
                    <option value="1" <?= (isset($user) && $user->getRoleId() == 1) ? 'selected' : '' ?>>Utilisateur</option>
                    <option value="2" <?= (isset($user) && $user->getRoleId() == 2) ? 'selected' : '' ?>>Administrateur</option>
                </select>
            <?php else : ?>
                <input type="hidden" id="roleId" name="roleId" value="1">
            <?php endif ?>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label for="lastname" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" id="lastname" name="lastname" value="<?= isset($user) ? htmlspecialchars($user->getLastname()) : '' ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sport focus:ring focus:ring-sport focus:ring-opacity-50">
                </div>
                <div>
                    <label for="firstname" class="block text-sm font-medium text-gray-700">Prénom</label>
                    <input type="text" id="firstname" name="firstname" value="<?= isset($user) ? htmlspecialchars($user->getFirstname()) : '' ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sport focus:ring focus:ring-sport focus:ring-opacity-50">
                </div>

            </div>
            <div>
                <label for="birthday" class="block text-sm font-medium text-gray-700">Âge</label>
                <input type="date" id="birthday" name="birthday" value="<?= isset($user) ? htmlspecialchars($user->getBirthday()) : '' ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sport focus:ring focus:ring-sport focus:ring-opacity-50">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="<?= isset($user) ? htmlspecialchars($user->getEmail()) : '' ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-nutrition focus:ring focus:ring-nutrition focus:ring-opacity-50">
            </div>
            <div>
                <label for="pwd" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input type="password" id="pwd" name="pwd" minlength="8" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-nutrition focus:ring focus:ring-nutrition focus:ring-opacity-50">
            </div>
            <div>
                <label for="confirmPwd" class="block text-sm font-medium text-gray-700">Confirmation mot de passe</label>
                <input type="password" id="confirmPwd" name="confirmPwd" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-nutrition focus:ring focus:ring-nutrition focus:ring-opacity-50">
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
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="actualWeight" class="block text-sm font-medium text-gray-700">Poids actuel (kg)</label>
                    <input type="number" id="actualWeight" name="actualWeight" value="<?= isset($healthdata) ? htmlspecialchars($healthdata->getActualWeight()) : '' ?>" step="0.1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sport focus:ring focus:ring-sport focus:ring-opacity-50">
                </div>
                <div>
                    <label for="height" class="block text-sm font-medium text-gray-700">Taille (cm)</label>
                    <input type="number" id="height" name="height" value="<?= isset($healthdata) ? htmlspecialchars($healthdata->getHeight()) : '' ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sport focus:ring focus:ring-sport focus:ring-opacity-50">
                </div>
            </div>

            <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-sport to-nutrition hover:from-sport/80 hover:to-nutrition/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sport">
                <?= isset($user) ? 'Modifier' : "S'inscrire" ?>
            </button>
            <?php if (!isset($user)) : ?>
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Vous avez déjà un compte ?
                        <a href="index.php?ctrl=user&action=displayFormConnexion" class="font-medium text-sport hover:text-sport/80">
                            Se connecter
                        </a>
                    </p>
                </div>
            <?php endif; ?>

    </div>
    </form>
</div>
</div>