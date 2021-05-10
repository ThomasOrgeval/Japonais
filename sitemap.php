<?php require './model/sitemap.php';
header('Content-type: application/xml; charset=utf-8');
$xml = '<?xml version="1.0" encoding="utf-8"?>';
$xml .= '
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    ';

$list = [
    ['callable' => "getAllWords", 'prefix' => "https://lexiquejaponais.fr/recherche/", 'item' => "slug", 'freq' => "yearly"],
    ['callable' => "getAllGroups", 'prefix' => "https://lexiquejaponais.fr/groupe/", 'item' => "slug", 'freq' => "yearly"],
    ['callable' => "getAllKanjis", 'prefix' => "https://lexiquejaponais.fr/kanji/", 'item' => "id", 'freq' => "never"],
    ['callable' => "getAllMusics", 'prefix' => "https://lexiquejaponais.fr/musique/", 'item' => "slug", 'freq' => "never"]
];

foreach ($list as $item) {
    $words = call_user_func($item['callable']);
    foreach ($words as $word) {
        $xml .= '
    <url>
        <loc>' . $item['prefix'] . $word[$item['item']] . '</loc>
        <changefreq>' . $item['freq'] . '</changefreq>
    </url>';
    }
}

$xml .= '    <url>
        <loc>https://lexiquejaponais.fr/cours</loc>
        <lastmod>2021-01-20</lastmod>
        <changefreq>yearly</changefreq>
    </url>
    <url>
        <loc>https://lexiquejaponais.fr/nombres</loc>
        <lastmod>2021-01-20</lastmod>
        <changefreq>never</changefreq>
    </url>
    <url>
        <loc>https://lexiquejaponais.fr/kana</loc>
        <lastmod>2021-01-20</lastmod>
        <changefreq>never</changefreq>
    </url>
    <url>
        <loc>https://lexiquejaponais.fr/musique</loc>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>https://lexiquejaponais.fr/</loc>
        <lastmod>2021-01-20</lastmod>
        <changefreq>never</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>https://lexiquejaponais.fr/accueil</loc>
        <lastmod>2021-01-20</lastmod>
        <changefreq>never</changefreq>
        <priority>1.0</priority>
    </url>
</urlset>';
echo $xml;