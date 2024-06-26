<?php
if (!empty($this->error)) {
    $error = '';

?>
    <div id="system-message-container ">
        <dl id="system-message" class="hidden" style="display: none;">
            <dt class="error">Error</dt>
            <dd class="error message">
                <ul>
                    <?php
                    foreach ($this->error as $key => $value) {
                        $error .= '<li><b>' . $key . ':</b> ' . $value . '</li>';
                    }
                    echo $error;
                    ?>
                </ul>
            </dd>
        </dl>
    </div>
<?php
}

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

$arrStatus      = array("default" => "- Select Status -", "0" => "UnPublish", "1" => "Publish");
$statusSelect   = Helper::cmsSelectBox("form[status]", "inputbox", $arrStatus, $this->data['category']['status'] ?? "", true);
?>
<div id="system-message-container">
    <?= $strMess ?>
</div>
<div id="element-box">
    <div class="m">
        <form action="#" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
            <!-- FORM LEFT -->
            <div class="width-100 fltlft">
                <fieldset class="adminform">
                    <legend>Edit Category</legend>
                    <ul class="adminformlist">
                        <li>
                            <label>Name<span class="star">&nbsp;*</span></label>
                            <input style="height: 30px" type="text" name="form[name]" id="name" value="<?= $this->data['category']['name'] ?? "" ?>" class="inputbox" size="70">
                        </li>
                        <li>
                            <label>Image<span class="star">&nbsp;*</span></label>
                            <input type="file" style="height: 30px" name="image" class="inputbox" size="70" value="<?= $this->data['category']['image'] ?? "" ?>">
                        </li>
                        <li>
                            <img width="60px" height="90px" src="<?= UPLOAD_URL . "category/" . $this->data['category']['image']   ?>" alt="">
                        </li>
                        <li>
                            <label>Status</label>
                            <?php echo $statusSelect  ?>
                        </li>
                        <li>
                            <label>Ordering<span class="star">&nbsp;*</span></label>
                            <input style="height: 30px" type="text" name="form[ordering]" id="ordering" value="<?= $this->data['category']['ordering'] ?? "" ?>" class="inputbox" size="70">
                        </li>

                    </ul>
                    <div class="clr"></div>
                    <div>
                        <input type="hidden" name="form[image_hidden]" id="image_hidden" value="<?= $this->data['category']['image'] ?>">
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