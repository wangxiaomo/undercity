<?php

/**
 * Some rights reserved：abc3210.com
 * Contact email:admin@abc3210.com
 */
class IndexAction extends BaseAction {

    private $url;

    //初始化
    protected function _initialize() {
        parent::_initialize();
        import('Url');
        $this->url = get_instance_of('Url');
    }

    public function index() {
        die("no access");
    }
}
