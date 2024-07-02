<?php
// SORT LIST
$columnPost     = $this->_arrParams['filter_column'] ?? "id";
$orderPost      = $this->_arrParams['filter_column_asc'] ?? "asc";
$lbId           = Helper::linkSort("ID", "id", $columnPost, $orderPost);
$lbName         = Helper::linkSort("Name", "name", $columnPost, $orderPost);
$lbImage        = Helper::linkSort("Image", "image", $columnPost, $orderPost);
$lbDesc         = Helper::linkSort("Desc", "desc", $columnPost, $orderPost);
$lbPrice        = Helper::linkSort("Price", "price", $columnPost, $orderPost);
$lbSaleOff      = Helper::linkSort("Sale Off", "saleoff", $columnPost, $orderPost);
$lbQuantity     = Helper::linkSort("Quantity", "quantity", $columnPost, $orderPost);
$lbOrdering     = Helper::linkSort("Ordering", "ordering", $columnPost, $orderPost);
$lbStatus       = Helper::linkSort("Status", "status", $columnPost, $orderPost);
$lbCategory     = Helper::linkSort("Category", "cate_id", $columnPost, $orderPost);



// SELECT STATUS 
$arrStatus          = array("2" => "- Select Status -", "0" => "Unpublish", "1" => "Public");
$selectStatus       = Helper::cmsSelectBox("filter_status", "inputbox", $arrStatus, $this->_arrParams['filter_status'] ?? "");

// SELECT CATEGORY
$arrCategory                = $this->data['category'];
$arrCategory['default']     = "- Select Category -";
krsort($arrCategory);
$category = Helper::cmsSelectBox("filter_category", "inputbox", $arrCategory, $this->_arrParams['filter_category'] ?? "");

// SELECT PAGINATION
$arrPagination      = array("default" => "- Select Pagination -", "5" => "5", "10" => "10", "20" => "20", "50" => "50");
$paginationSelect   = Helper::cmsSelectBox("filter_page", "inputbox", $arrPagination, $this->_arrParams['filter_page'] ?? "");

// PAGINATION

$pagination = $this->pagination->showPagination();

// MESSAGE
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
<!-- THÔNG BÁO LỖI HOẶC THÀNH CÔNG -->
<div id="system-message-container">
    <?= $strMess  ?>
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
                    <?= $selectStatus ?>
                    <?= $paginationSelect ?>
                    <?= $category  ?>
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
                        <th width="3%" class="title"> <?= $lbId ?> </th>
                        <th width="10%"> <?= $lbName ?></th>
                        <th width="10%" class="center"> <?= $lbImage ?> </th>
                        <th width="18%" class="center"> <?= $lbDesc ?> </th>
                        <th width="8%"> <?= $lbPrice ?> </th>
                        <th width="6%"> <?= $lbSaleOff ?></th>
                        <th width="4%"> <?= $lbQuantity ?></th>
                        <th width="10%"> <?= $lbOrdering ?></th>
                        <th width="8%"> <?= $lbStatus ?></th>
                        <th width="8%"> <?= $lbCategory ?> </th>
                        <th width="10%">
                            <span>Action</span>
                        </th>
                    </tr>
                </thead>

                <!-- BODY TABLE -->
                <tbody>

                    <?php

                    if (!empty($this->data['book'])) {
                        foreach ($this->data['book'] as $key => $value) {
                            $id     = $value['id'];
                            $name   = Helper::truncateString($value['name'], 50);
                            $image  = $value['image'];
                            $desc   = Helper::truncateString($value['desc'], 100);
                            $price  = $value['price'];
                            $saleOff    = $value['saleoff'];
                            $quantity   = $value['quantity'];
                            $author = $value['author'];
                            $status = Helper::cmsStatus($value['status'], URL::createLink("admin", "book", "ajaxStatus", array("id" => $id, "status" => $value['status'])), $id);
                            $ordering = $value['ordering'];
                            $cate     = $value['cate_id'];

                            // Action
                            $linkDelete   = URL::createLink("admin", "book", "delete", array("id" => $id));
                            $delete       = 'javascript:deleteItem(\' ' . $linkDelete . ' \', ' . $id . ')';
                            $linkUpdate   = URL::createLink("admin", "book", "edit", array("id" => $id));
                            $linkDetail   = URL::createLink("admin", "book", "detail", array("id" => $id));
                    ?>

                            <tr class="row0" id="item-<?= $id ?>">
                                <td class="center">
                                    <input type="checkbox" name="checkbox[]" value="<?= $id ?>">
                                </td>
                                <td class="center"><a href="#"><?= $id ?></a></td>
                                <td class="center"><a href="#"><?= $name ?></a></td>
                                <td class="center"><a href="#"><img style="object-fit: cover;" width="60px" height="90px" src="<?= UPLOAD_URL ?>book/<?= $image ?>" alt=""></a></td>
                                <td class="center"><?= $desc ?></td>
                                <td class="center"><?= number_format($price) ?></td>
                                <td class="center"><?= $saleOff ?>%</td>
                                <td class="center"><?= $quantity ?></td>
                                <td class="order">
                                    <input type="text" name="order" id="<?= $id ?>" value="<?= $ordering ?>" class="text-area-order">
                                </td>
                                <td class="center">
                                    <?= $status ?>
                                </td>
                                <td class="center"><?= $cate ?></td>
                                <td>
                                    <div style="display: flex;justify-content: space-evenly;">
                                        <a href="<?= $linkUpdate ?>" style="padding: 4px 8px;background: #ffc107;color: #fff;border-radius: 5px;">Update</a>
                                        <a href="<?= $delete ?>" class="" style="padding: 4px 8px;background: #ec4536;color: #fff; border-radius: 5px;">Delete</a>
                                    </div>
                                    <div style="margin-top: 10px; display: flex;justify-content: center">
                                        <a href="<?= $linkDetail ?>" class="" style="padding: 4px 8px;background:#287ce9;color: #fff; border-radius: 5px;">Detail</a>
                                    </div>
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