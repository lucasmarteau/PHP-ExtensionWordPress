<?php

function mon_plugin_publish_scraped_content($url) {
    // Vérifier les capacités de l'utilisateur
    if (!current_user_can('publish_posts')) {
        return 'Permission refusée.';
    }

    // Scraper le contenu de l'URL
    $scraped_data = scrape_url_content($url);

    // Vérifier si le scraper a réussi à récupérer les données
    if (empty($scraped_data['post_title']) || empty($scraped_data['post_content'])) {
        return 'Erreur : Impossible de récupérer le contenu scrappé.';
    }

    // Créer un nouvel article WordPress avec le contenu scrappé
    $new_post = array(
        'post_title'    => wp_strip_all_tags($scraped_data['post_title']),
        'post_content'  => $scraped_data['post_content'],
        'post_status'   => 'draft',
        'post_author'   => get_current_user_id(),
    );

    // Insérer le post dans la base de données
    $post_id = wp_insert_post($new_post);

    // Vérifier les erreurs d'insertion
    if (is_wp_error($post_id)) {
        $error_message = $post_id->get_error_message();
        error_log("Erreur lors de l'insertion du post : " . $error_message);
        return 'Erreur lors de la publication de l\'article : ' . $error_message;
    } elseif ($post_id) {
        // Succès : retourner un message avec le lien vers le post publié
        return 'Le contenu scrappé a été publié avec succès en tant qu\'article. <a href="' . get_permalink($post_id) . '" target="_blank">Voir l\'article</a>';
    } else {
        // Autre erreur non spécifiée
        return 'Erreur : Impossible de publier le contenu scrappé.';
    }
}
?>
