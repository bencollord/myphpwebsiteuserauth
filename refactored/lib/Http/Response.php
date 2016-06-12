<?php

namespace MyCodeLab\Http;

class Response
{
  const CONTINUE                         = 100;
  const SWITCHING_PROTOCOLS              = 101;
  const OK                               = 200;
  const CREATED                          = 201;
  const ACCEPTED                         = 202;
  const NON_AUTHORITATIVE_INFORMATION    = 203;
  const NO_CONTENT                       = 204;
  const RESET_CONTENT                    = 205;
  const PARTIAL_CONTENT                  = 206;
  const MULTIPLE_CHOICES                 = 300;
  const MOVED_PERMANENTLY                = 301;
  const FOUND                            = 302;
  const SEE_OTHER                        = 303;
  const NOT_MODIFIED                     = 304;
  const USE_PROXY                        = 305;
  const TEMPORARY_REDIRECT               = 307;
  const BAD_REQUEST                      = 400;
  const UNAUTHORIZED                     = 401;
  const PAYMENT_REQUIRED                 = 402;
  const FORBIDDEN                        = 403;
  const NOT_FOUND                        = 404;
  const METHOD_NOT_ALLOWED               = 405;
  const NOT_ACCEPTABLE                   = 406;
  const PROXY_AUTHENTICATION_REQUIRED    = 407;
  const REQUEST_TIME_OUT                 = 408;
  const CONFLICT                         = 409;
  const GONE                             = 410;
  const LENGTH_REQUIRED                  = 411;
  const PRECONDITION_FAILED              = 412;
  const REQUEST_ENTITY_TOO_LARGE         = 413;
  const REQUEST_URI_TOO_LARGE            = 414;
  const UNSUPPORTED_MEDIA_TYPE           = 415;
  const REQUESTED_RANGE_NOT_SATISFIABLE  = 416;
  const EXPECTATION_FAILED               = 417;
  const INTERNAL_SERVER_ERROR            = 500;
  const NOT_IMPLEMENTED                  = 501;
  const BAD_GATEWAY                      = 502;
  const SERVICE_UNAVAILABLE              = 503;
  const GATEWAY_TIMEOUT                  = 504;
  const HTTP_VERSION_NOT_SUPPORTED       = 505;

  /**
   * @var string[]
   */
  private static $statuses = [
    100 => 'Continue',
    101 => 'Switching Protocols',
    200 => 'OK',
    201 => 'Created',
    202 => 'Accepted',
    203 => 'Non-Authoritative Information',
    204 => 'No Content',
    205 => 'Reset Content',
    206 => 'Partial Content',
    300 => 'Multiple Choices',
    301 => 'Moved Permanently',
    302 => 'Found',
    303 => 'See Other',
    304 => 'Not Modified',
    305 => 'Use Proxy',
    307 => 'Temporary Redirect',
    400 => 'Bad Request',
    401 => 'Unauthorized',
    402 => 'Payment Required',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    406 => 'Not Acceptable',
    407 => 'Proxy Authentication Required',
    408 => 'Request Time-out',
    409 => 'Conflict',
    410 => 'Gone',
    411 => 'Length Required',
    412 => 'Precondition Failed',
    413 => 'Request Entity Too Large',
    414 => 'Request-URI Too Large',
    415 => 'Unsupported Media Type',
    416 => 'Requested range not satisfiable',
    417 => 'Expectation Failed',
    500 => 'Internal Server Error',
    501 => 'Not Implemented',
    502 => 'Bad Gateway',
    503 => 'Service Unavailable',
    504 => 'Gateway Time-out',
    505 => 'HTTP Version not supported'
  ];

  /**
   * @var string[]
   */
  protected $headers = array();

  /**
   * @var string - Response MIME type
   */
  protected $contentType;

  /**
   * @var string
   */
  protected $body = '';

  /**
   * @var int
   */
  protected $statusCode;

  public function __construct($code = 200)
  {
    if (!array_key_exists($code, self::$statuses)) {
      throw new InvalidArgumentException("$code is not a valid HTTP status code.");
    }

    $this->statusCode = $code;
  }

  public function redirect($url) 
  {
    header("Location: $url");
  }

  public function addHeader($header, $value = null)
  {
    if (empty($value)) {
      $fragments = explode(':', $header);
      $header    = array_shift($fragments);
      $value     = implode(':', $fragments);
    }

    $this->headers[$header] = $value;

    return $this;
  }

  /**
   * Appends content to the response body.
   * 
   * @param string $input 
   *                      
   * @return $this
   */
  public function write($input) 
  {
    $this->body .= $input;

    return $this;
  }

  public function send()
  {
    $this->sendHeaders();
    $this->sendBody();
  }

  public function sendHeaders()
  {
    foreach ($this->headers as $name => $value) {
      header("{$name}: {$value}");
    }
  }

  public function sendBody()
  {
    echo $this->body;
  }

}