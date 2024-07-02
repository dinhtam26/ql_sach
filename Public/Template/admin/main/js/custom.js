// AJAX GROUP_ACP
function changGroup(url) {
    $.get(
        url,
        function (data, status) {
            var id = data["id"];
            var group = data["group"];
            var linkGroup = data["link"];

            var removeClass = "publish";
            var addClass = "unpublish";
            if (group == 1) {
                removeClass = "unpublish";
                addClass = "publish";
            }
            // Thay đổi Class
            $("a#group-" + id + " span")
                .removeClass(removeClass)
                .addClass(addClass);
            // Thay đổi link
            $("a#group-" + id).attr("href", "javascript:changGroup('" + linkGroup + "')");

            $("a#group-" + id + " span").notify("Cập nhật thành công", {
                position: "top",
                className: "success",
                autoHideDelay: 2000,
                showDuration: 200,
            });
        },
        "json"
    );
}

// AJAX STATUS
function changStatus(url) {
    // console.log(url);
    $.get(
        url,
        function (data, status) {
            console.log(data);
            var id = data["id"];
            var status = data["status"];
            var link = data["link"];

            var removeClass = "publish";
            var addClass = "unpublish";
            if (status == 1) {
                removeClass = "unpublish";
                addClass = "publish";
            }
            // Thay đổi Class
            $("a#status-" + id + " span")
                .removeClass(removeClass)
                .addClass(addClass);
            // Thay đổi link
            $("a#status-" + id).attr("href", "javascript:changStatus('" + link + "')");

            $("a#status-" + id + " span").notify("Cập nhật thành công", {
                position: "top",
                className: "success",
                autoHideDelay: 2000,
                showDuration: 200,
            });
        },
        "json"
    );
}

// Hàm để thay đổi public , uppublic và xóa nhiều phần tử
function submitForm(url) {
    $("#adminForm").attr("action", url);
    $("#adminForm").submit();
}

// SORT LIST (hàm sắp xếp)
function sortList(column, order) {
    $("input[name=filter_column]").val(column);
    $("input[name=filter_column_asc]").val(order);
    $("#adminForm").submit();
}

// Submit Pagination
function changePage(page) {
    $("input[name=filter_pagination]").val(page);
    $("#adminForm").submit();
}

$(document).ready(function () {
    // Check All Checkbox
    $("#check-all").change(function () {
        var checkStatus = this.checked;
        $("#adminForm")
            .find(":checkbox")
            .each(function () {
                this.checked = checkStatus;
            });
    });

    // Submit Form Search
    $("#filter-bar button[name='search-kw']").click(function () {
        $("#adminForm").submit();
    });

    // Submit Form Clear
    // Submit Form Search
    $("#filter-bar button[name='clear-kw']").click(function () {
        $("#filter_search").val("");
        $("#adminForm").submit();
    });

    // Lọc theo publish và unpublish
    $("#filter-bar select[name='filter_status']").change(function () {
        $("#adminForm").submit();
    });

    // Lọc theo giá trị pagination
    $("#filter-bar select[name='filter_page']").change(function () {
        $("#adminForm").submit();
    });

    // Lọc theo giá trị group
    $("#filter-bar select[name='filter_group']").change(function () {
        $("#adminForm").submit();
    });

    // Lọc theo giá trị category
    $("#filter-bar select[name='filter_category']").change(function () {
        $("#adminForm").submit();
    });

    // Thay đổi ordering
    $(".text-area-order").change(function () {
        const urlParams = new URLSearchParams(window.location.search);
        const controller = urlParams.get("controller") ? urlParams.get("controller") : "index";
        let current = $(this);
        let value = $(this).val();
        let id = $(this).attr("id");
        let url = "index.php?module=admin&controller=" + controller + "&action=ajaxOrder";
        $.ajax({
            type: "GET",
            url: url,
            data: { id: id, value: value, type: "changeOrder" },
            dataType: "json",
            success: function (data) {
                console.log(data);
                current.notify("Cập nhật thành công", { position: "top", className: data.class, arrowSize: 10 });
            },
        });
    });

    // Thiết lập thông báo lỗi trong 3 giây
    $("#system-message").fadeIn("slow");

    // Ẩn thông báo lỗi sau 3 giây
    setTimeout(function () {
        $("#system-message").fadeOut("slow", function () {
            $(this).removeClass("error").addClass("hidden");
        });
    }, 3000);

    // Active Menu
    const urlParams = new URLSearchParams(window.location.search);
    const controller = urlParams.get("controller") ? urlParams.get("controller") : "index";
    $("#submenu li a." + controller).addClass("active");
});

function changStatusUser(url) {
    // console.log(url);
    $.ajax({
        type: "GET",
        url: url,
        data: { type: "changStatus" },
        dataType: "json",
        success: function (data) {
            var id = data["id"];
            var status = data["status"];
            var link = data["url"];

            var classRemove = "publish";
            var classAdd = "unpublish";
            if (status == 1) {
                classRemove = "unpublish";
                classAdd = "publish";
            }
            $("a#status-" + id + " span")
                .removeClass(classRemove)
                .addClass(classAdd);
            $("a#status-" + id).attr("href", "javascript:changStatusUser('" + link + "')");

            $("a#status-" + id + " span").notify("Cập nhật thành công", {
                position: "top",
                className: "success",
                autoHideDelay: 2000,
                showDuration: 200,
            });
        },
    });
}

function deleteItem(url, id) {
    console.log(url);
    console.log(id);
    $(function () {
        $("#dialog-confirm").dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                Yes: function () {
                    $.ajax({
                        type: "GET",
                        url: url,
                        data: { type: "deleteUser" },
                        dataType: "json",
                        success: function (data, response) {
                            console.log(data);
                            if (data == undefined) {
                                $("#item-" + id).hide(500);
                                $("#system-message").text("Bạn đã xóa thành công").show();
                                setTimeout(() => {
                                    $("#system-message").hide();
                                }, 2000);
                            }
                        },
                    });
                    $(this).dialog("close");
                },
                Cancel: function () {
                    $(this).dialog("close");
                },
            },
        });
    });
}
