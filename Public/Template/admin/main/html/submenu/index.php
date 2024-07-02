<?php
$linkGroup      = URL::createLink("admin", "group", "index");
$linkUser       = URL::createLink("admin", "user", "index");
$linkCategory   = URL::createLink("admin", "category", "index");
$linkBook       = URL::createLink("admin", "book", "index");

?>
<div id="submenu-box">
    <div class="m">
        <ul id="submenu">
            <li><a class="group" href="<?= $linkGroup ?>">Group</a></li>
            <li><a class="user" href="<?= $linkUser ?>">User</a></li>
            <li><a class="category" href="<?= $linkCategory ?>">Category</a></li>
            <li><a class="book" href="<?= $linkBook ?>">Book</a></li>

        </ul>
        <div class="clr"></div>
    </div>
</div>