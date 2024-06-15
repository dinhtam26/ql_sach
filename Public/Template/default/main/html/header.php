<?php
$linkHome       = URL::createLink("default", "index", "index");
$linkCategory   = URL::createLink("default", "category", "index");
$linkMyAccount  = URL::createLink("default", "user", "index");
$linkRegister   = URL::createLink("default", "user", "register");
$linkLogin      = URL::createLink("default", "user", "login");





?><div class="header">
    <div class="logo"><a href="index.html"><img src="<?= $images ?>/logo.gif" alt="" title="" border="0"></a></div>
    <div id="menu">
        <ul>
            <li class="index-index "><a href="<?= $linkHome ?>">home</a></li>
            <li class="category-index "><a href="<?= $linkCategory ?>">category</a></li>
            <li class="user-index "><a href="<?= $linkMyAccount ?>">My account</a></li>
            <li class="user-register "><a href="<?= $linkRegister ?>">Register</a></li>
            <li class="user-login "><a href="<?= $linkLogin ?>">Login</a></li>
        </ul>
    </div>
</div>