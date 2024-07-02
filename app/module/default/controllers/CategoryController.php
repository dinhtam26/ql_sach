<?php
class CategoryController extends Controller
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
        $this->_view->_title = "BookStore";
        $this->_view->listItem      = $this->_model->listItems($this->_arrParams, $this->_pagination);
        $totalItem                  = $this->_model->countCategory($this->_arrParams);
        $this->_view->pagination    = new Pagination($totalItem, $this->_pagination);
        $this->_view->render("category/index");
    }
}
