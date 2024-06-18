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
                            <input type="text" name="form[name]" id="name" value="" class="inputbox" size="40">
                        </li>
                        <li>
                            <label>Status</label>
                            <select name="form[status]" class="">
                                <option value="default">- Select Status -</option>
                                <option value="1">Publish</option>
                                <option value="0">Unpublish</option>
                            </select>
                        </li>
                        <li>
                            <label>Group ACP</label>
                            <select name="form[group_acp]" class="">
                                <option value="default">- Select Group ACP -</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </li>
                        <li>
                            <label>Ordering<span class="star">&nbsp;*</span></label>
                            <input type="text" name="form[ordering]" id="ordering" value="" class="inputbox" size="40">
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
