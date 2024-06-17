<?php
class CategoryModel extends Model
{
    private $_column = array("id", "username", "email", "fullname", "password", "created", "created_by", "modified", "modified_by", "status", "ordering", "group_id");
    public function __construct()
    {
        parent::__construct();
        $this->setTable("user");
    }
}
