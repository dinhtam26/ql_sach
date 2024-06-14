<?php
class ErrorController extends Controller
{
    public function __construct($arrParams)
    {
        parent::__construct($arrParams);
        echo "<h3>" . __METHOD__ . "</h3>";
        $this->_templateObj->setFolderTemplate("default/main");
        $this->_templateObj->setFileTemplate("index.php");
        $this->_templateObj->setFileConfig("template.ini");
        $this->_templateObj->load();
    }


    public function indexAction()
    {
        $this->_view->data = "<h3>This is an error</h3>";
        $this->_view->render("error/index", false);
    }
}
