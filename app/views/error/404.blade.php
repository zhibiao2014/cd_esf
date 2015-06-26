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
      overflow:hidden;
    }
    .error-spacer
    {
      height:4em;
    }
</style>

  <div class="wrapper">
    <div class="error-spacer"></div>
    <div role="main" class="main">

      <h1>Unn</h1>

      <h2>你查看的页面不存在！！！</h2>

      <p>
        或许你想去到我们的 <a href="{{{ route('esf') }}}">首页</a>看看?
      </p>
    </div>
  </div>

@stop