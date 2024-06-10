<?php

$columnPost = $this->_arrParams['filter_column'] ?? "name";
$orderPost  = $this->_arrParams['filter_column_asc'] ?? "asc";
$lbName         = Helper::linkSort("Name", "name", $columnPost, $orderPost);
$lbStatus       = Helper::linkSort("Status", "status", $columnPost, $orderPost);
$lbGroup_acp    = Helper::linkSort("Group ACP", "group_acp", $columnPost, $orderPost);
$lbOrdering     = Helper::linkSort("Ordering", "ordering", $columnPost, $orderPost);
$lbCreated      = Helper::linkSort("Created", "created", $columnPost, $orderPost);
$lbCreatedBy    = Helper::linkSort("Created_By", "created_by", $columnPost, $orderPost);
$lbModified     = Helper::linkSort("Modified", "modified", $columnPost, $orderPost);
$lbModifiedBy   = Helper::linkSort("Modified_By", "modified_by", $columnPost, $orderPost);
$lbID           = Helper::linkSort("ID", "id", $columnPost, $orderPost);

// SELECT 
$arrStatus       = [2 => "- Select Status -", 0 => "Unpublish", 1 => "Public"];
$selectBoxStatus = Helper::cmsSelectBox("filter_status", "inputbox", $arrStatus, $this->_arrParams['filter_status'] ?? "");


$arrPagination       = ['default' => "Select Pagination", "5" => 5, "10" => 10, "50" => 50];
$selectPagination = Helper::cmsSelectBox("filter_page", "inputbox", $arrPagination, $this->_arrParams['filter_page'] ?? "");
// PAGINATION
$paginationXHTML = "";
if ($this->pagination->totalItemPerPage > $this->pagination->totalItems) {
    $paginationXHTML = "";
} else {
    $paginationXHTML = $this->pagination->showPagination();
}


// MESSAGE
$message = Session::getSession("message");
Session::deleteSession("message");
$strMess = '';

if (!empty($message)) {

    $strMess .= '<dl id="system-message">
                    <dt class="' . $message['class'] . '">' . ucfirst($message['class']) . '</dt>
                    <dd class="' . $message['class'] . ' message">
                        <ul>
                            <li>' . $message['content'] . '</li>
                        </ul>
                    </dd>
                </dl>';
}
?>
<div id="toolbar-box">
    <div class="m">
        <!-- TOOLBAR -->
        <?php include_once "toolbar/index.php" ?>
        <!-- TITLE -->
        <div class="pagetitle icon-48-groups">
            <h2><?= $this->_title ?></h2>
        </div>
    </div>
</div>

<?php include_once "submenu/index.php" ?>

<div id="system-message-container">
    <?= $strMess ?>
</div>

<div id="element-box">
    <div class="m">
        <form action="#" method="post" name="adminForm" id="adminForm">
            <!-- FILTER -->
            <fieldset id="filter-bar">
                <div class="filter-search fltlft">
                    <label class="filter-search-lbl" for="filter_search">Filter:</label>
                    <input type="text" name="filter_search" id="filter_search" value="<?= $this->_arrParams['filter_search'] ?? "" ?>">
                    <button type="submit" name="search-kw">Search</button>
                    <button type="button" name="clear-kw">Clear</button>
                </div>
                <div class="filter-select fltrt">
                    <?= $selectBoxStatus ?>
                    <?= $selectPagination ?>
                </div>
            </fieldset>
            <div class="clr"></div>

            <table class="adminlist" id="modules-mgr">
                <!-- HEADER TABLE -->
                <thead>
                    <tr>
                        <th width="1%">
                            <input type="checkbox" name="checkall-toggle" id="check-all">
                        </th>
                        <th class="title"><?= $lbName ?></th>
                        <th width="10%"><?= $lbStatus ?></th>
                        <th width="10%" class="left"><?= $lbGroup_acp  ?></th>
                        <th width="10%"><?= $lbOrdering  ?></th>
                        <th width="10%" class="left"><?= $lbCreated ?></th>
                        <th width="10%"><?= $lbCreatedBy ?></th>
                        <th width="10%"><?= $lbModified ?></th>
                        <th width="10%"><?= $lbModifiedBy ?></th>
                        <th width="1%" class="nowrap"><?= $lbID ?></th>
                    </tr>
                </thead>

                <!-- BODY TABLE -->
                <tbody>
                    <?php
                    if (!empty($this->data)) {
                        $i = 0;
                        foreach ($this->data as $item) {

                            $className = ($i % 2 == 0) ? "row0" : "row1";
                            $id             = $item['id'];
                            $name           = $item['name'];

                            $created = Helper::cmsFormatDate($item['created']);
                            $modified = Helper::cmsFormatDate($item['modified']);


                            $linkAjaxStatus = URL::createLink("admin", "group", "ajaxStatus", array("id" => $id, "status" => $item['status']));
                            $status         = Helper::cmsStatus($item['status'], $linkAjaxStatus, $id);

                            $linkGroupACP   = URL::createLink("admin", "group", "ajaxGroup", array("id" => $id, "group" => $item['group_acp']));
                            $group_acp      = Helper::cmsGroupACP($item['group_acp'], $linkGroupACP, $id);

                            $linkEdit       = URL::createLink("admin", "group", "edit", array("id" => $id));
                    ?>
                            <tr class="<?= $className ?>">
                                <td class="center">
                                    <input type="checkbox" name="checkbox[]" value="<?= $id  ?>">
                                </td>
                                <td class="center"><a href="<?= $linkEdit ?> "><?= $name ?></a></td>
                                <td class="center"> <?= $status ?> </td>
                                <td class="left"><?= $group_acp ?></td>
                                <td class="order">
                                    <input type="text" name="order" id="<?= $id  ?>" value="<?= $item['ordering'] ?>" class="text-area-order">
                                </td>
                                <td class="center"><?= $created ?></td>
                                <td class="center"><?= $item['created_by'] ?></td>
                                <td class="center"><?= $modified ?></td>
                                <td class="center"><?= $item['modified_by'] ?></td>
                                <td class="center"><?= $id  ?></td>
                            </tr>

                    <?php
                            $i++;
                        }
                    }
                    ?>
                </tbody>

                <!-- FOOTER TABLE -->
                <tfoot>
                    <tr>
                        <td colspan="10">
                            <!-- PAGINATION -->
                            <div class="container">
                                <div class="pagination">
                                    <?= $paginationXHTML ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>

            <div>
                <input type="hidden" name="filter_column" value="id">
                <input type="hidden" name="filter_column_asc" value="desc">
                <input type="hidden" name="filter_pagination" value="1">

            </div>
        </form>

        <div class="clr"></div>
    </div>
</div>

<?php
// echo "<pre/>";
// print_r($this);
// echo "<pre/>";
// echo $this->pagination->totalItems;
// echo "<pre/>";
// print_r($message);
// echo "<pre/>";
