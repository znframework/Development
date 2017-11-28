<?php namespace ZN\Services\Request;

use ZN\In;
use ZN\Helpers\Converter;
use CallController, Lang, Http;

class InternalURL extends CallController implements InternalURLInterface
{
    //--------------------------------------------------------------------------------------------------------
    //
    // Author     : Ozan UYKUN <ozanbote@gmail.com>
    // Site       : www.znframework.com
    // License    : The MIT License
    // Copyright  : (c) 2012-2016, znframework.com
    //
    //--------------------------------------------------------------------------------------------------------

    //--------------------------------------------------------------------------------------------------------
    // Scheme Constant
    //--------------------------------------------------------------------------------------------------------
    //
    // @const int
    //
    //--------------------------------------------------------------------------------------------------------
    const SCHEME    = PHP_URL_SCHEME;

    //--------------------------------------------------------------------------------------------------------
    // Host Constant
    //--------------------------------------------------------------------------------------------------------
    //
    // @const int
    //
    //--------------------------------------------------------------------------------------------------------
    const HOST      = PHP_URL_HOST;

    //--------------------------------------------------------------------------------------------------------
    // Port Constant
    //--------------------------------------------------------------------------------------------------------
    //
    // @const int
    //
    //--------------------------------------------------------------------------------------------------------
    const PORT      = PHP_URL_PORT;

    //--------------------------------------------------------------------------------------------------------
    // User Constant
    //--------------------------------------------------------------------------------------------------------
    //
    // @const int
    //
    //--------------------------------------------------------------------------------------------------------
    const USER      = PHP_URL_USER;

    //--------------------------------------------------------------------------------------------------------
    // Pass Constant
    //--------------------------------------------------------------------------------------------------------
    //
    // @const int
    //
    //--------------------------------------------------------------------------------------------------------
    const PASS      = PHP_URL_PASS;

    //--------------------------------------------------------------------------------------------------------
    // Path Constant
    //--------------------------------------------------------------------------------------------------------
    //
    // @const int
    //
    //--------------------------------------------------------------------------------------------------------
    const PATH      = PHP_URL_PATH;

    //--------------------------------------------------------------------------------------------------------
    // Query Constant
    //--------------------------------------------------------------------------------------------------------
    //
    // @const int
    //
    //--------------------------------------------------------------------------------------------------------
    const QUERY     = PHP_URL_QUERY;

    //--------------------------------------------------------------------------------------------------------
    // fragment Constant
    //--------------------------------------------------------------------------------------------------------
    //
    // @const int
    //
    //--------------------------------------------------------------------------------------------------------
    const FRAGMENT  = PHP_URL_FRAGMENT;

    //--------------------------------------------------------------------------------------------------------
    // Rfc1738 Constant
    //--------------------------------------------------------------------------------------------------------
    //
    // @const int
    //
    //--------------------------------------------------------------------------------------------------------
    const RFC1738   = PHP_QUERY_RFC1738;

    //--------------------------------------------------------------------------------------------------------
    // Rfc3986 Constant
    //--------------------------------------------------------------------------------------------------------
    //
    // @const int
    //
    //--------------------------------------------------------------------------------------------------------
    const RFC3986   = PHP_QUERY_RFC3986;

    //--------------------------------------------------------------------------------------------------------
    // Base
    //--------------------------------------------------------------------------------------------------------
    //
    // @param  string  $uri: empty
    // @param  numeric $index:  0
    // @return string
    //
    //--------------------------------------------------------------------------------------------------------
    public function base(String $uri = NULL, Int $index = 0) : String
    {
        return $this->host(BASE_DIR . $uri);
    }

    //--------------------------------------------------------------------------------------------------------
    // Site
    //--------------------------------------------------------------------------------------------------------
    //
    // @param  string  $uri: empty
    // @param  numeric $index:  0
    // @return string
    //
    //--------------------------------------------------------------------------------------------------------
    public function site(String $uri = NULL, Int $index = 0) : String
    {
        return $this->host
        (
               BASE_DIR.
               INDEX_STATUS.
               In::getCurrentProject().
               suffix(Lang::current()).
               $uri
         );
    }

    //--------------------------------------------------------------------------------------------------
    // siteUrls() - v.4.2.6
    //--------------------------------------------------------------------------------------------------
    //
    // @param string $uri
    // @param int    $index
    //
    // @return string
    //
    //--------------------------------------------------------------------------------------------------
    function sites(String $uri = NULL, Int $index = 0) : String
    {
        return str_replace(SSL_STATUS, Http::fix(true), $this->site($uri, $index));
    }

    //--------------------------------------------------------------------------------------------------------
    // Current
    //--------------------------------------------------------------------------------------------------------
    //
    // @param  string  $fix empty
    // @return string
    //
    //--------------------------------------------------------------------------------------------------------
    public function current(String $fix = NULL) : String
    {
        $currentUrl = $this->host(server('requestUri'));

        if( ! empty($fix) )
        {
            return suffix(rtrim($currentUrl, $fix)) . $fix;
        }

        return $currentUrl;
    }

    //--------------------------------------------------------------------------------------------------------
    // Host
    //--------------------------------------------------------------------------------------------------------
    //
    // @param  string  $uri: empty
    // @return string
    //
    //--------------------------------------------------------------------------------------------------------
    public function host(String $uri = NULL) : String
    {
        return HOST_URL . In::cleanInjection($uri);
    }

    //--------------------------------------------------------------------------------------------------------
    // Prev
    //--------------------------------------------------------------------------------------------------------
    //
    // @param  void
    // @return string
    //
    //--------------------------------------------------------------------------------------------------------
    public function prev() : String
    {
        return $_SERVER['HTTP_REFERER'] ?? '';
    }

    //--------------------------------------------------------------------------------------------------------
    // Base 64 Decode
    //--------------------------------------------------------------------------------------------------------
    //
    // @param  string  $data: empty
    // @param  bool    $strict: false
    // @return mixed
    //
    //--------------------------------------------------------------------------------------------------------
    public function base64Decode(String $data, Bool $strict = false) : String
    {
        return base64_decode($data, $strict);
    }

    //--------------------------------------------------------------------------------------------------------
    // Base 64 Encode
    //--------------------------------------------------------------------------------------------------------
    //
    // @param  string  $data: empty
    // @return mixed
    //
    //--------------------------------------------------------------------------------------------------------
    public function base64Encode(String $data) : String
    {
        return base64_encode($data);
    }

    //--------------------------------------------------------------------------------------------------------
    // Headers
    //--------------------------------------------------------------------------------------------------------
    //
    // @param  string $url: empty
    // @param  string $format: 0
    // @return mixed
    //
    //--------------------------------------------------------------------------------------------------------
    public function headers(String $url, Int $format = 0) : Array
    {
        return get_headers($url, $format);
    }

    //--------------------------------------------------------------------------------------------------------
    // Headers
    //--------------------------------------------------------------------------------------------------------
    //
    // @param  string $fileName: empty
    // @param  bool   $useIncludePath: false
    // @return mixed
    //
    //--------------------------------------------------------------------------------------------------------
    public function metaTags(String $fileName, Bool $useIncludePath = false) : Array
    {
        return get_meta_tags($fileName, $useIncludePath);
    }

    //--------------------------------------------------------------------------------------------------------
    // Build Query
    //--------------------------------------------------------------------------------------------------------
    //
    // @param  mixed  $data         : empty
    // @param  string $numericPrefix: NULL
    // @param  string $separator    : NULL
    // @param  Int    $enctype = self::RFC1738
    // @return mixed
    //
    //--------------------------------------------------------------------------------------------------------
    public function buildQuery($data, String $numericPrefix = NULL, String $separator = NULL, Int $enctype = PHP_QUERY_RFC1738) : String
    {
        return http_build_query($data, $numericPrefix, $separator ?? '&', $enctype);
    }

    //--------------------------------------------------------------------------------------------------------
    // Parse
    //--------------------------------------------------------------------------------------------------------
    //
    // @param  string  $url      : empty
    // @param  scalar  $component: 1
    // @return mixed
    //
    //--------------------------------------------------------------------------------------------------------
    public function parse(String $url, $component = 1)
    {
        return parse_url($url, Converter\VariableTypes::toConstant($component, 'PHP_URL_'));
    }

    //--------------------------------------------------------------------------------------------------------
    // Raw Decode
    //--------------------------------------------------------------------------------------------------------
    //
    // @param  string  $str: empty
    //
    //--------------------------------------------------------------------------------------------------------
    public function rawDecode(String $str) : String
    {
        return rawurldecode($str);
    }

    //--------------------------------------------------------------------------------------------------------
    // Raw Encode
    //--------------------------------------------------------------------------------------------------------
    //
    // @param  string  $str: empty
    // @return mixed
    //
    //--------------------------------------------------------------------------------------------------------
    public function rawEncode(String $str) : String
    {
        return rawurlencode($str);
    }

    //--------------------------------------------------------------------------------------------------------
    // Decode
    //--------------------------------------------------------------------------------------------------------
    //
    // @param  string  $str: empty
    //
    //--------------------------------------------------------------------------------------------------------
    public function decode(String $str) : String
    {
        return urldecode($str);
    }

    //--------------------------------------------------------------------------------------------------------
    // Encode
    //--------------------------------------------------------------------------------------------------------
    //
    // @param  string  $str: empt
    // @return mixed
    //
    //--------------------------------------------------------------------------------------------------------
    public function encode(String $str) : String
    {
        return urlencode($str);
    }
}
