<?php
class Pagination
{
    var $page;
    var $page_items;
    var $total_items;
    var $total_pages;
    var $limit;
    function __construct( $page_items = NULL )
    {
        
        
        $this->page         = ( isset($_GET['pagesize']) && is_numeric($_GET['pagesize']) ) ? $_GET['pagesize'] : 1;
        $this->page         = ( $this->page < 1 ) ? $this->page = 1 : $this->page;
        $this->page_items   = ( isset($page_items) && is_numeric($page_items) ) ? $page_items : 20;
        settype($this->page, 'integer');
        settype($this->page_items, 'integer');
    }
    
    function Pagination( $page_items = NULL )
    {
        $this->__construct($page_items);
    }
    
    function getLimit( $total_items )
    {
        $this->total_items = ( $total_items == 0 ) ? 1 : $total_items;
        $this->total_pages = ceil($this->total_items/$this->page_items);
        settype($this->total_pages, 'integer');    
        if( $this->page > $this->total_pages )
            $this->page = $this->total_pages;
        $this->limit        = $this->page_items;
        
        if ( $this->page >= 2 )
            $this->limit = ($this->page - 1) * $this->page_items. ', ' .$this->page_items;
        
        return $this->limit;
    }
    
    function getPagination( $url = NULL, $index = 3)
    {
        $url            = $this->stripPage();        
        $separator      = ( strstr($url, '?') ) ? '&' : '?';
        $output         = array();
        $prev_page      = ( $this->page > 1 ) ? $this->page - 1: 1;
        $next_page      = $this->page+1;
        
        if ( $this->page != 1 )
            $output[]   = '<li><a href="' .$url . $separator. 'pagesize=' .$prev_page. '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
        if ( $this->total_pages > (($index*2)+3) && $this->page >= ($index+3) ) {
            $output[]   = '<li><a href="' .$url . $separator. 'pagesize=1">1</a></li>';
            $output[]   = '<li><a href="' .$url . $separator. 'pagesize=2">2</a></li>';
        }
        if ( $this->page > $index+3 )
            $output[]   = '<li><a href=""><span style="border:0; background: transparent; color: #888;">..</span></a></li>';
        for ( $i=1; $i<=$this->total_pages; $i++ ) {
            if ( $this->page == $i )
                    $output[] = '<li><a href="" class="active"><span class="pagingnav">' .$this->page. '</span></a></li>';
            elseif ( ($i >= ($this->page-$index) && $i < $this->page) or ($i <= ($this->page+$index) && $i > $this->page) )
                    $output[]   = '<li><a href="' .$url . $separator. 'pagesize=' .$i. '">' .$i. '</a></li>';
        }
        
        if ( $this->page < ($this->total_pages-6) )
            $output[]   = '<li><a href="" class="active"><span style="border:0; background: transparent; color: #888;">..</span></a></li>';              
        if ( $this->total_pages > (($index*2)+3) && $this->page <= $this->total_pages-($index+3) ) {
            $output[]   = '<li><a href="' .$url . $separator. 'pagesize=' .($this->total_pages-2). '">' .($this->total_pages-2). '</a></li>';
            $output[]   = '<li><a href="' .$url . $separator. 'pagesize=' .($this->total_pages-1). '">' .($this->total_pages-1). '</a></li>';        
        }
        if ( $this->page != $this->total_pages )
            $output[]   = '<li><a aria-label="Next" href="' .$url . $separator. 'pagesize=' .$next_page. '"><span aria-hidden="true">&raquo;</span></a></li>';
        
        return implode('', $output);
    }
    
   
   
    
    function getStartItem() {
        $start_item = 1;
        if ( $this->page >= 2 )
            $start_item = (($this->page - 1) * $this->page_items)+1;
        if ( $start_item >= $this->total_items )
            $start_item = $this->total_items;
        
        return $start_item;
    }
    
    function getEndItem()
    {
        $end_item = $this->getStartItem();
        $end_item = ($end_item + $this->page_items)-1;
        if ( $end_item >= $this->total_items )
            $end_item = $this->total_items;
        
        return $end_item;
    }
    
   
    
    function getPage()
    {
        return $this->page;
    }
    
    function getTotalPages()
    {
        return $this->total_pages;
    }
    
    function stripPage( $query_string = null )
    {
       
    	
        foreach ( $_GET as $key => $value ) {
            if ( $key != 'pagesize' )
                $query_string .= '&' .$key. '=' .$value;
        }
        
        return $_SERVER['SCRIPT_NAME']. ( $query_string ) ? '?' .substr($query_string, 1) : '';
    }
}
?>
