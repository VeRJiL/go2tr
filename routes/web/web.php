<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $dom = new DomDocument();
    $dom->loadHTMLFile(public_path('html.html'));

    $contents = $dom->getElementsByTagName('img');

    foreach ($contents as $content) {
        $content->setAttribute('height', 400);
        $content->setAttribute('width', 600);
    }

    $html = $dom->saveHTML();

    $newDom = new DOMDocument();
    $newDom->loadHTML($html);

    $newContents = $dom->getElementsByTagName('img');

    $array = [];
    foreach ($newContents as $newContent) {
        $array['height'] = $newContent->getAttribute('height');
        $array['width'] = $newContent->getAttribute('width');
        $array['title'] = $newContent->getAttribute('title');
        $array['alt'] = $newContent->getAttribute('alt');
    }

    dd($array);
});
