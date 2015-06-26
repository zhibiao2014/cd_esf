@if ($paginator->getLastPage() > 1)
<?php $previousPage = ($paginator->getCurrentPage() > 1) ? $paginator->getCurrentPage() - 1 : 1; ?>  
<ul class="ui pagination menu">  
  <a href="{{ $paginator->getUrl($previousPage) }}"
    class="item{{ ($paginator->getCurrentPage() == 1) ? ' disabled' : '' }}">
    <i class="icon left arrow"></i> 上一页
  </a>
  @for ($i = 1; $i <= $paginator->getLastPage(); $i++)
  <a href="{{ $paginator->getUrl($i) }}"
    class="item{{ ($paginator->getCurrentPage() == $i) ? ' active' : '' }}">
      {{ $i }}
  </a>
  @endfor
  <a href="{{ $paginator->getUrl($paginator->getCurrentPage()+1) }}"
    class="item{{ ($paginator->getCurrentPage() == $paginator->getLastPage()) ? ' disabled' : '' }}">
    下一页 
  </a>
</ul>  
@endif