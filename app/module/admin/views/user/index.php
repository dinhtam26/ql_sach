<?php
$arrStatus  = array("default" => "- Select Status -", "0" => "unpublish", "1" => "public");
$status     = Helper::cmsSelectBox("filter_status", "inputbox", $arrStatus, $this->_arrParams['filter_status'] ?? "");

$arrPagination  = array("default" => "- Select Pagination -", "5" => "5", "10" => "10", "20" => "20", "50" => "50");
$paginationSelect         = Helper::cmsSelectBox("filter_page", "inputbox", $arrPagination, $this->_arrParams['filter_page'] ?? "");


if (!empty([$this->data['listGroupName']])) {
    $arrGroup   = array_column($this->data['listGroupName'], "name", "id");
    $arrGroup['default']    = "- Select Group - ";
    krsort($arrGroup);

    $groupSelect    = Helper::cmsSelectBox("filter_group", "inputbox", $arrGroup, $this->_arrParams['filter_group'] ?? "");
}


$pagination = $this->pagination->showPagination();
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
                            <a href="#" onclick="javascript:sortList('name', 'desc')">
                                <span>UserName</span>
                                <img width="10px" height="10px" scr="/BookStore/Public/Template/admin/main/images/admin/sort_asc.png" alt="">
                            </a>
                        </th>
                        <th class="title">
                            <a href="#" onclick="javascript:sortList('name', 'desc')">
                                <span>Email</span>
                                <img width="10px" height="10px" scr="/BookStore/Public/Template/admin/main/images/admin/sort_asc.png" alt="">
                            </a>
                        </th>
                        <th class="title">
                            <a href="#" onclick="javascript:sortList('name', 'desc')">
                                <span>FullName</span>
                                <img width="10px" height="10px" scr="/BookStore/Public/Template/admin/main/images/admin/sort_asc.png" alt="">
                            </a>
                        </th>
                        <th width="6%">
                            <a href="#" onclick="javascript:sortList('status', 'desc')">
                                <span>Status</span>
                            </a>
                        </th>
                        <th width="6%">
                            <a href="#" onclick="javascript:sortList('status', 'desc')">
                                <span>Ordering</span>
                            </a>
                        </th>
                        <th width="10%">
                            <a href="#" onclick="javascript:sortList('status', 'desc')">
                                <span>Created</span>
                            </a>
                        </th>
                        <th width="10%">
                            <a href="#" onclick="javascript:sortList('status', 'desc')">
                                <span>Created_By</span>
                            </a>
                        </th>
                        <th width="10%">
                            <a href="#" onclick="javascript:sortList('status', 'desc')">
                                <span>Modified</span>
                            </a>
                        </th>
                        <th width="10%">
                            <a href="#" onclick="javascript:sortList('status', 'desc')">
                                <span>Modified_By</span>
                            </a>
                        </th>
                        <th width="10%">
                            <a href="#" onclick="javascript:sortList('status', 'desc')">
                                <span>Group Name</span>
                            </a>
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
                            $groupName  = $value['group_name']
                    ?>
                            <tr class="row0">
                                <td class="center">
                                    <input type="checkbox" name="checkbox[]" value="<?= $id ?>">
                                </td>
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
                            </tr>
                    <?php  # code...
                        }
                    } ?>
                </tbody>
                <!-- FOOTER TABLE -->
                <tfoot>
                    <tr>
                        <td colspan="11">
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

echo "<pre/>";
print_r($this->_arrParams);
echo "<pre/>";
