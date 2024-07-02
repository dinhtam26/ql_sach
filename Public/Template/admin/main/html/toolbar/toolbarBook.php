<?php
// New
$linkNew = URL::createLink("admin", "book", "add");
$btnNew = Helper::cmsButton("New", "toolbar-popup-new", $linkNew, "icon-32-new");

// Edit
$linkEdit = URL::createLink("admin", "book", "edit", array("id" => ($this->_arrParams['id'] ?? "")));
$btnEdit = Helper::cmsButton("Edit", "toolbar-edit", $linkEdit, "icon-32-edit", "submit");

// Public
$linkPublic = URL::createLink("admin", "book", "status", array("type" => 1));
$btnPublic  = Helper::cmsButton("Public", "toolbar-publish", $linkPublic, "icon-32-publish", "submit");

// Unpublic
$linkUnPublic = URL::createLink("admin", "book", "status", array("type" => 0));
$btnUnPublic  = Helper::cmsButton("Unpublic", "toolbar-unpublish", $linkUnPublic, "icon-32-unpublish", "submit");

// Trash
$linkTrash = URL::createLink("admin", "book", "deleteAll");
$btnTrash  = Helper::cmsButton("Trash", "toolbar-trash", $linkTrash, "icon-32-trash", "submit");

// Save 
$linkSave = URL::createLink("admin", "book", "add");
$btnSave  = Helper::cmsButton("Save", "toolbar-apply", $linkSave, "icon-32-apply", "submit");

// Save & New
$linkSaveNew = URL::createLink("admin", "book", "add");
$btnSaveNew   = Helper::cmsButton("Save & New", "toolbar-save-new", $linkSaveNew, "icon-32-save-new", "submit");
// Save & Close
$linkSaveClose = URL::createLink("admin", "book", "add");
$btnSaveClose   = Helper::cmsButton("Save & Close", "toolbar-save", $linkSaveClose, "icon-32-save", "submit");

// Cancel
$linkCancel = URL::createLink("admin", "book", "index");
$btnCancel   = Helper::cmsButton("Cancel", "toolbar-cancel", $linkCancel, "icon-32-cancel");
