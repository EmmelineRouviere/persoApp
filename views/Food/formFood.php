<?php 
$page="formFood"; 

$pageWithoutSidebar = ['Accueil', 'Inscription', 'Connexion']; 

function loadSidebar($page, $pageWithoutSidebar) {
    return in_array($page, $pageWithoutSidebar);
}
if (!loadSidebar($_SESSION['page'], $pageWithoutSidebar)) {
  require_once 'inc/sidebar.php';
}

?>

    <div class="flex-grow p-8">
        <h1 class="text-3xl font-bold mb-8"> <?= isset($food) ? 'Modifier l\'' : 'Ajouter un '?>aliment</h1>

        <form action="?ctrl=food&action=<?= isset($food) ? 'update&id='.$food->getId() : 'add'?>" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="namefood">
                    Nom de l'aliment
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="namefood" id="namefood" value="<?= isset($food) ? htmlspecialchars($food->getNamefood()) : '' ?>" type="text" placeholder="Ex: Pomme" required>
            </div>
            <!-- <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="categorie">
                    Catégorie
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="categorie" required>
                    <option value="">Sélectionnez une catégorie</option>
                    <option value="fruits">Fruits</option>
                    <option value="legumes">Légumes</option>
                    <option value="viandes">Viandes</option>
                    <option value="poissons">Poissons</option>
                    <option value="produits_laitiers">Produits laitiers</option>
                    <option value="cereales">Céréales</option>
                    <option value="autres">Autres</option>
                </select>
            </div> -->
            <!-- <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="calories">
                    Calories (pour 100g)
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="calories" name="calories" value="" type="number" min="0" step="0.1" placeholder="Ex: 52" required>
            </div> -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="proteines">
                    Protéines (g pour 100g)
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="proteines" name="proteines" value="<?= isset($food) ? htmlspecialchars($food->getProteines()) : '' ?>" type="number" min="0" step="0.1" placeholder="Ex: 0.3" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="glucides">
                    Glucides (g pour 100g)
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="glucides" name="glucides" value="<?= isset($food) ? htmlspecialchars($food->getLipides()) : '' ?>" type="number" min="0" step="0.1" placeholder="Ex: 14" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="lipides">
                    Lipides (g pour 100g)
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="lipides" name="lipides" value="<?= isset($food) ? htmlspecialchars($food->getGlucides()) : '' ?>" type="number" min="0" step="0.1" placeholder="Ex: 0.2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="calories">
                    Calories (g pour 100g)
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="calories" name="calories" value="<?= isset($food) ? htmlspecialchars($food->getCalories()) : '' ?>" type="number" min="0" step="0.1" placeholder="Ex: 2.4" required>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-nutrition hover:bg-nutrition/80 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                <?= isset($food) ? 'Modifier' : 'Ajouter' ?>
                </button>
                <button class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="reset">
                    Réinitialiser
                </button>
            </div>
        </form>
    </div>

</div>