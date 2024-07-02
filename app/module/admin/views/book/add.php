<?php
$arrStatus      = array("default" => "- Select Status -", "0" => "UnPublish", "1" => "Publish");
$statusSelect   = Helper::cmsSelectBox("form[status]", "inputbox", $arrStatus, $this->_arrParams['form']['status'] ?? "", true);


$arrCategory                = $this->data['category'];
$arrCategory['default']     = "- Select Status -";
krsort($arrCategory);
$categoryStatus = Helper::cmsSelectBox("form[cate_id]", "inputbox", $arrCategory, $this->_arrParams['form']['cate_id'] ?? "", true);

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

?>
<div id="element-box">
    <div class="m">
        <form action="#" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
            <!-- FORM LEFT -->
            <div class="width-100 fltlft">
                <fieldset class="adminform">
                    <legend>Add Category</legend>
                    <ul class="adminformlist">
                        <li>
                            <label>Name<span class="star">&nbsp;*</span></label>
                            <input style="height: 30px" type="text" name="form[name]" id="name" value="<?= $this->_arrParams['form']['name'] ?? "" ?>" class="inputbox" size="70">
                        </li>
                        <li>
                            <label>Desc<span class="star">&nbsp;*</span></label>
                            <!-- <input style="height: 30px" type="text" name="form[desc]" id="desc" value="" class="inputbox" size="70"> -->
                            <textarea cols="20" rows="10" name="form[desc]" id="desc"><?= $this->_arrParams['form']['desc'] ?? "" ?></textarea>
                        </li>
                        <li>
                            <label>Image<span class="star">&nbsp;*</span></label>
                            <input type="file" style="height: 30px" name="image" class="inputbox" size="70">
                        </li>
                        <li>
                            <label>Price<span class="star">&nbsp;*</span></label>
                            <input style="height: 30px" type="text" name="form[price]" id="price" value="<?= $this->_arrParams['form']['price'] ?? "" ?>" class="inputbox" size="70">
                        </li>
                        <li>
                            <label>Sale Off<span class="star">&nbsp;*</span></label>
                            <input style="height: 30px" type="text" name="form[saleoff]" id="saleoff" value="<?= $this->_arrParams['form']['saleoff'] ?? "" ?>" class="inputbox" size="70">
                        </li>
                        <li>
                            <label>Quantity<span class="star">&nbsp;*</span></label>
                            <input style="height: 30px" type="text" name="form[quantity]" id="quantity" value="<?= $this->_arrParams['form']['quantity'] ?? "" ?>" class="inputbox" size="70">
                        </li>
                        <li>
                            <label>Author<span class="star">&nbsp;*</span></label>
                            <input style="height: 30px" type="text" name="form[author]" id="quantity" value="<?= $this->_arrParams['form']['author'] ?? "" ?>" class="inputbox" size="70">
                        </li>
                        <li>
                            <label>Category</label>
                            <?= $categoryStatus ?>
                        </li>
                        <li>
                            <label>Status</label>
                            <?= $statusSelect ?>
                        </li>
                        <li>
                            <label>Ordering<span class="star">&nbsp;*</span></label>
                            <input style="height: 30px" type="text" name="form[ordering]" id="ordering" value="<?= $this->_arrParams['form']['ordering'] ?? "" ?>" class="inputbox" size="70">
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