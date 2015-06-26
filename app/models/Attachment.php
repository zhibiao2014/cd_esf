<?php
use lib\Tool;

class Attachment extends CustomerModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'attachment';
    public $timestamps = false;

    static public function getAttachments( $project_id ) {
      $attachments = \Category::join('attachment', 'category.id', '=', 'attachment.category_id')
      ->where(array('category.project_id' => $project_id))
      ->select('category.project_id', 'attachment.*')
      ->orderBy('attachment.sort', 'asc')
      ->orderBy('attachment.id', 'asc')
      ->get()->toArray();
      return $attachments;
    }

    static public function getAttachmentsGroupByCat( $project_id ) {
      $attachments = self::getAttachments( $project_id );
      $temp = array();
      if (is_array($attachments)) {
        foreach ($attachments as $key => $value) {
          $temp[$value['category_id']][] = $value;
        }
      }
      return $temp;
    }

    static public function upload() {
      $file = Input::file('Filedata');
      $destination_path = '/uploads/'. date("Y/m/d/");
      $real_path = public_path() . $destination_path;
      $original_name = Tool::sanitize_file_name( $file->getClientoriginalName() );
      $filename = Tool::unique_filename( $real_path, $original_name);
      $extension = $file->getClientOriginalExtension();
        // $mine_type = $file->getClientMimeType();
      $size = $file->getSize();
      $upload_success = $file->move( $real_path, $filename);
      $mine_type = mime_content_type( $real_path . $filename );
      $compression_filename = self::gd_compression_image( $real_path, $mine_type, $filename );

      // self::imagick_compression_image( $real_path, $filename );

      // $imagick = new Imagick( $real_path, $filename );

      if( $upload_success ) {
        $image_source = self::gd_create_image( $mine_type, $real_path.$filename );
        $attachment = new self();
        // $attachment->id = time();
        $attachment->path = $destination_path . $filename;
        $attachment->url = route('home') . $destination_path . $filename;
        $attachment->compression_image = $destination_path . $compression_filename;
        $attachment->compression_url = route('home') . $destination_path . $compression_filename;
        if ( $image_source ) {
          $attachment->width = imagesx($image_source);
          $attachment->height = imagesy($image_source);
        }
        $attachment->name = $original_name;
        $attachment->ext = $extension;
        $attachment->size = $size;
        $attachment->upload_time = time();
        $attachment->upload_ip = \Request::getClientIp();
        return $attachment;
      } else {
        return false;
      }
    }

    static public function remove_attachments_by_category_id( $category_id ) {
      $attachments = self::where( array('category_id' => $category_id ) )->select("id")->get()->toArray();
      if ( !empty($attachments) ) {
        $attachment_ids = array();
        foreach ($attachments as $key => $value) {
          $attachment_ids[] = $value['id'];
        }
        unset($attachments);
        self::destroy($attachment_ids);
        \Mark::remove_marks_by_attachment_id( $attachment_ids );
      }
    }

    /**
    *  批量删除Attachment , Mark , Discuss
    *  @param array $category_ids
    */
    static public function remove_attachments_by_category_ids( $category_ids ) {
      $attachments = self::whereIn( 'category_id', $category_ids )->select("id")->get()->toArray();
      if ( !empty($attachments) ) {
        $attachment_ids = array();
        foreach ($attachments as $key => $value) {
          $attachment_ids[] = $value['id'];
        }
        unset($attachments);
        self::destroy($attachment_ids);
        \Mark::remove_marks_by_attachment_ids( $attachment_ids );
      }
    }

    static public function imagick_compression_image( $real_path, $filename, $compression_percent=75 ) {
      $compression_filename = "imagick-compression-" . $filename;
      $imagick = new \Imagick( $real_path . $filename );
      $imagick->setCompression( \Imagick::COMPRESSION_JPEG );
      $imagick->setCompressionQuality($compression_percent);
      $imagick->stripImage();
      if ( $imagick->writeImage( $real_path . $compression_filename ) ) {
        return $compression_filename;
      }
      return $filename;
    }

    static public function gd_compression_image( $real_path, $mine_type, $filename, $quality=80 ) {
      $original_file = $real_path . $filename;
      $compression_filename = "compression-" . $filename;
      $image = self::gd_create_image( $mine_type, $original_file );
      if ( isset($image) ) {
        if ( imagejpeg( $image, $real_path . $compression_filename , $quality ) )  return $compression_filename;
      }
      return $filename;
    }

    static public function gd_create_image( $mine_type, $file_path ) {
      switch ($mine_type) {
        case 'image/gif':
        $image = imagecreatefromgif( $file_path );
        break;
        case 'image/jpeg':
        $image = imagecreatefromjpeg( $file_path );
        break;
        case 'image/png':
        $image = imagecreatefrompng( $file_path );
        break;
        default:
        return false;
        break;
      }
      return $image;
    }
  }
