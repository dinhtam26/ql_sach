<?php
class URL
{
    public static function createLink($module, $controller, $action, $params = null)
    {
        $strParams = "";
        if (!empty($params)) {

            foreach ($params as $key => $value) {
                $strParams .= "&$key=$value";
            }
        }
        $url = 'index.php?module=' . $module . '&controller=' . $controller . '&action=' . $action . '' . $strParams;
        return $url;
    }
}
