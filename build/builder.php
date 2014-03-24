<?php
$params = new stdClass();
$params->revealPath = '../lib/reveal';
$params->file = '../data/themes.csv';

function getThemes($file)
{
    $themes = $labels = array();
    $counter = 1;
    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($counter == 1) {
                foreach ($row as $column => $value)
                    $labels[$column] = slugify($value);
            } else {
                $theme = array();
                foreach ($row as $column => $value)
                    $theme[$labels[$column]] = $value;
                $themes[] = $theme;
            }

            $counter++;
        }
        fclose($handle);
    }
    return $themes;
}

function slugify($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\\pL\d]+~u', '_', $text);

    // trim
    $text = trim($text, '_');

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // lowercase
    $text = strtolower($text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}
?><!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Wordpress themes - A simple showcase</title>

    <meta name="description" content="Wordpress themes - A simple showcase using reveal.js">

    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="stylesheet" href="<?php echo $params->revealPath; ?>/css/reveal.min.css">
    <link rel="stylesheet" href="<?php echo $params->revealPath; ?>/css/theme/night.css" id="theme">

    <!-- If the query includes 'print-pdf', use the PDF print sheet -->
    <script>
        document.write('<link rel="stylesheet" href="<?php echo $params->revealPath; ?>/css/print/' + ( window.location.search.match(/print-pdf/gi) ? 'pdf' : 'paper' ) + '.css" type="text/css" media="print">');
    </script>

    <!--[if lt IE 9]>
    <script src="<?php echo $params->revealPath; ?>/lib/js/html5shiv.js"></script>
    <![endif]-->
</head>

<body>

<div class="reveal">

    <!-- Any section element inside of this container is displayed as a slide -->
    <div class="slides">

        <section> <!-- titlecard -->
            <h1 style="line-height:1em;">Wordpress themes</h1>

            <h2 style="font-style:italic">Showcase</h2>
        </section>
        <!--<section>
            <h1>Overview</h1>
            <ul>
                <li class="fragment">What it is dependency management &amp; how it can help you</li>
                <li class="fragment">How to discover and use packages</li>
                <li class="fragment">How to write (and publish!) your own packages</li>
            </ul>
            <aside class="notes">
                <ul>
                    <li>Talking about dependency management in PHP: Important topic, dear to me, <b>move the community forward</b></li>
                    <li>time allowing: What came before (PEAR), &amp; travis</li>
                </ul>
            </aside>
        </section>-->

        <?php foreach (getThemes($params->file) as $counter => $theme): ?>

            <?php //var_dump($theme); ?>
            <section> <!-- Theme <?php echo $counter ?> -->
                <section> <!-- Intro -->
                    <h1><?php echo $theme['name'] . ' #' . $counter; ?></h1>
                    <img src="<?php echo $theme['image_url']; ?>">
<!--                </section>-->
<!--                <section>-->
                    <h2><a target="_blank" href="<?php echo $theme['seller']; ?>"><?php echo $theme['seller']; ?></a>
                    </h2>
                    <ul>
                        <li><a target="_blank" href="<?php echo $theme['demo_url']; ?>">Live demo</a></li>
                        <li><a target="_blank" href="<?php echo $theme['description_url']; ?>">Description</a></li>
                        <li><a target="_blank" href="<?php echo $theme['download_url']; ?>">Download</a></li>
                        <li>Creator <?php echo $theme['creator']; ?></li>
                        <li>Added: <?php echo $theme['date']; ?></li>
                    </ul>
                </section>
            </section>
        <?php endforeach; ?>
    </div>
    <!-- .slides -->
</div>

<script src="<?php echo $params->revealPath; ?>/lib/js/head.min.js"></script>
<script src="<?php echo $params->revealPath; ?>/js/reveal.min.js"></script>

<script>
    // Full list of configuration options available here:
    // https://github.com/hakimel/reveal.js#configuration
    Reveal.initialize({
        controls: true,
        progress: true,
        history: true,
        center: true,

        // Optional libraries used to extend on reveal.js
        dependencies: [
            { src: '<?php echo $params->revealPath; ?>/lib/js/classList.js', condition: function () {
                return !document.body.classList;
            } },
            { src: '<?php echo $params->revealPath; ?>/plugin/markdown/marked.js', condition: function () {
                return !!document.querySelector('[data-markdown]');
            } },
            { src: '<?php echo $params->revealPath; ?>/plugin/markdown/markdown.js', condition: function () {
                return !!document.querySelector('[data-markdown]');
            } },
            { src: '<?php echo $params->revealPath; ?>/plugin/highlight/highlight.js', async: true, callback: function () {
                hljs.initHighlightingOnLoad();
            } },
            { src: '<?php echo $params->revealPath; ?>/plugin/zoom-js/zoom.js', async: true, condition: function () {
                return !!document.body.classList;
            } },
            { src: '<?php echo $params->revealPath; ?>/plugin/notes/notes.js', async: true, condition: function () {
                return !!document.body.classList;
            } }
            // { src: 'plugin/search/search.js', async: true, condition: function() { return !!document.body.classList; } }
            // { src: 'plugin/remotes/remotes.js', async: true, condition: function() { return !!document.body.classList; } }
        ]
    });

</script>

</body>
</html>
