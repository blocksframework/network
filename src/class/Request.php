<?php

namespace Blocks\Network;

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;

class Request {
    static public ServerRequestInterface $request;

    public static function init() {
        self::$request = ServerRequest::fromGlobals();
    }

    public static function isPost() {
        if ( isset( $_SERVER['REQUEST_METHOD'] ) && $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            return true;
        } else {
            return false;
        }
    }

    public static function isGet() {
        if ( isset( $_SERVER['REQUEST_METHOD'] ) && $_SERVER['REQUEST_METHOD'] === 'GET' ) {
            return true;
        } else {
            return false;
        }
    }

    public static function getMethod() {
        return isset( $_SERVER['REQUEST_METHOD'] )? $_SERVER['REQUEST_METHOD'] : null;
    }

    public static function getProtocol() {
        return isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
    }

    public static function getUserAgent() {
        if ( key_exists('HTTP_USER_AGENT', $_SERVER ) ) {
            return $_SERVER['HTTP_USER_AGENT'];
        } else {
            return null;
        }
    }

    public static function isAjax() {
        if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) === 'xmlhttprequest' ) {
            return true;
        } else {
            return false;
        }
    }

    public static function checkReferer() {
        if ( empty( $_SERVER['HTTP_REFERER'] ) ) {
            return false;
        }

        $refererHeader = $_SERVER['HTTP_REFERER'];
        $serverName = $_SERVER['SERVER_NAME'];

        if ($refererHeader && $serverName) {
            // Extracting the host from the referer header
            $refererHost = parse_url($refererHeader, PHP_URL_HOST);

            // If the referer host is available or it doesn't match the server name, return false
            if ( !empty($refererHost) && $refererHost === $serverName ) {
                return true;
            }
        }

        return false;
    }

}
