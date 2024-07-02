<?php
class BookModel extends Model
{
    private $_column = array("id", "name", "image", "created", "created_by", "modified", "modified_by", "status", "ordering", "desc", "saleoff", "price", "quantity", "author", "cate_id");

    // Construct (set table)
    public function __construct()
    {
        parent::__construct();
        $this->setTable("book");
    }

    // LIST ITEMS
    public function listItems($arrParams, $pagination)
    {

        $sql[]  = "SELECT `b`.`id`, `b`.`name`, `b`.`image`, `b`.`desc`, `price`, `author`,`saleoff`,`quantity`, `b`.`status`, `b`.`ordering`, `c`.`name` AS `cate_id`";
        $sql[]  = "FROM `$this->table` AS `b` INNER JOIN `category` AS `c` ON `c`.id = `b`.cate_id ";

        // SEARCH 
        if (!empty($arrParams['filter_search'])) {
            $keySearch = $arrParams['filter_search'];
            $sql[]  = "AND (`b`.`name`  LIKE '%$keySearch%' OR `c`.name LIKE '%$keySearch%' )";
        }



        //  FILTER STATUS

        if (isset($arrParams['filter_status']) && $arrParams['filter_status'] != 2) {
            $status = $arrParams['filter_status'];
            $sql[]  = "AND `b`.`status` = '$status'";
        }

        // FILTER CATEGORY
        if (isset($arrParams['filter_category']) && $arrParams['filter_category'] != 'default') {
            $cate = $arrParams['filter_category'];
            $sql[]  = "AND `b`.`cate_id` = '$cate'";
        }

        // SORT
        if (!empty($arrParams['filter_column']) && !empty($arrParams['filter_column_asc'])) {
            $column             = $arrParams['filter_column'];
            $filter_asc_desc    = $arrParams['filter_column_asc'];
            $sql[] = "ORDER BY `$column` $filter_asc_desc";
        } else {
            $sql[] = "ORDER BY `id` DESC";
        }

        // // FILTER PAGINATION
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

    public function countBook($arrParams)
    {

        $sql[]  = "SELECT COUNT(`id`) AS 'total'";
        $sql[]  = "FROM `$this->table` WHERE `id` > '0'";

        // SEARCH 
        if (!empty($arrParams['filter_search'])) {
            $keySearch = $arrParams['filter_search'];
            $sql[]  = "AND (`name`  LIKE '%$keySearch%')";
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

    // changStatus (Update lại trạng thái status)
    public function changeStatusAjax($arrParams)
    {
        $userInfo   = Session::getSession("user");
        $idUser     = $userInfo['info']['id'];
        $time       = date("Y-m-d", time());
        if (!empty($arrParams)) {
            $id     = $arrParams['id'];
            $status = ($arrParams['status'] == 1) ? 0 : 1;
            $sql = "UPDATE `$this->table` SET `status` = '$status', `modified_by` = '$idUser', `modified` = '$time' WHERE `id` = '$id'";
            $this->query($sql);
            return array("id" => $id, "status" => $status, "link" => "index.php?module=admin&controller=group&action=ajaxStatus&id=$id&status=$status");
        }
    }

    public function changerOrder($arrParams)
    {
        $userInfo   = Session::getSession("user");
        $idUser     = $userInfo['info']['id'];
        $time       = date("Y-m-d", time());
        if (!empty($arrParams) && $arrParams['type'] == "changeOrder") {
            $id         = $arrParams['id'];
            $ordering   = $arrParams['value'];
            $sql = "UPDATE `$this->table` SET `ordering` = '$ordering',`modified_by`= '$idUser',`modified` = '$time'  WHERE `id` = '$id'";
            $this->query($sql);
            return array("title" => "Cập nhật thành công", "class" => "success");
        }
    }

    // CHANGE STATUS (BY CHECKBOX)
    public function changeStatus($arrParams)
    {
        $userInfo   = Session::getSession("user");
        $idUser     = $userInfo['info']['id'];
        $time       = date("Y-m-d", time());
        if (!empty($arrParams['checkbox'])) {

            $ids    = $this->createWhereDeleteSql($arrParams['checkbox']);
            $status = $arrParams['type'];
            $sql = "UPDATE `$this->table` SET `status` = '$status',`modified_by`= '$idUser',`modified` = '$time'  WHERE `id` IN ($ids)";
            $this->query($sql);
            Session::setSession('message', array('class' => "success", "content" => 'Chúc mừng bạn cập nhật thành công'));
        } else {
            Session::setSession('message', array('class' => "error", "content" => 'Vui lòng chọn vào phần tử bạn muốn thay đổi status'));
        }
    }

    public function deleteAll($arrParams)
    {
        require_once LIBS_PATH . "upload/Upload.php";
        $uploadObj = new Upload();
        if (!empty($arrParams['checkbox'])) {

            $ids    = $this->createWhereDeleteSql($arrParams['checkbox']);
            // Lấy tên hình ảnh để xóa
            $sql = "SELECT `image` FROM `$this->table` WHERE `id` IN($ids)";
            $listImg = $this->singleRecord($sql);
            foreach ($listImg as $value) {
                $uploadObj->deleteFileUpload("book", $value);
            }

            $sql = "DELETE FROM `$this->table`  WHERE `id` IN ($ids)";
            $this->query($sql);
            Session::setSession('message', array('class' => "success", "content" => 'Bạn vừa xóa thành công'));
        } else {
            Session::setSession('message', array('class' => "error", "content" => 'Vui lòng chọn vào phần tử bạn muốn xóa'));
            Helper::redirect("admin", "book", "index");
        }
    }

    public function getCategory()
    {
        $sql = "SELECT `id`, `name` FROM `category`";
        $result = $this->listRecord($sql);
        $result = array_column($result, "name", "id");
        return $result;
    }

    public function addBook($arrParams)
    {
        require_once LIBS_PATH . "upload/Upload.php";
        $uploadObj = new Upload();

        $userInfo    = Session::getSession("user");
        $idUser      = $userInfo['info']['id'];

        $data               = array_intersect_key($arrParams['form'], array_flip($this->_column));
        $data['created_by'] = $idUser;
        $data['created']    = date("Y-m-d", time());
        $data['image']      = $uploadObj->uploadFile($arrParams['form']['image'], "book");
        $this->insert($data);
        Session::setSession('message', array("class" => "success", "content" => "Thêm mới thành công "));
    }

    public function getBookById($arrParams)
    {
        $id = $arrParams['id'];
        $sql  = "SELECT `b`.`id`, `b`.`name`, `b`.`image`, `b`.`desc`, `price`, `author`,`saleoff`,`quantity`, `b`.`status`, `b`.`ordering`,  `cate_id`,
                 `b`.`created`, `b`.modified,
                 (SELECT `u`.`username`  FROM `user` AS `u` WHERE `u`.`id` = `b`.`created_by`) AS created_by,
                 (SELECT `u`.`username`  FROM `user` AS `u` WHERE `u`.`id` = `b`.`modified_by`) AS modified_by
                 FROM `$this->table` AS `b` WHERE `id` = '$id'";
        $result = $this->singleRecord($sql);
        if (!empty($result)) {
            return $result;
        } else {
            Helper::redirect("admin", "book", "index");
        }
    }

    public function editBook($arrParams)
    {

        require_once LIBS_PATH . "upload/Upload.php";
        $uploadObj = new Upload();
        $userInfo   = Session::getSession("user");
        $idUser     = $userInfo['info']['id'];
        $data        = array_intersect_key($arrParams['form'], array_flip($this->_column));

        if ($data['image']['name'] == null) {
            unset($data['image']);
        } else {
            $uploadObj->deleteFileUpload("category", $arrParams['form']['image_hidden']);
            $data['image'] = $uploadObj->uploadFile($arrParams['form']['image'], "category");
        }
        $data['modified']       = date("Y-m-d", time());
        $data['modified_by']    = $idUser;
        $ids = [['id',  $arrParams['id']]];
        $this->update($data, $ids);
        Session::setSession('message', array("class" => "success", "content" => "Update thành công"));
    }

    // DELETE CATEGORY 
    public function deleteBook($arrParams)
    {
        require_once LIBS_PATH . "upload/Upload.php";
        $uploadObj = new Upload();
        if (!empty($arrParams['id']) && $arrParams['type'] == "deleteUser") {
            $ids = $arrParams['id'];

            // Lấy tên hình ảnh để xóa
            $sql = "SELECT `image` FROM `$this->table` WHERE `id` IN($ids)";
            $listImg = $this->singleRecord($sql);
            foreach ($listImg as $value) {
                $uploadObj->deleteFileUpload("book", $value);
            }

            // Thực hiện xóa theo id
            $sql = "DELETE FROM `$this->table` WHERE `id` IN($ids)";
            $this->query($sql);
        }
    }
}
