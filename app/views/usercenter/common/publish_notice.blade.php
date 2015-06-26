@extends('layouts.main')
@section('content')
<div class="set_cent fr">
  <div class="title_477 mb5">
    <h2>提示</h2>
  </div>
  <div class="notice">
    <p>你最多可发布条数为{{$user->allow_publish_num}}，如需再发信息请删除旧数据，如有疑问请联系客服（400-0736-600转0），谢谢！</p>
  </div>
</div>
<div class="clear"></div>
@stop