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
        $this->_view->_title    = "Category";
        $this->_view->data['listItem']      = $this->_model->listItems($this->_arrParams, $this->_pagination);
        $totalItem                          = $this->_model->countCategory($this->_arrParams);
        $this->_view->pagination            = new Pagination($totalItem, $this->_pagination);
        $this->_view->render("category/index");
    }

    public function ajaxStatusAction()
    {
        $result = $this->_model->ajaxStatus($this->_arrParams);
        echo json_encode($result);
    }

    // AJAX ORDERING
    public function ajaxOrderAction()
    {
        $result = $this->_model->changerOrder($this->_arrParams);
        echo json_encode($result);
    }

    // CHANGE STATUS (Thay đổi Status theo checkbox)
    public function statusAction()
    {
        $this->_model->changeStatus($this->_arrParams);
        Helper::redirect("admin", "category", "index");
    }

    // DELETE 
    public function deleteAction()
    {
        $id = $this->_model->deleteCategory($this->_arrParams);
        echo json_encode($id);
    }

    public function deleteAllAction()
    {
        $this->_model->deleteAllCate($this->_arrParams);
        Helper::redirect("admin", "category", "index");
    }



    // Add 
    public function addAction()
    {

        $this->_view->_title = "Add Category";

        $this->_view->render("category/add");
    }
}
