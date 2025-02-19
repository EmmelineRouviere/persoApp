<div class="flex">
    <button id="menuToggle" class="lg:hidden fixed top-4 left-4 z-50 p-2 bg-white rounded-md shadow-md">
        <i class="fa-solid fa-bars"></i>
    </button>


    <nav id="sidebar" class="fixed lg:static inset-y-0 left-0 bg-white w-64 min-h-screen flex flex-col transition-all duration-300 shadow transform -translate-x-full lg:translate-x-0">
        <div class="p-4 border-b">
            <h1 class="text-2xl font-bold text-center bg-gradient-to-l from-nutrition to-sport text-transparent bg-clip-text">Healthy Copilot</h1>
        </div>
        <div class="flex-grow overflow-y-auto">
            <div class="p-4 border-b">
                <a href="?ctrl=user&action=connected" class="flex items-center mb-4">
                    <i class="fa-solid fa-user text-6xl  p-2 mx-auto text-transparent bg-clip-text bg-gradient-to-r from-nutrition to-sport hover:shadow hover:rounded-full hover:p-2"></i>
                </a>
                <?php if (isset($_SESSION[APP_TAG]['connected'])) : ?>
                    <a href="index.php?ctrl=user&action=showProfile&id=<?= $_SESSION[APP_TAG]['connected']['id'] ?>" class="block text-center"><?= $_SESSION[APP_TAG]['connected']['firstname'] ?></a>
                <?php endif; ?>

                <a href="?ctrl=user&action=logout" class="block text-center text-red-500 hover:text-red-700">Se déconnecter</a>
            </div>
            <ul class="p-4">
                <?php if ($_SESSION[APP_TAG]['connected']['role'] == 1) : ?>

                    <li class="mb-4">
                        <h2 class="text-lg font-semibold mb-2 text-nutrition">Nutrition</h2>
                        <ul class="space-y-2">
                            <li><a href="index.php?ctrl=daymeal&action=mealOftheDay" class="block p-2 rounded <?= $page = "day" ? 'hover:bg-nutrition hover:text-white' : 'bg-nutrition text-white' ?> transition-colors" data-page="informationMeal">Votre journée</a></li>
                            <li><a href="index.php?ctrl=food&action=index" class="block p-2 rounded <?= $page = "foods" ? 'hover:bg-nutrition hover:text-white' : 'bg-nutrition text-white' ?> transition-colors" data-page="aliments">Les aliments</a></li>
                            <li><a href="index.php?ctrl=meal&action=indexUser" class="block p-2 rounded <?= $page = "meals" ? 'hover:bg-nutrition hover:text-white' : 'bg-nutrition text-white' ?> transition-colors" data-page="meals">Vos repas</a></li>
                            <li><a href="index.php?ctrl=meal&action=history" class="block p-2 rounded <?= $page = "historic" ? 'hover:bg-nutrition hover:text-white' : 'bg-nutrition text-white' ?> transition-colors" data-page="historicalmeals">Historique</a></li>
                        </ul>
                    </li>
                    <li>
                        <h2 class="text-lg font-semibold mb-2 text-sport">Entraînement</h2>
                        <ul class="space-y-2">
                            <li><a href="#" class="block p-2 rounded hover:bg-sport hover:text-white transition-colors" data-page="informationSport">Vos informations</a></li>
                            <li><a href="#" class="block p-2 rounded hover:bg-sport hover:text-white transition-colors" data-page="calendar">Calendrier</a></li>
                            <li><a href="#" class="block p-2 rounded hover:bg-sport hover:text-white transition-colors" data-page="trainings">Mes entraînements</a></li>
                            <li><a href="#" class="block p-2 rounded hover:bg-sport hover:text-white transition-colors" data-page="historicaltrainings">Historique</a></li>
                        </ul>
                    </li>
                <?php else :  ?>
                    <li>
                        <h2 class="text-lg font-semibold mb-2">ADMIN</h2>
                        <ul class="space-y-2">
                            <li><a href="index.php?ctrl=admin&action=indexUser" class="block p-2 rounded <?= $page = "day" ? 'hover:bg-nutrition hover:text-white' : 'bg-nutrition text-white' ?> transition-colors" data-page="informationMeal">Users</a></li>
                            <li><a href="index.php?ctrl=food&action=index" class="block p-2 rounded <?= $page = "foods" ? 'hover:bg-nutrition hover:text-white' : 'bg-nutrition text-white' ?> transition-colors" data-page="aliments">Aliments</a></li>
                            <li><a href="index.php?ctrl=admin&action=indexMeal" class="block p-2 rounded <?= $page = "meals" ? 'hover:bg-nutrition hover:text-white' : 'bg-nutrition text-white' ?> transition-colors" data-page="meals">Repas</a></li>
                        </ul>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </nav>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('sidebar');

            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
            });

            document.addEventListener('click', function(event) {
                const isClickInsideMenu = sidebar.contains(event.target);
                const isClickOnToggle = menuToggle.contains(event.target);

                if (!isClickInsideMenu && !isClickOnToggle && !sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.add('-translate-x-full');
                }
            });

            function handleResize() {
                if (window.innerWidth >= 1024) { /
                    sidebar.classList.remove('-translate-x-full');
                } else {
                    sidebar.classList.add('-translate-x-full');
                }
            }
            
            window.addEventListener('resize', handleResize);
            handleResize(); 
        });
    </script>