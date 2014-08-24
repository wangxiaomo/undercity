<?php

class OrderModel extends CommonModel {

    public function generate_order($options){
        // 检测上次生成订单时间
        $uid = $options['uid'];
        $last_order = D('Order')->where("uid=$uid")->order('creation_time desc')->find();
        $time = strtotime($last_order['creation_time']);
        if(time() - $time < 60){
            // 小于一分钟的订单抛弃
            return false;
        }
        $options['creation_time'] = NULL;
        return D('Order')->data($options)->add();
    }

    public function get_order_by_id($id){
        return D('Order')->where("id=$id")->find();
    }

    public function get_total_price(&$context){
        list($foods, $price) = $this->get_foods($context);
        return $price;
    }

    public function get_foods(&$context){
        $food_pairs = array_filter(explode(',', $context));
        $price = 0;
        $Helper = D('Weixin');
        foreach($food_pairs as $pair){
            list($food_id, $count) = explode('-', $pair);
            $food = $Helper->get_food_by_id($food_id);
            if($food){
                $food['count'] = $count;
                $food['total'] = $food['price'] * $count;
                $price += $food['total'];
                $foods[] = $food;
            }
        }
        return array($foods, $price);
    }

    public function get_order_status(&$order){
        switch($order['status']){
            case '0': return '新订单!';
            case '1': return '正在派送!';
            case '2': return '已处理订单!';
            default:  return '异常订单!';
        }
    }

    public function get_pay_status(&$order){
        switch($order['use_user_money']){
            case '0': return '货到付款';
            case '1': return '余额支付';
            default:  return '状态未知';
        }
    }

    public function get_user_order_count($uid){
        return D("Order")->where("uid=$uid")->count();
    }

    public function get_user_orders($uid, $count=20){
        return D("Order")->where("uid=$uid")->order("creation_time desc")->limit($count)->select();
    }
}
