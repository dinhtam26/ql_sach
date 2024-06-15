<?php
class IndexController extends Controller
{

    public function __construct($arrParams)
    {
        parent::__construct($arrParams);
        $this->_templateObj->setFolderTemplate("admin/main");
        $this->_templateObj->setFileTemplate("index.php");
        $this->_templateObj->setFileConfig("template.ini");
        $this->_templateObj->load();
    }

    public function loginAction()
    {
        $this->_templateObj->setFolderTemplate("admin/main");
        $this->_templateObj->setFileTemplate("login.php");
        $this->_templateObj->setFileConfig("template.ini");
        $this->_templateObj->load();
        $this->_view->_title = "Login";

        $infoUser = $this->_model->infoItem($this->_arrParams);

        if (!empty($this->_arrParams['form'])) {
            $id = $this->_model->loginAdmin($this->_arrParams);

            if (!empty($id)) {
                $arrSession = array(
                    "login"     => true,
                    "info"      => $infoUser,
                    "time"      => time(),
                    "group_acp" => $infoUser['group_acp']
                );
                Session::setSession("user", $arrSession);
                header("Location: " . URL::createLink("admin", "index", "index"));
                exit();
            } else {
                $this->_view->errors = "Email hoặc mật khẩu của bạn chưa đúng vui lòng nhập lại";
            }
        }

        $this->_view->render("index/login");
    }

    public function logoutAction()
    {
        Session::deleteSession("user");
        header("Location: " . URL::createLink("admin", "index", "login"));
        exit();
    }

    public function indexAction()
    {


        $this->_view->_title = "Index";
        $this->_view->render("index/index");
    }
}
