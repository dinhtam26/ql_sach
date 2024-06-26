<?php
require_once SCRIPT_PATH . "PHPThumb" . DS . "PHPThumb.php";
class Upload
{
    public function uploadFile($fileObject, $folderUpload)
    {
        if ($fileObject['tmp_name'] != null) {
            $uploadDir    = UPLOAD_PATH . $folderUpload . DS;
            $newString    = $this->createString(6);
            $imagePath    = $newString . basename($fileObject['name']);
            move_uploaded_file($fileObject['tmp_name'], $uploadDir  . $imagePath);
            return $imagePath;
        }
    }

    public function deleteFileUpload($folderUpload, $fileName)
    {
        $fileName = UPLOAD_PATH . $folderUpload . DS . $fileName;
        if (file_exists($fileName)) {
            @unlink($fileName);
        }
    }

    private function createString($length = 5)
    {
        $arrStr = array_merge(range("a", "z"), range(0, 9));
        $string = implode("", $arrStr);
        $string = str_shuffle($string);
        $string = substr($string, 3, $length);
        return $string;
    }
}
