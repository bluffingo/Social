<?php

namespace Social;

include("../private/common.php");

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
?>
<link rel="stylesheet" href="/trinium-default.css">
<div class="page">
    <div class="page-contents">
        <div class="container">
            <h1>Social</h1>
            <h2>Post message (not functional for now)</h2>
            <div class="content-box">
                <form action="/" method="post">
                    <div class="form-input">
                        <textarea class="form-submit" id=" post-content" name="content" rows="4" cols="50" maxlength="280" required></textarea>
                    </div>
                    <div class="form-button-container">
                        <button type="submit" class="button button-primary">Post</button>
                        <button type="reset" class="button button-secondary">Clear</button>
                    </div>
                </form>
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