<?php
// New
$linkNew = URL::createLink("admin", "category", "add");
$btnNew = Helper::cmsButton("New", "toolbar-popup-new", $linkNew, "icon-32-new");

// Edit
$linkEdit = URL::createLink("admin", "category", "edit", array("id" => ($this->_arrParams['id'] ?? "")));
$btnEdit = Helper::cmsButton("Edit", "toolbar-edit", $linkEdit, "icon-32-edit", "submit");

// Public
$linkPublic = URL::createLink("admin", "category", "status", array("type" => 1));
$btnPublic  = Helper::cmsButton("Public", "toolbar-publish", $linkPublic, "icon-32-publish", "submit");

// Unpublic
$linkUnPublic = URL::createLink("admin", "category", "status", array("type" => 0));
$btnUnPublic  = Helper::cmsButton("Unpublic", "toolbar-unpublish", $linkUnPublic, "icon-32-unpublish", "submit");

// Trash
$linkTrash = URL::createLink("admin", "category", "deleteAll");
$btnTrash  = Helper::cmsButton("Trash", "toolbar-trash", $linkTrash, "icon-32-trash", "submit");

// Save 
$linkSave = URL::createLink("admin", "category", "add");
$btnSave  = Helper::cmsButton("Save", "toolbar-apply", $linkSave, "icon-32-apply", "submit");

// Save & New
$linkSaveNew = URL::createLink("admin", "category", "add");
$btnSaveNew   = Helper::cmsButton("Save & New", "toolbar-save-new", $linkSaveNew, "icon-32-save-new", "submit");
// Save & Close
$linkSaveClose = URL::createLink("admin", "category", "add");
$btnSaveClose   = Helper::cmsButton("Save & Close", "toolbar-save", $linkSaveClose, "icon-32-save", "submit");

// Cancel
$linkCancel = URL::createLink("admin", "category", "index");
$btnCancel   = Helper::cmsButton("Cancel", "toolbar-cancel", $linkCancel, "icon-32-cancel");
