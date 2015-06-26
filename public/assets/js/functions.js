/**
* 全选checkbox,注意：标识checkbox id固定为为check_box
* @param string name 列表check名称,如 uid[]
*/
function selectAllOrCancle(name) {
  if ($("#check_box").attr("checked")=='checked') {
    $("input[name='"+name+"']").each(function() {
      $(this).attr("checked","checked");
    });
  } else {
    $("input[name='"+name+"']").each(function() {
      $(this).removeAttr("checked");
    });
  }
}

//第一种形式 第二种形式 更换显示样式
function setTab(name,cursel,n){
  for(i=1;i<=n;i++){
    var menu=document.getElementById(name+i);
    var con=document.getElementById("con_"+name+"_"+i);
    menu.className=i==cursel?"tab01":"tab02";
    con.style.display=i==cursel?"block":"none";
  }
}

/**
* 全选checkbox,注意：标识checkbox id固定为为check_box
* @param string name 列表check名称,如 uid[]
*/
function selectall(name) {
  // alert( $("input[name='"+name+"']").length );
  /*$("input[name='"+name+"']").each(function() {
    $(this).attr("checked","checked");
  });*/
}

function sendsms( url ) {
  var Timer=null;
  var mobile = $('#phone').val();
  origin_phone = $('.origin_phone').text();
  if ( mobile == origin_phone ) {
    $('#valid_codeTip').attr('class', 'onFocus').text('手机号码没有更改，无需验证').show();
    return ;
  };
  // $('#phone').attr('disabled','disabled').addClass('Input_5');
  $('#btn_getcode').attr('disabled','disabled').val('发送中……');
  if (Timer!=null) {
    window.clearInterval(Timer);
    Timer=null;
  }
  $.ajax({
    url : url,
    type : 'post',
    dataType : 'json',
    data : {temp_mobile:mobile},
    success: function(ret) {
      if(!ret) {
        $('#valid_codeTip').attr('class', 'onError').text('数据发送失败,请重试！').show();
        $('#btn_getcode').val('向此手机发送验证码');
        $('#phone').removeAttr('disabled').removeClass('Input_5');
        $('#btn_getcode').removeAttr('disabled');
      }
      if(!ret[0]) {
        $('#valid_codeTip').attr('class', 'onError').text(ret[1]).show();
        $('#btn_getcode').val('向此手机发送验证码');
        $('#phone').removeAttr('disabled').removeClass('Input_5');
        $('#btn_getcode').removeAttr('disabled');
      } else {
        $('#valid_codeTip').attr('class', 'onCorrect').text('发送成功！').show();
        $('#valid_code').data('code', ret[1]['code']);
        var timc = ret[1]['time']||90;
        window.setInterval(function() {
          if(timc!=0) {
            timc--;
            $('#btn_getcode').val(timc+'秒后可再次重试');
          } else {
            if(Timer!=null) {
              window.clearInterval(Timer);
              Timer=null;
            }
            $('#btn_getcode').val('向此手机发送验证码');
            $('#phone').removeAttr('disabled').removeClass('Input_5');
            $('#btn_getcode').removeAttr('disabled');
          }
        },1000);
        $('#valid_code_notice').show();
      }
    },
    error: function() {
      $('#btn_getcode').removeAttr('disabled').val('向此手机发送验证码');
      $('#valid_codeTip').attr('class', 'onError').text('验证码发送错误，请稍后再试').show();
    }
  });
}

function dvmouseout(obj, ulid) {
  document.getElementById(ulid).style.display = 'none';
  obj.className = "tag_select";
}
function LocationHrefReplace(url) {
  if (navigator.userAgent.indexOf("MSIE") > 0) {
    var referLink = document.createElement('a');
    referLink.href = url;
    document.body.appendChild(referLink);
    referLink.click();
  } else {
    window.location.replace(url);
  }
}
function dvmouseover(obj, ulid) {
  document.getElementById(ulid).style.display = '';
  obj.className = "tag_select_hover";
}

function limouseover(obj) {
  if (obj.className != "open_selected") {
    obj.className = 'open_hover';
  }
}
function limouseout(obj) {
  if (obj.attributes["selected"] == "true") {
    obj.className = 'open_selected';
  }
  else {
    if (obj.className != "open_selected") {
      obj.className = 'open';
    }
  }
}
var timeout;
function hiddenPt(dl) {
  var citychange = document.getElementById(dl.id);
  citychange.style.display = "none";
  timeout = setTimeout("hiddenPt", 100)
}
function showPt(dl) {
  var citychange = document.getElementById(dl.id);
  window.clearTimeout(timeout);
  citychange.style.display = "block";
}


//幻灯window.onload=function
function SlideShow(c) {
  var a = document.getElementById("slideContainer"), f = document.getElementById("slidesImgs").getElementsByTagName("li"), h = document.getElementById("slideBar"), n = h.getElementsByTagName("span"), d = f.length, c = c || 3000, e = lastI = 0, j, m;
  function b() {
    m = setInterval(function () {
      e = e + 1 >= d ? e + 1 - d : e + 1;
      g()
    }, c)
  }
  function k() {
    clearInterval(m)
  }
  function g() {
    f[lastI].style.display = "none";
    n[lastI].className = "";
    f[e].style.display = "block";
    n[e].className = "on";
    lastI = e
  }
  f[e].style.display = "block";
  a.onmouseover = k;
  a.onmouseout = b;
  h.onmouseover = function (i) {
    j = i ? i.target : window.event.srcElement;
    if (j.nodeName === "SPAN") {
      e = parseInt(j.innerHTML, 10) - 1;
      g()
    }
  };
  b()
};

// 顶部搜索切换
function SwapTab(name, cls_show, cls_hide, cur, cnt) {
  for (i = 1; i <= cnt; i++) {
    if (i == cur) {
      $('#con_' + name + '_' + i).show();
      $('#' + name + i).attr('class', cls_show);
    } else {
      $('#con_' + name + '_' + i).hide();
      $('#' + name + i).attr('class', cls_hide);
    }
  }
}