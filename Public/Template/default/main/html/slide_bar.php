<?php
$model      = new Model();
$sql        = "SELECT `id`, `name` FROM `category`";
$category   = $model->listRecord($sql);
$listCate = '';
if (!empty($category)) {
    foreach ($category  as $key => $value) {
        $link = "#";
        $name = $value['name'];
        $listCate .= '<li style="margin-top: 3px"><a href="' . $link . '">' . $name . '</a></li>';
    }
}

?>
<!-- LANGUAGES -->
<?php
require_once 'block/langueges.php';
?>

<!-- CURRENCY -->
<?php
require_once 'block/currency.php';
?>

<!-- CART -->
<?php
require_once 'block/cart.php';
?>






<div class="right_box">
    <div class="title"><span class="title_icon"><img src="<?= $images ?>/bullet4.gif" alt="" title=""></span>Promotions</div>
    <div class="new_prod_box">
        <a href="details.html">product name</a>
        <div class="new_prod_bg">
            <span class="new_icon"><img src="<?= $images ?>/promo_icon.gif" alt="" title=""></span>
            <a href="details.html"><img src="<?= $images ?>/thumb1.gif" alt="" title="" class="thumb" border="0"></a>
        </div>
    </div>

    <div class="new_prod_box">
        <a href="details.html">product name</a>
        <div class="new_prod_bg">
            <span class="new_icon"><img src="<?= $images ?>/promo_icon.gif" alt="" title=""></span>
            <a href="details.html"><img src="<?= $images ?>/thumb2.gif" alt="" title="" class="thumb" border="0"></a>
        </div>
    </div>

    <div class="new_prod_box">
        <a href="details.html">product name</a>
        <div class="new_prod_bg">
            <span class="new_icon"><img src="<?= $images ?>/promo_icon.gif" alt="" title=""></span>
            <a href="details.html"><img src="<?= $images ?>/thumb3.gif" alt="" title="" class="thumb" border="0"></a>
        </div>
    </div>
</div>

<div class="right_box">

    <div class="title"><span class="title_icon"><img src="<?= $images ?>/bullet5.gif" alt="" title=""></span>Categories</div>

    <ul class="list">
        <?php
        echo $listCate;
        ?>
    </ul>
</div>


<!--end of right content-->