<?php
$page = "meal";
if (loadSidebar($_SESSION['page'])) {
  require_once 'inc/sidebar.php';
}


?>



    <div class="flex-1 p-8 overflow-y-auto h-full">
      <h1 class="text-3xl font-bold mb-6 pt-8"><?= $meal->getNameMeal() ?></h1>
      <p class="text-gray-600 mb-6"><?= $meal->getDescriptionMeal() ?></p>
      <div class="flex justify-between my-4">
        <a href="?ctrl=meal&action=displayFormMeal&id=<?= $meal->getId()?>" class=" btn bg-nutrition text-white px-4 py-2 rounded hover:bg-nutrition/80 transition-colors">Modifier</a>
        <button data-modal-target="meal-modal-<?= $meal->getId()?>" class="btn border-solid border bg-white border-red-500 text-red-500 px-4 py-2 rounded hover:bg-red-600 hover:text-white transition-colors open-modal">Supprimer</button>
      </div>



      <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Résumé nutritionnel</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div>
            <p class="text-gray-600">Calories</p>
            <p class="text-2xl font-bold text-nutrition"><?= $meal->getTotalCalories()?> kcal</p>
          </div>
          <div>
            <p class="text-gray-600">Protéines</p>
            <p class="text-2xl font-bold text-sport"><?= $meal->getTotalProteines()?>g</p>
          </div>
          <div>
            <p class="text-gray-600">Glucides</p>
            <p class="text-2xl font-bold"><?= $meal->getTotalGlucides()?>g</p>
          </div>
          <div>
            <p class="text-gray-600">Lipides</p>
            <p class="text-2xl font-bold"><?= $meal->getTotalLipides()?>g</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Composition du repas</h2>
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="bg-gray-50">
                <th class="px-4 py-2 text-left">Aliment</th>
                <th class="px-4 py-2 text-left">Quantité (g)</th>
                <th class="px-4 py-2 text-left">Calories</th>
                <th class="px-4 py-2 text-left">Protéines</th>
                <th class="px-4 py-2 text-left">Glucides</th>
                <th class="px-4 py-2 text-left">Lipides</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($foods as $food) : ?>
                <tr>
                  <td class="px-4 py-2"><?= $food->getNamefood() ?></td>
                  <td class="px-4 py-2"><?= $food->getQuantity() ?>g</td>
                  <td class="px-4 py-2"><?= $food->getCalories() ?> kcal</td>
                  <td class="px-4 py-2"><?= $food->getProteines() ?>g</td>
                  <td class="px-4 py-2"><?= $food->getGlucides() ?>g</td>
                  <td class="px-4 py-2"><?= $food->getLipides() ?>g</td>
                </tr>
              <?php endforeach ?>

            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>


 
    <div id="meal-modal-<?=$meal->getId()?>" class="modal fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Suppression de : <?=$meal->getNameMeal()?></h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500 mb-4">Êtes-vous sûr de vouloir supprimer ce repas ? Cette action est irréversible.</p>
                    <div class="flex justify-between">
                    <a href="?ctrl=meal&action=delete&id=<?= $meal->getId()?>" class="delete-food btn bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition-colors">Supprimer</a>

                        <button class="close-modal px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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