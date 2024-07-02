<?php
$arrStatus      = array("default" => "- Select Status -", "0" => "UnPublish", "1" => "Publish");
$statusSelect   = Helper::cmsSelectBox("form[status]", "inputbox", $arrStatus, $this->data['book']['status'] ?? "", true);

$arrCategory   = array();
$arrCategory                = $this->data['category'];
$arrCategory['default']     = "- Select Status -";
krsort($arrCategory);
$categoryStatus = Helper::cmsSelectBox("form[cate_id]", "inputbox", $arrCategory, $this->data['book']['cate_id'] ?? "", true);
$priceAfterSale = $this->data['book']['price'] - ($this->data['book']['price'] * $this->data['book']['saleoff'] * 0.01) ?? "";
?>

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
?>
<div id="system-message-container">
    <?= $strMess ?>
</div>
<div id="element-box">
    <div class="m">
        <form action="#">
            <!-- FORM LEFT -->
            <div class="width-100 fltlft">
                <fieldset class="adminform">
                    <legend>Detail Category</legend>
                    <div class="adminformlist" style="display: flex; justify-content: space-between;">
                        <div>
                            <div>
                                <label>Name<span class="star">&nbsp;*</span></label>
                                <input disabled style="height: 30px" type="text" value="<?= $this->data['book']['name'] ?? "" ?>" class="inputbox" size="70">
                            </div>
                            <div>
                                <label>Desc<span class="star">&nbsp;*</span></label>
                                <textarea disabled cols="20" rows="10"><?= $this->data['book']['desc'] ?? "" ?></textarea>
                            </div>
                            <div>
                                <label>Image<span class="star">&nbsp;*</span></label>
                                <img width="60px" height="90px" src="<?= UPLOAD_URL . "book/" . $this->data['book']['image']   ?>" alt="">
                            </div>

                            <div>
                                <label>Price<span class="star">&nbsp;*</span></label>
                                <input disabled style="height: 30px" type="text" value="<?= $this->data['book']['price'] ?? "" ?>" class="inputbox" size="70">
                            </div>
                            <div>
                                <label>Sale Off<span class="star">&nbsp;*</span></label>
                                <input disabled style="height: 30px" type="text" value="<?= $this->data['book']['saleoff']   ?? "" ?>%" class="inputbox" size="70">
                            </div>
                            <div>
                                <label>Price After Sale<span class="star">&nbsp;*</span></label>
                                <input disabled style="height: 30px" type="text" value="<?= $priceAfterSale ?>" class="inputbox" size="70">
                            </div>
                        </div>
                        <div>
                            <div>
                                <label>Quantity<span class="star">&nbsp;*</span></label>
                                <input disabled style="height: 30px" type="text" name="form[quantity]" id="quantity" value="<?= $this->data['book']['quantity'] ?? "" ?>" class="inputbox" size="70">
                            </div>
                            <div>
                                <label>Author<span class="star">&nbsp;*</span></label>
                                <input disabled style="height: 30px" type="text" id="quantity" value="<?= $this->data['book']['author'] ?? "" ?>" class="inputbox" size="70">
                            </div>
                            <div>
                                <label>Category</label>
                                <?= $categoryStatus ?>
                            </div>
                            <div>
                                <label>Status</label>
                                <?= $statusSelect ?>
                            </div>
                            <div>
                                <label>Ordering<span class="star">&nbsp;*</span></label>
                                <input disabled style="height: 30px" type="text" value="<?= $this->data['book']['ordering'] ?? "" ?>" class="inputbox" size="70">
                            </div>
                            <div>
                                <label>Created<span class="star">&nbsp;*</span></label>
                                <input disabled style="height: 30px" type="text" value="<?= $this->data['book']['created'] ?? "" ?>" class="inputbox" size="70">
                            </div>
                            <div>
                                <label>Created_by<span class="star">&nbsp;*</span></label>
                                <input disabled style="height: 30px" type="text" value="<?= $this->data['book']['created_by'] ?? "" ?>" class="inputbox" size="70">
                            </div>
                            <div>
                                <label>Modified<span class="star">&nbsp;*</span></label>
                                <input disabled style="height: 30px" type="text" value="<?= $this->data['book']['modified'] ?? "" ?>" class="inputbox" size="70">
                            </div>
                            <div>
                                <label>Modified_by<span class="star">&nbsp;*</span></label>
                                <input disabled style="height: 30px" type="text" value="<?= $this->data['book']['modified_by'] ?? "" ?>" class="inputbox" size="70">
                            </div>
                        </div>
                    </div>
                    <div class="clr"></div>
                    <div>
                        <input type="hidden" name="form[token]" value="1384158288">
                        <input type="hidden" name="form[image_hidden]" id="image_hidden" value="<?= $this->data['book']['image'] ?>">
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