<?php
class Pagination
{
    // Tổng số phần tử 
    public $totalItems;
    // Tổng số phần tử trên 1 trang
    public  $totalItemPerPage = 1;
    // Page Range 
    public $pageRange         = 3;
    // Tổng số trang
    public $totalPages;
    // Trang hiện tại 
    public $currentPage;

    public function __construct($totalItems, $pagination)
    {
        $this->totalItems       = $totalItems;
        $this->totalItemPerPage = $pagination['totalItemPerPage'];
        if ($pagination['pageRange'] % 2 == 0) {
            $pageRange = $pagination['pageRange'] + 1;
            $this->pageRange        = $pageRange;
        }

        $this->currentPage      = $pagination['currentPage'];
        $this->totalPages       = ceil($totalItems / $pagination['totalItemPerPage']);
    }

    public function showPagination()
    {
        // <div class="button2-right off"><div class="start"><span>Start</span></div></div>
        $paginationHTML = "";

        if ($this->totalPages > 1) {
            $start = '<div class="button2-right off"><div class="start"><span>Start</span></div></div>';
            $prev  = '<div class="button2-right off"><div class="prev"><span>Prev</span></div></div>';
            if ($this->currentPage > 1) {
                $start = '<div class="button2-right "><div class="start"><a href="#" onclick="javascript:changePage(1)" >Start</a></div></div>';
                $prev = '<div class="button2-right "><div class="prev"><a onclick="javascript:changePage(' . ($this->currentPage - 1) . ')" href="#">Prev</a></div></div>';
            }
            // <div class="button2-left"><div class="next"><a href="page=' . $this->totalPages . '">End</a></div></div>
            $next = '<div class="button2-left off"><div class="next "><a href="#">Next</a></div></div>';
            $end  = '<div class="button2-left off"><div class="next "><a href="#">End</a></div></div>';
            if ($this->currentPage < $this->totalPages) {

                $next = '<div class="button2-left"><div class="next"><a onclick="javascript:changePage(' . ($this->currentPage + 1) . ')" href="#">Next</a></div></div>';
                $end = '<div class="button2-left"><div class="next"><a onclick="javascript:changePage(' . $this->totalPages . ')" href="#">End</a></div></div>';
            }
            // currentPage = 1      1 2 3
            if ($this->pageRange < $this->totalPages) {
                if ($this->currentPage == 1) {
                    $startPage = 1;
                    $endPage   = $this->pageRange;
                } else if ($this->currentPage == $this->totalPages) {
                    $startPage = $this->totalPages - $this->pageRange + 1;
                    $endPage   = $this->totalPages;
                } else {
                    $startPage  = $this->currentPage - ($this->pageRange - 1) / 2;
                    $endPage   = $this->currentPage + ($this->pageRange - 1) / 2;
                }
            } else {
                $startPage = 1;
                $endPage   = $this->totalPages;
            }
            $listPage = '<div class="button2-left">
                            <div class="page">';
            for ($i = $startPage; $i <= $endPage; $i++) {
                if ($this->currentPage == $i) {
                    $listPage .= '<a class="active" style="color: red" onclick="javascript:changePage(' . $i . ')"  href="#">' . $i . '</a>';
                } else {
                    $listPage .= '<a onclick="javascript:changePage(' . $i . ')"  href=" #">' . $i . '</a>';
                }
            }

            $listPage .= '</div>
                     </div>';
            $pageOfTotal = '<div class="limit">Page ' . $this->currentPage . ' of ' . $this->totalPages . '</div>';
            $paginationHTML =   $start . $prev . $listPage . $next . $end . $pageOfTotal;
        }
        return $paginationHTML;
    }

    public function showPaginationPublic()
    {
        // <div class="button2-right off"><div class="start"><span>Start</span></div></div>
        $paginationHTML = "";

        if ($this->totalPages > 1) {
            $prev  = '<span class="disabled">&lt;&lt;</span>';
            if ($this->currentPage > 1) {
                $prev = '<span > <a onclick="javascript:changePage(' . ($this->currentPage - 1) . ')" href="#">&lt;&lt;</a></span>';
            }

            $next = '<span class="disabled">&gt;&gt;</span>';
            if ($this->currentPage < $this->totalPages) {
                $next = '<span ><a onclick="javascript:changePage(' . ($this->currentPage + 1) . ')" href="#">&gt;&gt;</a></span>';
            }


            // currentPage = 1      1 2 3
            if ($this->pageRange < $this->totalPages) {
                if ($this->currentPage == 1) {
                    $startPage = 1;
                    $endPage   = $this->pageRange;
                } else if ($this->currentPage == $this->totalPages) {
                    $startPage = $this->totalPages - $this->pageRange + 1;
                    $endPage   = $this->totalPages;
                } else {
                    $startPage  = $this->currentPage - ($this->pageRange - 1) / 2;
                    $endPage   = $this->currentPage + ($this->pageRange - 1) / 2;
                }
            } else {
                $startPage = 1;
                $endPage   = $this->totalPages;
            }
            $listPage = '';
            for ($i = $startPage; $i <= $endPage; $i++) {
                if ($this->currentPage == $i) {
                    $listPage .= '<a style="background: #795636; color: #fff" onclick="javascript:changePage(' . $i . ')"  href="#">' . $i . '</a>';
                } else {
                    $listPage .= '<a onclick="javascript:changePage(' . $i . ')"  href="#">' . $i . '</a>';
                }
            }


            // $pageOfTotal = '<div class="limit">Page ' . $this->currentPage . ' of ' . $this->totalPages . '</div>';
            $paginationHTML =    $prev . $listPage . $next;
        }
        return $paginationHTML;
    }
}
