
<?php 
$page="formMealAdd"; 
$pageWithoutSidebar = ['Accueil', 'Inscription', 'Connexion']; 

function loadSidebar($page, $pageWithoutSidebar) {
    return in_array($page, $pageWithoutSidebar);
}

if (!loadSidebar($_SESSION['page'], $pageWithoutSidebar)) {
  require_once 'inc/sidebar.php';
}
?>

    <div class="flex-grow p-8">
        <h1 class="text-3xl font-bold mb-8">Créer un repas</h1>

        <form action="?ctrl=meal&action=add" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="nameMeal">
                Nom du repas
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nameMeal" name="nameMeal" type="text" placeholder="Ex: Petit-déjeuner équilibré" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="descriptionMeal">
                Description du repas
            </label>
            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="descriptionMeal" name="descriptionMeal" placeholder="Décrivez votre repas" rows="3"></textarea>
        </div>
        <div id="foodItems" class="mb-4">
            <!-- Le premier élément d'aliment est généré par PHP -->
            <div class="food-item mb-4 p-4 border rounded">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="font-bold">Aliment 1</h3>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="food[1][id]">
                            Nom de l'aliment
                        </label>
                        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="food[1][id]" name="food[1][id]" required>
                        <option selected value="">Choisir un aliment</option>
                            <?php  foreach ($foodOptions as $option): ?>
                                <option value="<?= $option->getId()?>"><?= $option->getNamefood()?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="food[1][quantity]">
                            Quantité (en grammes)
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="food[1][quantity]" name="food[1][quantity]" type="number" min="0" step="1" placeholder="Ex: 100" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <button type="button" id="add-food" class="bg-nutrition hover:bg-nutrition/80 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Ajouter un aliment
            </button>
        </div>
        <div class="flex items-center justify-between">
            <button class="bg-nutrition hover:bg-nutrition/80 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Créer le repas
            </button>
            <button class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="reset">
                Réinitialiser
            </button>
        </div>
    </form>
</div>
    </div>
    </div>

    <script>
// Gestion du formulaire de création de repas
const addFoodButton = document.getElementById('add-food');
const foodItemsContainer = document.getElementById('foodItems');
let foodItemCount = 1; // Commencer à 1 car le premier élément est déjà présent


addFoodButton.addEventListener('click', () => {
    foodItemCount++;
    const foodItem = document.createElement('div');
    foodItem.className = 'food-item mb-4 p-4 border rounded';
    foodItem.innerHTML = `
        <div class="flex justify-between items-center mb-2">
            <h3 class="font-bold">Aliment ${foodItemCount}</h3>
            <button type="button" class="remove-food text-red-500 hover:text-red-700">Supprimer</button>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="food[${foodItemCount}][id]">
                    Nom de l'aliment
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="food[${foodItemCount}][id]" name="food[${foodItemCount}][id]" required>
                <option selected value="">Choisir un aliment</option>
                            <?php  foreach ($foodOptions as $option): ?>
                                <option value="<?= $option->getId()?>"><?= $option->getNamefood()?></option>
                            <?php endforeach ?>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="food[${foodItemCount}][quantity]">
                    Quantité (en grammes)
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="food[${foodItemCount}][quantity]" name="food[${foodItemCount}][quantity]" type="number" min="0" step="1" placeholder="Ex: 100" required>
            </div>
        </div>
    `;
    foodItemsContainer.appendChild(foodItem);

    // Ajouter un gestionnaire d'événements pour le bouton de suppression
    const removeButton = foodItem.querySelector('.remove-food');
    removeButton.addEventListener('click', () => {
        foodItemsContainer.removeChild(foodItem);
    });
});
</script>