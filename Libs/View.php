<?php
class View
{
    private $moduleName;
    public $data;
    public $_templatePath;
    public $_title;
    public $_metaHTTP;
    public $_metaName;
    public $_cssFile;
    public $_jsFile;
    public $_dirImage;
    public $_fileView;
    public $_arrParams;


    public function __construct($moduleName)
    {
        $this->moduleName = $moduleName;
    }

    public function render($viewName, $loadFull = true)
    {
        $path = MODULE_PATH . $this->moduleName . DS . "views" . DS . $viewName . ".php";
        if (file_exists($path)) {
            if ($loadFull == true) {
                $this->_fileView = $viewName;
                require_once $this->_templatePath;
            } else {
                require_once $path;
            }
        }
    }

    // Thiết lập đường dẫn đến file Template
    public function setTemplatePath($value)
    {
        $this->_templatePath = $value;
    }

    public function setTitle($value)
    {
        return $this->_title = '<title>' . $value . '</title>';
    }

    public function setCss($arrayCss)
    {
        $xhtml = '';
        if (!empty($arrayCss)) {
            foreach ($arrayCss as $css) {
                $file = APP_URL . $this->moduleName . DS . "views" . DS . $css;
                $this->_cssFile .= '<link rel="stylesheet" type="text/css" href="' . $file . '" />';
            }
        }
    }

    public function setJs($arrayJs)
    {
        $xhtml = '';
        if (!empty($arrayJs)) {
            foreach ($arrayJs as $js) {
                $file = APP_URL . $this->moduleName . DS . "views" . DS . $js;
                $this->_jsFile .= '<script src="' . $file . '"></script>';
            }
        }
    }
}
