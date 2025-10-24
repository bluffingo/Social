<?php

/*
  Social

  Copyright (C) 2025 Chaziz

  Social is free software: you can redistribute it and/or modify it under the 
  terms of the GNU Affero General Public License as published by the Free 
  Software Foundation, either version 3 of the License, or (at your option) any
  later version. 

  Social is distributed in the hope that it will be useful, but WITHOUT ANY 
  WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
  FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more 
  details.

  You should have received a copy of the GNU Affero General Public License
  along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/

namespace Social;

global $twig, $database;

/*
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
*/

$posts = $database->fetchArray($database->query("SELECT j.* FROM journals j ORDER BY j.timestamp DESC LIMIT 10"));

$data = [
    'posts' => $posts,
];

echo $twig->render('index.twig', [
    'data' => $data,
]);
