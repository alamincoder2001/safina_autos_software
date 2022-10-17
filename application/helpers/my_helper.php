<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_client_ip'))
{
    function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }  
    
    function set_upload_options($path, $file_name = null, $size = 0, $types = 'jpg|jpeg|png|gif', $overwrite = false)
    {   
        //upload an image options
        $config = array();
        $config['upload_path']      = $path;
        $config['allowed_types']    = $types;
        $config['max_size']         = $size;
        if($file_name != null){
            $config['file_name']    = $file_name; 
        }
        $config['overwrite']        = $overwrite;

        return $config;
    }

    function getStatusLabel($status){
        switch ($status) {
            case 'Placed':
                return '<span class="label label-default">Placed</span>';

            case 'Pending':
                return '<span class="label label-warning" style="color: #000;">Pending</span>';

            case 'Processing':
                return '<span class="label label-primary">Processing</span>';
                
            case 'Shipped':
                return '<span class="label label-primary">Shipped</span>';

            case 'Delivered':
                return '<span class="label label-success">Delivered</span>';

            case 'Returned':
                return '<span class="label label-danger">Returned</span>';

            case 'Cancelled':
                return '<span class="label label-danger">Cancelled</span>';
            
            default:
            return '';
        }
    }
}