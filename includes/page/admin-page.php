<?php

// Fonction pour ajouter une page d'administration dans le menu
function mon_plugin_add_admin_page() {
    add_menu_page(
        'Mon Plugin',                // Titre de la page
        'Mon Plugin',                // Texte du menu
        'manage_options',            // Capacité requise pour voir la page
        'mon-plugin-admin',          // Identifiant unique de la page
        'mon_plugin_admin_page_callback', // Fonction de rappel pour afficher la page
        'dashicons-admin-generic',   // Icône du menu
        85                           // Position dans le menu
    );
}
add_action('admin_menu', 'mon_plugin_add_admin_page');

// Fonction pour enqueuer les styles CSS de l'administration
function mon_plugin_admin_enqueue_styles($hook) {
    if ($hook != 'toplevel_page_mon-plugin-admin') {
        return;
    }
    wp_enqueue_style('mon-plugin-admin-styles', plugin_dir_url(__FILE__) . '../../assets/css/admin-style.css');
}
add_action('admin_enqueue_scripts', 'mon_plugin_admin_enqueue_styles');

// Fonction de callback pour afficher la page d'administration
function mon_plugin_admin_page_callback() {
    $search_results = '';
    $scraped_content = '';
    $publish_message = '';

    // Vérifier les permissions de l'utilisateur
    if (!current_user_can('manage_options')) {
        wp_die(__('Vous n\'avez pas les autorisations nécessaires pour accéder à cette page.'));
    }

    // Vérifier si le formulaire de recherche ou de scraping a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recherche d'articles
        if (isset($_POST['search_keyword'])) {
            $keyword = sanitize_text_field($_POST['search_keyword']);
            $date_filter = isset($_POST['date_filter']) ? sanitize_text_field($_POST['date_filter']) : '';
            $num_results = isset($_POST['num_results']) ? (int)$_POST['num_results'] : 10;
            if (!empty($keyword)) {
                $search_results = search_articles_by_keyword($keyword, $date_filter, $num_results);
            } else {
                $search_results = "Veuillez entrer un mot-clé valide.";
            }
        }

        // Scraping
        if (isset($_POST['scrape_url_submit'])) {
            $url = esc_url_raw($_POST['scrape_url']);
            if (!empty($url)) {
                $publish_message = mon_plugin_publish_scraped_content($url); // Appel de la fonction de publication
                $scraped_data = scrape_url_content($url);
                $scraped_content = $scraped_data['post_content'];
            } else {
                $scraped_content = "Veuillez entrer une URL valide.";
            }
        }
    }

    // Afficher les formulaires et les résultats
    echo '<div class="wrap">';
    echo '<h1>Mon Plugin</h1>';

    // Formulaire de recherche d'articles
    echo '<h2>Recherche d\'articles</h2>';
    echo '<form method="post">';
    echo '<label for="search_keyword">Entrez un mot-clé pour rechercher des articles :</label>';
    echo '<input type="text" id="search_keyword" name="search_keyword" value="' . esc_attr(isset($_POST['search_keyword']) ? $_POST['search_keyword'] : '') . '" required>';

    // Select pour filtre de date
    echo '<h3>Filtrer par date :</h3>';
    echo '<select name="date_filter">';
    echo '<option value="">Aucun filtre</option>';
    echo '<option value="d1">Dernière heure</option>';
    echo '<option value="d1d">Dernières 24 heures</option>';
    echo '<option value="w">Dernière semaine</option>';
    echo '<option value="m">Dernier mois</option>';
    echo '</select>';

    // Select pour nombre de résultats
    echo '<h3>Nombre de résultats à afficher :</h3>';
    echo '<select name="num_results">';
    echo '<option value="5">5</option>';
    echo '<option value="10">10</option>';
    echo '<option value="20">20</option>';
    echo '<option value="50">50</option>';
    echo '</select>';

    echo '<input type="submit" name="search" value="Rechercher">';
    echo '</form>';

    if (!empty($search_results)) {
        echo $search_results;
    }

    echo '<hr>';

    // Formulaire pour scraper une URL
    echo '<h2>Scraping de contenu</h2>';
    echo '<form method="post">';
    echo '<label for="scrape_url">Entrez une URL à scraper :</label>';
    echo '<input type="text" id="scrape_url" name="scrape_url" value="' . esc_attr(isset($_POST['scrape_url']) ? $_POST['scrape_url'] : '') . '" required>';
    echo '<input type="submit" name="scrape_url_submit" value="Scraper">';
    echo '</form>';

    // Affichage du contenu scrappé
    if (!empty($scraped_content)) {
        echo '<div style="border: 1px solid #ccc; padding: 10px; width: 100%; max-height: 500px; overflow-y: scroll;">';
        echo '<h3>Contenu scrappé depuis ' . esc_html($url) . ' :</h3>';
        echo $scraped_content;
        echo '</div>';
    }

    // Affichage du message de publication
    if (!empty($publish_message)) {
        echo '<div class="publish-message">';
        echo $publish_message;
        echo '</div>';
    }

    echo '</div>'; // Fin de la div wrap
}
?>
