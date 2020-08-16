<?php
class Result
{
  public $code;
  public $message;
  public $data;

  public static function successRes($data)
  {
    $instance = new self();
    $instance->code = '0000';
    $instance->message = 'SUCCESS';
    $instance->data = $data;
    return $instance;
  }

  public static function failRes($data)
  {
    $instance = new self();
    $instance->code = '0001';
    $instance->message = 'FAIL';
    $instance->data = $data;
    return $instance;
  }
}
