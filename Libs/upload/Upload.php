<?php
class Upload
{
    // Biến lưu trữ tên tập tin
    private $_fileName;

    // Biến lưu trữ kích thước tập tin
    private $_fileSize;

    // Biến lưu trữ phần mở rộng của tập tin
    private $_fileExtension;

    // Biến lưu trữ đường dẫn thư mục tạm 
    private $_fileTmp;

    // Biến lữu trữ các giá trị error
    private $_errors;

    // Biến lưu trữ đường dẫn để upload 
    private $_uploadDir;


    // Phương thức khởi tạo

    public function __construct($value)
    {
        // $value = $_FILES['fileUpload'];
        $this->_fileName        = $value['name'];
        $this->_fileSize        = $value['size'];
        $this->_fileExtension   = $this->getFileExtension();
        $this->_fileTmp         = $value['tmp_name'];
    }

    // Phương thức lấy phần mở rộng 
    public function getFileExtension()
    {
        $result = pathinfo($this->_fileName, PATHINFO_EXTENSION);
        return $result;
    }

    // Phương thức thiết lập phần mở rộng

    public function setFileExtension($arrayExtension)
    {

        // Kiểm tra xem extension có trong mảng không
        if (in_array(strtolower($this->_fileExtension), $arrayExtension) == false) {
            $this->_errors[] = "Phần mở rộng không phù hợp";
        }
    }

    // Phương thức thiết lập kích thước tối thiểu và tối đa
    public function setFileSize($min, $max)
    {
        if ($this->_fileSize > $max || $this->_fileSize < $min) {
            $this->_errors[] = "Kích thước file của bạn không phù hợp";
        }
    }

    // Phương thức thiết lập đường dẫn đến Folder upload
    public function setUploadDir($value)
    {
        if (file_exists($value)) {
            $this->_uploadDir = $value;
        } else {
            $this->_errors[]    = "Thư mục không hợp lệ";
        }
    }

    // Phương thức kiểm tra xem đủ điều kiện để upload chưa
    public function isValid()
    {
        return empty($this->_errors); // Trả về true nếu k có lỗi và false nếu có lỗi
    }

    // Phương thức upload tập tin
    public function upload($rename = true)
    {
        if ($rename == true) {
            $fileName = $this->randomString(6);
            $destination =  $this->_uploadDir . $fileName;
        } else {
            $destination =  $this->_uploadDir . $this->_fileName;
        }
        move_uploaded_file($this->_fileTmp, $destination);
        echo "Upload thành công";
    }



    private function randomString($length)
    {
        $char = array_merge(range("a", "z"), range("A", "Z"), range(0, 9));
        // $char = shuffle($char);
        $char = implode("", $char);
        $char = str_shuffle($char);

        $result = substr($char, 0, $length) . "." . $this->_fileExtension;
        return $result;
    }
}
