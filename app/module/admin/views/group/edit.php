<?php
$arrStatus  =   array("default" => "- Select Status -", "0" => "Unpublish", "1" => "Publish");
$status     =   Helper::cmsSelectBox("form[status]", "", $arrStatus, $this->data['status']);

$arrGroup_acp  =   array("default" => "- Select Status -", "0" => "No", "1" => "Yes");
$group_acp     =   Helper::cmsSelectBox("form[group_acp]", "", $arrGroup_acp, $this->data['group_acp']);
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
<div id="system-message-container">

</div>
<!-- Content FORM -->
<div id="element-box">
    <div class="m">
        <form action="#" method="post" name="adminForm" id="adminForm" class="form-validate">
            <!-- FORM LEFT -->
            <div class="width-100 fltlft">
                <fieldset class="adminform">
                    <legend>Details</legend>
                    <ul class="adminformlist">
                        <li>
                            <label>Name<span class="star">&nbsp;*</span></label>
                            <input type="text" name="form[name]" id="name" value="<?= $this->data['name'] ?>" class="inputbox" size="40">
                        </li>
                        <li>
                            <label>Status</label>
                            <?php echo $status  ?>
                        </li>
                        <li>
                            <label>Group ACP</label>
                            <?= $group_acp ?>
                        </li>
                        <li>
                            <label>Ordering<span class="star">&nbsp;*</span></label>
                            <input type="text" name="form[ordering]" id="ordering" value="<?= $this->data['ordering'] ?>" class="inputbox" size="40">
                        </li>

                        <li>
                            <label>ID</label>
                            <input type="text" name="form[id]" id="id" value="<?= $this->data['id'] ?>" readonly class="inputbox" size="40">
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
<!-- End Content FORM-->

<?php
