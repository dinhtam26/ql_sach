<?php
$images = TEMPLATE_URL . "default/main/images";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->_metaHTTP ?>
    <?= $this->_metaName ?>
    <title><?= $this->_title ?></title>
    <?= $this->_cssFile ?>
    <?= $this->_jsFile ?>
</head>

<body>
    <div id="wrap">
        <?php include "html/header.php" ?>


        <div class="center_content">
            <div class="left_content">
                <?php
                require_once MODULE_PATH . $this->moduleName . DS . "views" . DS . $this->_fileView . ".php";
                ?>
            </div>
            <div class="right_content">
                <?php include "html/slide_bar.php" ?>
            </div>
            <div class="clear"></div>
        </div>
        <!--end of center content-->


        <?php include "html/footer.php" ?>


    </div>


</body>

</html>