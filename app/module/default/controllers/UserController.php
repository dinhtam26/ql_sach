<?php
class UserController extends Controller
{
    public function __construct($arrParams)
    {
        parent::__construct($arrParams);

        $this->_templateObj->setFolderTemplate("default/main");
        $this->_templateObj->setFileTemplate("index.php");
        $this->_templateObj->setFileConfig("template.ini");
        $this->_templateObj->load();
    }

    public function indexAction()
    {
        $this->_view->_title = "User Default";
        $this->_view->setCss(array("user/css/bootstrap.min.css"));
        $this->_view->render("user/index");
    }

    public function addAction()
    {
        echo "<h3>" . __METHOD__ . "</h3>";
    }
}
