<?php
namespace lib;
class SMS {

  private static function postSMS($url, $data = '') {
    $port = "";
    $post = "";
    $row = parse_url($url);
    $host = $row['host'];
    $port = isset($row['port']) ? $row['port'] : 80;
    $file = $row['path'];
    while (list($k, $v) = each($data)) {
       //转URL标准码
      $post .= rawurlencode($k) . "=" . rawurlencode($v) . "&";
    }
    $post = substr($post, 0, -1);
    $len = strlen($post);
    $fp = @fsockopen($host, $port, $errno, $errstr, 10);
    if (!$fp) {
      return "$errstr ($errno)\n";
    } else {
      $receive = '';
      $out = "POST $file HTTP/1.1\r\n";
      $out .= "Host: $host\r\n";
      $out .= "Content-type: application/x-www-form-urlencoded\r\n";
      $out .= "Connection: Close\r\n";
      $out .= "Content-Length: $len\r\n\r\n";
      $out .= $post;
      fwrite($fp, $out);
      while (!feof($fp)) {
        $receive .= fgets($fp, 128);
      }
      fclose($fp);
      $receive = explode("\r\n\r\n", $receive);
      unset($receive[0]);
      return implode("", $receive);
    }
  }

  public static function send($phone, $msg) {
    $config = array(
    'sms_psn' => 'cdwanxun', // 账号
    'sms_pwd' => 'dR5Hlo81', // 密码
    'sms_sendurl' => 'http://api.sms.cn/mtutf8/', // 发送路径
    );
    $data = array (
      //用户账号
      'uid' => $config['sms_psn'],
      //MD5位32密码,密码和用户名拼接字符
      'pwd' => md5($config['sms_pwd'] . $config['sms_psn']),
      //号码
      'mobile' => $phone,
      //内容 
      'content' => $msg, 
      'mobileids' => '',
      //定时发送
      'time' => '', 
      );
    //POST方式提交
    $re = self::postSMS($config['sms_sendurl'], $data);   
    return $re;
  }
}