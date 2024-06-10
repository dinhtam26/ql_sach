<?php
class UserController extends Controller
{
    public function indexAction()
    {
        echo "<h3>" . __METHOD__ . "</h3>";
        $this->setModel("admin", "index");
        $this->_model->listItem();
    }

    public function addAction()
    {
        echo "<h3>" . __METHOD__ . "</h3>";
    }
}
