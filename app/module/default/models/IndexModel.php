<?php
class IndexModel extends Model
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
        $data['status']     = '0';
        $this->insert($data);
        Session::setSession("message", array("class" => "success", "id" => "message-success", "content" => "Bạn vừa lập tài khoản thành công vui lòng đợi cộng tác viên duyệt"));
    }

    public function infoItem($arrParams)
    {
        if (!empty($arrParams['form'])) {
            $email      = $arrParams['form']['email'];
            $password   = $arrParams['form']['password'];
            $query = "SELECT `u`.`id`, `u`.`username`, `u`.`email`, `g`.`group_acp`, `u`.`status`, `u`.`fullname`, `u`.`group_id`
                  FROM `user` AS `u` LEFT JOIN `grouper` AS `g` ON `u`.group_id = `g`.id  
                  WHERE `email` = '$email'
                  AND `password` = '$password' ";
            $result = $this->singleRecord($query);
            return $result;
        }
    }

    public function loginDefault($arrParams)
    {
        $email      = $arrParams['form']['email'];
        $password   = $arrParams['form']['password'];
        $query = "SELECT `id` FROM `user` WHERE `email` = '$email' AND `password` = '$password'";
        $result = $this->singleRecord($query);
        return $result;
    }
}
