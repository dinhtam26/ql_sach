<?php
class Bootstrap
{

    private $_params;
    private $_controllerObj;
    public function __construct()
    {
        $this->setParams();
        $controllerName = ucfirst($this->_params['controller'] ?? DEFAULT_CONTROLLER)  . "Controller";
        $filePath = MODULE_PATH . ($this->_params['module'] ?? DEFAULT_MODULE) . DS . "controllers" . DS . $controllerName . ".php";

        if (file_exists($filePath)) {
            $this->loadExistingController($filePath, $controllerName);
            $this->callMethod();
        } else {
            $this->_error();
        }
    }

    // SET PARAMS 
    public function setParams()
    {
        $defaultParams = ['module' => DEFAULT_MODULE, 'controller' => DEFAULT_CONTROLLER, 'action' => DEFAULT_ACTION];
        $this->_params = array_merge($defaultParams, $_GET, $_POST);
    }

    // LOAD DEFAULT CONTROLLER
    private function loadDefaultController()
    {
        $controllerName = ucfirst(DEFAULT_CONTROLLER) . "Controller";
        $actionName     = DEFAULT_ACTION . "Action";
        echo  $filePath       = MODULE_PATH . "admin" . DS . "controllers" . DS . $controllerName . ".php";
        if (file_exists($filePath)) {
            require_once $filePath;
            $this->_controllerObj = new $controllerName($this->_params);
        }
    }
    // LOAD Existing CONTROLLER
    private function loadExistingController($filePath, $controllerName)
    {
        $controllerName = ucfirst($this->_params['controller']) . "Controller";
        $filePath = MODULE_PATH . $this->_params['module'] . DS . "controllers" . DS . $controllerName . ".php";

        if (file_exists($filePath)) {
            require_once $filePath;
            $this->_controllerObj = new $controllerName($this->_params);
            $this->_controllerObj->setParams($this->_params);
        } else {
            $this->_error();
        }
    }

    public function callMethod()
    {
        $actionName = $this->_params['action'] . "Action";

        if (method_exists($this->_controllerObj, $actionName)) {

            $module     = $this->_params['module'];
            $controller = $this->_params['controller'];
            $action     = $this->_params['action'];
            if ($module == "admin") {
                $pageLogin  = ($this->_params['controller'] == "index" && $this->_params['action'] == "login");
                if (!empty(Session::getSession("user"))) {
                    $userInfo   = Session::getSession("user");
                    $login      = $userInfo['login'];
                    $time       = $userInfo['time'] + 3600;

                    if ($login == true && $time >= time()) {
                        if ($userInfo['group_acp'] == 1) {
                            if ($pageLogin == true) {
                                header("Location: " . URL::createLink("admin", "index", "index"));
                                exit();
                            }
                        } else {
                            if ($pageLogin == false) {
                                header("Location: " . URL::createLink("admin", "index", "login"));
                                exit();
                            }
                        }
                    } else {
                        Session::deleteSession("user");
                        if ($pageLogin == false) {
                            header("Location: " . URL::createLink("admin", "index", "login"));
                            exit();
                        }
                    }
                } else {
                    if ($pageLogin == false) {
                        header("Location: " . URL::createLink("admin", "index", "login"));
                        exit();
                    }
                }
            } else if ($module == "default") {
                $arrRouteNeedAuth = array(
                    array("controller" => "user", "action" => "index"),
                    array("controller" => "cart", "action" => "list"),
                    array("controller" => "cart", "action" => "inc"),
                    array("controller" => "cart", "action" => "dec"),
                    array("controller" => "cart", "action" => "del"),
                );

                $page = array("controller" => $this->_params['controller'], "action" => $this->_params['action']);
                if (empty(Session::getSession("user")) && in_array($page, $arrRouteNeedAuth)) {
                    header("Location: " . URL::createLink("default", "index", "login"));
                    exit();
                }
            }
            $this->_controllerObj->$actionName();
        } else {
            $this->_error();
        }
    }



    public function  middleware_auth_check($act, $arrRouteNeedAuth)
    {
        if (empty($_SESSION['user']) && in_array($act, $arrRouteNeedAuth)) {
            header('Location: ' . ROOT_URL . '?act=user-login');
            exit();
        }
    }




    public function _error()
    {
        require_once MODULE_PATH . "default" . DS . "controllers" . DS . "ErrorController.php";
        $errorCtl = new ErrorController($this->_params);
        $errorCtl->setView("default");

        $errorCtl->indexAction();
    }
}
