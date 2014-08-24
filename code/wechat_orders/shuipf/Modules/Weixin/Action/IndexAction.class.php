<?php

class IndexAction extends BaseAction {

    public function __construct(){
        BaseAction::__construct();
        C('TMPL_ACTION_ERROR', APP_PATH . 'Modules/Weixin/Tpl/error.php');
        C('TMPL_ACTION_SUCCESS', APP_PATH . 'Modules/Weixin/Tpl/success.php');
    }

    public function index(){
        require_once(UTILS_PATH . 'wechat.php');
        $wechat = get_wechat();
        $wechat->valid(); // 微信 callback 验证
    }

    private function handle_malls(&$malls){
        $Helper = D('Weixin');
        $res = array();
        foreach($malls as $mall){
            // 检测是否有菜品
            list($categories, $foods) = $Helper->get_details_by_mall($mall['id']);
            if($foods){
                $res[] = $mall;
            }
        }
        return $res;
    }

    private function handle_open_or_closed(&$malls){
        $rank_malls = array();
        $closed_malls = array();
        $cnt = (int)date('H');
        if($cnt === 0){
            $cnt = 24;
        }
        foreach($malls as $mall){
            if($cnt >= $mall['open_hour'] && $cnt < $mall['close_hour']){
                $mall['close'] = false;
            }else{
                $mall['close'] = true;
            }
            if($mall['close_hour'] > 24){
                $mall['close_hour'] = '凌晨' . $mall['close_hour'] % 24;
            }
            if($mall['close']){
                $closed_malls[] = $mall;
            }else{
                $rank_malls[] = $mall;
            }
        }
        return array_merge($rank_malls, $closed_malls);
    }

    public function searchMall(){
        $user = get_session_user();
        $uid = $user['uid'];
        if(!$user){
            die("no access");
        }
        $kw = $this->_get('kw');
        $malls = D('Weixin')->get_all_malls_by_keyword($kw);
        $malls = $this->handle_malls($malls);
        $this->assign('malls', $malls);
        return $this->display('mall');
    }

    public function mall(){
        $user = get_session_user();
        $malls = F('cache_all_malls');
        if(!$malls){
            $malls = D('Weixin')->get_all_malls();
            $malls = $this->handle_malls($malls);
            F('cache_all_malls', $malls);
        }
        $malls = $this->handle_open_or_closed($malls);
        $this->assign('malls', $malls);
        return $this->display();
    }

    public function order(){
        $user = get_session_user();
        $uid = $user['uid'];
        if(!$user){
            die("no access");
        }
        $config = D('Weixin')->get_config();
        if($_POST){
            $mall_id = cookie('mall_id'); // 当前结算门店
            $order_context = cookie('cart_' . $mall_id); // 购物车内容
            $price = D('Order')->get_total_price($order_context);
            if(!$price){
                return $this->error('店小二有点累,请稍候再试', U('Weixin/Index/order'));
            }
            $discount = D('Weixin')->get_discount_by_user($uid);
            $use_user_money = $this->_post('use_user_money') == 'on'? 1: 0;
            $loc_express_id = $this->_post('loc_express_id');

            $express = D("Express")->where("id=$loc_express_id")->find();
            if($express['free_shipping'] > $price){
                $express_price = $express['price']? $express['price']: 0;
                // 加上邮费
                $price = $price + $express_price * $discount;
            }else{
                // 免邮
                $express_price = 0;
            }
            // 精度截取
            $price = floor($price*10)/10;
            if($use_user_money){
                if($price > $user['money']){
                    die("price is bigger than user's money!");
                }
                $user_money = $user['money'] - $price;
                D('VIPUser')->update_user_money($uid, $user_money);
                $origin_price = -$price;
                $price = 0;
            }

            $username = $this->_post('name');
            $mobile = $this->_post('tel');
            $loc = $this->_post('address');
            $memo = $this->_post('note');
            // 判断是否需要为匿名用户存储地址信息
            if(!$user['loc']){
                D('VIPUser')->update_user_loc($uid, $username, $mobile, $loc);
            }
            $ORDER = D('Order');
            $order_id = $ORDER->generate_order(array(
                'uid'       =>  $uid,
                'mall_id'   =>  $mall_id,
                'order_context' =>  $order_context,
                'username'  =>  $username,
                'mobile'    =>  $mobile,
                'loc'       =>  $loc,
                'memo'      =>  $memo,
                'use_user_money'    =>  $use_user_money,
                'discount'  =>  $discount,
                'express_price' =>  $express_price,
                'price'     =>  $price
            ));
            if($order_id){
                if($use_user_money){
                    D('MoneyLog')->data(array(
                        'uid'   =>  $uid,
                        'money' =>  $origin_price
                    ))->add();
                }
                cookie('cart_' . $mall_id, null);
                // 订购完成后整理mall_ids
                $targets = array();
                $cookie_mall_ids = array_filter(explode(',', cookie('user_mall_ids')));
                foreach($cookie_mall_ids as $cookie_mall_id){
                    if($cookie_mall_id == $mall_id){
                        continue;
                    }
                    $order_context = cookie('cart_' . $cookie_mall_id); // 购物车内容
                    if(array_filter(explode(',', $order_context))){
                        $targets[] = $cookie_mall_id;
                    }else{
                        cookie('cart_' . $cookie_mall_id, null);
                    }
                }
                cookie('user_mall_ids', implode(',', $targets));
                if(C("WECHAT_NOTIFY")){
                    require_once(UTILS_PATH . 'wechat.php');
                    $wechat = get_wechat();
                    // 1. 提醒管理员
                    $openids = explode("\n", $config['remind_openid']);
                    foreach($openids as $openid){
                        $wechat->sendCustomMessage(array(
                            'touser'    =>  $openid,
                            'msgtype'   =>  'text',
                            'text'      =>  array('content' =>  "有订单了！订单号为$order_id!赶快去查看吧！")
                        ));
                    }
                    // 2. 提醒用户
                    $wechat->sendCustomMessage(array(
                        'touser'    =>  $user['openid'],
                        'msgtype'   =>  'text',
                        'text'      =>  array('content' =>  "订单成功生成，客服会电话联系你确认订单！如没有反应你可拨打客服电话催单！ 0577-27888872")
                    ));
                }
                if(C("EMAIL_NOTIFY") && C("EMAIL_AUDIT")){
                    require_once(UTILS_PATH . 'mail.php');
                    send_mail(C("EMAIL_AUDIT"), "新订单${order_id}!!!", "快去后台查看吧！");
                }
                return $this->success('订购成功', U('Weixin/Index/order'));
            }
        }
        // 获取用户信息
        $user['discount'] = D('Weixin')->get_discount_by_user($uid);

        $mall_id = $this->_get('id');
        $mall_id = $mall_id? $mall_id: cookie('mall_id');
        cookie('mall_id', $mall_id);
        // 用户选择此门店点餐. 记录门店 id 到 cookie 中.
        $cookie_mall_ids = array_filter(explode(',', cookie('user_mall_ids')));
        if(array_search($mall_id, $cookie_mall_ids) === FALSE){
            $cookie_mall_ids[] = $mall_id;
            cookie('user_mall_ids', implode(',', $cookie_mall_ids));
        }
        list($categories, $foods) = D('Weixin')->get_details_by_mall($mall_id);
        // 邮费列表
        $expresses = D("Express")->where("mall=$mall_id")->order("id")->select();
        if(!$expresses){
            $expresses = D("Express")->where("mall=-1")->order("id")->select();
        }
        $this->assign('mall', D('Weixin')->get_mall($mall_id));
        $this->assign('expresses', $expresses);
        $this->assign('config', $config);
        $this->assign('user', $user);
        $this->assign('categories', $categories);
        $this->assign('foods', $foods);
        return $this->display();
    }

    public function zone(){
        $user = get_session_user();
        $uid = $user['uid'];
        if(!$user){
            die("no access");
        }
        $this->assign('is_vip', D("VIPUser")->is_user_vip($user));
        $this->assign('user', $user);
        // 获取用户订单个数
        $this->assign('order_count', D("Order")->get_user_order_count($uid));
        $this->assign('config', D("Weixin")->get_config());
        return $this->display();
    }

    public function updateInfo(){
        $user = get_session_user();
        $uid = $user['uid'];
        if(!$user){
            die("no access");
        }
        // 更新会员资料.
        if($_POST){
            $username = $this->_post('name');
            $gender = $this->_post('gender');
            $mobile = $this->_post('mobile');
            $qq = $this->_post('qq');
            $loc = $this->_post('loc');

            D('VIPUser')->update_user_info($user['uid'], $username, $gender, $mobile, $qq, $loc);
            return $this->success('修改成功', U('Weixin/Index/zone'));
        }
        $this->assign('user', $user);
        return $this->display();
    }

    public function upgrade(){
        $user = get_session_user();
        $uid = $user['uid'];
        if(!$user){
            die("no access");
        }
        // 更新会员资料.
        if($_POST){
            $username = $this->_post('name');
            $gender = $this->_post('gender');
            $mobile = $this->_post('mobile');
            $qq = $this->_post('qq');
            $loc = $this->_post('loc');

            D('VIPUser')->upgrade_user($user['uid'], $username, $gender, $mobile, $qq, $loc, 1, 1);
            return $this->success('申请成功，等待审核！', U('Weixin/Index/zone'));
        }
        $this->assign('user', $user);
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

    public function myOrder(){
        $user = get_session_user();
        $uid = $user['uid'];
        if(!$user){
            die("no access");
        }

        $orders = D("Order")->get_user_orders($uid);
        $orders = $this->handle_orders($orders);
        $this->assign('config', D("Weixin")->get_config());
        $this->assign('orders', $orders);
        return $this->display();
    }

    public function special($id){
        $user = get_session_user();
        $special = D('Special')->where("id=$id")->find();
        if(!$special){
            _404("您查找的页面不存在!");
        }
        $malls = D('Weixin')->get_all_malls_by_special($id);
        $malls = $this->handle_malls($malls);
        $this->assign('malls', $malls);
        $this->assign('special', $special);
        return $this->display();
    }

    public function dump_config(){
        dump(D("Weixin")->get_config());
    }

    public function web_mall(){
        load_debug_user();
        return $this->redirect('mall');
    }

    public function web_special($id){
        load_debug_user();
        return $this->redirect('special', array('id'=>$id));
    }

    public function clear_cache(){
        F('cache_all_malls', null);
        echo "清除完毕";
    }

    public function test(){
        $openid = 'oLFajjs1DWBrTKYUNBf2q0cBGCDU'; // DEBUG
        $user = D('VIPUser')->get_user_by_openid($openid);
        dump($user);
    }
}
