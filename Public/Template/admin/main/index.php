<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
    <?= $this->_metaHTTP ?>
    <?= $this->_metaName ?>
    <title><?= $this->_title ?></title>
    <?= $this->_cssFile ?>
    <?= $this->_jsFile ?>
</head>



<body>
    <?php include_once "html/header.php"; ?>
    <div id="content-box">
        <!-- LOAD CONTENT -->

        <div id="toolbar-box">
            <div class="m">
                <!-- TOOLBAR -->
                <?php include_once "html/toolbar/index.php" ?>
                <!-- TITLE -->
                <div class="pagetitle icon-48-groups">
                    <h2><?= $this->_title ?></h2>
                </div>
            </div>
        </div>
        <?php include_once "html/submenu/index.php" ?>
        <?php
        require_once MODULE_PATH . $this->moduleName . DS . "views" . DS . $this->_fileView . ".php";
        ?>
    </div>
    <?php include_once "html/footer.php"; ?>
</body>

</html>