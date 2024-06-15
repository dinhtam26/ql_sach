<?php
$linkControlPanel   = URL::createLink("admin", "control", "index");
$linkMyProFile      = URL::createLink("admin", "index", "profile");
$linkUserManage     = URL::createLink("admin", "user", "index");
$linkAddUser        = URL::createLink("admin", "user", "add");
$linkAdmin          = URL::createLink("admin", "index", "index");
$linkGroupManage    = URL::createLink("admin", "group", "index");
$linkAddGroup       = URL::createLink("admin", "group", "add");
$linkLogout         = URL::createLink("admin", "index", "logout");
$linkView           = URL::createLink("default", "index", "index");
?>
<div id="border-top" class="h_blue">
    <span class="title"><a href="<?= $linkAdmin ?>">Administration</a></span>
</div>


<div id="header-box">
    <div id="module-status">
        <span class="viewsite"><a href="<?= $linkView ?>">View Site</a></span>
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