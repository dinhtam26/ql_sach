<?php
class CategoryController extends Controller
{

    public function __construct($arrParams)
    {

        parent::__construct($arrParams);
        $this->_templateObj->setFolderTemplate("admin/main");
        $this->_templateObj->setFileTemplate("index.php");
        $this->_templateObj->setFileConfig("template.ini");
        $this->_templateObj->load();
    }

    public function indexAction()
    {
        $this->_view->_title = "Category";

        $this->_view->render("category/index");
    }
}
