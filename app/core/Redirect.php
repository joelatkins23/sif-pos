<?php

/**
 * Class Redirect
 *
 * Simple abstraction for redirecting the user to a certain page
 */
class Redirect {

    /**
     * To the homepage
     */
    public static function home() {
        header("location: " . base_url());
        return print "<html><script>document.location.href='" . base_url() . "';</script></html>";
    }

    /**
     * To the error 404
     */
    public static function error404() {
        $page = base_url() . "error";
        header("location: {$page}");
        return print "<html><script>document.location.href='{$page}';</script></html>";
    }

    /**
     * To the defined pages
     *
     * @param $path
     */
    public static function to($path) {
        $redirect = base_url() . $path;
        header("location: {$redirect}");
        return print "<html><script>document.location.href='" . $redirect . "';</script></html>";
    }

}
