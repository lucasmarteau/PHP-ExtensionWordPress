<?php
function get_scraped_content_template($content) {
    ob_start();
    ?>
    <div class="scraped-content">
        <div class="scraped-body">
            <?php echo wpautop(wp_kses_post($content)); ?>
        </div>
    </div>
    <style>
        .scraped-content {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px auto;
            max-width: 800px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            padding: 20px;
            overflow: hidden;
        }
        .scraped-body {
            margin-top: 20px;
        }
        .scraped-body p {
            margin: 15px 0;
            font-size: 16px;
            line-height: 1.8;
        }
        .scraped-body ul, .scraped-body ol {
            margin: 15px 0 15px 30px;
            padding-left: 10px;
        }
        .scraped-body li {
            margin-bottom: 8px;
        }
        .scraped-body img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 15px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
    <?php
    return ob_get_clean();
}
?>
