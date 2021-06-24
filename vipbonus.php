<?php
/**
 * Created by PhpStorm.
 * User: TheSMAX
 * Date: 30.07.2020
 * Time: 21:18
 */
$mysqli = new mysqli('mysqlsvr72.world4you.com', 'sql1522293', '8N$cmhy4wB', '9973853db1');
//$mysqli = new mysqli('localhost', 'root', '', '9973853db1');
$users = $mysqli->query('SELECT DISTINCT u.user_id as uid, u.user_access_name as uan, ui.user_gender as ug
                                FROM tbl_users u
                                JOIN tbl_user_photos up ON up.photo_user_id_ref = u.user_id
                                JOIN tbl_user_info ui ON ui.user_id_ref = u.user_id
                                WHERE u.user_password = "7c222fb2927d828af22f592134e8932480637c0d"
                                OR u.user_access_name = "admin"
                                OR u.user_access_name = "TheSMAX"
                                OR u.user_access_name = "Julia"
                                OR u.user_access_name = "Niveauvoll"
                                ORDER BY u.user_register_date desc');
foreach($users as $u){
        $mysqli->query('UPDATE tbl_users SET user_is_vip = "yes" WHERE user_id = '.$u['uid']);
        $mysqli->query('INSERT INTO tbl_payment_transactions_stripe(
                              user_id, amount, currency, created_date, type, payment_status)
                              VALUES('.$u['uid'].',0.00, "EUR", CURRENT_TIMESTAMP, "vip", "success")');
        $lastid = $mysqli->insert_id;
        ($u['ug'] == "male") ? $package = 2 : $package = 6;
        $mysqli->query('INSERT INTO tbl_user_buy_vip(
                              purchased_user_id, vip_package_id, vip_package_name, vip_package_amount, vip_package_diamonds, package_validity_in_months, package_activated_using, transaction_id_ref, buy_vip_date,	buy_vip_flag)
                              VALUES('.$u['uid'].', '.$package.', "3 MONTH VIP", 0.00, 0, 3, "amount", '.$lastid.', CURRENT_TIMESTAMP, "web")');
        $vip_users = $mysqli->query('SELECT user_id, user_access_name, user_email FROM tbl_users WHERE user_id = '.$u['uid']);
        $viparr = $vip_users->fetch_array();
        echo($viparr['user_id'].' - '. $viparr['user_access_name'].' '.$viparr['user_email'].'<br>');
}
