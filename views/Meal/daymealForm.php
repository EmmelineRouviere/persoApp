<?php
$page = "Ajouter un repas consommé";
if (loadSidebar($_SESSION['page'])) {
    require_once 'inc/sidebar.php';
}

?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-nutrition">Ajouter un repas consommé</h1>

    <form action="?ctrl=daymeal&action=add" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <input type="hidden" name="userId" value="<?=$_SESSION[APP_TAG]['connected']['id']?>">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="date">
                Date de consommation
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="consumed_date" name="date" type="date" required value="<?= date('Y-m-d') ?>">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="namemeal">
                Type de repas
            </label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="namemeal" name="namemeal" required>
                <option value="">Sélectionnez un type de repas</option>
                <?php foreach ($namemeals as $namemeal): ?>
                    <option value="<?= htmlspecialchars($namemeal->getId()) ?>">
                        <?= htmlspecialchars($namemeal->getLabel()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="meal">
                Repas consommé
            </label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="meal" name="meal" required>
                <option value="">Sélectionnez un repas</option>
                <?php foreach ($meals as $meal): ?>
                    <option value="<?= htmlspecialchars($meal->getId()) ?>">
                        <?= htmlspecialchars($meal->getNameMeal()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="flex items-center justify-between">
            <button class="bg-nutrition hover:bg-nutrition/80 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300" type="submit">
                Ajouter le repas consommé
            </button>
            <button class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300" type="reset">
                Réinitialiser
            </button>
        </div>
    </form>
</div>
</div>