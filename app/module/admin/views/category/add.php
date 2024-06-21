<div id="system-message-container ">
    <dl id="system-message" class="hidden" style="display: none;">
        <dt class="error">Error</dt>
        <dd class="error message">
            <ul>
                <li><b>Username:</b> Không được để rỗng</li>
                <li><b>Email:</b> Không được để rỗng</li>
                <li><b>Password:</b> Không được để rỗng</li>
                <li><b>Fullname:</b> Không được để rỗng</li>
                <li><b>Status:</b> Vui lòng chọn status</li>
                <li><b>Group_id:</b> Vui lòng chọn group_id</li>
                <li><b>Ordering:</b> Không được để rỗng</li>
            </ul>
        </dd>
    </dl>
</div>
<div id="element-box">
    <div class="m">
        <form action="#" method="post" name="adminForm" id="adminForm" class="form-validate">
            <!-- FORM LEFT -->
            <div class="width-100 fltlft">
                <fieldset class="adminform">
                    <legend>Details</legend>
                    <ul class="adminformlist">
                        <li>
                            <label>Username<span class="star">&nbsp;*</span></label>
                            <input style="height: 30px" type="text" name="form[username]" id="name" value="" class="inputbox" size="70">
                        </li>
                        <li>
                            <label>Email<span class="star">&nbsp;*</span></label>
                            <input style="height: 30px" type="text" name="form[email]" id="email" value="" class="inputbox" size="70">
                        </li>
                        <li>
                            <label>Password<span class="star">&nbsp;*</span></label>
                            <input style="height: 30px" type="password" name="form[password]" id="password" value="" class="inputbox" size="70">
                        </li>
                        <li>
                            <label>FullName<span class="star">&nbsp;*</span></label>
                            <input style="height: 30px" type="text" name="form[fullname]" id="fullname" value="" class="inputbox" size="70">
                        </li>
                        <li>
                            <label>Status</label>
                            <select style="height: 30px; width: 380px" name="form[status]" class="inputbox">
                                <option value="default">- Select Status -</option>
                                <option value="0">UnPublish</option>
                                <option value="1">Publish</option>
                            </select>
                        </li>
                        <li>
                            <label>Group Name</label>
                            <select style="height: 30px; width: 380px" name="form[group_id]" class="inputbox">
                                <option value="default">- Select Group - </option>
                                <option value="3">Member</option>
                                <option value="2">Manager</option>
                                <option value="1">Admin</option>
                            </select>
                        </li>
                        <li>
                            <label>Ordering<span class="star">&nbsp;*</span></label>
                            <input style="height: 30px" type="text" name="form[ordering]" id="ordering" value="" class="inputbox" size="70">
                        </li>
                    </ul>
                    <div class="clr"></div>
                    <div>
                        <input type="hidden" name="form[token]" value="1384158288">
                    </div>
                </fieldset>
            </div>
            <div class="clr"></div>
            <div>
            </div>
        </form>
        <div class="clr"></div>
    </div>
</div>