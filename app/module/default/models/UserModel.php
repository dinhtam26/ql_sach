<?php
class UserModel extends Model
{
    private $_column = array("id", "username", "email", "fullname", "password", "created", "created_by", "modified", "modified_by", "status", "ordering", "group_id");
    public function __construct()
    {
        parent::__construct();
        $this->setTable("user");
    }

    public function register($arrParams)
    {
        $data = array_intersect_key($arrParams, array_flip($this->_column));
        $data['group_id']   = '3';
        $data['status']     = '0';
        $this->insert($data);
        Session::setSession("message", array("class" => "success", "id" => "message-success", "content" => "Bạn vừa lập tài khoản thành công vui lòng đợi cộng tác viên duyệt"));
    }
}
