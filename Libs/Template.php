<?php
class Template
{
    // File Config (template.ini)
    private $_fileConfig;
    // Folder Template
    private $_folderTemplate;
    // File Template (index.php)
    private $_fileTemplate;
    // Controller Obj
    private $_controller;

    public function __construct($controller)
    {
        $this->_controller = $controller;
    }

    public function load()
    {
        $fileConfig     = $this->getFileConfig();
        $folderTemplate = $this->getFolderTemplate();
        $fileTemplate   = $this->getFileTemplate();

        $pathFileConfig = TEMPLATE_PATH . $folderTemplate . DS . $fileConfig;
        if (file_exists($pathFileConfig)) {
            $arrConfig          = parse_ini_file($pathFileConfig);
            $view               =  $this->_controller->getView();
            $view->setTemplatePath(TEMPLATE_PATH . $folderTemplate  . DS . $fileTemplate);
            $view->_title       = $this->createTitle($arrConfig['title']);
            $view->_metaHTTP    = $this->createMeta($arrConfig['metaHTTP'], "http-equiv");
            $view->_metaName    = $this->createMeta($arrConfig['metaName'], 'name');
            $view->_cssFile     = $this->createLink($arrConfig['dirCss'], $arrConfig['fileCss'], 'css');
            $view->_jsFile      = $this->createLink($arrConfig['dirJs'], $arrConfig['fileJs'], 'js');
            $view->_dirImage     = $arrConfig['dirImg'];
        }
    }

    // CREATE CSS JS 
    public function createLink($path, $files, $type = 'css')
    {
        $xhtml = '';
        if (!empty($files)) {
            $path = TEMPLATE_URL . $this->_folderTemplate . DS . $path . DS;
            foreach ($files as $file) {
                if ($type == 'css') {
                    $xhtml .= ' <link rel="stylesheet" type="text/css" href="' . $path . $file . '" />';
                } else if ($type == 'js') {
                    $xhtml .= '<script src="' . $path . $file . '"></script>';
                }
            }
        }
        return $xhtml;
    }


    // CREATE META
    public function createMeta($arrMeta, $typeMeta = 'name')
    {
        $xhtml = '';
        if (!empty($arrMeta)) {
            foreach ($arrMeta as $meta) {
                $temp = explode("|", $meta);
                $xhtml .= '<meta ' . $typeMeta . '="' . $temp[0] . '" content="' . $temp[1] . '">';
            }
        }
        return $xhtml;
    }


    // CREATE TITLE
    public function createTitle($value)
    {
        return  '<title>' . $value . '</title>';
    }

    // SET FOLDER TEMPLATE
    public function setFolderTemplate($value = "default/main")
    {
        $this->_folderTemplate = $value;
    }

    // GET FOLDER TEMPLATE
    public function getFolderTemplate()
    {
        return $this->_folderTemplate;
    }

    // SET FILE TEMPLATE
    public function setFileTemplate($value = "index.php")
    {
        $this->_fileTemplate = $value;
    }
    // GET FILE TEMPLATE
    public function getFileTemplate()
    {
        return $this->_fileTemplate;
    }

    // SET FILE CONFIG
    public function setFileConfig($value = "template.ini")
    {
        $this->_fileConfig = $value;
    }

    // GET FILR TEMPLATE
    public function getFileConfig()
    {
        return $this->_fileConfig;
    }
}
