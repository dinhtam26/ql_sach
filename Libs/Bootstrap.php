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
            $this->loadDefaultController();
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
        $filePath       = MODULE_PATH . DEFAULT_MODULE . DS . "controllers" . DS . $controllerName . ".php";
        if (file_exists($filePath)) {
            require_once $filePath;
            $this->_controllerObj = new $controllerName();
            $this->_controllerObj->setView(DEFAULT_MODULE);
            $this->_controllerObj->$actionName();
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
        }
    }

    public function callMethod()
    {
        $actionName = $this->_params['action'] . "Action";
        if (method_exists($this->_controllerObj, $actionName)) {
            $this->_controllerObj->$actionName();
        } else {
            $this->_error();
        }
    }







    public function _error()
    {
        require_once MODULE_PATH . "default" . DS . "controllers" . DS . "ErrorController.php";
        $errorCtl = new ErrorController();
        $errorCtl->setView("default");

        $errorCtl->indexAction();
    }
}
