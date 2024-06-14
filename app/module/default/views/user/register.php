<?php
$linkForm = URL::createLink("default", "user", "register");
$strMessage = '';
if (!empty($this->error)) {
    $strMessage .= '<div style="background: #d51e1eb3; padding: 5px 10px;" class="error">';
    $strMessage .= '<ul>';
    foreach ($this->error as $key => $value) {
        $strMessage .= '<li><strong>' . ucfirst($key) . '</strong>: ' . $value . '</li>';
    }
    $strMessage .= '<ul>';
    $strMessage .= '</div>';
} else {
    $message = Session::getSession("message");
    Session::deleteSession("message");
    if (!empty($message)) {
        $strMessage .= '<div id="' . $message['id'] . '" style="background: green; padding: 5px 10px;"" class="success">';
        $strMessage .= '<ul>';

        $strMessage .= '<li>' . $message['content'] ?? "" . '</li>';

        $strMessage .= '<ul>';
        $strMessage .= '</div>';
    }
}

?>


<div class="title"><span class="title_icon"><img src="images/bullet1.gif" alt="" title=""></span>Register</div>

<div class="feat_prod_box_details">
    <div class="contact_form">
        <div class="form_subtitle">create new account</div>

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
                <label class="contact"><strong>Username:</strong></label>
                <input type="text" name="form[username]" class="contact_input" value="<?= $this->data['form']['username'] ?? "" ?>">
            </div>


            <div class="form_row">
                <label class="contact"><strong>Password:</strong></label>
                <input type="text" name="form[password]" class="contact_input" value="<?= $this->data['form']['password'] ?? "" ?>">
            </div>


            <div class="form_row">
                <label class="contact"><strong>FullName:</strong></label>
                <input type="text" name="form[fullname]" class="contact_input" value="<?= $this->data['form']['fullname'] ?? "" ?>">
            </div>
            <div class="form_row">
                <label class="contact"><strong>:</strong></label>
                <input type="hidden" name="form[token]" value="<?= time() ?>" class="contact_input">
            </div>
            <div class="form_row">
                <input type="submit" name="form[submit]" class="register" value="register">
            </div>
        </form>
    </div>

</div>






<div class="clear"></div>


<?php
