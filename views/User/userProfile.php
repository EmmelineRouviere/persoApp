<?php
$page = "userProfile";
if (loadSidebar($_SESSION['page'])) {
    require_once 'inc/sidebar.php';
}
?>
<div class="flex-grow p-8">

    <?php if (ErrorHandler::hasErrors()): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <?php foreach (ErrorHandler::getErrors() as $code => $message): ?>
                <p class="text-sm mb-2 last:mb-0">
                    <?= htmlspecialchars($message) ?>
                </p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <h1 class="text-3xl font-bold mb-8">Profil Utilisateur</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Informations personnelles -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold mb-4">Informations personnelles</h2>
            <div class="space-y-4">
                <div>
                    <p class="text-gray-600">Nom</p>
                    <p class="text-xl font-medium"><?= $user->getFirstname() ?> <?= $user->getLastname() ?></p>
                </div>
                <div>
                    <p class="text-gray-600">Email</p>
                    <p class="text-xl font-medium"><?= $user->getEmail() ?></p>
                </div>
                <div>
                    <p class="text-gray-600">Date de naissance</p>
                    <p class="text-xl font-medium"><?= $user->getBirthday() ?></p>
                </div>
                <div>
                    <p class="text-gray-600">Sexe</p>
                    <p class="text-xl font-medium"><?= $user->getSexe() ?></p>
                </div>
                <div>
                    <p class="text-gray-600">Taille</p>
                    <p class="text-xl font-medium"><?= $user->getHeight() ?>cm</p>
                </div>
                <div>
                    <p class="text-gray-600">Poids actuel</p>
                    <p class="text-xl font-medium"><?= $user->getActualWeight() ?> kg</p>
                </div>
            </div>
            <div class="mt-8 flex justify-center">
                <a href="?ctrl=user&action=displayFormProfil&id=<?= $user->getId() ?>" class="btn border-solid border bg-white border-green-600 text-green-600 px-4 py-2 rounded hover:bg-nutrition hover:text-white transition-colors duration-300">
                    Modifier
                </a>
            </div>
        </div>

        <!-- Objectifs -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold mb-4">Objectifs</h2>
            <div class="space-y-4 flex flex-cols">
                <?php if ($user->getObjectifId() === null) : ?>
                    <p>Aucun objectif enregistré à ce jour</p>
                    <a href="?ctrl=objectif&action=displayFormObjectif" class="bg-nutrition text-white px-4 py-2 rounded hover:bg-nutrition/80 transition-colors duration-300 ">Créer mon premier objectif</a>
            </div>
        <?php else: ?>
            <div>
                <p class="text-gray-600">Objectif de poids | <?= $user->getObjectifLabel() ?></p>
                <p class="text-xl font-medium"><?= $user->getWeightObjectif() ?>kg</p>
            </div>
            <div>
                <p class="text-gray-600">Objectif d'activité physique</p>
                <p class="text-xl font-medium"><?= $user->getWorkoutObjectifPerWeek() ?> / semaine</p>
            </div>
        </div>
        <div class="mt-8 flex justify-center">
            <a href="?ctrl=objectif&action=displayFormObjectif&id=<?= $user->getObjectifId() ?> " class="btn bg-nutrition hover:bg-nutrition/80 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
                Modifier
            </a>
        </div>
    <?php endif; ?>
    </div>

</div>

</div>
</div>