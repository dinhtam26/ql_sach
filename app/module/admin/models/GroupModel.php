<?php
class GroupModel extends Model
{
    private $_column = array("id", "name", "created", "created_by", "modified", "modified_by", "status", "ordering", "group_acp");



    // Construct (set table)
    public function __construct()
    {
        parent::__construct();
        $this->setTable("grouper");
    }

    // ListItem (Hiển thị danh sách group)
    public function listItem($arrayParams, $pagination)
    {
        $sql[] = "SELECT `id`, `name`, `created`, `created_by`, `modified`,`modified_by`, `status`, `ordering`, `group_acp` FROM `$this->table`";

        $flag = false;
        // SEARCH
        if (!empty($arrayParams['filter_search'])) {
            $keySearch = $arrayParams['filter_search'];
            $sql[] = "WHERE `name` LIKE '%$keySearch%' ";
            $flag = true;
        }

        // FILTER STATUS
        if (isset($arrayParams['filter_status']) && $arrayParams['filter_status'] != 2) {
            $keyStatus = $arrayParams['filter_status'];
            if ($flag == true) {
                $sql[] = "AND `status` = '$keyStatus' ";
            } else {
                $sql[] = "WHERE `status` = '$keyStatus' ";
            }
        }

        // SORT
        if (!empty($arrayParams['filter_column']) && !empty($arrayParams['filter_column_asc'])) {
            $column             = $arrayParams['filter_column'];
            $filter_asc_desc    = $arrayParams['filter_column_asc'];
            $sql[] = "ORDER BY `$column` $filter_asc_desc";
        } else {
            $sql[] = "ORDER BY `id` DESC";
        }

        // PAGINATION

        $position         = ($pagination['currentPage'] - 1) * $pagination['totalItemPerPage'];
        $totalItemPerPage = $pagination['totalItemPerPage'];
        if (!empty($arrayParams['filter_page'])) {
            if (is_numeric($arrayParams['filter_page'])) {
                $totalItemPerPage  = $arrayParams['filter_page'];
            } else {
                $totalItemPerPage = $pagination['totalItemPerPage'];
            }
        }




        $sql[] = "LIMIT $position ,  $totalItemPerPage";

        $query = implode(" ", $sql);
        $result = $this->listRecord($query);
        return $result;
    }

    // countItem (Hiển thị danh sách group)
    public function countItem($arrayParams)
    {

        $sql[] = "SELECT COUNT(`id`) AS 'total' FROM `$this->table`";
        $flag = false;
        // SEARCH
        if (!empty($arrayParams['filter_search'])) {
            $keySearch = $arrayParams['filter_search'];
            $sql[] = "WHERE `name` LIKE '%$keySearch%' ";
            $flag = true;
        }

        // FILTER STATUS
        if (isset($arrayParams['filter_status']) && $arrayParams['filter_status'] != 2) {
            $keyStatus = $arrayParams['filter_status'];
            if ($flag == true) {
                $sql[] = "AND `status` = '$keyStatus' ";
            } else {
                $sql[] = "WHERE `status` = '$keyStatus' ";
            }
        }


        $query = implode(" ", $sql);

        $result = $this->singleRecord($query);
        return $result['total'];
    }

    // changStatus (Update lại trạng thái status)
    public function changStatus($arrParams)
    {
        if (!empty($arrParams)) {
            $id     = $arrParams['id'];
            $status = ($arrParams['status'] == 1) ? 0 : 1;
            $sql = "UPDATE `$this->table` SET `status` = '$status' WHERE `id` = '$id'";
            $this->query($sql);
            return array("id" => $id, "status" => $status, "link" => "index.php?module=admin&controller=group&action=ajaxStatus&id=$id&status=$status");
        }
    }

    // changeGroupACP (Update lại trạng thái của group_acp)
    public function changeGroupACP($arrParams)
    {
        if (!empty($arrParams)) {
            $id     = $arrParams['id'];
            $group = ($arrParams['group'] == 1) ? 0 : 1;
            $sql = "UPDATE `$this->table` SET `group_acp` = '$group' WHERE `id` = '$id'";
            $this->query($sql);
            Session::setSession('message', array('class' => "success", "content" => 'Cập nhật status thành công'));
            return array("id" => $id, "group" => $group, "link" => "index.php?module=admin&controller=group&action=ajaxGroup&id=$id&group=$group");
        }
    }

    // changeAllStatus (Thay đổi nhiều status)
    public function changeAllStatus($arrParams)
    {
        if (!empty($arrParams['checkbox'])) {
            $status = $arrParams['type'];
            $ids    = $this->createWhereDeleteSql($arrParams['checkbox']);
            $sql = "UPDATE `$this->table` SET `status` = '$status' WHERE `id` IN($ids)";
            $this->query($sql);
            Session::setSession('message', array('class' => "success", "content" => 'Cập nhật status thành công'));
        } else {
            Session::setSession('message', array('class' => "error", "content" => 'Vui lòng chọn vào phần tử muốn thay đổi trạng thái'));
        }
    }

    // Xóa 1 hoặc nhiều group theo checkbox
    public function deleteGroup($arrParams)
    {
        if (!empty($arrParams['checkbox'])) {
            $ids = $this->createWhereDeleteSql($arrParams['checkbox']);
            echo $sql = "DELETE FROM `$this->table` WHERE `id` IN($ids)";
            $this->query($sql);
            Session::setSession('message', array('class' => "success", "content" => 'Xóa phần tử thành công thành công'));
        } else {
            Session::setSession('message', array('class' => "error", "content" => 'Vui lòng chọn vào phần tử muốn xóa'));
        }
    }

    // 
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

    // Thêm mới group
    public function addGroup($arrParams)
    {
        if (!empty($arrParams['form']) && $arrParams['form']['token'] > 0) {
            $data = array_intersect_key($arrParams['form'], array_flip($this->_column));
            $data['created']    = date("Y-m-d", time());
            $data['created_by'] = 1;
            $this->insert($data);
            Session::setSession('message', array('class' => "success", "content" => 'Đã thêm thành công'));
        }
    }

    // Lấy sản phẩm theo ID
    public function getOneItem($id)
    {
        if (isset($id)) {
            $sql    =  "SELECT `id`, `name`, `created`, `created_by`, `modified`,`modified_by`, `status`, `ordering`, `group_acp` 
                        FROM `$this->table` WHERE `id` = '$id'";
            $result =   $this->singleRecord($sql);
        }
        return $result;
    }

    // Update Group
    public function updateGroup($arrParams)
    {
        if (!empty($arrParams['form']) && $arrParams['form']['token'] > 0) {
            $data = array_intersect_key($arrParams['form'], array_flip($this->_column));
            $data['modified']    = date("Y-m-d", time());
            $data['modified_by'] = 10;
            $ids = [['id',  $arrParams['form']['id']]];
            $this->update($data,  $ids);
            Session::setSession('message', array('class' => "success", "content" => 'Cập nhật thành công thành công'));
        }
    }
}
