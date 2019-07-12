<?php
use Illuminate\Support\Str;

if (!function_exists('adminUrl')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function adminUrl($string)
    {
        $result = Str::start($string, '/');
        $result = config('site.admin_routes_prefix') . $result;
        return url($result);
    }
}