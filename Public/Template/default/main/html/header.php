<?php
$linkHome       = URL::createLink("default", "index", "index");
$linkCategory   = URL::createLink("default", "category", "index");
$linkMyAccount  = URL::createLink("default", "user", "index");
$linkRegister   = URL::createLink("default", "index", "register");
$linkLogin      = URL::createLink("default", "index", "login");
$linkLogout      = URL::createLink("default", "index", "logout");
$linkAdmin      = URL::createLink("admin", "index", "index");

$userInfo = Session::getSession("user");



?><div class="header">
    <div class="logo"><a href="index.html"><img src="<?= $images ?>/logo.gif" alt="" title="" border="0"></a></div>
    <div id="menu">
        <?php if (!empty($userInfo)) {  ?>

            <ul>
                <li class="index-index "><a href="<?= $linkHome ?>">home</a></li>
                <li class="category-index "><a href="<?= $linkCategory ?>">category</a></li>
                <li class="index-logout "><a href="<?= $linkLogout ?>">Book Product</a></li>
                <li class="user-index "><a href="<?= $linkMyAccount ?>">My account</a></li>
                <li class="index-logout "><a href="<?= $linkLogout ?>">Logout</a></li>
                <?php if ($userInfo['group_acp'] == 1) { ?>
                    <li class="index-logout "><a href="<?= $linkAdmin ?>">Admin</a></li>
                <?php    } ?>
            </ul>



        <?php  } else { ?>
            <ul>
                <li class="index-index "><a href="<?= $linkHome ?>">home</a></li>
                <li class="category-index "><a href="<?= $linkCategory ?>">category</a></li>
                <li class="index-logout "><a href="<?= $linkLogout ?>">Book Product</a></li>

                <li class="index-register "><a href="<?= $linkRegister ?>">Register</a></li>
                <li class="index-login "><a href="<?= $linkLogin ?>">Login </a></li>

            </ul>
        <?php  } ?>
    </div>
</div>