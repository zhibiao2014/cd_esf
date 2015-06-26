@extends('layouts.esf')
@section('content')
<style type="text/css">
  .wrapper
  {
    font-family:'Droid Sans', sans-serif;
    font-size:10pt;
    color:#555;
    line-height: 25px;
    width:760px;
    margin:0 auto 5em auto;
  }
  .main
  {
    overflow:hidden; position:relative;
  }
  .error-spacer
  {
    height:4em;
  }
</style>
<div class="wrapper">
  <div class="error-spacer"></div>
  <div role="main" class="main">
    <h1><img src="assets/images/user/zp/sorry.png" width="600" height="300" /></h1>
    <p style="font:16px/1.6 'Microsoft Yahei'; position:absolute; left:228px; top:143px;">
      请返回我们的 <a href="{{{ route('esf') }}}" style="color:#900">首页</a> 看看?
    </p>
  </div>
</div>
@stop