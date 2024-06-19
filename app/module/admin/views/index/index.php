<?php
$images             = TEMPLATE_URL . "admin/main/images";
$linkNewBook        = URL::createLink("admin", "book", "add");
$linkBookManage     = URL::createLink("admin", "book", "index");
$linkCateManage     = URL::createLink("admin", "category", "index");
$linkGroupManage    = URL::createLink("admin", "group", "index");
$linkUserManage     = URL::createLink("admin", "user", "index");

// MESSAGE PERMISSION
$messagePer = Session::getSession("permission");
Session::deleteSession("permission");
$strMess  = '';
if (!empty($messagePer)) {

    $strMess .= '<dl id="system-message">
                    <dt class="error">Error</dt>
                    <dd class="error message">
                        <ul>
                            <li>' . $messagePer . '</li>
                        </ul>
                    </dd>
                </dl>';
}
?>
<div id="content-box">
    <div id="system-message-container">
        <?= $strMess ?>
    </div>
    <div id="element-box">
        <div id="system-message-container"></div>
        <div class="m">
            <div class="adminform">
                <div class="cpanel-left">
                    <div class="cpanel">
                        <div class="icon-wrapper">
                            <div class="icon">
                                <a href="<?= $linkNewBook ?>">
                                    <img src="<?= $images ?>/header/icon-48-article-add.png" alt="">
                                    <span>Add New Book</span>
                                </a>
                            </div>
                        </div>
                        <div class="icon-wrapper">
                            <div class="icon">
                                <a href="<?= $linkBookManage ?>">
                                    <img src="<?= $images ?>/header/icon-48-article.png" alt="">
                                    <span>Book Manager</span>
                                </a>
                            </div>
                        </div>
                        <div class="icon-wrapper">
                            <div class="icon">
                                <a href="<?= $linkCateManage ?>">
                                    <img src="<?= $images ?>/header/icon-48-category.png" alt="">
                                    <span>Category Manager</span>
                                </a>
                            </div>
                        </div>
                        <div class="icon-wrapper">
                            <div class="icon">
                                <a href="<?= $linkGroupManage ?>">
                                    <img src="<?= $images ?>/header/icon-48-menumgr.png" alt="">
                                    <span>Group Manager</span>
                                </a>
                            </div>
                        </div>
                        <div class="icon-wrapper">
                            <div class="icon">
                                <a href="<?= $linkUserManage ?>">
                                    <img src="<?= $images ?>/header/icon-48-user.png" alt="">
                                    <span>User Manager</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="clr"></div>
        </div>
    </div>
</div>