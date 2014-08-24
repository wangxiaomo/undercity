<?php

class WeixinModel extends CommonModel {

    public function get_category($cat_id){
        $r = D('FoodCategory')->where("id=$cat_id")->find();
        return $r? $r['name']: '';
    }

    public function get_all_categories(){
        return D('FoodCategory')->order('rank_order')->select();
    }

    public function get_details_by_mall($mall_id){
        $_cache = F("cache_detail_by_mall_${mall_id}");
        if($_cache) return $_cache;
        // 根据 mall id 获取相对应的 categories 和 foods
        $categories = $this->get_all_categories();
        $res_catids = array();
        $res_categories = array();
        $res_foods = array();
        foreach($categories as $category){
            $cat_id = $category['id'];
            $foods = D('Food')->where("cat_id=$cat_id")->order('rank_order')->select();
            foreach($foods as $food){
                if($food['mall_id'] == -1){
                    if(array_search($category['id'], $res_catids) === FALSE){
                        $res_categories[] = $category;
                        $res_catids[] = $category['id'];
                    }
                    $res_foods[$cat_id][] = $food;
                    $pack = &$res_foods[$cat_id][$food['name']];
                    if(!$pack) $pack = array();
                    $pack[] = $food;
                }else{
                    $mall_ids = explode(',', $food['mall_id']);
                    if(array_search($mall_id, $mall_ids) !== FALSE){
                        if(array_search($category['id'], $res_catids) === FALSE){
                            $res_categories[] = $category;
                            $res_catids[] = $category['id'];
                        }
                        $pack = &$res_foods[$cat_id][$food['name']];
                        if(!$pack) $pack = array();
                        $pack[] = $food;
                    }
                }
            }
        }
        $res = array($res_categories, $res_foods);
        F("cache_detail_by_mall_${mall_id}", $res);
        return $res;
    }

    public function easy_get_mall($mall_id){
        return $mall_id == -1? '所有门店': '特定门店';
    }

    public function get_mall($mall_id){
        $_cache = F("cache_mall_${mall_id}");
        if($_cache) return $_cache;
        $mall = D("Mall")->where("id=$mall_id")->find();
        F("cache_mall_${mall_id}", $mall);
        return $mall;
    }

    public function get_all_malls(){
        return D('Mall')->order('rank_order')->select();
    }

    public function get_all_malls_by_keyword($kw){
        return D('Mall')->where(array(
            'name'  =>  array('like', "%$kw%")
        ))->order('rank_order')->select();
    }

    public function get_all_malls_by_special($sid){
        $special = D('Special')->where("id=$sid")->find();
        $mall_ids = $special['mall'];
        if($mall_ids == -1){
            return $this->get_all_malls();
        }else{
            return D('Mall')->where(array('id'  =>  array('in', $mall_ids)))->select();
        }
    }

    public function get_status($status){
        return $status == 1? '在售': '下架';
    }

    public function get_food_count_by_category($cat_id){
        return D('Food')->where("cat_id=$cat_id")->count();
    }

    public function get_food_by_id($food_id){
        return D('Food')->where("id=$food_id")->find();
    }

    public function get_config(){
        $config = F('OrderConfig');
        if(!$config){
            $rows = D('OrderConfig')->select();
            $config = array();
            foreach($rows as $row){
                $config[$row['config_key']] = $row['config_value'];
            }
        }
        return $config;
    }

    public function set_config($key, $value){
        $ConfigFactory = D('OrderConfig');
        $config_pair = $ConfigFactory->where("config_key='$key'")->find();
        if($config_pair){
            $ConfigFactory->where("config_key='$key'")->save(array('config_value'=>$value));
        }else{
            $ConfigFactory->data(array(
                'config_key'   =>  $key,
                'config_value' =>  $value
            ))->add();
        }
        F('OrderConfig', null);
    }

    public function get_user_discounts(){
        $user_discounts = F('UserDiscount');
        if($user_discounts){
            return $user_discounts;
        }
        $res = array();
        $rows = D('UserDiscount')->order('id')->select();
        foreach($rows as $row){
            $res[$row['id']] = $row;
        }
        F('UserDiscount', $res);
        return $res;
    }

    public function set_user_discount($id, $discount){
        D('UserDiscount')->where("id=$id")->save(array('discount'=>$discount));
        F('UserDiscount', null);
    }

    public function get_discount_by_level($level){
        $user_discounts = $this->get_user_discounts();
        $discount = $user_discounts[$level];
        return $discount? $discount['discount']: $user_discounts[0]['discount'];
    }

    public function get_discount_by_user($uid){
        // 未审核的按 level 0 的 discount 走
        $user = D('VIPUser')->get_user($uid);
        if($user['need_check'] == '1'){
            return $this->get_discount_by_level(0);
        }else{
            return $this->get_discount_by_level($user['level']);
        }
    }
}
