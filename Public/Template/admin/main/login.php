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
    <div id="border-top" class="h_blue">
        <span class="title"><a href="index.php">Administration</a></span>
    </div>
    <div id="content-box">
        <!-- LOAD CONTENT -->
        <?php

        require_once MODULE_PATH . $this->moduleName . DS . "views" . DS . $this->_fileView . ".php";
        ?>
    </div>
    <?php include_once "html/footer.php"; ?>
</body>

</html>