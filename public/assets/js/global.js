$(function(){
  // 默认文字
  $('input, textarea').placeholder();

  /* 修改手机号码 */
  $(".phone").on("click", "#edit_phone" , function( e ) {
    e.preventDefault();
    $(this).attr("id", "reset").text("使用默认手机").siblings(".origin_phone").hide().siblings("#phone").show().focus();
    $(".valid_code").show();
  });

  /* 修改手机号码 */
  $(".phone").on("click", "#reset" , function( e ) {
    e.preventDefault();
    $(this).attr("id", "edit_phone").text("修改").siblings(".origin_phone").show().siblings("#phone").hide();
    $(".valid_code").hide();
  });

  /* 区域处理 */
  $("#area_top").change(function() {
    area_top_id = $(this).val();
    area_obj = $(this).siblings('#area');
    if ( area_top_id != 0 ) {
      html = '<option value=0>请选择</option>';
      $.each( GlobalParams.areas, function( index, value) {
        if ( value.pid == area_top_id ) {
          html += "<option value='" + value.id + "'>" + value.name + "</option>";
        }
      });
      $(area_obj).html( html );
    };
  });
  /* 区域处理结束 */

  /* 特色标签处理 */
  $("#add_customer_tag").click(function() {
    num = $(this).data( 'num' ) ? $(this).data( 'num' ) : 3;
    length = $(this).data( 'length' ) ? $(this).data( 'length' ) : 10;
    placeholder = $(this).data( 'placeholder' ) ? $(this).data( 'placeholder' ) : '特色标签';
    input_obj = $(this).siblings('#customer_tag');
    tag_string = input_obj.val();
    if ( customer_tag >= num ) {
      alert( '自定义标签最多三个' );
    } else {
      if( tag_string.length <= 0 || tag_string.length > length ) {
        alert( placeholder + '长度必须大于0且不超过十个汉字' );
      } else {
        $('#brightspot').append("<li class='actived'>" + tag_string +  "<a href='javascript:void(0);' class='cbdel'></a><input type='hidden' name='info[customer_tag][]' value='" + tag_string + "'/></li>");
        customer_tag++;
        input_obj.attr('placeholder', "最多还可增加" + ( num - customer_tag ) + "个" + placeholder).val('');
      };
    }
  })
  $('#brightspot').on('click', 'li .cbdel', function() {
    $(this).parent('li').remove();
    customer_tag--;
    $('#customer_tag').attr('placeholder', "最多还可增加" + ( num - customer_tag ) + "个" + placeholder).val('');
  });

  $('#fuli input[type="checkbox"]').change(function(){
    $(this).parent('li').toggleClass('active');
  });
  /* 特色标签处理结束 */

  /* 不同类型发布切换 */
  $(".type_tab input[type='radio']").change(function(){
    window.location = $(this).data('url');
  })

  /* 委托切换 */
  $(".commission .wt_button").click(function( e ){
    e.preventDefault();
    $(this).addClass('active').siblings('.wt_button').removeClass('active').siblings('input').val( $(this).data('commission') );
  });

  /* 小区JS效果处理 */
  $("#community_name").keyup( function() {
    house_name = $(this).val();
    var items = [];
    if ( house_name != "" ) {
      $.each( GlobalParams.houses, function( key, val ) {
        if ( val.title.indexOf(house_name) != -1 ) {
          items.push( "<li data-id='" + val.id + "' data-title='" + val.title + "' data-price='" + val.price + "'><span class='fr'>" + val.address + "</span><span class='mc'>" + val.title +  "</span></li>" );
        };
      });
      if ( items.length > 0 ) {
        $("#lp_results").html( items.join( "" ) ).show();
      };
    } else {
      $("#lp_results").html( "" ).hide();
    }
  });
  $('#lp_results').on( "click", 'li', function(e) {
    e.stopPropagation();
    $(this).parent().hide().siblings('#community_name').val($(this).data('title')).siblings('#community_id').val($(this).data('id'));
    $('#address').val($(this).children('.fr').text()).focus();
  });
  // 隐藏下拉
  if ( $("#community_name").length > 0 ) {
    $(document).bind('click', function(e) {
      var container = $("#lp_results");
      if (container.has(e.target).length === 0) {
        container.hide();
      }
    });
  }
  /* 小区结束 */

  /* 删除 */
  $('.delete_button').click(function(){
    _this = $(this);
    dialog({
      title: '提示',
      content: '删除后不可恢复，确定删除吗？',
      okValue: '确定',
      ok: function () {
        _this.parent('form').submit();
        return true;
      },
      cancelValue: '取消',
      cancel: function () {}
    }).show();
  });
  /* 删除结束 */
  /* 刷新房源 */
  $('.refresh').click(function(e) {
    refresh_obj = this;
    e.preventDefault();
    if ( GlobalParams.allow_refresh_time <= GlobalParams.refresh_time ) {
      dialog({
        title: '提示',
        content: '你今天的刷新次数已用完！',
        okValue: '确定',
        ok: function () {},
        quickClose: true
      }).show();
    } else {
      is_first = true;
      dialog({
        title: '提示',
        content: '确认刷新！',
        okValue: '确定',
        ok: function () {
          if ( !is_first ) {
            return false;
          };
          _this = this;
          this.content("刷新中……");
          is_first = false;
          $.ajax({
            url : GlobalParams.refresh_url,
            type : 'post',
            data: { 'id' : $(refresh_obj).data('id'), 'model' : $(refresh_obj).data('model') },
            dataType : 'json',
            success: function( res ) {
              _this.content( res.message );
              setTimeout(function () {
                _this.close().remove();
              }, 2000);
            },
            error: function() {
              _this.content('刷新失败，请稍后再试');
              _this.ok = function() {
                return ;
              };
              setTimeout(function () {
                _this.close().remove();
              }, 2000);
            }
          })
          return false;
        },
        cancelValue: '取消',
        cancel: function () {}
      }).show();
}
});
/* 刷新房源结束 */

/* 顶部搜索js */
if ( $( '.search_box' ).length > 0 ) {
  $(document).bind('click', function(e) {
    $(".menubar").each( function(index, obj) {
      $("#"+$(obj).data("target")).addClass("hidbox");
    });
  });
  $(".menubar").click( function(e) {
    e.stopPropagation();
    $(".menubar").each( function(index, obj) {
      $("#"+$(obj).data("target")).addClass("hidbox");
        // if(obj != this ) {$("#"+$(obj).data("target")).addClass("hidbox");}
      });
    $id = $(this).data("target");
    if ($("#"+$id).hasClass('hidbox')) {
      $("#"+$id).removeClass('hidbox');
    } else {
      $("#"+$id).addClass('hidbox');
    };
  });

  $(".search_box .pick a").click(function(){
    $cls = $(this).parent(".pick").data("target");
    $(this).siblings("input").val($(this).attr('val'));
    $(this).parent(".pick").siblings("a."+$cls).text($(this).text());
    $(this).parent(".pick").addClass("hidbox");
  });
}
/* 顶部搜索js结束 */

$('#price_filter').click(function() {
  query = $(this).data('query');
  price1 = $(this).siblings('.esf_textA').val();
  price2 = $(this).siblings('.esf_textB').val();
  query.price = [price1, price2];
  window.location.href = $(this).data('url') + '?' + $.param( query );
});

/* 列表排序js */
$('#sort_select').change(function() {
  base_url = $(this).data('url');
  value = $(this).val();
  sort = value.split('-');
  if (/\?/.test(base_url)) {
    window.location.href = base_url + '&s[]=' + sort[0] + '&s[]=' + sort[1];
  } else {
    window.location.href = base_url + '?s[]=' + sort[0] + '&s[]=' + sort[1];
  }

});
/* 列表排序js结束 */

  //资讯中心 城市分类隐藏显示
  var showcity;
  $( "#city_Name" ).hover( function() {
    window.clearTimeout(showcity);
    $('#city_Name').attr('class', 'cne1');
    $('#city_List').slideDown();
  },function() {
    showcity=window.setTimeout( function() {
      $('#city_Name').attr('class', 'cne2');
      $('#city_List').slideUp();
    } ,600);
  } );

  // 全选
  $('.frptao').on( 'click', '.selectall', function() {
    $(this).attr('class', 'cancelall').val('取消全选').siblings('label').children('input').prop('checked', true);
  });

  $('.frptao').on( 'click', '.cancelall', function() {
    $(this).attr('class', 'selectall').val('全选').siblings('label').children('input').prop('checked', false);
  });

  // 自定义tabs
  $('.tabs').click(function( e ){
    e.preventDefault()
    tbdate = $(this).closest( '.tabDate' );
    var current_block = $(tbdate).children(".tabs.tab01").attr('href');
    $(tbdate).children(".tabs").removeClass("tab01");
    $(this).addClass("tab01");
    $(current_block).hide()
    var activeTab = $(this).attr("href");
    $(activeTab).show();
  });


  /* 文件上传 */
  if ( $("#file_upload").length > 0 ) {
    $('#file_upload').uploadify({
      'auto'            : true,
      'swf'             : GlobalParams.upload_swf + '?' + Math.random(),
      'uploader'        : GlobalParams.upload_url,
      'buttonImage'     : '',
      'buttonClass'     : 'ButUpImg_1',
      'buttonText'      : '请上传图片',
      'height'          : '30',
      'width'           : '80',
      'fileSizeLimit'   : "3MB",
      'fileTypeDesc'    : '图片上传',
      'fileTypeExts'    : '*.gif; *.jpg; *.png; *.jpeg',
      'removeTimeout'   : 1,
      'queueSizeLimit'  : 99,
      'uploadLimit'     : (GlobalParams.hasOwnProperty('image_num')) ? 10 - GlobalParams.image_num : 10,
      'onUploadError'   : function(file, errorCode, errorMsg, errorString) {
        alert(file.name + ' 上传失败，错误原因: ' + errorString);
      },
      'onUploadSuccess' : function(file, data, response) {
        var image_info = $.parseJSON(data);
        if ( image_info.error_code == 1 ) {
          alert( image_info.message[0] );
        } else {
          input_name = $('#upload_box').data('input') ? $('#upload_box').data('input') : 'room_images';
          image = image_info.data;
          var html = '<div class="imgbox">' +
          '<div class="w_upload">' +
          '<a href="javascript:void(0)" class="item_close">删除</a>' +
          '<span class="item_box"><img src="' + image.url + '"></span>' +
          '</div>' +
          '<input type="hidden" name="info[' + input_name + '][' + image.id + '][id]" value="' + image.id + '" />' +
          '<input type="hidden" name="info[' + input_name + '][' + image.id + '][url]" value="' + image.url + '" />' +
          '</div>';
          $('#preview').append(html);
          $('span.upload_count').html( $('.upload_count').text() - ( -1 ) );
        };
      }
    });
    $('#preview').on('click', '.item_close', function(e) {
      $(this).parents("div.imgbox").remove();
      $('span.upload_count').html( $('.upload_count').text() - 1 );
    });
  }
  /* 文件上传结束 */


  /* 日期插件 */
  if ($('.datepicker').length > 0) {
    $('.datepicker').datepicker( {altFormat: "yy-mm-dd", changeMonth: true, changeYear: true} );
    $.datepicker.regional['zh-CN'] = {
      clearText: '清除',
      clearStatus: '清除已选日期',
      closeText: '关闭',
      closeStatus: '不改变当前选择',
      prevText: '<上月',
      prevStatus: '显示上月',
      prevBigText: '<<',
      prevBigStatus: '显示上一年',
      nextText: '下月>',
      nextStatus: '显示下月',
      nextBigText: '>>',
      nextBigStatus: '显示下一年',
      currentText: '今天',
      currentStatus: '显示本月',
      monthNames: ['一月','二月','三月','四月','五月','六月', '七月','八月','九月','十月','十一月','十二月'],
      monthNamesShort: ['一','二','三','四','五','六', '七','八','九','十','十一','十二'],
      monthStatus: '选择月份',
      yearStatus: '选择年份',
      weekHeader: '周',
      weekStatus: '年内周次',
      dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
      dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
      dayNamesMin: ['日','一','二','三','四','五','六'],
      dayStatus: '设置 DD 为一周起始',
      dateStatus: '选择 m月 d日, DD',
      dateFormat: 'yy-mm-dd',
      firstDay: 1,
      initStatus: '请选择日期',
      isRTL: false
    };
    $.datepicker.setDefaults($.datepicker.regional['zh-CN']);
  };
});