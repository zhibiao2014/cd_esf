@if ($paginator->getLastPage() > 1)
<?php
$max_page = $paginator->getLastPage();
$paged = $paginator->getCurrentPage();
$previousPage = ($paged > 1) ? $paged - 1 : 1;
$nextPage = ( $paged >= $max_page ) ? $max_page : $paged + 1;
?>
<div class="page fr mt10 mr10 FDpage2 pa">
  <span>共 {{$paginator->getTotal()}} 条</span>
  {{sprintf('<a href="%s" class="a1%s"> 上一页 </a>', $paginator->getUrl($previousPage), ($paged == 1) ? ' disabled' : '')}}
  <span class="cur">{{$paged}}</span>
  {{sprintf('<a href="%s" class="a1%s"> 下一页 </a>', $paginator->getUrl($nextPage), ($paged == $max_page) ? ' disabled' : '')}}
</div>
@endif