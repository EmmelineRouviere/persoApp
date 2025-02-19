<?php
$page = "Repas du jour en cours";

if (loadSidebar($_SESSION['page'])) {
    require_once 'inc/sidebar.php';
}

?>
<div class="container mx-auto px-4 py-8">

    <?php if ($daymeals === null) : ?>
        <div class="items-center pt-8">
            <h2 class="text-3xl text-center">Il semble que vous n'ayez encore rien mangé aujourd'hui</h2>
            <a href="?ctrl=daymeal&action=displayDaymealForm" class="btn bg-nutrition text-white px-4 py-2 rounded hover:bg-nutrition/80 transition-colors my-6 block mx-auto max-w-[350px] w-fit">Ajouter mon premier repas de la journée</a>

        </div>
    <?php else : ?>
        <div class="flex">
            <h3 class="text-3xl font-bold mb-8 pt-8 text-center lg:text-left">Repas enregistrés aujourd'hui</h3>
        </div>
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

        <a href="?ctrl=daymeal&action=displayDaymealForm" class="mx-auto btn bg-nutrition text-white px-4 py-2 rounded hover:bg-nutrition/80 transition-colors my-6 block max-w-[350px] w-fit">Ajouter un repas </a>


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-4">
            <?php foreach ($daymeals as $daymeal) : ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="assets/img/repas.jpg" alt="Petit-déjeuner" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-bold mb-2"><?= $daymeal->getNameMeal() ?> | <?= $daymeal->getMealName() ?></h2>
                        <p class="text-gray-600 mb-4"><?= $daymeal->getDescriptionMeal() ?></p>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-nutrition font-semibold"><?= $daymeal->getTotalCalories() ?>kcal</span>
                            <span class="text-sport font-semibold"><?= $daymeal->getTotalProteines() ?>g protéines</span>
                        </div>
                        <div class="flex justify-between">
                            <a href="?ctrl=meal&action=show&id=<?= $daymeal->getMealId() ?>" class="btn border-solid border bg-white border-green-600 text-green-600 px-4 py-2 rounded hover:bg-nutrition hover:text-white transition-colors">Voir le détail</a>
                            <button data-modal-target="daymeal-modal-<?= $daymeal->getDayId() ?>" class="btn border-solid border bg-white border-red-500 text-red-500 px-4 py-2 rounded hover:bg-red-600 hover:text-white transition-colors open-modal">Supprimer</button>

                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</div>

<?php if ($daymeals !== null) : ?>
    <?php foreach ($daymeals as $daymeal) : ?>
        <div id="daymeal-modal-<?= $daymeal->getDayId() ?>" class="modal fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Suppression du repas <?= $daymeal->getMealName() ?></h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500 mb-4">Êtes-vous sûr de vouloir supprimer ce repas ? Cette action est irréversible.</p>
                        <div class="flex justify-between">
                            <a href="?ctrl=daymeal&action=delete&id=<?= $daymeal->getDayId() ?>" class="btn bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition-colors">Supprimer</a>
                            <button class="close-modal px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                Annuler
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
<?php endif ?>
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