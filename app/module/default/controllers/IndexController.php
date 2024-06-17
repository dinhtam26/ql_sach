<?php
class IndexController extends Controller
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
        $this->_view->render("index/index");
    }

    public function registerAction()
    {
        $this->_view->_title = "Register";

        if (!empty($this->_arrParams['form'])) {

            // Kiểm tra trang website khi refesh trang
            if ($this->_arrParams['form']['token'] == Session::getSession("token")) {
                Session::deleteSession("token");
                header("Location: " . URL::createLink("default", "user", "register"));
                exit();
            } else {
                Session::setSession("token", $this->_arrParams['form']['token']);
            }

            $validate = new Validate($this->_arrParams['form']);
            $email = $this->_arrParams['form']['email'];
            $query = "SELECT `id` FROM `user` WHERE `email` = '$email'";

            $validate->addRule("username", "string", array("min" => 2, "max" => 255))
                ->addRule("email", "email")
                ->addRule("email", "recordExits", array("database" => $this->_model, "query" => $query))
                ->addRule("password", "password");
            $validate->run();

            if ($validate->isValid() == false) {
                $this->_view->error         = $validate->getErrors();
                $this->_view->data['form']  = $validate->getResult();
            } else {
                $this->_model->register($this->_arrParams['form']);
            }
        }


        $this->_view->render("index/register");
    }

    public function loginAction()
    {
        $this->_view->_title = "Login";
        // echo "<pre/>";
        // print_r($this->_arrParams);
        // echo "<pre/>";

        $infoUser = $this->_model->infoItem($this->_arrParams);

        if (!empty($this->_arrParams['form'])) {
            $id = $this->_model->loginDefault($this->_arrParams);

            if (!empty($id)) {
                $arrSession = array(
                    "login"     => true,
                    "info"      => $infoUser,
                    "time"      => time(),
                    "group_acp" => $infoUser['group_acp']
                );
                Session::setSession("user", $arrSession);
                header("Location: " . URL::createLink("default", "user", "index"));
                exit();
            } else {
                $this->_view->error = "Email hoặc mật khẩu của bạn chưa đúng vui lòng nhập lại";
                // Session::setSession('message', array("class" => "error", "content" => "Email hoặc mật khẩu của bạn chưa đúng vui lòng nhập lại"));
            }
        }


        $this->_view->render("index/login");
    }

    public function logoutAction()
    {
        Session::deleteSession("user");
        header("Location: " . URL::createLink("default", "index", "index"));
        exit();
    }
}
