<?php
$linkLogin = URL::createLink("admin", "index", "login");
$strMessage = '';
if (!empty($this->errors)) {
    $strMessage .= '<dl id="system-message">
                        <dt class="error">Error</dt>
                        <dd class="error message">
                            <ul>
                                <li>' . $this->errors . '</li>
                            </ul>
                        </dd>
                    </dl>';
}

?>
<div id="content-box">
    <div id="element-box" class="login">
        <div class="m wbg">
            <h1>Administration Login</h1>
            <!-- ERROR -->

            <div id="system-message-container">
                <?= $strMessage ?>
            </div>

            <div id="section-box">
                <div class="m">
                    <form action="<?= $linkLogin ?>" method="post" id="form-login">
                        <fieldset class="loginform">
                            <label>Email</label>
                            <input name="form[email]" id="mod-login-username" type="text" class="inputbox" size="15">
                            <label id=" mod-login-password-lbl" for="mod-login-password">Password</label>
                            <input name="form[password]" id="mod-login-password" type="password" class="inputbox" size="15">
                            <div class="button-holder">
                                <div class="button1">
                                    <div class="next">
                                        <a href="#" onclick="document.getElementById('form-login').submit();">Log in</a>
                                    </div>
                                </div>
                            </div>
                            <div class="clr"></div>
                        </fieldset>
                    </form>
                    <div class="clr"></div>
                </div>
            </div>

            <!-- <p>Use a valid username and password to gain access to the administrator backend.</p> -->
            <p><a href="http://localhost/joomla/">Go to site home page.</a></p>
            <div id="lock"></div>
        </div>
    </div>
</div>