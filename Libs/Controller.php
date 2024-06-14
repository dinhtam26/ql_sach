<?php
class Controller
{
    // View Object
    protected $_view;
    // Model Object 
    protected $_model;

    // Template Object
    protected $_templateObj;
    // Param (GET - POST)
    protected $_arrParams;
    // Pagination  
    protected $_pagination = array(
        "totalItemPerPage" => 5,
        "pageRange" => 3,
    );

    public function __construct($arrParams)
    {
        $this->setModel($arrParams['module'], $arrParams['controller']);
        $this->setView($arrParams['module']);
        $this->setTemplate($this);
        $this->setParams($arrParams);

        $this->_pagination['currentPage'] = isset($arrParams['filter_pagination']) ? $arrParams['filter_pagination'] : 1;
        if (!empty($this->_arrParams['filter_page'])) {
            if (is_numeric($this->_arrParams['filter_page'])) {
                $this->_pagination['totalItemPerPage'] = $this->_arrParams['filter_page'];
            }
        }

        $this->_view->_arrParams = $arrParams;
    }
    // SET MODEL
    public function setModel($moduleName, $modelName)
    {
        $modelName = ucfirst($modelName) . "Model";
        $path = MODULE_PATH . $moduleName . DS . "models" . DS . $modelName . ".php";
        if (file_exists($path)) {
            require_once $path;
            $this->_model = new $modelName();
        }
    }

    // GET MODEL
    public function getModel()
    {
        return $this->_model;
    }

    // SET VIEW
    public function setView($moduleName)
    {
        $this->_view = new View($moduleName);
    }

    // GET VIEW
    public function getView()
    {
        return $this->_view;
    }

    // SET TEMPLATE
    public function setTemplate()
    {
        $this->_templateObj = new Template($this);
    }

    // GET TEMPLATE
    public function getTemplate()
    {
        return $this->_templateObj;
    }

    // SET PARAMS
    public function setParams($arrParams)
    {
        $this->_arrParams = $arrParams;
    }

    // GET PARAMS
    public function getParams()
    {
        return $this->_arrParams;
    }

    // SET PAGINATION
    public function setPagination($pagination)
    {
        $this->_pagination = $pagination;
    }
}
