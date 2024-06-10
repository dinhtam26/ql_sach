<?php
class GroupController extends Controller
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
        $this->_view->_title    = "UserManage - UserGroup";
        // DS Items group
        $this->_view->data      = $this->_model->listItem($this->_arrParams, $this->_pagination);
        // Total items group

        $totalItem              = $this->_model->countItem($this->_arrParams);
        $this->_view->pagination = new Pagination($totalItem, $this->_pagination);
        $this->_view->render("group/index");
    }

    public function addAction()
    {
        $this->_view->_title = "UserManage - Add";

        // Validate
        if (!empty($this->_arrParams['form'])) {
            $validate = new Validate($this->_arrParams['form']);
            $validate->addRule("name", "string", array("min" => 2, "max" => 255))
                ->addRule("ordering", "int", array("min" => 1, "max" => 100))
                ->addRule("status", "status")
                ->addRule("group_acp", "status");

            $validate->run();
            // Kiểm tra xem có lỗi không 
            if ($validate->isValid() == false) {
                $this->_view->error = $validate->getErrors();
            } else {
                $this->_model->addGroup($this->_arrParams);
                header("Location: " . URL::createLink("admin", "group", "index"));
            }
        }



        $this->_view->render("group/add");
    }

    public function editAction()
    {
        $this->_view->_title = "UserManage - Edit";
        if (!empty($this->_arrParams)) {
            $this->_view->data =  $this->_model->getOneItem($this->_arrParams['id']);
        }

        // Validate
        if (!empty($this->_arrParams['form'])) {
            $validate = new Validate($this->_arrParams['form']);
            $validate->addRule("name", "string", array("min" => 2, "max" => 255))
                ->addRule("ordering", "int", array("min" => 1, "max" => 100))
                ->addRule("status", "status")
                ->addRule("group_acp", "status");

            $validate->run();
            // Kiểm tra xem có lỗi không 
            if ($validate->isValid() == false) {
                $this->_view->error = $validate->getErrors();
            } else {
                $this->_model->updateGroup($this->_arrParams);
                header("Location: " . URL::createLink("admin", "group", "index"));
            }
        }


        $this->_view->render("group/edit");
    }

    // AJAX STATUS
    public function ajaxStatusAction()
    {
        $result =  $this->_model->changStatus($this->_arrParams);
        echo json_encode($result);
    }
    // AJAX GROUP ACP
    public function ajaxGroupAction()
    {

        $result =  $this->_model->changeGroupACP($this->_arrParams);
        echo json_encode($result);
    }

    // AJAX STATUS ALL
    public function statusAction()
    {
        $this->_model->changeAllStatus($this->_arrParams);
        header("Location:" . URL::createLink("admin", "group", "index"));
        exit();
    }

    // TRASH
    public function deleteAction()
    {
        $this->_model->deleteGroup($this->_arrParams);
        header("Location:" . URL::createLink("admin", "group", "index"));
        exit();
    }

    // AJAX ORDERING
    public function ajaxOrderAction()
    {
        $result = $this->_model->changerOrder($this->_arrParams);
        echo json_encode($result);
    }
}
