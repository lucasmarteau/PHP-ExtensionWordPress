<?php
/*
 * Plugin Name: Manuel d'utilisation de Mon Plugin
 * Description: Page de manuel d'utilisation pour le plugin Mon Plugin.
 * Version: 1.0
 * Author: Votre Nom
 * Text Domain: manuel-utilisation-plugin
 */

// Fonction pour afficher le contenu de la page de manuel
function mon_plugin_manuel_utilisation_page() {
    ?>
    <div class="wrap">
        <h1>Manuel d'utilisation de Mon Plugin</h1>

        <h2>Introduction</h2>
        <p>Bienvenue dans le manuel d'utilisation de Mon Plugin. Ce plugin vous permet de...</p>

        <h2>Installation</h2>
        <p>Pour installer Mon Plugin, suivez les étapes suivantes :</p>
        <ol>
            <li>Téléchargez le fichier ZIP du plugin depuis votre compte.</li>
            <li>Accédez à l'administration de WordPress.</li>
            <li>Allez dans la section Plugins > Ajouter nouveau.</li>
            <li>Cliquez sur "Téléverser un plugin" et sélectionnez le fichier ZIP.</li>
            <li>Activez le plugin une fois l'installation terminée.</li>
        </ol>

        <h2>Configuration</h2>
        <p>Pour configurer Mon Plugin, suivez ces instructions :</p>
        <ol>
            <li>Allez dans la section Mon Plugin dans le menu d'administration.</li>
            <li>Configurez les options selon vos besoins.</li>
            <li>Scraper.</li>
        </ol>

        <h2>Fonctionnalités</h2>
        <p>Mon Plugin offre les fonctionnalités suivantes :</p>
        <ul>
            <li><strong>WebScraping :</strong> Permet de récupérer du contenu à partir d'URLs.</li>
            <li><strong>Publication Automatique :</strong> Publie le contenu scrappé sous forme d'articles.</li>
            <li><strong>Configuration Avancée :</strong> Options pour personnaliser le comportement du plugin.</li>
        </ul>

        <h2>Support</h2>
        <p>Pour toute assistance supplémentaire, veuillez me contacter à lucasmarteau.2004@gmail.om.</p>
    </div>
    <?php
}

// Fonction pour ajouter une page de manuel dans le menu d'administration
function mon_plugin_add_manuel_page() {
    add_menu_page(
        'Manuel d\'utilisation de Mon Plugin', // Titre de la page
        'Manuel d\'utilisation',              // Texte du menu
        'manage_options',                     // Capacité requise pour voir la page
        'mon-plugin-manuel',                  // Slug de la page
        'mon_plugin_manuel_utilisation_page', // Fonction de rappel pour afficher la page
        'dashicons-book-alt',                 // Icône du menu
        85                                    // Position dans le menu
    );
}
add_action('admin_menu', 'mon_plugin_add_manuel_page');
?>
