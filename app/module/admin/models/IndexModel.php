<?php
class IndexModel extends Model
{
    public function __construct()
    {
        parent::__construct();

        $this->setTable("user");
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

    public function getUserById($id)
    {
        $sql    = "SELECT `username`, `email`, `fullname` FROM `user` WHERE `id` = '$id'";
        $result = $this->singleRecord($sql);
        return $result;
    }

    public function loginAdmin($arrParams)
    {
        $email      = $arrParams['form']['email'];
        $password   = $arrParams['form']['password'];
        $query = "SELECT `id` FROM `user` WHERE `email` = '$email' AND `password` = '$password'";
        $result = $this->singleRecord($query);
        return $result;
    }

    public function editProfile($arrParam)
    {

        $id = [['id',  $arrParam['id']]];
        $this->update($arrParam['form'], $id);
        Session::setSession('message', array("class" => "success", "content" => "Cập nhật thành công"));
    }
}
