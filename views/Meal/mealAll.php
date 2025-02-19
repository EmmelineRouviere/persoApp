<?php
$page = "meals";
if (loadSidebar($_SESSION['page'])) {
    require_once 'inc/sidebar.php';
}

?>

<div class="flex-grow py-8 md:p-8">
    <div class="px-4">
        <h1 class="text-3xl font-bold mb-4 text-center sm:text-left">Vos repas</h1>

        <div class="mb-6 flex flex-col sm:flex-row justify-between space-y-4 sm:space-y-0 <?= $meals ? '' : 'hidden' ?>">
            <a href="?ctrl=meal&action=displayformMeal" class="btn bg-nutrition text-white text-center px-4 py-2 rounded hover:bg-nutrition/80 transition-colors">Créer votre repas</a>

            <form action="?ctrl=food&action=search" method="GET" class="w-full sm:w-auto">
                <input type="hidden" name="ctrl" value="meal">
                <input type="hidden" name="action" value="search">
                <div class="flex w-full">
                    <input type="text" name="searchTerm" placeholder="Rechercher un repas..." value="" class="flex-grow px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-nutrition">
                    <button type="submit" class="bg-nutrition text-white px-4 py-2 rounded-r-md hover:bg-nutrition/80 transition-colors">Rechercher</button>
                </div>
            </form>
        </div>
    </div>

    <?php if ($meals !== null) : ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-4">
            <?php foreach ($meals as $meal) : ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="assets/img/repas.jpg" alt="Petit-déjeuner équilibré" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-bold mb-2"><?= $meal->getNameMeal() ?>  <?= $_SESSION[APP_TAG]['connected']['role'] == 2 ? " | Créé par : " . $meal->getMealOwner() : '' ?></h2>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-nutrition font-semibold">Calories : <?= $meal->getTotalCalories() ?>kcal</span>
                            <span class="text-sport font-semibold">Protéines : <?= $meal->getTotalProteines() ?>g</span>
                        </div>
                        <div class="flex justify-between">
                            <a href="?ctrl=meal&action=show&id=<?= $meal->getId() ?>" class="btn border-solid border bg-white border-green-600 text-green-600 px-4 py-2 rounded hover:bg-nutrition hover:text-white transition-colors">Voir le détail</a>
                            
                            <div class="flex justify-between items-center">
                                <button class="text-black p-1 rounded border border-black open-modal" data-modal-target="meal-modal-<?= $meal->getId() ?>">
                                    <i class="fa-solid fa-plus"></i>   
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center hidden">
            <nav class="inline-flex rounded-md shadow">
                <a href="#" class="px-3 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    Précédent
                </a>
                <a href="#" class="px-3 py-2 border-t border-b border-gray-300 bg-white text-sm font-medium text-nutrition hover:bg-gray-50">
                    1
                </a>
                <a href="#" class="px-3 py-2 border-t border-b border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    2
                </a>
                <a href="#" class="px-3 py-2 border-t border-b border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    3
                </a>
                <a href="#" class="px-3 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    Suivant
                </a>
            </nav>
        </div>
    <?php else : ?>

        <div class="items-center">
            <h2 class="text-3xl text-center"> Oups ... il semblerait que vous n'ayez aucun repas encore enregistrés ! </h2>
            <a href="?ctrl=meal&action=displayformMeal" class="btn bg-nutrition text-white px-4 py-2 rounded hover:bg-nutrition/80 transition-colors my-6 block mx-auto max-w-[350px] w-fit">Créer mon premier repas</a>
        </div>

    <?php endif ?>
</div>

<?php if ($meals !== null) : ?>
<?php foreach ($meals as $meal) : ?>
    <div id="meal-modal-<?= $meal->getId() ?>" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Ajouter le repas <?= htmlspecialchars($meal->getNameMeal()) ?></h3>
                <div class="mt-2 px-7 py-3">
                    <form action="?ctrl=daymeal&action=add" method="POST">
                        <input type="hidden" name="meal" value="<?= $meal->getId() ?>">
                        <input type="hidden" name="userId" value="<?= $_SESSION[APP_TAG]['connected']['id'] ?>">
                        <input type="hidden" name="date" value="<?= date('Y-m-d') ?>">
                        <div class="mb-4">
                            <label for="namemeal-<?= $meal->getId() ?>" class="block text-sm font-medium text-gray-700">Type de repas</label>
                            <select id="namemeal-<?= $meal->getId() ?>" name="namemeal" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-nutrition focus:border-nutrition sm:text-sm">
                                <option value="">Sélectionnez un type de repas</option>
                                <?php foreach ($nameMeals as $nameMeal): ?>
                                    <option value="<?= htmlspecialchars($nameMeal->getId()) ?>">
                                        <?= htmlspecialchars($nameMeal->getLabel()) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-sport text-white text-base font-medium rounded-md shadow-sm hover:bg-sport/80 focus:outline-none focus:ring-2 focus:ring-sport">
                            Confirmer
                        </button>
                    </form>
                </div>
                <div class="items-center px-4 py-3">
                    <button class="close-modal px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<?php endif;?>

</div>

<script>

document.addEventListener('DOMContentLoaded', function() {
    const openButtons = document.querySelectorAll('.open-modal');
    const closeButtons = document.querySelectorAll('.close-modal');

    openButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
            }
        });
    });

    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.fixed');
            if (modal) {
                modal.classList.add('hidden');
            }
        });
    });

    // Fermer la modale si on clique en dehors
    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('fixed')) {
            event.target.classList.add('hidden');
        }
    });
});
</script>