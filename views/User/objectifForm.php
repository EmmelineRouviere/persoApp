<?php
$page = "Créer un nouvel objectif";
if (loadSidebar($_SESSION['page'])) {
    require_once 'inc/sidebar.php';
}
?>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8 text-nutrition"><?= isset($objectifUser) ? 'Modifier objectif' : 'Créer un nouvel objectif' ?></h1>
        <?php if (ErrorHandler::hasErrors()): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <?php foreach (ErrorHandler::getErrors() as $code => $message): ?>
                    <p class="text-sm mb-2 last:mb-0">
                        <?= htmlspecialchars($message) ?>
                    </p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="?ctrl=objectif&action=<?= isset($objectifUser) ? 'update' : 'create' ?>" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <?php if (isset($objectifUser)) : ?>
            <input type="hidden" name="objectifId" value="<?= htmlspecialchars($objectifUser->getObjectifId()) ?>">
        <?php endif ?>
        <input type="hidden" name="userId" value="<?= $_SESSION[APP_TAG]['connected']['id'] ?>">   
        <input type="hidden" name="state" value="false">   
        
        <div class="mb-4">
            <label for="objectif" class="block text-sm font-medium text-gray-700">Type d'objectif</label>
            <select id="objectif" name="objectif" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-nutrition focus:ring focus:ring-nutrition focus:ring-opacity-50">
                <option value="">Choisissez un objectif</option>
                <?php foreach($objectives as $objective) : ?>
                    <option value="<?= $objective->getId() ?>" <?= (isset($objectifUser) && $objectifUser->getObjectifLabelId() == $objective->getId()) ? 'selected' : '' ?>>
                        <?= $objective->getLabel() ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="weightObjectif">
                Objectif de poids (en kg)
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                   id="weightObjectif" 
                   name="weightObjectif" 
                   type="number" 
                   step="0.1" 
                   value="<?= isset($objectifUser) ? htmlspecialchars($objectifUser->getWeightObjectif()) : '' ?>"
                   placeholder="Ex: 70.5">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="workoutObjectifPerWeek">
                Nombre d'entraînements par semaine
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                   id="workoutObjectifPerWeek" 
                   name="workoutObjectifPerWeek" 
                   type="number" 
                   min="0" 
                   max="7" 
                   value="<?= isset($objectifUser) ? htmlspecialchars($objectifUser->getWorkoutObjectifPerWeek()) : '' ?>"
                   placeholder="Ex: 3">
        </div>

        <div class="flex items-center justify-between">
            <button class="bg-nutrition hover:bg-nutrition/80 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300" type="submit">
                <?= isset($objectifUser) ? 'Modifier' : 'Créer' ?> l'objectif
            </button>
        </div>
    </form>
    </div>
    </div>

