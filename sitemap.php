<?php require './model/sitemap.php';
header('Content-type: application/xml; charset=utf-8');
$xml = '<xml version="1.0" encoding="utf-8">';
$xml .= '
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>https://lexiquejaponais.fr/</loc>
        <lastmod>20-01-2021</lastmod>
        <changefreq>never</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>https://lexiquejaponais.fr/accueil</loc>
        <lastmod>20-01-2021</lastmod>
        <changefreq>never</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>https://lexiquejaponais.fr/cours</loc>
        <lastmod>20-01-2021</lastmod>
        <changefreq>yearly</changefreq>
    </url>
    <url>
        <loc>https://lexiquejaponais.fr/nombres</loc>
        <lastmod>20-01-2021</lastmod>
        <changefreq>never</changefreq>
    </url>
    <url>
        <loc>https://lexiquejaponais.fr/kana</loc>
        <lastmod>20-01-2021</lastmod>
        <changefreq>never</changefreq>
    </url>
    <url>
        <loc>https://lexiquejaponais.fr/musique</loc>
        <changefreq>monthly</changefreq>
    </url>';

$words = getAllWords();
foreach ($words as $word) {
    $xml .= '
    <url>
        <loc>https://lexiquejaponais.fr/recherche/' . $word['slug'] . '</loc>
        <changefreq>yearly</changefreq>
    </url>';
}

$groups = getAllGroups();
foreach ($groups as $group) {
    $xml .= '
    <url>
        <loc>https://lexiquejaponais.fr/groupe/' . $group['slug'] . '</loc>
        <changefreq>yearly</changefreq>
    </url>';
}

$kanjis = getAllKanjis();
foreach ($kanjis as $kanji) {
    $xml .= '
    <url>
        <loc>https://lexiquejaponais.fr/kanji/' . $kanji['id'] . '</loc>
        <changefreq>never</changefreq>
    </url>';
}

$musics = getAllMusics();
foreach ($musics as $music) {
    $xml .= '
    <url>
        <loc>https://lexiquejaponais.fr/musique/' . $music['slug'] . '</loc>
        <changefreq>never</changefreq>
    </url>';
}

$xml .= '
</urlset>';
echo $xml;
