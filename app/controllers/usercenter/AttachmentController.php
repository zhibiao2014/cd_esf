<?php
namespace usercenter;

use BaseController;
use View;
use Response;
use Input;
use Validator;
use Attachment;

class AttachmentController extends BaseController {

  protected $rules = array( 'Filedata' => 'image|mimes:jpeg,jpg,gif,png|max:3072|required' );

  public function store() {
      $input = Input::all();
      $validator = Validator::make($input, $this->rules);
      if ($validator->fails()) {
        $messages = $validator->messages();
        return Response::json(array( 'error_code' => 1 , 'message' => $messages ));
      }
      $attachment = Attachment::upload();
      if ( $attachment->save() ) {
        return Response::json( array( 'error_code' => 0 , 'data' => $attachment->toArray() ) , 200);
      } else {
        return Response::json( array( 'error_code' => 1 , 'message' => array('上传失败') ), 400 );
      }
  }

}