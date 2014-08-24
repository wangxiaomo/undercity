<?php

class VIPUserModel extends CommonModel {

    public function get_user_by_uid($uid){
        return D('VipUser')->where("uid=$uid")->find();
    }

    public function get_user_by_openid($openid){
        // 根据 openid 返回相应的用户，如果不存在，则创建
        $user = D('VipUser')->where("openid='$openid'")->find();
        if(!$user){
            $uid = D('VipUser')->data(array('openid'=>$openid, 'creation_time'=>NULL))->add();
            return $this->get_user($uid);
        }
        return $user;
    }

    public function get_user($uid){
        return $this->get_user_by_uid($uid);
    }

    public function update_user_money($uid, $money){
        D('VipUser')->where("uid=$uid")->save(array('money'=>$money));
    }

    public function get_users_need_check(){
        return D('VipUser')->where('need_check=1')->order('uid')->select();
    }

    public function check_user($uid){
        D('VipUser')->where("uid=$uid")->save(array('need_check'=>0, 'status'=>1));
    }

    public function is_user_vip(&$user){
        return $user['status'] != 0 && $user['need_check'] != 1? true: false;
    }

    public function update_user_loc($uid, $username, $mobile, $loc){
        D('VipUser')->where("uid=$uid")->save(array(
            'username'  =>  $username,
            'mobile'    =>  $mobile,
            'loc'       =>  $loc,
        ));
    }

    public function update_user_info($uid, $username, $gender, $mobile, $qq, $loc){
        D('VipUser')->where("uid=$uid")->save(array(
            'username'  =>  $username,
            'gender'    =>  $gender,
            'mobile'    =>  $mobile,
            'qq'        =>  $qq,
            'loc'       =>  $loc,
        ));
    }

    public function upgrade_user($uid, $username, $gender, $mobile, $qq, $loc, $status, $need_check){
        D('VipUser')->where("uid=$uid")->save(array(
            'username'  =>  $username,
            'gender'    =>  $gender,
            'mobile'    =>  $mobile,
            'qq'        =>  $qq,
            'loc'       =>  $loc,
            'status'    =>  $status,
            'need_check'=>  $need_check,
			'level'		=>	1,
        ));
    }
}
