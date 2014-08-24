<?php

class SpecialModel extends CommonModel {

    public function get_all_special(){
        return D('Special')->order('rank_order')->select();
    }
}
