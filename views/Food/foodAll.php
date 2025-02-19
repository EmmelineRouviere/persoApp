<?php
$page = "foods";

if (loadSidebar($_SESSION['page'])) {
    require_once 'inc/sidebar.php';
}

?>
<div class="flex-grow p-4 sm:p-8">
    <h1 class="text-3xl sm:text-3xl font-bold mb-4 mb-6 text-center md:text-left pt-8">Les aliments</h1>

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0 sm:space-x-4 mb-6">
        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
            <a href="?ctrl=food&action=displayFormFood" class="btn bg-nutrition text-white px-4 py-2 rounded hover:bg-nutrition/80 transition-colors text-center">Ajouter un aliment</a>
            <a href="?ctrl=meal&action=displayformMeal" class="btn border-solid border bg-white border-green-600 text-green-600 px-4 py-2 rounded hover:bg-nutrition hover:text-white transition-colors text-center">Constituer un repas</a>
        </div>

        <form action="?ctrl=food&action=search" method="GET" class="w-full sm:w-auto">
            <input type="hidden" name="ctrl" value="food">
            <input type="hidden" name="action" value="search">
            <div class="flex">
                <input type="text" name="searchTerm" placeholder="Rechercher un aliment..." value="" class="flex-grow px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-nutrition">
                <button type="submit" class="bg-nutrition text-white px-4 py-2 rounded-r-md hover:bg-nutrition/80 transition-colors">Rechercher</button>
            </div>
        </form>
    </div>

    <?php if (!empty($foods)) : ?>
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto hidden sm:table">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-2 sm:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aliment</th>
                        <th class="px-2 sm:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Protéines (g)</th>
                        <th class="px-2 sm:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lipides (g)</th>
                        <th class="px-2 sm:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Glucides (g)</th>
                        <th class="px-2 sm:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Calories (kcal)</th>
                        <?php if ($_SESSION[APP_TAG]['connected']['role'] == 2) : ?>
                            <th class="px-2 sm:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($foods as $food) : ?>
                        <tr>
                            <td class="px-2 sm:px-4 py-2 whitespace-nowrap"><?= $food->getNamefood() ?></td>
                            <td class="px-2 sm:px-4 py-2 whitespace-nowrap"><?= $food->getProteines() ?></td>
                            <td class="px-2 sm:px-4 py-2 whitespace-nowrap"><?= $food->getLipides() ?></td>
                            <td class="px-2 sm:px-4 py-2 whitespace-nowrap"><?= $food->getGlucides() ?></td>
                            <td class="px-2 sm:px-4 py-2 whitespace-nowrap"><?= $food->getCalories() ?></td>
                            <?php if ($_SESSION[APP_TAG]['connected']['role'] == 2) : ?>
                                <td class="px-2 sm:px-4 py-2 whitespace-nowrap">
                                    <a href="?ctrl=food&action=displayFormFood&id=<?= $food->getId() ?>" class="mr-2 sm:mr-4"><i class="fa-regular fa-pen-to-square"></i></a>
                                    <button class="open-modal" data-modal-target="food-modal-<?= $food->getId() ?>"><i class="fa-solid fa-trash text-red"></i></button>
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

        <div class="sm:hidden">
            <?php foreach ($foods as $food) : ?>
                <div class="bg-white p-4 mb-4 rounded shadow">
                    <h3 class="font-bold text-lg mb-2"><?= $food->getNamefood() ?></h3>
                    <div class="grid grid-cols-2 gap-2">
                        <p><span class="font-semibold">Protéines:</span> <?= $food->getProteines() ?></p>
                        <p><span class="font-semibold">Lipides:</span> <?= $food->getLipides() ?></p>
                        <p><span class="font-semibold">Glucides:</span> <?= $food->getGlucides() ?></p>
                        <p><span class="font-semibold">Calories:</span> <?= $food->getCalories() ?></p>
                    </div>
                    <?php if ($_SESSION[APP_TAG]['connected']['role'] == 2) : ?>
                        <div class="mt-2">
                            <a href="?ctrl=food&action=displayFormFood&id=<?= $food->getId() ?>" 
                            class="mr-2 sm:mr-4"><i class="fa-regular fa-pen-to-square"></i></a>
                            <button class="open-modal" 
                            data-modal-target="food-modal-<?= $food->getId() ?>"><i 
                            class="fa-solid fa-trash text-red"></i></button>
                        </div>
                    <?php endif ?>
                </div>
            <?php endforeach ?>
        </div>
</div>
<?php else : ?>
    <p class="text-center">Aucun aliment encore enregistré</p>
<?php endif; ?>
</div>

<?php foreach ($foods as $food) : ?>
    <div id="food-modal-<?= $food->getId() ?>" class="modal fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-11/12 sm:w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Suppression de : <?= $food->getNamefood() ?></h3>
                <div class="mt-2 px-4 sm:px-7 py-3">
                    <p class="text-sm text-gray-500 mb-4">Êtes-vous sûr de vouloir supprimer cet aliment ? Cette action est irréversible.</p>
                    <div class="flex flex-col sm:flex-row justify-center sm:justify-between space-y-2 sm:space-y-0">
                        <a href="?ctrl=food&action=delete&id=<?= $food->getId() ?>" class="delete-food btn bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition-colors w-full sm:w-auto">Supprimer</a>
                        <button class="close-modal px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300 w-full sm:w-auto">
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const openButtons = document.querySelectorAll('.open-modal');
        const closeButtons = document.querySelectorAll('.close-modal');
        const modals = document.querySelectorAll('.modal');

        openButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.stopPropagation(); // Empêche la propagation de l'événement
                const modalId = this.getAttribute('data-modal-target');
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.remove('hidden');
                }
            });
        });

        closeButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.stopPropagation(); // Empêche la propagation de l'événement
                const modal = this.closest('.modal');
                if (modal) {
                    modal.classList.add('hidden');
                }
            });
        });

        // Fermer la modale si on clique en dehors
        modals.forEach(modal => {
            modal.addEventListener('click', function(event) {
                if (event.target === this) {
                    this.classList.add('hidden');
                }
            });
        });

        // Empêcher la fermeture lorsqu'on clique à l'intérieur de la modale
        modals.forEach(modal => {
            const modalContent = modal.querySelector('.relative');
            if (modalContent) {
                modalContent.addEventListener('click', function(event) {
                    event.stopPropagation();
                });
            }
        });
    });
</script>