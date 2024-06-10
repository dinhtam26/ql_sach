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
        $sql[] = "SELECT `u`.id,`username`, `email`, `fullname`, `u`.`status`, `u`.`ordering`, `u`.`created`,`u`.`created_by`, `u`.`modified`, `u`.`modified_by`, `g`.name AS 'group_name'";
        $sql[] = "FROM `$this->table` AS `u`, `grouper` AS `g` ";
        $sql[] = " WHERE `u`.group_id =  `g`.id";


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
    public function addUser($arrParams)
    {
        if (!empty($arrParams['form']) && ($arrParams['form']['token'] > 0)) {
            $data               = $arrParams['form'];
            $data['created']    = date("Y-m-d", time());
            $data['created_by']     = 2;

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
    public function updateUser($arrParams)
    {
        if (!empty($arrParams['form']) && ($arrParams['form']['token'] > 0)) {
            $data               = $arrParams['form'];
            $data['modified']    = date("Y-m-d", time());
            $data['created_by']     = 3;
            $ids = [['id',  $arrParams['id']]];
            $data = array_intersect_key($data, array_flip($this->_column));
            $this->update($data, $ids);
            Session::setSession('message', array("class" => "success", "content" => "Cập nhật thành công"));
        }
    }
}
