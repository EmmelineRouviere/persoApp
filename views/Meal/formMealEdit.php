<?php
$page = "formMealEdit";
if (loadSidebar($_SESSION['page'])) {
    require_once 'inc/sidebar.php';
}
?>

<div class="flex-grow p-8">
    <h1 class="text-3xl font-bold mb-8">Modifier le repas</h1>
    <?php if (ErrorHandler::hasErrors()): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <?php foreach (ErrorHandler::getErrors() as $code => $message): ?>
                <p class="text-sm mb-2 last:mb-0">
                    <?= htmlspecialchars($message) ?>
                </p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="?ctrl=meal&action=edit" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <input type="hidden" name="meal_id" value="<?= $meal->getId() ?>">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="nameMeal">
                Nom du repas
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nameMeal" name="nameMeal" value="<?= htmlspecialchars($meal->getNameMeal()) ?>" type="text" placeholder="Ex: Petit-déjeuner équilibré" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="descriptionMeal">
                Description du repas
            </label>
            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="descriptionMeal" name="descriptionMeal" placeholder="Décrivez votre repas" rows="3"><?= htmlspecialchars($meal->getDescriptionMeal()) ?></textarea>
        </div>
        <div id="foodItems" class="mb-4">
            <?php foreach ($foods as $index => $food) : ?>
                <div class="food-item mb-4 p-4 border rounded">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="font-bold">Aliment <?= $index + 1 ?></h3>
                        <button type="button" class="remove-food text-red-500 hover:text-red-700">Supprimer</button>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="food[<?= $index ?>][id]">
                                Nom de l'aliment
                            </label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="food[<?= $index ?>][id]" name="food[<?= $index ?>][id]" required>
                                <?php foreach ($foodOptions as $option): ?>
                                    <option value="<?= $option->getId() ?>" <?= $option->getId() == $food->getId() ? 'selected' : '' ?>><?= htmlspecialchars($option->getNamefood()) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="food[<?= $index ?>][quantity]">
                                Quantité (en grammes)
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?= $food->getQuantity() ?>" id="food[<?= $index ?>][quantity]" name="food[<?= $index ?>][quantity]" type="number" min="0" step="1" placeholder="Ex: 100" required>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <div class="mb-4">
            <button type="button" id="add-food" class="btn border-solid border bg-white border-green-600 text-green-600 px-4 py-2 rounded hover:bg-nutrition hover:text-white transition-colors">
                Ajouter un aliment
            </button>
        </div>
        <div class="flex items-center justify-between">
            <button class="bg-nutrition hover:bg-nutrition/80 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Modifier le repas
            </button>
           
        </div>
    </form>
</div>
</div>
</div>
</div>

<script>
let foodItemCount = <?= count($foods) ?>;

function createFoodItemElement(index) {
    const foodItem = document.createElement('div');
    foodItem.className = 'food-item mb-4 p-4 border rounded';
    foodItem.innerHTML = `
        <div class="flex justify-between items-center mb-2">
            <h3 class="font-bold">Aliment ${index + 1}</h3>
            <button type="button" class="remove-food text-red-500 hover:text-red-700">Supprimer</button>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="food[${index}][id]">
                    Nom de l'aliment
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="food[${index}][id]" name="food[${index}][id]" required>
                    <option value="">Choisir un aliment</option>
                    <?php foreach ($foodOptions as $option): ?>
                        <option value="<?= $option->getId() ?>"><?= htmlspecialchars($option->getNamefood()) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="food[${index}][quantity]">
                    Quantité (en grammes)
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="food[${index}][quantity]" name="food[${index}][quantity]" type="number" min="0" step="1" placeholder="Ex: 100" required>
            </div>
        </div>
    `;

    const removeButton = foodItem.querySelector('.remove-food');
    removeButton.addEventListener('click', () => foodItem.remove());

    return foodItem;
}

document.getElementById('add-food').addEventListener('click', () => {
    const foodItem = createFoodItemElement(foodItemCount);
    document.getElementById('foodItems').appendChild(foodItem);
    foodItemCount++;
});

// Ajouter la fonctionnalité de suppression aux éléments existants
document.querySelectorAll('.remove-food').forEach(button => {
    button.addEventListener('click', () => button.closest('.food-item').remove());
});
</script>