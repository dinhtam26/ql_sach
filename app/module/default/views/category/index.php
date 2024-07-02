<?php
$xhtml = '';
if (!empty($this->listItem)) {
    foreach ($this->listItem as $key => $value) {
        $name   = $value['name'];
        $link   = '#';
        $image  = UPLOAD_URL . "category" . DS . $value['image'];
        $xhtml .= '<div class="new_prod_box">
                        <a href="' . $link . '">' . $name . '</a>
                        <div class="new_prod_bg">
                            <a href="' . $link . '">
                                <img width="60px" height="90px" style="object-fit: cover" src="' . $image . '" alt="" title="" class="thumb" border="0">
                            </a>
                        </div>
                    </div>';
    }
}

$pagination = $this->pagination->showPaginationPublic();
// echo "<pre/>";
// print_r($pagination);
// echo "<pre/>";
?>
<form action="#" method="post" name="adminForm" id="adminForm">
    <!-- NAV -->
    <div class="crumb_nav">
        <a href="index.html">home</a> &gt;&gt; category name
    </div>

    <!-- TITLE -->
    <div class="title">
        <span class="title_icon">
            <img src="images/bullet1.gif" alt="" title="">
        </span>
        Category books
    </div>

    <!-- CATEGORY LIST -->
    <div class="new_products">

        <!-- CATEGORY ITEM  -->
        <?php
        echo $xhtml;
        ?>
        <!-- PAGINATION -->
        <div class="pagination">
            <?php
            echo $pagination
            ?>
        </div>

        <div>
            <input type="hidden" name="filter_pagination" value="1">
        </div>

    </div>

</form>