<?php
$page = "profile";
if (loadSidebar($_SESSION['page'])) {
    require_once 'inc/sidebar.php';
}

?>
<div class="lg:w-5/6">
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
        <h1 class="text-3xl font-bold mb-8 text-center md:text-left">Bienvenue, <?= $_SESSION[APP_TAG]['connected']['firstname'] ?></h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold mb-4">Vos objectifs</h2>
                <?php if ($user->getObjectifId() === null) : ?>
                    <p>Aucun objectif enregistré à ce jour</p>
                    <a href="?ctrl=objectif&action=all" class="btn">Créer mon premier objectif</a>

                <?php else: ?>
                    <a href="?ctrl=objectif&action=all" class="btn">Voir tous mes objectifs</a>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-nutrition mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <?= $user->getObjectifLabel() ?> <?= $user->getWeightObjectif() !== null ?  '| Poids visé : ' . $user->getWeightObjectif() . 'kg' : '' ?>
                        </li>
                        <?php if ($user->getWorkoutObjectifPerWeek() !== null) : ?>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-nutrition mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Nombre d'entrainement par semaine visé : <?= $user->getWorkoutObjectifPerWeek() ?>
                            </li>
                        <?php endif; ?>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-nutrition mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Manger 5 fruits et légumes par jour
                        </li>
                    </ul>


                <?php endif; ?>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold mb-4">Vos données</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600">Poids actuel</p>
                        <p class="text-2xl font-bold"><?= $user->getActualWeight() ?> kg</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Taille</p>
                        <p class="text-2xl font-bold"><?= $user->getHeight() ?> cm</p>
                    </div>
                    <div>
                        <p class="text-gray-600">IMC</p>
                        <p class="text-2xl font-bold"><?= $user->calculateIMC() ?></p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold"><?= $user->getIMCCategory() ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total journalier -->
        <div class="mt-8 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4">Objectif Calories journalières</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <?php foreach ($calorieNeeds as $activityLevel => $calories) : ?>
                    <div class="md:text-center text-left">
                        <p class="font-semibold"><?= $activityLevel ?></p>
                        <p><?= $calories ?>kcal</p>
                    </div>
                <?php endforeach ?>
            </div>
        </div>

        <?php if ($daymeals === null) : ?>
            <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                <h2 class="text-3xl text-center">Il semble que vous n'ayez encore rien mangé aujourd'hui</h2>
                <a href="?ctrl=daymeal&action=displayDaymealForm" class="btn bg-nutrition text-white px-4 py-2 rounded hover:bg-nutrition/80 transition-colors my-6 block mx-auto max-w-[350px] w-fit">Ajouter mon premier repas de la journée</a>
            </div>
        <?php else : ?>

            <!-- Total journalier -->
            <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4">Total journalier</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="mb-4 sm:mb-0">
                        <p class="text-gray-600">Calories totales</p>
                        <p class="text-3xl font-bold text-nutrition"><?= $daymealInformation->getTotalCalories() ?> kcal</p>
                    </div>
                    <div class="mb-4 sm:mb-0">
                        <p class="text-gray-600">Protéines totales</p>
                        <p class="text-3xl font-bold text-sport"><?= $daymealInformation->getTotalProteines() ?>g</p>
                    </div>
                    <div class="mb-4 sm:mb-0">
                        <p class="text-gray-600">Lipides totales</p>
                        <p class="text-3xl font-bold text-sport"><?= $daymealInformation->getTotalLipides() ?>g</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Glucides totaux</p>
                        <p class="text-3xl font-bold text-sport"><?= $daymealInformation->getTotalGlucides() ?>g</p>
                    </div>
                </div>
            </div>


            <div class="container mx-auto px-4 py-8">
                <h3 class="text-3xl font-bold mb-8">Repas enregistrés aujourd'hui</h3>


                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($daymeals as $daymeal) : ?>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <img src="assets/img/repas.jpg" alt="Image-repas" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h2 class="text-xl font-bold mb-2"><?= $daymeal->getNameMeal() ?> | <?= $daymeal->getMealName() ?></h2>
                                <p class="text-gray-600 mb-4"><?= $daymeal->getDescriptionMeal() ?></p>
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-nutrition font-semibold"><?= $daymeal->getTotalCalories() ?>kcal</span>
                                    <span class="text-sport font-semibold"><?= $daymeal->getTotalProteines() ?>g protéines</span>
                                </div>
                                <div class="flex justify-between">
                                    <a href="?ctrl=meal&action=show&id=<?= $daymeal->getMealId() ?>" class="btn border-solid border bg-white border-green-600 text-green-600 px-4 py-2 rounded hover:bg-nutrition hover:text-white transition-colors">Voir le détail</a>
                                    <a href="?ctrl=daymeal&action=delete&id=<?= $daymeal->getDayId() ?>" class="btn border-solid border bg-white border-red-500 text-red-500 px-4 py-2 rounded hover:bg-red-600 hover:text-white transition-colors open-modal">Supprimer</a>

                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif; ?>
            </div>






    </div>
</div>
</div>