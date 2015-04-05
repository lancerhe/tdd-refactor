<?php
/**
 * 应用核心视图类  \Core\View
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-04-17
 */
namespace Core;

class View extends \Yaf\View\Simple {
    
    /**
     * Display page
     * @param  string  $view_path  filepath, ex: production/index.html.
     * @param  array   $tpl_vars   display variables.
     * @return string
     */
    public function display( $view_path, $tpl_vars = null) {
        header("Content-type: text/html; charset=utf-8");
        parent::display( $view_path, $tpl_vars );
    }
}