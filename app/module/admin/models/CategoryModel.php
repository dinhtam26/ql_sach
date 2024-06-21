<?php
class CategoryModel extends Model
{
    private $_column = array("id", "name", "image", "created", "created_by", "modified", "modified_by", "status", "ordering");

    // Construct (set table)
    public function __construct()
    {
        parent::__construct();
        $this->setTable("category");
    }

    // LIST ITEMS
    public function listItems($arrParams, $pagination)
    {

        $sql[]  = "SELECT `id`, `name`, `image`, `created`, 
                  (SELECT `username`  FROM `user` AS `u` WHERE `u`.`id` = `c`.`created_by`) AS 'created_by' , `modified`,
                  (SELECT `username`  FROM `user` AS `u` WHERE `u`.`id` = `c`.`modified_by`) AS 'modified_by', `status`, `ordering`";
        $sql[]  = "FROM `$this->table` AS `c` WHERE `id` > '0'";

        // SEARCH 
        if (!empty($arrParams['filter_search'])) {
            $keySearch = $arrParams['filter_search'];
            $sql[]  = "AND `name` LIKE '%$keySearch%'";
        }

        // FILTER STATUS

        if (isset($arrParams['filter_status']) && $arrParams['filter_status'] != 2) {
            $status = $arrParams['filter_status'];
            $sql[]  = "AND `status` = '$status'";
        }

        // FILTER PAGINATION
        $position         = ($pagination['currentPage'] - 1) * $pagination['totalItemPerPage'];
        $totalItemPerPage = $pagination['totalItemPerPage'];
        if (!empty($arrParams['filter_page']) && $arrParams['filter_page'] != "default") {
            $totalItemPerPage   = $arrParams['filter_page'];
        }
        $sql[] = "LIMIT $position ,  $totalItemPerPage";
        $sql    = implode(" ", $sql);
        $result = $this->listRecord($sql);
        return $result;
    }

    // COUNT CATEGORY
    public function countCategory($arrParams)
    {

        $sql[]  = "SELECT COUNT(`id`) AS 'total'";
        $sql[]  = "FROM `$this->table` WHERE `id` > '0'";

        // SEARCH 
        if (!empty($arrParams['filter_search'])) {
            $keySearch = $arrParams['filter_search'];
            $sql[]  = "AND `name` LIKE '%$keySearch%'";
        }

        // FILTER STATUS

        if (isset($arrParams['filter_status']) && $arrParams['filter_status'] != 2) {
            $status = $arrParams['filter_status'];
            $sql[]  = "AND `status` = '$status'";
        }
        $sql    = implode(" ", $sql);
        $result = $this->singleRecord($sql);
        return $result['total'];
    }

    // CHANGE ONE STATUS AJAX
    public function ajaxStatus($arrParams)
    {
        $userInfo   = Session::getSession("user");
        $idUser     = $userInfo['info']['id'];
        if (!empty($arrParams)) {
            $id     = $arrParams['id'];
            $status = ($arrParams['status'] == 1) ? 0 : 1;
            $sql = "UPDATE `$this->table` SET `status` = '$status', `modified_by` = '$idUser' WHERE `id` = '$id'";
            $this->query($sql);
            return array("id" => $id, "status" => $status, "link" => "index.php?module=admin&controller=category&action=ajaxStatus&id=$id&status=$status");
        }
    }
    // CHANGE ORDER
    public function changerOrder($arrParams)
    {
        $userInfo   = Session::getSession("user");
        $idUser     = $userInfo['info']['id'];
        if (!empty($arrParams) && $arrParams['type'] == "changeOrder") {
            $id         = $arrParams['id'];
            $ordering   = $arrParams['value'];
            $sql = "UPDATE `$this->table` SET `ordering` = '$ordering',`modified_by`= '$idUser'  WHERE `id` = '$id'";
            $this->query($sql);
            return array("title" => "Cập nhật thành công", "class" => "success");
        }
    }

    // CHANGE STATUS BY CHECKBOX
    public function changeStatus($arrParams)
    {
        $userInfo   = Session::getSession("user");
        $idUser     = $userInfo['info']['id'];
        if (!empty($arrParams['checkbox'])) {
            $status = $arrParams['type'];
            $ids    = $this->createWhereDeleteSql($arrParams['checkbox']);
            $sql    = "UPDATE `$this->table` SET `status` = '$status', `modified_by` = '$idUser' WHERE id IN($ids)";
            $this->query($sql);
            Session::setSession('message', array('class' => "success", "content" => 'Bạn đã thay đổi thành công status'));
        } else {
            Session::setSession('message', array('class' => "error", "content" => 'Vui lòng chọn vào phần tử muốn thay đổi status'));
        }
    }

    // DELETE CATEGORY 
    public function deleteCategory($arrParams)
    {
        if (!empty($arrParams['id']) && $arrParams['type'] == "deleteUser") {
            $ids = $arrParams['id'];
            $sql = "DELETE FROM `$this->table` WHERE `id` IN($ids)";
            $this->query($sql);
        }
    }

    // DELETE CATEGORY BY CHECK BOX 
    public function deleteAllCate($arrParams)
    {
        if (!empty($arrParams['checkbox'])) {
            $ids    = $this->createWhereDeleteSql($arrParams['checkbox']);
            $sql    = "DELETE FROM `$this->table` WHERE `id` IN($ids) ";
            $this->query($sql);
            Session::setSession('message', array('class' => "success", "content" => 'Bạn đã xóa thành công'));
        } else {
            Session::setSession('message', array('class' => "error", "content" => 'Vui lòng chọn vào phần tử muốn xóa'));
        }
    }

    // ADD CATEGORY 
    public function addCate($arrParams)
    {
        $userInfo    = Session::getSession("user");
        $idUser      = $userInfo['info']['id'];
        $data        = array_intersect_key($arrParams['form'], array_flip($this->_column));
        $dirFile     = UPLOAD_PATH . 'category/';
        $imagePath   = time() . basename($data['image']['name']);
        if (move_uploaded_file($data['image']['tmp_name'], $dirFile . $imagePath)) {
            $data['image'] = $imagePath;
        }
        $data['created_by'] = $idUser;
        $data['created']    = date("Y-m-d", time());
        // Kiểm tra xem có trùng tên với database không 
        $nameBook = $data['name'];
        $sql = "SELECT `id` FROM `$this->table` WHERE `name` = '$nameBook'";
        $result = $this->singleRecord($sql);
        if (!empty($result)) {
            Session::setSession('message', array("class" => "error", "content" => "Tên sách này đã tồn tại"));
        } else {
            $this->insert($data);
            Session::setSession('message', array("class" => "success", "content" => "Thêm mới thành công "));
        }
    }
}
