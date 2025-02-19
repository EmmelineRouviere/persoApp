<?php
$page = "users";

if (loadSidebar($_SESSION['page'])) {
    require_once 'inc/sidebar.php';
}

?>
<div class="flex-grow p-8">
    <h1 class="text-3xl font-bold mb-6">Utilisateurs</h1>

    <div class="flex space-x-4 justify-between">
        <div class="mb-6 space-x-4">
            <a href="?ctrl=user&action=displayFormProfil" class="btn bg-nutrition text-white px-4 py-2 rounded hover:bg-nutrition/80 transition-colors">Ajouter un user</a>
        </div>

        <form action="?ctrl=user&action=search" method="GET" class="mb-6">
            <input type="hidden" name="ctrl" value="user">
            <input type="hidden" name="action" value="search">
            <div class="flex">
                <input type="text" name="searchTerm" placeholder="Rechercher un user..." value="" class="flex-grow px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-nutrition">
                <button type="submit" class="bg-nutrition text-white px-4 py-2 rounded-r-md hover:bg-nutrition/80 transition-colors">Rechercher</button>
            </div>
        </form>
    </div>

    <?php if (!empty($users)) : ?>
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de naissance</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Etat de santé</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dernière connexion</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap"><?= $user->getFirstname()?> <?= $user->getLastname()?></td>
                            <td class="px-4 py-2 whitespace-nowrap"><?= $user->getEmail()?></td>
                            <td class="px-4 py-2 whitespace-nowrap"><?= $user->getBirthday()?></td>
                            <td class="px-4 py-2 whitespace-nowrap"><?= $user->getIMCCategory()?></td>
                            <td class="px-4 py-2 whitespace-nowrap">12/12/2024</td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    <a href="?ctrl=user&action=showProfile&id=<?= $user->getId() ?>"><i class="fa-solid fa-eye mr-2"></i></a>
                                    <a href="?ctrl=user&action=displayFormProfil&id=<?= $user->getId() ?>"><i class="fa-regular fa-pen-to-square mr-2"></i></a>
                                    <button class="open-modal" data-modal-target="user-modal-<?= $user->getId() ?>"><i class="fa-solid fa-trash text-red"></i></button>
                                </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

    <?php else : ?>
        <p>Aucun user encore enregistré</p>
    <?php endif; ?>
</div>

<?php foreach ($users as $user) : ?>
    <div id="user-modal-<?= $user->getId()?>" class="modal fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Suppression de : <?= $user->getFirstname()?> <?= $user->getLastname()?></h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500 mb-4">Êtes-vous sûr de vouloir supprimer ce user ? Cette action est irréversible.</p>
                    <div class="flex justify-between">
                        <a href="?ctrl=admin&action=deleteUser&id=<?= $user->getId() ?>" class="delete-food btn bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition-colors">Supprimer</a>

                        <button class="close-modal px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
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