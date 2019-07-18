<?php

class MY_Loader extends CI_Loader
{
    function front_view($folder, $view, $vars = array(), $return = FALSE)
    {
        $this->_ci_view_paths = array_merge($this->_ci_view_paths, array(APPPATH . '../' . $folder . '/' => TRUE));
        return $this->_ci_load(array(
            '_ci_view' => $view,
            '_ci_vars' => $this->_ci_prepare_view_vars($vars),
            '_ci_return' => $return
        ));
    }

    function other_view($folder, $view, $vars = array(), $return = FALSE)
    {
        $this->_ci_view_paths = array_merge($this->_ci_view_paths, array(APPPATH . '../' . $folder . '/' => TRUE));

    }
}



?>