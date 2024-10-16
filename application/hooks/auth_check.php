<?php
function auth_check() {
    $CI =& get_instance();
    $CI->load->library('session');
    
    $excluded_pages = array('auth/login', 'auth/do_login'); 
    
    $current_page = $CI->router->fetch_class() . '/' . $CI->router->fetch_method();
    
    if (!in_array($current_page, $excluded_pages) && !$CI->session->userdata('logged_in')) {
        redirect('auth/login');
    }
}