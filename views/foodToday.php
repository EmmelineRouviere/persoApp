<?php 
$page="Repas du jour en cours"; 
$pageWithoutSidebar = ['Accueil', 'Inscription', 'Connexion']; 

function loadSidebar($page, $pageWithoutSidebar) {
    return in_array($page, $pageWithoutSidebar);
}
if (!loadSidebar($_SESSION['page'], $pageWithoutSidebar)) {
  require_once 'inc/sidebar.php';
}

?>
    <div class="container mx-auto px-4 py-8">
        <h3 class="text-3xl font-bold mb-8">Repas enregistrés aujourd'hui</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Petit-déjeuner -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="https://via.placeholder.com/400x200?text=Petit-déjeuner" alt="Petit-déjeuner" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-bold mb-2">Petit-déjeuner</h2>
                    <p class="text-gray-600 mb-4">Un petit-déjeuner équilibré pour bien commencer la journée.</p>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-nutrition font-semibold">450 calories</span>
                        <span class="text-sport font-semibold">20g protéines</span>
                    </div>
                    <div class="flex justify-between">
                        <button class="bg-nutrition text-white px-4 py-2 rounded hover:bg-nutrition/80 transition-colors expand-btn">Voir le détail</button>
                    </div>
                </div>
                <div class="details hidden p-4 bg-gray-50 border-t">
                    <ul class="space-y-2">
                        <li class="flex justify-between">
                            <span>Pain complet</span>
                            <span>100g</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Œuf</span>
                            <span>2 unités</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Avocat</span>
                            <span>50g</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Déjeuner -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="https://via.placeholder.com/400x200?text=Déjeuner" alt="Déjeuner" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-bold mb-2">Déjeuner</h2>
                    <p class="text-gray-600 mb-4">Un repas complet et équilibré pour le midi.</p>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-nutrition font-semibold">650 calories</span>
                        <span class="text-sport font-semibold">35g protéines</span>
                    </div>
                    <div class="flex justify-between">
                        <button class="bg-nutrition text-white px-4 py-2 rounded hover:bg-nutrition/80 transition-colors expand-btn">Voir le détail</button>
                    </div>
                </div>
                <div class="details hidden p-4 bg-gray-50 border-t">
                    <ul class="space-y-2">
                        <li class="flex justify-between">
                            <span>Poulet grillé</span>
                            <span>150g</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Riz brun</span>
                            <span>100g</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Brocoli</span>
                            <span>100g</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Collation -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="https://via.placeholder.com/400x200?text=Collation" alt="Collation" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-bold mb-2">Collation</h2>
                    <p class="text-gray-600 mb-4">Une collation saine pour tenir jusqu'au dîner.</p>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-nutrition font-semibold">200 calories</span>
                        <span class="text-sport font-semibold">10g protéines</span>
                    </div>
                    <div class="flex justify-between">
                        <button class="bg-nutrition text-white px-4 py-2 rounded hover:bg-nutrition/80 transition-colors expand-btn">Voir le détail</button>
                    </div>
                </div>
                <div class="details hidden p-4 bg-gray-50 border-t">
                    <ul class="space-y-2">
                        <li class="flex justify-between">
                            <span>Yaourt grec</span>
                            <span>150g</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Fruits rouges</span>
                            <span>50g</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Noix</span>
                            <span>15g</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Total journalier -->
        <div class="mt-8 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4">Total journalier</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600">Calories totales</p>
                    <p class="text-3xl font-bold text-nutrition">1300 kcal</p>
                </div>
                <div>
                    <p class="text-gray-600">Protéines totales</p>
                    <p class="text-3xl font-bold text-sport">65g</p>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const expandButtons = document.querySelectorAll('.expand-btn');
            
            expandButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const card = this.closest('.bg-white');
                    const details = card.querySelector('.details');
                    details.classList.toggle('hidden');
                    
                    if (details.classList.contains('hidden')) {
                        this.textContent = 'Voir le détail';
                    } else {
                        this.textContent = 'Masquer le détail';
                    }
                });
            });
        });
    </script> -->
