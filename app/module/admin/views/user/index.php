<?php
$arrStatus  = array("default" => "- Select Status -", "0" => "unpublish", "1" => "public");
$status     = Helper::cmsSelectBox("filter_status", "inputbox", $arrStatus, $this->_arrParams['filter_status'] ?? "");

$arrPagination        = array("default" => "- Select Pagination -", "5" => "5", "10" => "10", "20" => "20", "50" => "50");
$paginationSelect     = Helper::cmsSelectBox("filter_page", "inputbox", $arrPagination, $this->_arrParams['filter_page'] ?? "");


if (!empty([$this->data['listGroupName']])) {
    $arrGroup   = array_column($this->data['listGroupName'], "name", "id");
    $arrGroup['default']    = "- Select Group - ";
    krsort($arrGroup);

    $groupSelect    = Helper::cmsSelectBox("filter_group", "inputbox", $arrGroup, $this->_arrParams['filter_group'] ?? "");
}
$pagination = $this->pagination->showPagination();

// MESSAGE ERROR OR SUCCESS
$message = Session::getSession("message");
Session::deleteSession("message");
$strMess  = '';
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

// MESSAGE PERMISSION
$messagePer = Session::getSession("permission");
Session::deleteSession("permission");
$strMess  = '';
if (!empty($messagePer)) {

    $strMess .= '<dl id="system-message">
                    <dt class="error">Error</dt>
                    <dd class="error message">
                        <ul>
                            <li>' . $messagePer . '</li>
                        </ul>
                    </dd>
                </dl>';
}
$columnPost = $this->_arrParams['filter_column'] ?? "id";
$orderPost  = $this->_arrParams['filter_column_asc'] ?? "desc";

$lblID    = Helper::linkSort("ID", "id", $columnPost, $orderPost);
$lblUserName    = Helper::linkSort("Username", "username", $columnPost, $orderPost);
$lblEmail       = Helper::linkSort("Email", "email", $columnPost, $orderPost);
$lblFullName    = Helper::linkSort("FullName", "fullname", $columnPost, $orderPost);
$lblStatus      = Helper::linkSort("Status", "status", $columnPost, $orderPost);
$lblOrdering    = Helper::linkSort("Ordering", "ordering", $columnPost, $orderPost);
$lblCreated     = Helper::linkSort("Created", "created", $columnPost, $orderPost);
$lblCreated_by  = Helper::linkSort("Created_by", "created_by", $columnPost, $orderPost);
$lblModified    = Helper::linkSort("Modified ", "modified ", $columnPost, $orderPost);
$lblModified_by = Helper::linkSort("Modified_by", "modified_by", $columnPost, $orderPost);
$lblID          = Helper::linkSort("ID", "id", $columnPost, $orderPost);
$GroupName      = Helper::linkSort("GroupName", "group_id", $columnPost, $orderPost);



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
<div id="dialog-confirm" title="Thông báo" style="display: none">
    <p> Bạn có chắc muốn xóa không</p>
</div>
<div id="system-message-container">
    <?= $strMess ?>
</div>
<!-- CONTENT -->
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
                    <!-- SELECT STATUS -->
                    <?= $status ?>
                    <!-- SELECT PAGINATION -->
                    <?= $paginationSelect  ?>
                    <!-- SELECT group -->
                    <?= $groupSelect  ?>
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
                        <th class="title">
                            <?= $lblID ?>
                        </th>
                        <th class="title">
                            <?= $lblUserName ?>
                        </th>
                        <th class="title">
                            <?= $lblEmail ?>
                        </th>
                        <th class="title">
                            <?= $lblFullName ?>
                        </th>
                        <th width="6%">
                            <?= $lblStatus ?>
                        </th>
                        <th width="6%">
                            <?= $lblOrdering ?>
                        </th>
                        <th width="8%">
                            <?= $lblCreated ?>
                        </th>
                        <th width="10%">
                            <?= $lblCreated_by ?>
                        </th>
                        <th width="8%">
                            <?= $lblModified ?>
                        </th>
                        <th width="10%">
                            <?= $lblModified_by ?>
                        </th>
                        <th width="10%">
                            <?= $GroupName  ?>
                        </th>
                        <th width="10%">
                            <span>Action</span>
                        </th>

                    </tr>
                </thead>

                <!-- BODY TABLE -->
                <tbody>
                    <?php
                    if (!empty($this->data['listUser'])) {
                        $classStatus = "";
                        foreach ($this->data['listUser'] as $key => $value) {
                            $id         = $value['id'];
                            $username   = $value['username'];
                            $email      = $value['email'];
                            $fullName   = $value['fullname'];
                            $status     = ($value['status'] == 1 ? $classStatus = "publish" : $classStatus = "unpublish");
                            $ordering   = $value['ordering'];
                            $created    = Helper::cmsFormatDate($value['created']);
                            $create_by  = $value['created_by'];
                            $modified   = Helper::cmsFormatDate($value['modified']);
                            $modified_by = $value['modified_by'];
                            $groupName  = $value['group_name'];

                            $linkDelete = URL::createLink("admin", "user", "delete", array("id" => $id));
                            $delete = 'javascript:deleteUser(\' ' . $linkDelete . ' \', ' . $id . ')';
                            $linkUpdate = URL::createLink("admin", "user", "edit", array("id" => $id));
                    ?>
                            <tr class="row0" id="item-<?= $id ?>">
                                <td class="center">
                                    <input type="checkbox" name="checkbox[]" value="<?= $id ?>">
                                </td>
                                <td class="center"><a href="#"><?= $id ?></a></td>
                                <td class="center"><a href="#"><?= $username ?></a></td>
                                <td class="center"><a href="#"><?= $email ?></a></td>
                                <td class="center"><a href="#"><?= $fullName ?></a></td>
                                <td class="center">
                                    <a class="jgrid hasTip" id="status-<?= $id ?>" href="javascript:changStatusUser('<?= URL::createLink("admin", "user", "changeStatus", array("id" => $id, "status" => $value['status'])) ?>')">
                                        <span class="state <?= $classStatus ?>"></span>
                                    </a>
                                </td>
                                <td class="order">
                                    <input type="text" size="8" name="order" id="<?= $id  ?>" value="<?= $ordering ?>" class="text-area-order">
                                </td>
                                <td class="center"><?= $created ?></td>
                                <td class="center"><?= $create_by ?></td>
                                <td class="center"><?= $modified ?></td>
                                <td class="center"><?= $modified_by ?></td>
                                <td class="center"><?= $groupName ?></td>
                                <td style="display: flex;justify-content: space-evenly;">
                                    <a href="<?= $linkUpdate ?>" style="padding: 4px 8px;background: #ffc107;color: #fff;border-radius: 5px;">Update</a>
                                    <a href="<?= $delete ?>" class="" style="padding: 4px 8px;background: #ec4536;color: #fff; border-radius: 5px;">Delete</a>
                                </td>
                            </tr>
                    <?php  # code...
                        }
                    } ?>
                </tbody>
                <!-- FOOTER TABLE -->
                <tfoot>
                    <tr>
                        <td colspan="12">
                            <!-- PAGINATION -->
                            <div class="container">
                                <div class="pagination">
                                    <?= $pagination ?>
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
