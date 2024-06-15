<?php
$linkControlPanel   = URL::createLink("admin", "control", "index");
$linkMyProFile      = URL::createLink("admin", "profile", "index");
$linkUserManage     = URL::createLink("admin", "user", "index");
$linkAddUser        = URL::createLink("admin", "user", "add");


$linkGroupManage     = URL::createLink("admin", "group", "index");
$linkAddGroup        = URL::createLink("admin", "group", "add");

$linkLogout          = URL::createLink("admin", "index", "logout")
?>
<div id="border-top" class="h_blue">
    <span class="title"><a href="index.php">Administration</a></span>
</div>


<div id="header-box">
    <div id="module-status">
        <span class="no-unread-messages"><a href="<?= $linkLogout ?>">Log out</a></span>
    </div>
    <div id="module-menu">
        <!-- MENU -->
        <ul id="menu">
            <li class="node"><a href="#">Site</a>
                <ul>
                    <li><a class="icon-16-cpanel" href="<?= $linkControlPanel ?>">Control Panel</a></li>
                    <li><a class="icon-16-profile" href="<?= $linkMyProFile  ?>">My Profile</a></li>
                </ul>
            </li>
        </ul>

        <ul id="menu">
            <li class="node"><a href="#">User</a>
                <ul>
                    <li>
                        <a class="icon-16-user" href="<?= $linkUserManage  ?>">User Manager</a>
                        <ul class="menu-com-users-users">
                            <li>
                                <a href="<?= $linkAddUser ?>" class="icon-16-newarticle">Add New User</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="icon-16-user" href="<?= $linkGroupManage ?>">Group</a>
                        <ul class="menu-com-users-users">
                            <li>
                                <a href="<?= $linkAddGroup ?>" class="icon-16-newarticle">Add New Group</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>


        </ul>
    </div>

    <div class="clr"></div>
</div>