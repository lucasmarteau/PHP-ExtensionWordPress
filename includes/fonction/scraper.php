<?php
// Fonction pour scraper le contenu d'une URL et retourner les données nécessaires
function scrape_url_content($url) {
    $data = array(
        'post_title' => '',
        'post_content' => ''
    );

    // Vérification de l'URL non vide
    if (!empty($url)) {
        // Charger le contenu de l'URL avec Simple HTML DOM Parser
        $html = file_get_html($url);

        if ($html) {
            // Extraire le titre de la page
            $title_element = $html->find('title', 0);
            if ($title_element) {
                $data['post_title'] = trim($title_element->plaintext);
            }

            // Extraire le contenu principal (paragraphe, listes, etc.)
            $content = '';

            // Trouver les éléments de contenu souhaités
            $content_elements = $html->find('article, .entry-content, main');

            if (!empty($content_elements)) {
                foreach ($content_elements as $element) {
                    $content .= $element->innertext; // Utiliser innertext pour conserver les balises HTML
                }
            } else {
                // Si aucun élément spécifique trouvé, récupérer tous les paragraphes et listes
                foreach ($html->find('p, ul, ol') as $element) {
                    if ($element->tag == 'p') {
                        $content .= '<p>' . $element->plaintext . '</p>';
                    } elseif ($element->tag == 'ul' || $element->tag == 'ol') {
                        $content .= '<' . $element->tag . '>';
                        foreach ($element->find('li') as $li) {
                            $content .= '<li>' . $li->plaintext . '</li>';
                        }
                        $content .= '</' . $element->tag . '>';
                    }
                }
            }

            // Assigner le contenu extrait
            $data['post_content'] = $content;

            // Libérer la mémoire utilisée par Simple HTML DOM Parser
            $html->clear();
            unset($html);
        } else {
            $data['post_content'] = "Erreur : Impossible de charger le contenu de l'URL.";
        }
    } else {
        $data['post_content'] = "Veuillez entrer une URL valide.";
    }

    return $data;
}
?>
