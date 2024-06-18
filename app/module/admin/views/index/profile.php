<?php
// MESSAGE ERROR OR SUCCESS
$message = Session::getSession("message");
Session::deleteSession("message");
$strMess  = '';
if (!empty($message)) {

    $strMess .= '<dl id="system-message">
                    <dt class="' . $message['class'] . '">' . ucfirst($message['class']) . '</dt>
                    <dd class="' . $message['class'] . ' message">
                        <ul>
                            <li>' . $message['content'] . '</li>
                        </ul>
                    </dd>
                </dl>';
}
?>
<div id="toolbar-box">
    <div class="m">
        <!-- TOOLBAR -->
        <?php include_once "toolbar/index.php" ?>
        <!-- TITLE -->
        <div class="pagetitle icon-48-groups">
            <h2><?= $this->_title ?></h2>
        </div>
    </div>
</div>

<div id="system-message-container">
    <?= $strMess ?>
</div>
<!-- CONTENT ADD -->
<div id="element-box">
    <div class="m">
        <form action="#" method="post" name="adminForm" id="adminForm" class="form-validate">
            <!-- FORM LEFT -->
            <div class="width-100 fltlft">
                <fieldset class="adminform">
                    <legend>Details</legend>
                    <ul class="adminformlist">
                        <li>
                            <label>Username<span class="star">&nbsp;*</span></label>
                            <input style="height: 30px" type="text" name="form[username]" id="name" value="<?= $this->data['user']['username'] ?? $this->userInfo['username'] ?>" class="inputbox" size="70">
                        </li>
                        <li>
                            <label>Email<span class="star">&nbsp;*</span></label>
                            <input style="height: 30px" type="text" name="form[email]" id="email" value="<?= $this->data['user']['email'] ?? $this->userInfo['email'] ?>" class="inputbox" size="70">
                        </li>
                        <li>
                            <label>FullName<span class="star">&nbsp;*</span></label>
                            <input style="height: 30px" type="text" name="form[fullname]" id="fullname" value="<?= $this->data['user']['fullname'] ?? $this->userInfo['fullname'] ?>" class="inputbox" size="70">
                        </li>
                        <li>
                            <label>ID<span class="star">&nbsp;*</span></label>
                            <input disabled style="height: 30px" type="text" name="form[fullname]" id="fullname" value="<?= $this->userInfo['id'] ?>" class="inputbox" size="70">
                        </li>
                    </ul>
                    <div class="clr"></div>

                </fieldset>
            </div>
            <div class="clr"></div>
            <div>
            </div>
        </form>
        <div class="clr"></div>
    </div>
</div>