<?php
class Helper
{
    // CMS Button
    public static function cmsButton($name, $id, $link, $icon, $type = "new")
    {
        $xhtml  = '<li class="button" id="' . $id . '">';
        if ($type == "new") {
            $xhtml .= '<a class="modal" href="' . $link . '"><span class="' . $icon . '"></span>' . $name . '</a>';
        } else if ($type == "submit") {
            $xhtml .= '<a class="modal" href="#" onclick="javascript:submitForm(\'' . $link . '\');"><span class="' . $icon . '"></span>' . $name . '</a>';
        }

        $xhtml .= '</li>';
        return $xhtml;
    }

    // CMS Status
    public static function cmsStatus($value, $link, $id)
    {
        $strStatus = ($value == 0) ? "unpublish" : "publish";
        $xhtml = '<a class="jgrid hasTip" id="status-' . $id . '" href="javascript:changStatus(\'' . $link . '\');">
                    <span class="state ' . $strStatus . '"></span>
                </a>';
        return $xhtml;
    }

    // CMS Group ACP
    public static function cmsGroupACP($value, $link, $id)
    {
        $strGroup = ($value == 0) ? "unpublish" : "publish";
        $xhtml = '<a class="jgrid hasTip" id="group-' . $id . '" href="javascript:changGroup(\'' . $link . '\');">
                    <span class="state ' . $strGroup . '"></span>
                </a>';
        return $xhtml;
    }

    public static function cmsFormatDate($valueTime)
    {
        $xhtml = "";
        if ($valueTime == "0000-00-00") {
            $xhtml = "";
        } else {
            $xhtml = $valueTime;
            $xhtml  = date("d-m-Y", strtotime($xhtml));
        }
        return $xhtml;
    }

    // CMS Title Sort
    // $name là tên title
    // $column là sắp xếp theo cột nào
    // $columnPost là bấm vào cột nào
    // $orderPost là sắp xếp tăng hay giảm
    public static function linkSort($name, $column, $columnPost,  $orderPost)
    {
        $img = '';
        $order = ($orderPost == 'desc') ? 'asc' : 'desc';
        if ($column == $columnPost) {
            $img = '<img width="10px" height="10px" scr="/BookStore/Public/Template/admin/main/images/admin/sort_' . $orderPost . '.png" alt="">';
        }
        $xhtml = '<a href="#" onclick="javascript:sortList(\'' . $column . '\', \'' . $order . '\')">
                    <span>' . $name . '</span>
                    ' . $img . '
                  </a>';
        return $xhtml;
    }

    // Create SelectBox
    public static function cmsSelectBox($name, $class, $arrValue, $keySelect = 0, $style = false)
    {
        if ($style == true) {
            $xhtml = '  <select style="height: 30px; width: 380px" name="' . $name . '" class="' . $class . '">';
        } else {
            $xhtml = '  <select name="' . $name . '" class="' . $class . '">';
        }
        foreach ($arrValue as $key => $value) {
            if ($key == $keySelect) {
                $xhtml .= '<option value="' . $key . '" selected="selected">' . $value . '</option>';
            } else {
                $xhtml .= '<option value="' . $key . '" >' . $value . '</option>';
            }
        }
        $xhtml .= '</select>';
        return $xhtml;
    }
}
