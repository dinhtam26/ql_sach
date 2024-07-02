<?php
class CategoryModel extends Model
{
    private $_column = array("id", "username", "email", "fullname", "password", "created", "created_by", "modified", "modified_by", "status", "ordering", "group_id");
    public function __construct()
    {
        parent::__construct();
        $this->setTable("category");
    }

    public function listItems($arrParams, $pagination)
    {

        $sql[]  = "SELECT `id`, `name`, `image`";
        $sql[]  = "FROM `$this->table`  WHERE `status` = '1'";

        // SEARCH 
        // if (!empty($arrParams['filter_search'])) {
        //     $keySearch = $arrParams['filter_search'];
        //     $sql[]  = "AND `name` LIKE '%$keySearch%'";
        // }

        $sql[] = "ORDER BY `ordering` ASC";


        // FILTER PAGINATION
        $position         = ($pagination['currentPage'] - 1) * $pagination['totalItemPerPage'];
        $totalItemPerPage = $pagination['totalItemPerPage'];

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
}
