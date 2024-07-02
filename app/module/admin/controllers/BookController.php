<?php
class BookController extends Controller
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

        $this->_view->_title = "Book Store";
        $this->_view->data['category']  = $this->_model->getCategory();
        $this->_view->data['book']      = $this->_model->listItems($this->_arrParams, $this->_pagination);
        $totalItem                      = $this->_model->countBook($this->_arrParams);
        $this->_view->pagination        = new Pagination($totalItem, $this->_pagination);
        $this->_view->render("book/index");
    }

    // CHANGE STATUS AJAX
    public function ajaxStatusAction()
    {
        $result =  $this->_model->changeStatusAjax($this->_arrParams);
        echo json_encode($result);
    }

    // CHANGE ORDERING
    public function ajaxOrderAction()
    {
        $result = $this->_model->changerOrder($this->_arrParams);
        echo json_encode($result);
    }

    // CHANGE STATUS CHECKBOX
    public function statusAction()
    {
        $this->_model->changeStatus($this->_arrParams);
        Helper::redirect("admin", "book", "index");
    }

    // DELETE ALL
    public function deleteAllAction()
    {
        $this->_model->deleteAll($this->_arrParams);
        Helper::redirect("admin", "book", "index");
    }

    public function addAction()
    {
        if (!empty($_FILES)) {
            $this->_arrParams['form']['image'] = $_FILES['image'];
        }

        $this->_view->_title = "Add Book";
        $this->_view->data['category'] = $this->_model->getCategory();

        if (!empty($this->_arrParams['form'])) {
            $validate = new Validate($this->_arrParams['form']);

            $validate->addRule("name", "string", array("min" => 2, "max" => 250))
                ->addRule("desc", "string", array("min" => 2, "max" => 2000))
                ->addRule("author", "string", array("min" => 2, "max" => 50))
                ->addRule("price", "int", array("min" => 1000, "max" => 2000000))
                ->addRule("quantity", "int", array("min" => 1, "max" => 500))
                ->addRule("status", "status")
                ->addRule("cate_id", "status")
                ->addRule("ordering", "int", array("min" => 1, "max" => 100))
                ->addRule("image", "file", array("min" => 1024, "max" => 5240880, "extension" => array("png", "jpg", "jpeg", "webp")), false);
            $validate->run();

            if ($validate->isValid() == false) {
                $this->_view->error = $validate->getErrors();
            } else {
                $this->_view->data['form'] = $validate->getResult();
                $this->_model->addBook($this->_arrParams);

                Helper::redirect("admin", "book", "index");
            }
        }
        $this->_view->render("book/add");
    }

    public function editAction()
    {
        $this->_view->_title = "Edit Book";

        if (!empty($_FILES)) {
            $this->_arrParams['form']['image'] = $_FILES['image'];
        }


        if (!empty($this->_arrParams['form'])) {
            $validate = new Validate($this->_arrParams['form']);

            $validate->addRule("name", "string", array("min" => 2, "max" => 250))
                ->addRule("desc", "string", array("min" => 2, "max" => 2000))
                ->addRule("author", "string", array("min" => 2, "max" => 50))
                ->addRule("price", "int", array("min" => 1000, "max" => 2000000))
                ->addRule("quantity", "int", array("min" => 1, "max" => 500))
                ->addRule("status", "status")
                ->addRule("cate_id", "status")
                ->addRule("ordering", "int", array("min" => 1, "max" => 100))
                ->addRule("image", "file", array("min" => 1024, "max" => 5240880, "extension" => array("png", "jpg", "jpeg", "webp"), "update" => true), false);
            $validate->run();

            if ($validate->isValid() == false) {
                $this->_view->error = $validate->getErrors();
            } else {
                $this->_view->data['form'] = $validate->getResult();
                $this->_model->editBook($this->_arrParams);

                // Helper::redirect("admin", "category", "index");
            }
        }

        $this->_view->data['category']  = $this->_model->getCategory();
        $this->_view->data['book']      = $this->_model->getBookById($this->_arrParams);
        $this->_view->render("book/edit");
    }

    public function detailAction()
    {
        $this->_view->_title = "Detail Book";
        $this->_view->data['category']  = $this->_model->getCategory();
        $this->_view->data['book']      = $this->_model->getBookById($this->_arrParams);
        $this->_view->render("book/detail");
    }

    // DELETE 
    public function deleteAction()
    {
        $id = $this->_model->deleteBook($this->_arrParams);
        echo json_encode($id);
    }
}
