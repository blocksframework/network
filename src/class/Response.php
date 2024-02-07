<?php

namespace Blocks\Network;

class Response {
    private $headers = []; 
    private $output;

    public function addHeader($header) {
        $this->headers[] = $header;
    }

    public static function redirect(string $url, bool $permanent = true): void {
        $url = str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $url);

        if ($permanent) {
            header( $_SERVER['SERVER_PROTOCOL'] . ' 301 Moved Permanently' );
            header('Cache-Control: no-store, no-cache, must-revalidate');
            header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');
            header('Location: ' . $url, true, 301);

            exit();

        } else {
            header( $_SERVER['SERVER_PROTOCOL'] . ' 302 Found' );
            header('Cache-Control: no-store, no-cache, must-revalidate');
            header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');
            header('Location: ' . $url, true, 302);

            exit();
        }
    }

    public function denyAccess() {
        header( $_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden' );

        exit();
    }

    public function rejectRequest() {
        header( $_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');

        exit();
    }

    /** HTTP status code to wrong input
     * https://stackoverflow.com/a/42171674
     */
    protected function rejectClient() {
        header( $this->request->server['SERVER_PROTOCOL'] . ' 422 Unprocessable Entity' );

        exit();
    }

    public function setOutput(string $output): void {
        $this->output = $output;
    }

    public function output(): void {
        if ($this->output) {
            if ( !headers_sent() ) {
                foreach ($this->headers as $header) {
                    header($header, true);
                }
            }
            
            echo $this->output;
        }
    }
}







