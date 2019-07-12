<?php

if (!function_exists('htmlId')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function htmlId()
    {
        return 'id-' . uniqid();
    }
}
