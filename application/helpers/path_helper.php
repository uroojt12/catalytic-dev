<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('asset'))
{
    function asset($path = '')
    {
        if(empty($path))
        {
            return base_url().ASSETS;
        }
        else
        {
            return base_url().ASSETS.$path;
        }
    }
}

if ( ! function_exists('uploads'))
{
    function uploads($path = '')
    {
        if(empty($path))
        {
            return base_url().UPLOADS;
        }
        else
        {
            return base_url().UPLOADS.$path;
        }
    }
}
