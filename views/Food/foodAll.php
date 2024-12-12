<?php 
$page="foods"; 

$pageWithoutSidebar = ['Accueil', 'Inscription', 'Connexion']; 

function loadSidebar($page, $pageWithoutSidebar) {
    return in_array($page, $pageWithoutSidebar);
}
if (!loadSidebar($_SESSION['page'], $pageWithoutSidebar)) {
  require_once 'inc/sidebar.php';
}
  
?>
        <div class="flex-grow p-8">
            <h1 class="text-3xl font-bold mb-6">Les aliments</h1>

            <div class="flex space-x-4 justify-between">
                <div class="mb-6 space-x-4">
                    <a href="?ctrl=food&action=displayFormFood" class="btn bg-nutrition text-white px-4 py-2 rounded hover:bg-nutrition/80 transition-colors">Ajouter un aliment</a>
                    <a href="?ctrl=meal&action=displayformMeal" class="btn bg-sport text-white px-4 py-2 rounded hover:bg-sport/80 transition-colors">Constituer un repas</a>
                </div>
                
                <form action="?ctrl=food&action=search" method="GET" class="mb-6">
                    <input type="hidden" name="ctrl" value="food">
                    <input type="hidden" name="action" value="search">
                    <div class="flex">
                        <input type="text" name="searchTerm" placeholder="Rechercher un aliment..." value="" class="flex-grow px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-nutrition">
                        <button type="submit" class="bg-nutrition text-white px-4 py-2 rounded-r-md hover:bg-nutrition/80 transition-colors">Rechercher</button>
                    </div>
                </form>
            </div>

            <?php if(!empty($foods)) : ?>
            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aliment</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Protéines</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lipides</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Glucides</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Calories</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach($foods as $food) :?>
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap"><?= $food->getNamefood()?></td>
                            <td class="px-4 py-2 whitespace-nowrap"><?= $food->getProteines()?></td>
                            <td class="px-4 py-2 whitespace-nowrap"><?= $food->getLipides()?></td>
                            <td class="px-4 py-2 whitespace-nowrap"><?= $food->getGlucides()?></td>
                            <td class="px-4 py-2 whitespace-nowrap"><?= $food->getCalories()?></td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <a href="?ctrl=food&action=displayFormFood&id=<?= $food->getId()?>"><i class="fa-regular fa-pen-to-square mr-4"></i></a>
                                <a href="?ctrl=food&action=delete&id=<?= $food->getId()?>"><i class="fa-solid fa-trash text-red"></i></a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        
            <?php else : ?>
                <p>Désolé, cet aliment n'existe pas encore</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- <script>
        const sidebar = document.getElementById('sidebar');
        const links = document.querySelectorAll('a[data-page]');

        links.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const isNutrition = e.target.closest('li').previousElementSibling.textContent.includes('Nutrition');

                // Remove active class from all links
                links.forEach(l => l.classList.remove('bg-nutrition', 'bg-sport', 'text-white'));

                // Add active class to clicked link
                e.target.classList.add(isNutrition ? 'bg-nutrition' : 'bg-sport', 'text-white');

                // Change sidebar color
                sidebar.style.borderColor = isNutrition ? '#4CAF50' : '#FFA500';
            });
        });
    </script> -->
