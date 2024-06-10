<?php
// echo "<pre/>";
// print_r($this);
// echo "<pre/>";
// New
$linkNew = URL::createLink("admin", "group", "add");
$btnNew = Helper::cmsButton("New", "toolbar-popup-new", $linkNew, "icon-32-new");

// Edit
$linkEdit = URL::createLink("admin", "group", "edit", array("id" => ($this->_arrParams['id'] ?? "")));
$btnEdit = Helper::cmsButton("Edit", "toolbar-edit", $linkEdit, "icon-32-edit", "submit");

// Public
$linkPublic = URL::createLink("admin", "group", "status", array("type" => 1));
$btnPublic  = Helper::cmsButton("Public", "toolbar-publish", $linkPublic, "icon-32-publish", "submit");

// Unpublic
$linkUnPublic = URL::createLink("admin", "group", "status", array("type" => 0));
$btnUnPublic  = Helper::cmsButton("Unpublic", "toolbar-unpublish", $linkUnPublic, "icon-32-unpublish", "submit");

// Trash
$linkTrash = URL::createLink("admin", "group", "delete");
$btnTrash  = Helper::cmsButton("Trash", "toolbar-trash", $linkTrash, "icon-32-trash", "submit");

// Save 
$linkSave = URL::createLink("admin", "group", "add");
$btnSave  = Helper::cmsButton("Save", "toolbar-apply", $linkSave, "icon-32-apply", "submit");

// Save & New
$linkSaveNew = URL::createLink("admin", "group", "add");
$btnSaveNew   = Helper::cmsButton("Save & New", "toolbar-save-new", $linkSaveNew, "icon-32-save-new", "submit");
// Save & Close
$linkSaveClose = URL::createLink("admin", "group", "add");
$btnSaveClose   = Helper::cmsButton("Save & Close", "toolbar-save", $linkSaveClose, "icon-32-save", "submit");

// Cancel
$linkCancel = URL::createLink("admin", "group", "index");
$btnCancel   = Helper::cmsButton("Cancel", "toolbar-cancel", $linkCancel, "icon-32-cancel");

switch ($this->_arrParams['action']) {
    case 'index':
        $strButton = $btnNew .  $btnPublic . $btnUnPublic . $btnTrash;
        break;
    case 'add':
        $strButton = $btnSave . $btnSaveNew . $btnSaveClose . $btnCancel;
        break;
    case 'edit':
        $strButton = $btnEdit . $btnCancel;
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