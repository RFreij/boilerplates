<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 9-9-2017
 * Time: 21:03
 */

namespace app\services;

class Response {
    
    /**
     * @var array
     */
    public $headers;
    
    /**
     * @var string
     */
    protected $content;
    
    /**
     * @var string
     */
    protected $version;
    
    /**
     * @var int
     */
    protected $statusCode;
    
    /**
     * @var string
     */
    protected $statusText;
    
    /**
     * @var string
     */
    protected $charset;
    
    /**
     * Response constructor.
     *
     * @param string $content
     * @param int    $status
     * @param array  $headers
     */
    public function __construct($content = '', $status = 200, $headers = array()) {
        $this->headers = $headers;
        $this->setContent($content);
        $this->setStatusCode($status);
        $this->setProtocolVersion('1.0');
    }
    
    /** Factory method
     *
     * @param string $content
     * @param int    $status
     * @param array  $headers
     *
     * @return static
     */
    public static function response($content = '', $status = 200, $headers = array()) {
        return new static($content, $status, $headers);
    }
    
    /**
     * Returns the HTTP string
     * @return string
     */
    public function __toString() {
    }
    
    public function prepare() {
        
        $headers = $this->headers;
        
        foreach($headers as $header){
        
        }
        
    }
    
    
}