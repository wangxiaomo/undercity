<?php

class WeixinAction extends AdminbaseAction {

    public $pageCount = 20;

    public function mall(){
        $malls = D('Mall')->order('rank_order')->select();
        $this->assign('malls', $malls);
        return $this->display();
    }

    public function addMall(){
        if($_POST){
            $data = array(
                'name'  =>  $this->_post('name'),
                'city'  =>  $this->_post('city'),
                'tel'   =>  $this->_post('tel'),
                'loc'   =>  $this->_post('loc'),
                'open_hour' =>  $this->_post('open_hour'),
                'close_hour'    =>  $this->_post('close_hour'),
                'rank_order' =>  $this->_post('order')
            );
            if($img_file){
                $data['img'] = save_upload_file();
            }
            $r = D('Mall')->data($data)->add();
            if($r === false){
                return $this->error('已有同名店铺存在', U('Weixin/mall'));
            }
            // clear cache
            F('cache_all_malls', null);
            return $this->success('新增成功', U('Weixin/mall'));
        }
        return $this->display();
    }

    public function updateMall($id){
        if($_POST){
            $data = array(
                'name'  =>  $this->_post('name'),
                'city'  =>  $this->_post('city'),
                'tel'   =>  $this->_post('tel'),
                'loc'   =>  $this->_post('loc'),
                'open_hour' =>  $this->_post('open_hour'),
                'close_hour'    =>  $this->_post('close_hour'),
                'rank_order' =>  $this->_post('order')
            );
            $img_file = $_FILES['img']['tmp_name'];
            if($img_file){
                $data['img'] = save_upload_file();
            }
            $r = D('Mall')->where("id=$id")->save($data);
            if($r){
                // clear cache
                F("cache_detail_by_mall_${id}", null);
                F("cache_mall_${id}", null);
                F("cache_all_malls", null);
                return $this->success('修改成功', U('Weixin/mall'));
            }else{
                return $this->success('修改失败，已有同名店铺', U('Weixin/mall'));
            }
        }
        $mall = D('Weixin')->get_mall($id);
        if(!$mall){
            return _404('没有该条记录!');
        }
        $this->assign('mall', $mall);
        return $this->display();
    }

    public function addMallExpress(){
        if($_POST){
            $mall_id = $this->_post('mall');
            $loc = $this->_post('loc');
            $price = $this->_post('price');
            $minExpress = $this->_post('minExpress');
            $freeShipping = $this->_post('freeShipping');

            $mall = D('Mall')->where("id=$mall_id")->find();
            if($mall){
                $r = D('Express')->data(array(
                    'loc'   =>  $loc,
                    'price' =>  $price,
                    'mall'  =>  $mall_id,
                    'min_express'   =>  $minExpress,
                    'free_shipping' =>  $freeShipping
                ))->add();
                return $this->ajaxReturn(array('r'=>1, 'id' => $r), 'JSON');
            }
        }
    }

    public function updateMallExpress(){
        if($_POST){
            $id = $this->_post('id');
            $price = $this->_post('price');
            $minExpress = $this->_post('minExpress');
            $freeShipping = $this->_post('freeShipping');

            $mall = D('Express')->where("id=$id")->save(array('price'=>$price, 'min_express'=>$minExpress, 'free_shipping'=>$freeShipping));
            return $this->ajaxReturn(array('r'=>1), 'JSON');
        }
    }

    public function removeMallExpress(){
        if($_POST){
            $id = $this->_post('id');
            $mall = D('Express')->where("id=$id")->delete();
            return $this->ajaxReturn(array('r'=>1), 'JSON');
        }
    }

    public function mallExpress($id){
        $mall = D('Mall')->where("id=$id")->find();
        if(!$mall){
            return _404('没有该条记录!');
        }

        $expresses = D('Express')->where("mall=$id")->select();
        $this->assign('mall', $mall);
        $this->assign('expresses', $expresses);
        return $this->display();
    }

    public function deleteMall($id){
        D('Mall')->where("id=$id")->delete();
        // clear cache
        F("cache_detail_by_mall_${id}", null);
        F("cache_mall_${id}", null);
        F("cache_all_malls", null);
        return $this->success('删除成功', U('Weixin/mall'));
    }

    public function category(){
        $categories = D('FoodCategory')->order('rank_order')->select();
        $Helper = D('Weixin');
        foreach($categories as &$category){
            $category['n_count'] = $Helper->get_food_count_by_category($category['id']);
        }
        $this->assign('categories', $categories);
        return $this->display();
    }

    public function addCategory(){
        if($_POST){
            $data = array(
                'name'  =>  $this->_post('name'),
                'rank_order' =>  $this->_post('order')
            );
            $r = D('FoodCategory')->data($data)->add();
            if($r === false){
                return $this->error('新增失败，已有同名分类存在', U('Weixin/category'));
            }
            return $this->success('新增成功', U('Weixin/category'));
        }
        return $this->display();
    }

    public function updateCategory($id){
        if($_POST){
            $data = array(
                'name'  =>  $this->_post('name'),
                'rank_order' =>  $this->_post('order')
            );
            $r = D('FoodCategory')->where("id=$id")->save($data);
            if($r){
                return $this->success('修改成功', U('Weixin/category'));
            }else{
                return $this->success('修改失败，已有同名分类', U('Weixin/category'));
            }
        }
        $category = D('FoodCategory')->where("id=$id")->find();
        if(!$category){
            return _404('没有该条记录!');
        }
        $this->assign('category', $category);
        return $this->display();
    }

    public function deleteCategory($id){
        D('FoodCategory')->where("id=$id")->delete();
        return $this->success('删除成功', U('Weixin/category'));
    }

    public function foodByCategory($id){
        $p = isset($_GET['page'])? $_GET['page']: 1;
        import("@.Util.Page");
        $count = D('Food')->where("cat_id=$id")->count();
        $foods = D('Food')->where("cat_id=$id")->order('rank_order desc')->page($p . ',' . $this->pageCount)->select();
        $Page = new Page($count, $this->pageCount, $p);
        $show = $Page->show();
        foreach($foods as &$food){
            $Helper = D('Weixin');
            $food['category'] = $Helper->get_category($food['cat_id']);
            $food['mall'] = $Helper->easy_get_mall($food['mall_id']);
            $food['status'] = $Helper->get_status($food['status']);
        }
        $this->assign('foods', $foods);
        $this->assign('page', $show);
        return $this->display('Weixin/food');
    }

    public function food(){
        $p = isset($_GET['page'])? $_GET['page']: 1;
        import("@.Util.Page");
        $mall_id = $this->_get('id');
        $Food = D('Food');
        if($mall_id){
            $foods = $Food->order('rank_order desc')->select();
            $res = array();
            foreach($foods as $food){
                // 判断food归属店铺
                if($mall_id){
                    if($food['mall_id'] != '-1'){
                       $pairs = explode(',', $food['mall_id']);
                        if(array_search($mall_id, $pairs) === false){
                            continue;
                        }
                    }
                }
                $res[] = $food;
            }
            $count = count($res);
            $Page = new Page($count, $this->pageCount, $p);
            $show = $Page->show();
            $foods = array_slice($res, ($p-1)*$this->pageCount, $this->pageCount);
        }else{
            $count = $Food->count();
            $foods = $Food->order('rank_order desc')->page($p . ',' . $this->pageCount)->select();
            $Page = new Page($count, $this->pageCount, $p);
            $show = $Page->show();
        }
        $res = array();
        foreach($foods as $food){
            $Helper = D('Weixin');
            $food['category'] = $Helper->get_category($food['cat_id']);
            $food['mall'] = $Helper->easy_get_mall($food['mall_id']);
            $food['status'] = $Helper->get_status($food['status']);
            $res[] = $food;
        }

        $this->assign('page', $show);
        $this->assign('mall_id', $mall_id);
        $this->assign('malls', D('Weixin')->get_all_malls());
        $this->assign('foods', $res);
        return $this->display();
    }

    public function addFood(){
        if($_POST){
            $data = array(
                'name'  =>  $this->_post('name'),
                'subtag'    =>  $this->_post('subtag'),
                'rank_order' =>  $this->_post('order'),
                'mall_id'   =>  $this->_post('mall'),
                'cat_id'    =>  $this->_post('category'),
                'origin_price'  =>  $this->_post('origin_price'),
                'price' =>  $this->_post('price'),
                'status'    =>  $this->_post('status'),
                'unit'  =>  $this->_post('unit'),
                'min_count' =>  $this->_post('min_count'),
                'detail'    =>  $this->_post('detail')
            );
            $img_file = $_FILES['img']['tmp_name'];
            if($img_file){
                $data['img'] = save_upload_file();
            }
            D('Food')->data($data)->add();
            return $this->success('新增成功', U('Weixin/food'));
        }
        $Helper = D('Weixin');
        $malls = $Helper->get_all_malls();
        $categories = $Helper->get_all_categories();
        $this->assign('malls', $malls);
        $this->assign('categories', $categories);
        return $this->display();
    }

    public function updateFood($id){
        if($_POST){
            $data = array(
                'name'  =>  $this->_post('name'),
                'subtag'    =>  $this->_post('subtag'),
                'rank_order' =>  $this->_post('order'),
                'mall_id'   =>  $this->_post('mall'),
                'cat_id'    =>  $this->_post('category'),
                'origin_price'  =>  $this->_post('origin_price'),
                'price' =>  $this->_post('price'),
                'status'    =>  $this->_post('status'),
                'unit'  =>  $this->_post('unit'),
                'min_count' =>  $this->_post('min_count'),
                'detail'    =>  $this->_post('detail')
            );
            $img_file = $_FILES['img']['tmp_name'];
            if($img_file){
                $data['img'] = save_upload_file();
            }
            D('Food')->where("id=$id")->save($data);
            return $this->success('修改成功', U('Weixin/food'));
        }
        $food = D('Food')->where("id=$id")->find();
        if(!$food){
            return _404('没有该条记录!');
        }
        $Helper = D('Weixin');
        $malls = $Helper->get_all_malls();
        $categories = $Helper->get_all_categories();
        $this->assign('food', $food);
        $this->assign('malls', $malls);
        $this->assign('categories', $categories);
        return $this->display();
    }

    public function deleteFood($id){
        D('Food')->where("id=$id")->delete();
        return $this->success('删除成功', U('Weixin/food'));
    }

    public function config(){
        // 杂项设置. 邮费模板.
        if($_POST){
            $k = $this->_post('k');
            $v = $this->_post('v');
            D('Weixin')->set_config($k, trim($v));
            return $this->ajaxReturn(array('r'=>1), 'JSON');
        }
        $config = D('Weixin')->get_config();
        $this->assign('config', $config);
        return $this->display();
    }

    public function discount(){
        if($_POST){
            $id = $this->_post('id');
            $discount = $this->_post('discount');
            D('Weixin')->set_user_discount($id, $discount);
            return $this->ajaxReturn(array('r'=>1), 'JSON');
        }
        $discounts = D('Weixin')->get_user_discounts();
        $this->assign('discounts', $discounts);
        return $this->display();
    }

    public function normalUser(){
        // 普通用户, vip user status == 0
        $p = isset($_GET['page'])? $_GET['page']: 1;
        import("@.Util.Page");
        $VIPUser = D("VipUser");
        $count = $VIPUser->where("status=0")->count();
        $users = $VIPUser->where("status=0")->order("uid desc")->page($p . ',' . $this->pageCount)->select();
        $Page = new Page($count, $this->pageCount, $p);
        $show = $Page->show();
        $user_discounts = D('Weixin')->get_user_discounts();
        $this->assign('user_discounts', $user_discounts);
        $this->assign('users', $users);
        $this->assign('page', $show);
        return $this->display('Weixin/user');
    }

    public function vipUser(){
        // 会员用户, vip user status > 0 need_check == 0
        $p = isset($_GET['page'])? $_GET['page']: 1;
        import("@.Util.Page");
        $VIPUser = D("VipUser");
        $count = $VIPUser->where("status!=0 and need_check!=1")->count();
        $users = $VIPUser->where("status!=0 and need_check!=1")->order("uid desc")->page($p . ',' . $this->pageCount)->select();
        $Page = new Page($count, $this->pageCount, $p);
        $show = $Page->show();
        $user_discounts = D('Weixin')->get_user_discounts();
        $this->assign('user_discounts', $user_discounts);
        $this->assign('users', $users);
        $this->assign('page', $show);
        return $this->display('Weixin/user');
    }

    public function searchUser($uid){
        $users = D('VipUser')->where("uid=$uid")->select();
        $user_discounts = D('Weixin')->get_user_discounts();
        $this->assign('user_discounts', $user_discounts);
        $this->assign('users', $users);
        return $this->display('Weixin/user');
    }

    public function updateMoney(){
        if($_POST){
            $uid = $this->_post('uid');
            $money = (float)$this->_post('money');
            $user = D('VIPUser')->get_user($uid);
            if($user && is_float($money)){
                D('MoneyLog')->data(array(
                    'uid'   =>  $uid,
                    'money' =>  $money
                ))->add();
                $money = $user['money'] + $money;
                D('VipUser')->update_user_money($uid, $money);
                return $this->ajaxReturn(array('r'=>1, 'money'=>$money), 'JSON');
            }
        }
        die("no access");
    }

    public function deleteUser($id){
        D('VipUser')->where("uid=$id")->delete();
        return $this->success('删除成功', U('Weixin/normalUser'));
    }

    public function changeLevel(){
        if($_POST){
            $uid = $this->_post('uid');
            $level = $this->_post('level');
            D('VipUser')->where("uid=$uid")->save(array('level'=>$level));
            return $this->ajaxReturn(array('r'=>1), 'JSON');
        }
        die("no access");
    }

    public function checkUser(){
        if($_POST){
            $uid = $this->_post('uid');
            D("VIPUser")->check_user($uid);
            return $this->ajaxReturn(array('r'=>1), 'JSON');
        }
        $users = D("VIPUser")->get_users_need_check();
        $this->assign("users", $users);
        return $this->display();
    }

    private function handle_orders($orders){
        $Order = D("Order");
        $Weixin = D("Weixin");
        $User = D("VIPUser");
        foreach($orders as &$order){
            list($foods, $price) = $Order->get_foods($order['order_context']);
            $order['user'] = $User->get_user($order['uid']);
            $order['foods'] = $foods;
            $order['foods_price'] = $price;
            $order['mall'] = $Weixin->get_mall($order['mall_id']);
            $order['status_cn'] = $Order->get_order_status($order);
            $order['pay_status_cn'] = $Order->get_pay_status($order);
            $order['real_price'] = $order['foods_price'] + $order['express_price'] * $order['discount'];
            $order['real_price'] = floor($order['real_price']*10)/10;
        }
        return $orders;
    }

    private function get_orders($status=0){
        $p = isset($_GET['page'])? $_GET['page']: 1;
        import("@.Util.Page");
        $Order = D("Order");
        if($status != -1){
            $count = $Order->where("status=$status")->count();
            $orders = $Order->where("status=$status")->order("creation_time desc")
                            ->page($p . ',' . $this->pageCount)->select();
        }else{
            $count = $Order->count();
            $orders = $Order->order("creation_time desc")
                            ->page($p . ',' . $this->pageCount)->select();
        }
        $Page = new Page($count, $this->pageCount, $p);
        $show = $Page->show();
        $this->assign('page', $show);
        $this->assign('config', D("Weixin")->get_config());
        return $this->handle_orders($orders);
    }

    public function order(){
        $this->assign("orders", $this->get_orders($status=0));
        return $this->display();
    }

    public function sendOrder(){
        $this->assign("orders", $this->get_orders($status=1));
        return $this->display('Weixin/order');
    }

    public function doneOrder(){
        $this->assign("orders", $this->get_orders($status=2));
        return $this->display('Weixin/order');
    }

    public function allOrder(){
        $this->assign("orders", $this->get_orders($status=-1));
        return $this->display('Weixin/order');
    }

    public function searchOrder($id){
        $Order = D("Order");
        $order = $Order->get_order_by_id($id);
        $orders = $this->handle_orders(array($order));
        $this->assign('orders', $orders);
        return $this->display('Weixin/order');
    }

    public function changeOrderStatus(){
        if($_POST){
            $id = $this->_post("id");
            $status = $this->_post("status");
            D("Order")->where("id=$id")->save(array('status'=>$status));
            return $this->ajaxReturn(array('r'=>1), 'JSON');
        }
        die("no access");
    }

    public function deleteOrder(){
        if($_POST){
            $id = $this->_post('id');
            D("Order")->where("id=$id")->delete();
            return $this->ajaxReturn(array('r'=>1), 'JSON');
        }
        die("no access");
    }

    public function moneyLog(){
        $User = D("VIPUser");
        $logs = D("MoneyLog")->order("id desc")->select();
        foreach($logs as &$log){
            $log['user'] = $User->get_user($log['uid']);
        }
        $this->assign("logs", $logs);
        return $this->display();
    }

    public function updateVIPBg(){
        if($_POST){
            $img = save_upload_file();
            D('Weixin')->set_config('vip_bg', $img);
            $this->assign('status', 1);
        }
        $this->assign('config', D("Weixin")->get_config());
        return $this->display('Weixin/config');
    }

    public function express(){
        $expresses = D("Express")->order("id desc")->select();
        $this->assign("expresses", $expresses);
        return $this->display();
    }

    public function addExpress(){
        if($_POST){
            $data = array(
                'loc'  =>  $this->_post('loc'),
                'price' =>  $this->_post('price'),
                'min_express'   =>  $this->_post('min_express'),
                'free_shipping' =>  $this->_post('free_shipping'),
            );
            D('Express')->data($data)->add();
            return $this->success('新增成功', U('Weixin/express'));
        }
        return $this->display();
    }

    public function updateExpress($id){
        if($_POST){
            $data = array(
                'loc'  =>  $this->_post('loc'),
                'price' =>  $this->_post('price'),
                'min_express'   =>  $this->_post('min_express'),
                'free_shipping' =>  $this->_post('free_shipping'),
            );
            D('Express')->where("id=$id")->save($data);
            return $this->success('修改成功', U('Weixin/express'));
        }
        $express = D('Express')->where("id=$id")->find();
        if(!$express){
            return _404('没有该条记录!');
        }
        $this->assign('express', $express);
        return $this->display();
    }

    public function deleteExpress($id){
        D('Express')->where("id=$id")->delete();
        return $this->success('删除成功', U('Weixin/express'));
    }

    private function urlencode($url){
        return urlencode(C('SITE_DOMAIN') . $url);
    }

    public function url(){
        require_once(UTILS_PATH . 'wechat.php');
        $wechat = get_wechat();
        $appid = $wechat->get_app_id();

        $url_template = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_base#wechat_redirect";

        $mall_page_url = sprintf($url_template, $appid, $this->urlencode(U('Weixin/Index/mall')));
        $this->assign('mall_page', $mall_page_url);
        $specials = D('Special')->get_all_special();
        foreach($specials as &$special){
            $special['url'] = sprintf($url_template, $appid, $this->urlencode(U('Weixin/Index/special', array('id'=>$special['id']))));
        }
        $this->assign('specials', $specials);
        return $this->display();
    }

    public function special(){
        $specials = D('Special')->get_all_special();

        require_once(UTILS_PATH . 'wechat.php');
        $wechat = get_wechat();
        $appid = $wechat->get_app_id();

        $url_template = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_base#wechat_redirect";
        foreach($specials as &$special){
            $special['url'] = sprintf($url_template, $appid, $this->urlencode(U('Weixin/Index/special', array('id'=>$special['id']))));
        }
        $this->assign('specials', $specials);
        return $this->display();
    }

    public function addSpecial(){
        if($_POST){
            $data = array(
                'name'  =>  $this->_post('name'),
                'banner2'   =>  $_POST['banner2'], // 这里很危险 不转义
                'mall'  =>  $this->_post('mall'),
                'rank_order' =>  $this->_post('order')
            );
            $img_file = $_FILES['img']['tmp_name'];
            if($img_file){
                $data['banner1'] = save_upload_file();
            }
            D('Special')->data($data)->add();
            return $this->success('新增成功', U('Weixin/special'));
        }
        $malls = D('Weixin')->get_all_malls();
        $this->assign('malls', $malls);
        return $this->display();
    }

    public function updateSpecial($id){
        if($_POST){
            $data = array(
                'name'  =>  $this->_post('name'),
                'banner2'   =>  $_POST['banner2'], // 这里很危险 不转义
                'mall'  =>  $this->_post('mall'),
                'rank_order' =>  $this->_post('order')
            );
            $img_file = $_FILES['img']['tmp_name'];
            if($img_file){
                $data['banner1'] = save_upload_file();
            }
            D('Special')->where("id=$id")->save($data);
            return $this->success('修改成功', U('Weixin/special'));
        }
        $malls = D('Weixin')->get_all_malls();
        $this->assign('malls', $malls);
        $special = D('Special')->where("id=$id")->find();
        $this->assign('special', $special);
        return $this->display();
    }

    public function deleteSpecial($id){
        D('Special')->where("id=$id")->delete();
        return $this->success('删除成功', U('Weixin/special'));
    }
}
