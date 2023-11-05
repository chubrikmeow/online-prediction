<?php

use app\models\User;

/** 
 * @var User $users 
 */

?>

<div id="members-list">
    <div class="members-block white-block shadow-block">
        <h2>Top-10</h2>
        <ol>
            <?php foreach ($users as $user) { ?>
                <li><?php if ($user->avatar_id) { ?>
                    <img src="<?= $user->avatar->getUrl() ?>" alt="avatar">
                <?php } else { ?>
                    <img src="/img/no-avatar.jpg" alt="no avatar">
                <?php } ?> <strong><?= $user->username ?></strong> - <strong><?= $user->points ?></strong></li>
            <?php } ?>
        </ol>      
    </div>
</div>
