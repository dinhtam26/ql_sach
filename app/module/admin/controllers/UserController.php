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
}
