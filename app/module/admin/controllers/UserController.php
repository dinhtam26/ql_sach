<?php
class UserController extends Controller
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
        $this->_view->_title = "User";
        $totalItem           = $this->_model->countUser($this->_arrParams);
        $this->_view->pagination = new Pagination($totalItem, $this->_pagination);

        $this->_view->data['listUser']   =   $this->_model->listUser($this->_arrParams,  $this->_pagination);
        $this->_view->data['listGroupName']  = $this->_model->getGroupName($this->_arrParams);

        $this->_view->render("user/index");
    }

    // CHANGE STATUS
    public function statusAction()
    {
        $this->_model->changeAllStatus($this->_arrParams);
        Header("Location:" . URL::createLink("admin", "user", "index"));
        exit();
    }

    // CHANGE ONE STATUS USER
    public function changeStatusAction()
    {
        $result = $this->_model->changeOneStatus($this->_arrParams);
        echo json_encode($result);
    }

    // AJAX ORDERING
    public function ajaxOrderAction()
    {
        $result = $this->_model->changerOrder($this->_arrParams);
        echo json_encode($result);
    }

    // ADD
    public function addAction()
    {
        $this->_view->_title = "Add User";
        $this->_view->data['listGroupName']  = $this->_model->getGroupName($this->_arrParams);

        if (!empty($this->_arrParams['form'])) {
            $validate = new Validate($this->_arrParams['form']);

            $validate->addRule("username", "string", array("min" => 2, "max" => 255))
                ->addRule("email", "email")
                ->addRule("password", "password")
                ->addRule("fullname", "string", array("min" => 2, "max" => 255))
                ->addRule("status", "status")
                ->addRule("group_id", "status")
                ->addRule("ordering", "int", array("min" => 1, "max" => 100));

            $validate->run();
            if ($validate->isValid() == false) {
                $this->_view->errors = $validate->getErrors();
            } else {
                $this->_model->addUser($this->_arrParams);
                Header("Location:" . URL::createLink("admin", "user", "index"));
                exit();
            }
        }
        $this->_view->render("user/add");
    }

    // EDIT
    public function editAction()
    {
        $this->_view->_title = "Edit User";
        $this->_view->data['listGroupName']  = $this->_model->getGroupName($this->_arrParams);


        if (!empty($this->_model->getOneUser($this->_arrParams))) {
            $this->_view->data['userById'] = $this->_model->getOneUser($this->_arrParams);
        } else {
            Header("Location: " . URL::createLink("admin", "user", "index"));
        }
        // Validate
        if (!empty($this->_arrParams['form'])) {
            $validate = new Validate($this->_arrParams['form']);

            $validate->addRule("username", "string", array("min" => 2, "max" => 255))
                ->addRule("email", "email")
                ->addRule("password", "password")
                ->addRule("fullname", "string", array("min" => 2, "max" => 255))
                ->addRule("status", "status")
                ->addRule("group_id", "status")
                ->addRule("ordering", "int", array("min" => 1, "max" => 100));

            $validate->run();
            if ($validate->isValid() == false) {
                $this->_view->errors = $validate->getErrors();
            } else {
                $this->_model->updateUser($this->_arrParams);
            }
        }

        $this->_view->render("user/edit");
    }

    // DELETE 
    public function deleteAction()
    {

        $id = $this->_model->deleteUser($this->_arrParams);
        echo json_encode($id);
    }

    // DELETE ALL BY CHECKBOX
    public function deleteAllAction()
    {
        $this->_model->deleteAllUser($this->_arrParams);
        header("Location:" . URL::createLink("admin", "user", "index"));
        exit();
    }
}
