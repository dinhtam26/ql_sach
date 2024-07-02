<?php
switch ($this->_arrParams['controller']) {
    case 'index':
        $strButton = "";
        break;
    case 'user':
        require_once "toolbarUser.php";
        switch ($this->_arrParams['action']) {
            case 'index':
                $strButton = $btnNew .  $btnPublic . $btnUnPublic . $btnTrash;
                break;
            case 'add':
                $strButton = $btnSave .  $btnCancel;
                break;
            case 'edit':
                $strButton = $btnEdit . $btnCancel;
                break;
        }
        break;
    case 'group':
        require_once "toolbarGroup.php";
        switch ($this->_arrParams['action']) {
            case 'index':
                $strButton = $btnNew .  $btnPublic . $btnUnPublic . $btnTrash;
                break;
            case 'add':
                $strButton = $btnSave .  $btnCancel;
                break;
            case 'edit':
                $strButton = $btnEdit . $btnCancel;
                break;
        }
        break;
    case 'category':
        require_once "toolbarCate.php";
        switch ($this->_arrParams['action']) {
            case 'index':
                $strButton = $btnNew  . $btnPublic . $btnUnPublic . $btnTrash;
                break;
            case 'add':
                $strButton = $btnSave .  $btnCancel;
                break;
            case 'edit':
                $strButton = $btnEdit . $btnCancel;
                break;
        }
        break;
    case 'book':
        require_once "toolbarBook.php";
        switch ($this->_arrParams['action']) {
            case 'index':
                $strButton = $btnNew  . $btnPublic . $btnUnPublic . $btnTrash;
                break;
            case 'add':
                $strButton = $btnSave .  $btnCancel;
                break;
            case 'edit':
                $strButton = $btnEdit . $btnCancel;
                break;
            case 'detail':
                $strButton = $btnCancel;
                break;
        }
        break;
}
?>
<div class="toolbar-list" id="toolbar">
    <ul>
        <?php
        echo $strButton;
        ?>
    </ul>
    <div class="clr"></div>
</div>