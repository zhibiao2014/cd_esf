<?php
namespace lib;

class Tool {

  public static function safe_replace( $string ) {
    $string = str_replace('%20','',$string);
    $string = str_replace('%27','',$string);
    $string = str_replace('%2527','',$string);
    $string = str_replace('*','',$string);
    $string = str_replace('"','&quot;',$string);
    $string = str_replace("'",'',$string);
    $string = str_replace('"','',$string);
    $string = str_replace(';','',$string);
    $string = str_replace('<','&lt;',$string);
    $string = str_replace('>','&gt;',$string);
    $string = str_replace("{",'',$string);
    $string = str_replace('}','',$string);
    $string = str_replace('\\','',$string);
    return $string;
  }

  /**
   * Sanitizes a filename replacing whitespace with dashes
   *
   * Removes special characters that are illegal in filenames on certain
   * operating systems and special characters requiring special escaping
   * to manipulate at the command line. Replaces spaces and consecutive
   * dashes with a single dash. Trim period, dash and underscore from beginning
   * and end of filename.
   *
   *
   * @param string $filename The filename to be sanitized
   * @return string The sanitized filename
   */
  public static function sanitize_file_name( $filename ) {
    $filename_raw = $filename;
    $special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}");
    $filename = str_replace($special_chars, '', $filename);
    $filename = preg_replace('/[\s-]+/', '-', $filename);
    $filename = trim($filename, '.-_');
    return $filename;
  }

  /**
   * Get a filename that is sanitized and unique for the given directory.
   *
   * If the filename is not unique, then a number will be added to the filename
   * before the extension, and will continue adding numbers until the filename is
   * unique.
   *
   * The callback is passed three parameters, the first one is the directory, the
   * second is the filename, and the third is the extension.
   *
   * @param string $dir
   * @param string $filename
   * @param mixed $unique_filename_callback Callback.
   * @return string New filename, if given wasn't unique.
   */
  public static function unique_filename( $dir, $filename, $unique_filename_callback = null ) {
    // sanitize the file name before we begin processing
    // $filename = self::sanitize_file_name($filename);
    // separate the filename into a name and extension
    $info = pathinfo($filename);
    $ext = !empty($info['extension']) ? '.' . $info['extension'] : '';
    $name = basename($filename, $ext);
      // edge case: if file is named '.ext', treat as an empty name
    if ( $name === $ext )
      $name = '';

      // Increment the file number until we have a unique file to save in $dir. Use callback if supplied.
    if ( $unique_filename_callback && is_callable( $unique_filename_callback ) ) {
      $filename = call_user_func( $unique_filename_callback, $dir, $name, $ext );
    } else {
      $number = '';

          // change '.ext' to lower case
      if ( $ext && strtolower($ext) != $ext ) {
        $ext2 = strtolower($ext);
        $filename2 = preg_replace( '|' . preg_quote($ext) . '$|', $ext2, $filename );

              // check for both lower and upper case extension or image sub-sizes may be overwritten
        while ( file_exists($dir . "/$filename") || file_exists($dir . "/$filename2") ) {
          $new_number = $number + 1;
          $filename = str_replace( "$number$ext", "$new_number$ext", $filename );
          $filename2 = str_replace( "$number$ext2", "$new_number$ext2", $filename2 );
          $number = $new_number;
        }
        return $filename2;
      }

      while ( file_exists( $dir . "/$filename" ) ) {
        if ( '' == "$number$ext" )
          $filename = $filename . ++$number . $ext;
        else
          $filename = str_replace( "$number$ext", ++$number . $ext, $filename );
      }
    }

    return $filename;
  }

  public static function get_mark_xy( $scale_width, $mark ) {
    $xy =  explode(',', $mark['coordinate']);
    if ( $mark['width'] > $scale_width ) {
      $percent = $scale_width / $mark['width'];
      return array( $mark['width'] * $xy[0]/100 * $percent, $mark['height'] * $xy[1]/100 * $percent );
    } else {
      return array( $mark['width'] * $xy[0]/100, $mark['height'] * $xy[1]/100 );
    }
  }

  public static function base64_image( $file_type, $img_file ) {
    $imgData = base64_encode( file_get_contents(public_path().$img_file) );
    $src = 'data:image/'. $file_type .';base64,'.$imgData;
    return $src;
  }

  /**
   *  将数组转换成以主键值为key的多维数组
   *  @param array $array  需要转换的数组
   *  @param string $_key  主键名称
   */
  public static function array_key_translate($array, $_key = 'id') {
    if (is_array($array)) {
      $temp = array();
      foreach ($array as $value) {
        if ( is_array($value) ) {
          $temp[$value[$_key]] = $value;
        } elseif ( is_a($value, 'stdClass') ) {
          $temp[$value->$_key] = $value;
        } else {
          $temp[] = $value;
        }
      }
      return $temp;
    } elseif ( is_a($array, 'Illuminate\Database\Eloquent\Collection') ) {
      foreach ($array as $value) {
        $temp[$value->$_key] = $value;
      }
      return $temp;
    } else {
      $temp[] = $value;
    }
    return $array;
  }

  /**
   *  将数组转换成 主键 => 值 的键值对(一位数组)，适应select
   *  @param array $array  需要转换的数组
   *  @param string $_key  主键名称
   *  @param string $_value  字段名称
   */
  public static function array_translate($array, $_key = 'id', $_value= 'name') {
    if (is_array($array)) {
      $temp = array();
      foreach ($array as $value) {
        $temp[$value[$_key]] = $value[$_value];
      }
      return $temp;
    }
    return $array;
  }

  /**
   * 格式化文本域内容
   *
   * @param $string 文本域内容
   * @return string
   */
  public static function trim_textarea($string) {
    $string = nl2br ( str_replace ( ' ', '&nbsp;', $string ) );
    return $string;
  }


  /**
   * 字符截取 支持UTF8/GBK
   * @param $string
   * @param $length
   * @param $dot
   */
  public static function str_cut($string, $length, $dot = '...') {
    $strlen = strlen($string);
    if($strlen <= $length) return $string;
    $string = str_replace(array(' ','&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array('∵',' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);
    $strcut = '';
    $length = intval($length-strlen($dot)-$length/3);
    $n = $tn = $noc = 0;
    while($n < strlen($string)) {
      $t = ord($string[$n]);
      if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
        $tn = 1; $n++; $noc++;
      } elseif(194 <= $t && $t <= 223) {
        $tn = 2; $n += 2; $noc += 2;
      } elseif(224 <= $t && $t <= 239) {
        $tn = 3; $n += 3; $noc += 2;
      } elseif(240 <= $t && $t <= 247) {
        $tn = 4; $n += 4; $noc += 2;
      } elseif(248 <= $t && $t <= 251) {
        $tn = 5; $n += 5; $noc += 2;
      } elseif($t == 252 || $t == 253) {
        $tn = 6; $n += 6; $noc += 2;
      } else {
        $n++;
      }
      if($noc >= $length) {
        break;
      }
    }
    if($noc > $length) {
      $n -= $tn;
    }
    $strcut = substr($string, 0, $n);
    $strcut = str_replace(array('∵', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), array(' ', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), $strcut);
    return $strcut.$dot;
  }


  /**
   * 转义 javascript 代码标记
   *
   * @param $str
   * @return mixed
   */
  public static function trim_script($str) {
    if(is_array($str)){
      foreach ($str as $key => $val){
        $str[$key] = trim_script($val);
      }
    }else{
      $str = preg_replace ( '/\<([\/]?)script([^\>]*?)\>/si', '&lt;\\1script\\2&gt;', $str );
      $str = preg_replace ( '/\<([\/]?)iframe([^\>]*?)\>/si', '&lt;\\1iframe\\2&gt;', $str );
      $str = preg_replace ( '/\<([\/]?)frame([^\>]*?)\>/si', '&lt;\\1frame\\2&gt;', $str );
      $str = str_replace ( 'javascript:', 'javascript：', $str );
    }
    return $str;
  }

  public static function br2nl($text) {
    /*$breaks = array("<br />","<br>","<br/>");
    $text = str_ireplace($breaks, "\n", $text);*/
    return strip_tags($text);
  }

  /**
   *
   * @param $date
   * @return boolean
   */
  public static function isToday($date) {
    return (strtotime($date) === strtotime('today'));
  }

  public static function array_strip_tags($array) {
    $result = array();
    foreach ($array as $key => $value) {
      $key = strip_tags($key);
      if (is_array($value)) {
        $result[$key] = self::array_strip_tags($value);
      } else {
        $result[$key] = e($value);
      }
    }
    return $result;
  }

  public static function pagination( $paginator, $range = 5 ) {
    $page_string = '';
    $max_page = $paginator->getLastPage();
    $paged = $paginator->getCurrentPage();
    $previousPage = ($paged > 1) ? $paged - 1 : 1;
    $nextPage = ( $paged >= $max_page ) ? $max_page : $paged + 1;
    if( $max_page > 1 ) {
      $page_string .= '<div class="page fr mt10 mr10">';
      $page_string .= '<span>共 ' . $paginator->getTotal() .' 条</span>';
      $page_string .= sprintf('<a href="%s" class="a1%s"> 上一页 </a>', $paginator->getUrl($previousPage), ($paged == 1) ? ' disabled' : '');

      if( $max_page > $range ) {
        if( $paged < $range ) {
          for( $i = 1; $i <= ( $range + 1 ); $i++ ) {
            if( $i == $paged ){
              $page_string .= '<span class="cur">' . $i . '</span>';
            } else {
              $page_string .= '<a href="' . $paginator->getUrl($i) . '">' . $i . '</a>';
            }
          }
          $page_string .= '<span class="extend">...</span>';
        } elseif( $paged >= ( $max_page - ceil( ( $range/2 ) ) ) ) {
          $page_string .= '<span class="extend">...</span>';
          for( $i = $max_page - $range; $i <= $max_page; $i++ ) {
            if( $i == $paged ) {
              $page_string .= '<span class="cur">' . $i . '</span>';
            } else {
              $page_string .= '<a href="' . $paginator->getUrl($i) . '">' . $i . '</a>';
            }
          }
        } elseif( $paged >= $range && $paged < ( $max_page - ceil( ( $range/2 ) ) ) ) {
          $page_string .= '<span class="extend">...</span>';
          for( $i = ( $paged - ceil( $range/2 ) ); $i <= ( $paged + ceil( ( $range/2 ) ) ); $i++ ) {
            if( $i == $paged ) {
              $page_string .= '<span class="cur">' . $i . '</span>';
            } else {
              $page_string .= '<a href="' . $paginator->getUrl($i) . '">' . $i . '</a>';
            }
          }
          $page_string .= '<span class="extend">...</span>';
        }
      } else {
        for( $i = 1; $i <= $max_page; $i++ ) {
          if( $i == $paged ) {
            $page_string .= '<span class="cur">' . $i . '</span>';
          } else {
            $page_string .= '<a href="' . $paginator->getUrl($i) . '">' . $i . '</a>';
          }
        }
      }
      $page_string .= sprintf('<a href="%s" class="a1%s"> 下一页 </a>', $paginator->getUrl($nextPage), ($paged == $max_page) ? ' disabled' : '');
      $page_string .= '</div>';
    }
    return $page_string;
  }

  public static function get_timeago( $ptime ) {
    $etime = time() - $ptime;

    if( $etime < 10 ) {
      return '刚刚更新';
    }

    $a = array( 12 * 30 * 24 * 60 * 60  =>  '年',
      30 * 24 * 60 * 60       =>  '月',
      24 * 60 * 60            =>  '天',
      60 * 60             =>  '小时',
      60                  =>  '分钟',
      1                   =>  '秒'
      );

    foreach( $a as $secs => $str ) {
      $d = $etime / $secs;
      if( $d >= 1 ) {
        $r = round( $d );
        return '大约 ' . $r . ' ' . $str . '以前';
      }
    }
  }


  /**
   * 把返回的数据集转换成Tree
   * @access public
   * @param array $list 要转换的数据集
   * @param string $pid parent标记字段
   * @param string $level level标记字段
   * @return array
   */
  public static function list_to_tree($list, $pk='id',$pid = 'pid',$child = '_child',$root=0) {
      // 创建Tree
    $tree = array();
    if(is_array($list)) {
          // 创建基于主键的数组引用
      $refer = array();
      foreach ($list as $key => $data) {
        $refer[$data[$pk]] =& $list[$key];
      }
      foreach ($list as $key => $data) {
              // 判断是否存在parent
        $parentId = $data[$pid];
        if ($root == $parentId) {
          $tree[$data[$pk]] =& $list[$key];
        }else{
          if (isset($refer[$parentId])) {
            $parent =& $refer[$parentId];
            $parent[$child][$data[$pk]] =& $list[$key];
          }
        }
      }
    }
    return $tree;
  }

  /**
   * 返回遍历后按层级排序的数组
   * @access public
   * @param array $tree 要转换的树
   * @param string $cat 数组引用，保存结果集
   * @param string $level 层级标注
   * @return array
   */
  public static function tree_to_array($tree, &$cat = array(), $level = 1) {
    foreach ($tree as $key => $value) {
      $temp = $value;
      if ( isset($temp['_child']) && $temp['_child'] ) {
        $temp['_child'] = true;
        $temp['level'] = $level;
        $cat[$value['id']] = $temp;
      } else {
        $temp['_child'] = false;
        $temp['level'] = $level;
        $cat[$value['id']] = $temp;
      }
      if ( isset($temp['_child']) && $temp['_child'] ) {
        self::tree_to_array($value['_child'],$cat, ($level + 1));
      }
    }
  }

}


