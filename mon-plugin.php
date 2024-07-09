<?php
/*
 * Plugin Name:       Mon Plugin
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       WebScraping
 * Version:           0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            LucasMarteau, HectorMorlaix
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */

// Inclusion des Page du plugin
require_once plugin_dir_path(__FILE__) . 'includes/page/admin-page.php';
require_once plugin_dir_path(__FILE__) . 'includes/page/man.php';

// Inclusion des fonctions du plugin
require_once plugin_dir_path(__FILE__) . 'includes/fonction/search.php';
require_once plugin_dir_path(__FILE__) . 'includes/fonction/scraper.php';
require_once plugin_dir_path(__FILE__) . 'includes/fonction/publish-post.php';

require_once plugin_dir_path(__FILE__) . 'includes/templates/template.php';

// Inclusion des dépendances
require_once plugin_dir_path(__FILE__) . 'simple_html_dom.php';
?>
