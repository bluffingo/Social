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

global $twig;

$username = ($_GET['name'] ?? null);

use Social\UserData;

$data = [
    "id" => 1337,
    "username" => $username,
    "title" => "Social User !",
    "customcolor" => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
    "about" => "Lorem ipsum whatever the fuck",
    "birthdate" => "2007-01-15",
    "joined" => 1337420690,
    "lastseen" => time(),
];


$posts = [
    1 => [
        "id" => 4206969,
        "author" => 1337,
        "contents" => "Hello, world!",
        "timestamp" => time(),
    ],
];

function formatValue($key, $value)
{
    if (in_array($key, ['joined', 'lastseen'])) {
        return date('Y-m-d H:i:s', $value);
    }
    return $value;
}
?>
<link rel="stylesheet" href="/trinium-default.css">
<div class="page">
    <div class="page-contents">
        <div class="container">
            <h1>Social</h1>
            <h2><?php echo $data["title"]; ?></h2>
            <div class="content-box">
                <?php foreach ($data as $key => $value): ?>
                    <li>
                        <span class="data-key"><?= htmlspecialchars($key) ?>:</span>
                        <span class="data-value"><?= htmlspecialchars(formatValue($key, $value)) ?></span>
                    </li>
                <?php endforeach; ?>
            </div>
            <hr>
            <h2>Posts</h2>
            <div class="content-box">
                <?php foreach ($posts as $post): ?>
                    <?php $user = new UserData($post['author'])->getUserArray(); ?>
                    <div class="comment">
                        <a href="/user.php?name=<?php echo $user["username"]; ?>">
                            <div class="profile-picture">
                                <img src="pfp.png" class="pfp" alt="<?php echo $user["username"]; ?>">
                            </div>
                        </a>
                        <div class="comment-body">
                            <div class="comment-author">
                                <div class="comment-author">
                                    <div class="userlink">
                                        <a style="color:<?php echo $user["color"]; ?>;" href="/user.php?name=<?php echo $user["username"]; ?>"><?php echo $user["username"]; ?></a>
                                    </div>
                                    <span class="comment-timestamp"><?php echo date('Y-m-d H:i:s', $post['timestamp']); ?></span>
                                </div>
                            </div>
                            <div class="comment-contents">
                                <?php echo htmlspecialchars($post['contents']); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>