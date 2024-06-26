<?php
class UserModel extends Model
{
    private $_column = array("username", "email", "password", "fullname", "status", "ordering", "created", "created_by", "modified", "modified_by", "group_id");
    public function __construct()
    {
        parent::__construct();
        $this->setTable("user");
    }

    // LIST USER
    public function listUser($arrParams, $pagination)
    {
        $sql[] = "SELECT `u`.id,`u`.`username`, `u`.`email`, `u`.`fullname`, `u`.`status`, `u`.`ordering`, `u`.`created`,
                 (SELECT `us`.username FROM `user` AS `us` WHERE `u`.created_by = `us`.id)  AS 'created_by',
                 `u`.`modified`,
                 (SELECT `us`.username FROM `user` AS `us` WHERE `u`.modified_by = `us`.id)  AS 'modified_by',
                 `g`.name AS 'group_name'";
        $sql[] = "FROM `$this->table` AS `u`, `grouper` AS `g`";
        $sql[] = " WHERE `u`.group_id =  `g`.id ";


        // SEARCH
        if (!empty($arrParams['filter_search'])) {
            $keyWord    = $arrParams['filter_search'];
            $sql[]      = "AND (`u`.username  LIKE  '%$keyWord%' OR `u`.email  LIKE  '%$keyWord%' )";
        }

        // FILTER STATUS
        if (isset($arrParams['filter_status']) && $arrParams['filter_status'] != "default") {
            $status     = $arrParams['filter_status'];
            $sql[]      = "AND `u`.`status` = '$status'";
        }

        // FILTER GROUP
        if (!empty($arrParams['filter_group']) && $arrParams['filter_group'] != "default") {
            $groupId = $arrParams['filter_group'];
            $sql[]      = "AND `u`.`group_id` = '$groupId'";

            // die("dừng");
        }

        // SORT LIST (Sắp xếp danh sách)
        if (!empty($arrParams['filter_column']) && !empty($arrParams['filter_column_asc'])) {
            $column             = $arrParams['filter_column'];
            $filter_asc_dec     = $arrParams['filter_column_asc'];
            $sql[] = "ORDER BY $column $filter_asc_dec";
        }

        // FILTER PAGINATION
        $position         = ($pagination['currentPage'] - 1) * $pagination['totalItemPerPage'];
        $totalItemPerPage = $pagination['totalItemPerPage'];
        if (!empty($arrParams['filter_page']) && $arrParams['filter_page'] != "default") {
            $totalItemPerPage   = $arrParams['filter_page'];
        }
        $sql[] = "LIMIT $position ,  $totalItemPerPage";





        $sql = implode(" ", $sql);
        // die("Dừng");


        $result = $this->listRecord($sql);
        return $result;
    }

    // COUNT USER
    public function countUser($arrParams)
    {
        $sql[] = "SELECT COUNT(`u`.`id`) AS 'total'";
        $sql[] = "FROM `$this->table` AS `u`";
        $sql[] = " WHERE `u`.`id` > 0";


        // SEARCH
        if (!empty($arrParams['filter_search'])) {
            $keyWord    = $arrParams['filter_search'];
            $sql[]      = "AND (`u`.username  LIKE  '%$keyWord%' OR `u`.email  LIKE  '%$keyWord%' )";
        }

        // FILTER STATUS
        if (isset($arrParams['filter_status']) && $arrParams['filter_status'] != "default") {
            $status     = $arrParams['filter_status'];
            $sql[]      = "AND `u`.`status` = '$status'";
        }

        // FILTER GROUP
        if (!empty($arrParams['filter_group']) && $arrParams['filter_group'] != "default") {
            $groupId = $arrParams['filter_group'];
            $sql[]      = "AND `u`.`group_id` = '$groupId'";

            // die("dừng");
        }

        // FILTER PAGINATION
        if (!empty($arrParams['filter_page']) && $arrParams['filter_page'] != "default") {
            $totalItemPerPage   = $arrParams['filter_page'];
        }




        $sql = implode(" ", $sql);
        // die("Dừng");


        $result = $this->singleRecord($sql);
        return $result['total'];
    }

    // GET ID & GROUP_NAME
    public function getGroupName($arrParams)
    {
        $sql = "SELECT `id`, `name` 
                FROM `grouper`";
        $result = $this->listRecord($sql);
        return $result;
    }

    // CHANGE STATUS (CHECK BOX)
    public function changeAllStatus($arrParams)
    {
        if (!empty($arrParams['checkbox'])) {
            $ids = $this->createWhereDeleteSql($arrParams['checkbox']);
            $status = $arrParams['type'];
            $sql = "UPDATE $this->table SET `status` = '$status' WHERE `id` IN($ids)";
            $this->query($sql);
        }
    }

    // CHANGE STATUS ONE
    public function changeOneStatus($arrParams)
    {

        if ($arrParams['type'] == "changStatus") {
            $id     = $arrParams['id'];
            $status =   ($arrParams['status'] == 1) ? 0 : 1;
            $sql    = "UPDATE `$this->table` SET `status` = '$status' WHERE `id` = '$id'";
            $this->query($sql);
            return array("id" => $id, "status" => $status, "url" => URL::createLink("admin", "user", "changeStatus", array("id" => $id, "status" => $status)));
        }
    }

    // CHANG ORDERING
    public function changerOrder($arrParams)
    {
        if (!empty($arrParams) && $arrParams['type'] == "changeOrder") {
            $id         = $arrParams['id'];
            $ordering   = $arrParams['value'];
            $sql = "UPDATE `$this->table` SET `ordering` = '$ordering' WHERE `id` = '$id'";
            $this->query($sql);
            return array("title" => "Cập nhật thành công", "class" => "success");
        }
    }

    // ADD USER
    public function addUser($arrParams, $userInfo)
    {

        if (!empty($arrParams['form']) && ($arrParams['form']['token'] > 0)) {
            $data               = $arrParams['form'];
            $data['created']    = date("Y-m-d", time());
            $data['created_by'] = $userInfo['id'];
            $data = array_intersect_key($data, array_flip($this->_column));
            $this->insert($data);
            Session::setSession('message', array("class" => "success", "content" => "Thêm mới thành công 1 user"));
        }
    }

    // GET ONE USER BY ID
    public function getOneUser($arrParams)
    {
        if (!empty($arrParams['id'])) {
            $id = $arrParams['id'];
            $sql = "SELECT `id`, `username`, `email`, `password`, `fullname`, `status`, `group_id`, `ordering`
                    FROM $this->table 
                    WHERE `id` = '$id'";
            $result = $this->singleRecord($sql);
            return $result;
        }
    }

    // UPDATE USER
    public function updateUser($arrParams, $userInfo)
    {
        if (!empty($arrParams['form']) && ($arrParams['form']['token'] > 0)) {
            $data               = $arrParams['form'];
            $data['modified']    = date("Y-m-d", time());
            $data['modified_by']     = $userInfo['id'];
            $ids = [['id',  $arrParams['id']]];
            $data = array_intersect_key($data, array_flip($this->_column));
            $this->update($data, $ids);
            Session::setSession('message', array("class" => "success", "content" => "Cập nhật thành công"));
        }
    }

    public function deleteUser($arrParams)
    {
        if (!empty($arrParams['id']) && $arrParams['type'] == "deleteUser") {
            $ids = $arrParams['id'];
            $sql = "DELETE FROM `$this->table` WHERE `id` IN($ids)";
            $this->query($sql);
        }
    }

    public function deleteAllUser($arrParams)
    {
        if (!empty($arrParams['checkbox'])) {

            $ids = $arrParams['checkbox'];
            $ids = $this->createWhereDeleteSql($ids);
            $sql = "DELETE FROM `$this->table` WHERE `id` IN($ids)";
            $this->query($sql);
            Session::setSession("message", array("class" => "success", "content" => "Xóa thành công"));
        } else {
            Session::setSession("message", array("class" => "error", "content" => "Vui lòng chọn phần tử muốn xóa"));
        }
    }

    // LẤY TÊN NGƯỜI SỬA VÀ NGƯỜI THÊM THEO ID
    public function getNameByCreatedBy($arrParams)
    {

        $created = $this->createWhereDeleteSql($arrParams);
        echo $sql = "SELECT  `u`.username AS 'created_by' FROM `$this->table` AS `u` WHERE `id` IN($created) ";
        $result = $this->listRecord($sql);
        return $result;
    }
}
