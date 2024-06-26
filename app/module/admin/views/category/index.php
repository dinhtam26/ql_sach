<?php
$arrStatus    = array("2" => "- Select Status -", "0" => "Unpublish", "1" => "Public");
$selectStatus = Helper::cmsSelectBox("filter_status", "inputbox", $arrStatus, $this->_arrParams['filter_status'] ?? "");
$arrPagination        = array("default" => "- Select Pagination -", "5" => "5", "10" => "10", "20" => "20", "50" => "50");
$paginationSelect     = Helper::cmsSelectBox("filter_page", "inputbox", $arrPagination, $this->_arrParams['filter_page'] ?? "");

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
?>
<div id="dialog-confirm" title="Thông báo" style="display: none">
    <p> Bạn có chắc muốn xóa không</p>
</div>
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
                    <?php echo $selectStatus ?>
                    <?php echo $paginationSelect ?>
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
                                <span>ID</span>
                                <img width="10px" height="10px" scr="/PHP_Zend/BookStore/Public/Template/admin/main/images/admin/sort_asc.png" alt="">
                            </a>
                        </th>
                        <th width="10%"><a href="#">
                                <span>Name</span>
                            </a>
                        </th>
                        <th width="10%" class="left">
                            <a href="#">
                                <span>Hình ảnh</span>

                            </a>
                        </th>

                        <th width="10%" class="left">
                            <a href="#" onclick="javascript:sortList('created', 'desc')">
                                <span>Created</span>
                            </a>
                        </th>
                        <th width="10%">
                            <a href="#" onclick="javascript:sortList('created_by', 'desc')">
                                <span>Created_By</span>
                            </a>
                        </th>
                        <th width="10%">
                            <a href="#" onclick="javascript:sortList('modified', 'desc')">
                                <span>Modified</span>
                            </a>
                        </th>
                        <th width="10%">
                            <a href="#" onclick="javascript:sortList('modified_by', 'desc')">
                                <span>Modified_By</span>
                            </a>
                        </th>
                        <th width="10%"><a href="#" onclick="javascript:sortList('ordering', 'desc')">
                                <span>Ordering</span>

                            </a></th>
                        <th width="10%"><a href="#" onclick="javascript:sortList('ordering', 'desc')">
                                <span>Status</span>
                            </a>
                        </th>
                        <th width="10%">
                            <span>Action</span>
                        </th>
                    </tr>
                </thead>

                <!-- BODY TABLE -->
                <tbody>
                    <?php
                    if (!empty($this->data['listItem'])) {
                        foreach ($this->data['listItem'] as $key => $value) {
                            $id         = $value['id'];
                            $name       = $value['name'];
                            $image      = $value['image'];
                            $created    = Helper::cmsFormatDate($value['created']);
                            $created_by = $value['created_by'];
                            $modified   = Helper::cmsFormatDate($value['modified']);
                            $modified_by = $value['modified_by'];
                            $status     = Helper::cmsStatus($value['status'], URL::createLink("admin", "category", "ajaxStatus", array("id" => $id, "status" => $value['status'])), $id);
                            $ordering   = $value['ordering'];

                            // Action
                            $linkDelete = URL::createLink("admin", "category", "delete", array("id" => $id));
                            $delete = 'javascript:deleteItem(\' ' . $linkDelete . ' \', ' . $id . ')';
                            $linkUpdate = URL::createLink("admin", "category", "edit", array("id" => $id));
                    ?>
                            <tr class="row0" id="item-<?= $id ?>">
                                <td class="center">
                                    <input type="checkbox" name="checkbox[]" value="<?= $id ?>">
                                </td>
                                <td class="center"><a href="#"><?= $id ?></a></td>
                                <td class="center"><a href="#"><?= $name ?></a></td>
                                <td class="center"><a href="#"><img width="60px" src="<?= UPLOAD_URL ?>category/<?= $image ?>" alt=""></a></td>
                                <td class="center"><?= $created ?></td>
                                <td class="center"><?= $created_by ?></td>
                                <td class="center"><?= $modified ?></td>
                                <td class="center"><?= $modified_by ?></td>
                                <td class="order">
                                    <input type="text" name="order" id="<?= $id ?>" value="<?= $ordering ?>" class="text-area-order">
                                </td>
                                <td class="center">
                                    <?= $status ?>
                                </td>
                                <td style="display: flex;justify-content: space-evenly;">
                                    <a href="<?= $linkUpdate ?>" style="padding: 4px 8px;background: #ffc107;color: #fff;border-radius: 5px;">Update</a>
                                    <a href="<?= $delete ?>" class="" style="padding: 4px 8px;background: #ec4536;color: #fff; border-radius: 5px;">Delete</a>
                                </td>
                            </tr>
                    <?php
                        }
                    }

                    ?>
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