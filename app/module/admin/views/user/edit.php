<?php
$arrStatus      = array("default" => "- Select Status -", "0" => "UnPublish", "1" => "Publish");
$statusSelect   = Helper::cmsSelectBox("form[status]", "inputbox", $arrStatus, $this->_arrParams['form']['status'] ?? $this->data['userById']['status'], true);

if (!empty([$this->data['listGroupName']])) {
    $arrGroup   = array_column($this->data['listGroupName'], "name", "id");
    $arrGroup['default']    = "- Select Group - ";
    krsort($arrGroup);

    $groupSelect    = Helper::cmsSelectBox("form[group_id]", "inputbox", $arrGroup, $this->_arrParams['form']['group_id'] ?? $this->data['userById']['group_id'], true);
}

// THÔNG BÁO LỖI
$strMessage = '';
if (!empty($this->errors)) {
    $strMessage .= '<dl id="system-message"  >
                        <dt class="error">Error</dt>
                        <dd class="error message">
                            <ul>';
    foreach ($this->errors as $key => $error) {
        $strMessage .= ' <li><b>' . ucfirst($key) . ':</b>  ' . $error . '</li>';
    }
    $strMessage .= '        </ul> 
                         </dd>
                    </dl>';
}

$messageSuccess = Session::getSession("message");
Session::deleteSession("message");
$strMessageSuccess  = '';
if (!empty($messageSuccess)) {

    $strMessageSuccess .= '<dl id="system-message">
                    <dt class="' . $messageSuccess['class'] . '">' . ucfirst($messageSuccess['class']) . '</dt>
                    <dd class="' . $messageSuccess['class'] . ' message">
                        <ul>
                            <li>' . $messageSuccess['content'] . '</li>
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

<?php include_once "submenu/index.php" ?>
<!-- THÔNG BÁO LỖI -->
<div id="system-message-container ">
    <?= $strMessage . $strMessageSuccess ?>
</div>
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
                            <input style="height: 30px" type="text" name="form[username]" id="name" value="<?= $this->_arrParams['form']['username'] ?? $this->data['userById']['username'] ?? "" ?>" class="inputbox" size="70">
                        </li>
                        <li>
                            <label>Email<span class="star">&nbsp;*</span></label>
                            <input style="height: 30px" type="text" name="form[email]" id="email" value="<?= $this->_arrParams['form']['email'] ?? $this->data['userById']['email'] ?? "" ?>" class="inputbox" size="70">
                        </li>
                        <li>
                            <label>Password<span class="star">&nbsp;*</span></label>
                            <input style="height: 30px" type="password" name="form[password]" id="password" value="<?= $this->_arrParams['password']['username'] ?? $this->data['userById']['password'] ?? "" ?>" class="inputbox" size="70">
                        </li>
                        <li>
                            <label>FullName<span class="star">&nbsp;*</span></label>
                            <input style="height: 30px" type="text" name="form[fullname]" id="fullname" value="<?= $this->_arrParams['form']['fullname'] ?? $this->data['userById']['fullname'] ?? "" ?>" class="inputbox" size="70">
                        </li>
                        <li>
                            <label>Status</label>
                            <?= $statusSelect ?>
                        </li>
                        <li>
                            <label>Group Name</label>
                            <?= $groupSelect ?>
                        </li>
                        <li>
                            <label>Ordering<span class="star">&nbsp;*</span></label>
                            <input style="height: 30px" type="text" name="form[ordering]" id="ordering" value="<?= $this->_arrParams['form']['ordering'] ?? $this->data['userById']['ordering'] ?? "" ?>" class="inputbox" size="70">
                        </li>
                    </ul>
                    <div class="clr"></div>
                    <div>
                        <input type="hidden" name="form[token]" value="1384158288">
                    </div>
                </fieldset>
            </div>
            <div class="clr"></div>
            <div>
            </div>
        </form>
        <div class="clr"></div>
    </div>
</div>