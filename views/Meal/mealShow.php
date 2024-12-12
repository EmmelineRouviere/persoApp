<?php
$page = "meal";
$pageWithoutSidebar = ['Accueil', 'Inscription', 'Connexion'];

function loadSidebar($page, $pageWithoutSidebar)
{
  return in_array($page, $pageWithoutSidebar);
}
if (!loadSidebar($_SESSION['page'], $pageWithoutSidebar)) {
  require_once 'inc/sidebar.php';
}
?>



    <div class="flex-1 p-8 overflow-y-auto h-full">
      <h1 class="text-3xl font-bold mb-6"><?= $meal->getNameMeal() ?></h1>
      <p class="text-gray-600 mb-6">Un repas complet et nutritif pour le midi</p>
      <a href="?ctrl=meal&action=displayFormMeal&id=<?= $meal->getId()?>" class=" btn bg-nutrition text-white px-4 py-2 rounded hover:bg-nutrition/80 transition-colors">Modifier</a>
      <a href="?ctrl=meal&action=delete&id=<?= $meal->getId()?>" class=" btn bg-nutrition text-white px-4 py-2 rounded hover:bg-nutrition/80 transition-colors">Supprimer</a>



      <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Résumé nutritionnel</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div>
            <p class="text-gray-600">Calories</p>
            <p class="text-2xl font-bold text-nutrition"><?= $meal->getTotalCalories() ?> kcal</p>
          </div>
          <div>
            <p class="text-gray-600">Protéines</p>
            <p class="text-2xl font-bold text-sport"><?= $meal->getTotalProteines() ?>g</p>
          </div>
          <div>
            <p class="text-gray-600">Glucides</p>
            <p class="text-2xl font-bold"><?= $meal->getTotalGlucides() ?>g</p>
          </div>
          <div>
            <p class="text-gray-600">Lipides</p>
            <p class="text-2xl font-bold"><?= $meal->getTotalLipides() ?>g</p>
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