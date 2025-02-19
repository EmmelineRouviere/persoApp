<?php

$page= 'Accueil';
$_SESSION['page'] = $page ;

if (loadSidebar($_SESSION['page'])) {
  require_once 'inc/sidebar.php';
}
  
?>
    <header class="bg-gradient-to-r from-nutrition to-sport text-white">
        <div class="container mx-auto px-4 py-16 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">Votre Compagnon Santé et Fitness</h1>
            <p class="text-xl md:text-2xl mb-8">Nutrition équilibrée et entraînement personnalisé, tout en un</p>
            <a href="?ctrl=user&action=displayFormProfil" class="bg-white text-nutrition hover:bg-nutrition hover:text-white transition-colors duration-300 font-bold py-2 px-4 rounded-full text-lg">Commencer maintenant</a>
        </div>
    </header>

    <main class="container mx-auto px-4 py-16">
        <section class="mb-16">
            <h2 class="text-3xl font-bold text-center mb-8">Pourquoi choisir notre application ?</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <i class="fas fa-utensils text-4xl text-nutrition mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Suivi nutritionnel précis</h3>
                    <p>Enregistrez vos repas et obtenez des analyses détaillées de vos apports nutritionnels.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <i class="fas fa-dumbbell text-4xl text-sport mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Programmes d'entraînement personnalisés</h3>
                    <p>Des exercices adaptés à vos objectifs et à votre niveau de forme physique.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <i class="fas fa-chart-line text-4xl text-nutrition mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Suivi de vos progrès</h3>
                    <p>Visualisez vos avancées et restez motivé grâce à des graphiques et des statistiques détaillés.</p>
                </div>
            </div>
        </section>

        <section class="mb-16">
            <div class="bg-white p-8 rounded-lg shadow-md">
                <h2 class="text-3xl font-bold mb-4">Comment ça marche ?</h2>
                <ol class="list-decimal list-inside space-y-4">
                    <li class="text-lg"><span class="font-semibold">Inscrivez-vous</span> et renseignez vos informations personnelles</li>
                    <li class="text-lg"><span class="font-semibold">Définissez vos objectifs</span> de santé et de forme physique</li>
                    <li class="text-lg"><span class="font-semibold">Suivez votre alimentation</span> en enregistrant vos repas quotidiens</li>
                    <li class="text-lg"><span class="font-semibold">Réalisez les exercices</span> recommandés dans votre programme personnalisé</li>
                    <li class="text-lg"><span class="font-semibold">Suivez vos progrès</span> et ajustez vos objectifs au fil du temps</li>
                </ol>
            </div>
        </section>

        <section class="text-center">
            <h2 class="text-3xl font-bold mb-4">Prêt à transformer votre vie ?</h2>
            <p class="text-xl mb-8">Rejoignez des milliers d'utilisateurs satisfaits et commencez votre voyage vers une meilleure santé dès aujourd'hui.</p>
            <a href="index.php?ctrl=user&action=displayFormProfil" class="bg-gradient-to-r from-nutrition to-sport text-white hover:from-nutrition/80 hover:to-sport/80 transition-colors duration-300 font-bold py-3 px-6 rounded-full text-lg">S'inscrire gratuitement</a>
        </section>
    </main>
