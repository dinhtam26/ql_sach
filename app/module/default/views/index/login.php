<?php
$linkForm = URL::createLink("default", "index", "login");
$strMessage = '';
if (!empty($this->error)) {
    $strMessage .= '<div style="background: #d51e1eb3; padding: 5px 10px;" class="error">
                        <ul>
                        <li>' . $this->error . '</li>
                        <ul>
                    </div>';
}

?>


<div class="title"><span class="title_icon"><img src="images/bullet1.gif" alt="" title=""></span>Login</div>

<div class="feat_prod_box_details">
    <div class="contact_form">
        <div class="form_subtitle">Login Website</div>

        <!-- Thông báo Lỗi -->
        <div id="system-message-container">
            <?php echo $strMessage ?>
        </div>


        <!-- FORM -->
        <form name="register" action="<?= $linkForm ?>" method="post">

            <div class="form_row">
                <label class="contact"><strong>Email:</strong></label>
                <input type="email" name="form[email]" class="contact_input" value="<?= $this->data['form']['email'] ?? "" ?>">
            </div>
            <div class="form_row">
                <label class="contact"><strong>Password:</strong></label>
                <input type="text" name="form[password]" class="contact_input" value="<?= $this->data['form']['password'] ?? "" ?>">
            </div>
            <div class="form_row">
                <label class="contact"><strong>:</strong></label>
                <input type="hidden" name="form[token]" value="<?= time() ?>" class="contact_input">
            </div>
            <div class="form_row">
                <input type="submit" name="form[submit]" class="register" value="Login">
            </div>
        </form>
    </div>

</div>






<div class="clear"></div>


<?php
