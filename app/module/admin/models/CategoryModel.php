<?php
class CategoryModel extends Model
{
    private $_column = array("id", "name", "created", "created_by", "modified", "modified_by", "status", "ordering", "group_acp");

    // Construct (set table)
    public function __construct()
    {
        parent::__construct();
        $this->setTable("category");
    }
}
