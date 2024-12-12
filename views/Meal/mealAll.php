<?php
$page="meals"; 

$pageWithoutSidebar = ['Accueil', 'Inscription', 'Connexion']; 

function loadSidebar($page, $pageWithoutSidebar) {
    return in_array($page, $pageWithoutSidebar);
}
if (!loadSidebar($_SESSION['page'], $pageWithoutSidebar)) {
  require_once 'inc/sidebar.php';
}
?>

    <div class="flex-grow p-8">
        <div>
            <h1 class="text-3xl font-bold mb-4">Vos repas</h1>

            <div class="mb-6 flex justify-between">
                <a href= "?ctrl=meal&action=displayformMeal" class="btn bg-nutrition text-white px-4 py-2 rounded hover:bg-nutrition/80 transition-colors">Créer votre repas</a>
                <form action="?ctrl=food&action=search" method="GET" class="">
                        <input type="hidden" name="ctrl" value="meal">
                        <input type="hidden" name="action" value="search">
                        <div class="flex">
                            <input type="text" name="searchTerm" placeholder="Rechercher un repas..." value="" class="flex-grow px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-nutrition">
                            <button type="submit" class="bg-nutrition text-white px-4 py-2 rounded-r-md hover:bg-nutrition/80 transition-colors">Rechercher</button>
                        </div>
                </form>
            </div>
            
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach($meals as $meal) :?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://via.placeholder.com/400x200" alt="Petit-déjeuner équilibré" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-bold mb-2"><?= $meal->getNameMeal()?></h2>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-nutrition font-semibold">Calories : <?= $meal->getTotalCalories()?></span>
                            <span class="text-sport font-semibold">Protéines : <?= $meal->getTotalProteines()?>g</span>
                        </div>
                        <div class="flex justify-between">
                            <a href="?ctrl=meal&action=show&id=<?= $meal->getId()?>" class=" btn bg-nutrition text-white px-4 py-2 rounded hover:bg-nutrition/80 transition-colors">Voir le détail</a>
                            <button class="bg-sport text-white px-4 py-2 rounded hover:bg-sport/80 transition-colors">+</button>
                        </div>
                    </div>
                </div>
            <?php endforeach?>
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
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
    </div>

</div>
