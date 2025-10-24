<?php

/*
  Social
  
  Copyright (C) 2023-2025 Chaziz

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

namespace Social\Pages;

global $twig, $database;

use Social\VersionNumber;
use BluffingoCore\CoreVersionNumber;

$database_version = $database->getServerVersion();

// instead of using "Database software", check if we're running on MariaDB or MySQL.
// OpenSB is intended to be used with either one of these.
if (str_contains(strtolower($database_version), "maria")) {
    $database_server = "MariaDB";
} else {
    $database_server = "MySQL";
}

$socialVersionNumber = new VersionNumber;

$data = [
    "developers" => [
        'Chaziz'
    ],
    "software" => [
        'sbVersion' => [
            'title' => "Social " . $socialVersionNumber->getVersionName(),
            'info' => $socialVersionNumber->getVersionString(),
        ],
        'coreVersion' => [
            'title' => "BluffingoCore",
            'info' => (new CoreVersionNumber)->getVersionString(),
        ],
        'phpVersion' => [
            'title' => "PHP",
            'info' => phpversion(),
        ],
        'dbVersion' => [
            'title' => $database_server,
            'info' => $database_version,
        ],
    ],
];

echo $twig->render('version.twig', [
    'data' => $data,
]);
