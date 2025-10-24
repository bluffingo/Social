<?php

namespace Social;

include("../private/common.php");

use BluffingoCore\CoreVersionNumber;
use Social\VersionNumber;
use Social\UserData;

$posts = [
    1 => [
        "id" => 1,
        "author" => 1,
        "contents" => "Hello, world!",
        "timestamp" => 1337420690,
    ],
    2 => [
        "id" => 1,
        "author" => 59,
        "contents" => "Check this out Y'all... IMG_3895.jpeg",
        "timestamp" => 1666420690,
    ],
    3 => [
        "id" => 3,
        "author" => 2,
        "contents" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
        Nulla nec lorem eget mi commodo laoreet et eget risus. Donec sit amet placerat lectus. 
        Nam cursus maximus nisi, vel fringilla lorem blandit id. Cras sit amet felis sit amet mi 
        scelerisque iaculis. Sed metus turpis placerat.",
        "timestamp" => time(),
    ],
];

$data = [
    'posts' => $posts,
];

echo $twig->render('index.twig', [
    'data' => $data,
]);
