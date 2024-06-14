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


        $this->_view->render("user/register");
    }
}
