<div class = "flex">
<nav id="sidebar" class="bg-white w-64 min-h-screen flex flex-col transition-all duration-300" style="box-shadow: 4px 0 10px -2px rgba(76, 175, 80, 0.3);">
        <div class="p-4 border-b">
            <h1 class="text-2xl font-bold text-center bg-gradient-to-r from-nutrition to-sport text-transparent bg-clip-text">Mon App</h1>
        </div>
        <div class="flex-grow overflow-y-auto">
            <div class="p-4 border-b">
                <a href="?ctrl=user&action=profile" class="flex items-center mb-4">
                    <img src="https://via.placeholder.com/40" alt="Profile" class="rounded-full mr-2">
                    
                    <span class="font-medium">Jane Doe</span>
                </a>
                <a href="?ctrl=user&action=logout" class="text-red-500 hover:text-red-700">Se déconnecter</a>
            </div>
            <ul class="p-4">
                <li class="mb-4">
                    <h2 class="text-lg font-semibold mb-2 text-nutrition">Nutrition</h2>
                    <ul class="space-y-2">
                        <li><a href="index.php?ctrl=meal&action=mealOftheDay" class="block p-2 rounded <?= $page="day" ? 'hover:bg-nutrition hover:text-white' : 'bg-nutrition text-white'?> transition-colors" data-page="informationMeal">Votre journée</a></li>
                        <li><a href="index.php?ctrl=food&action=index" class="block p-2 rounded <?= $page="foods" ? 'hover:bg-nutrition hover:text-white' : 'bg-nutrition text-white' ?> transition-colors" data-page="aliments">Les aliments</a></li>
                        <li><a href="index.php?ctrl=meal&action=index" class="block p-2 rounded <?= $page="meals" ? 'hover:bg-nutrition hover:text-white' : 'bg-nutrition text-white' ?> transition-colors" data-page="meals">Vos repas</a></li>
                        <li><a href="index.php?ctrl=meal&action=history" class="block p-2 rounded <?= $page="historic" ? 'hover:bg-nutrition hover:text-white' : 'bg-nutrition text-white' ?> transition-colors" data-page="historicalmeals">Historique</a></li>
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
            </ul>
        </div>
    </nav>