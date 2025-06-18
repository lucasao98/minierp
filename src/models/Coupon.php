<?php

require_once "../config/connection.php";

class Coupon {
    private $id_coupon;
    private $coupon_code;
    private $discount;
    private $minimum_price;
    private $created_at;
    private $expired_at;

    public function getCouponByCode($coupon_code) {
        try {
            $pdo = connect_db();
            $statment = $pdo->prepare("SELECT * FROM coupons WHERE coupon_code = :coupon_code");
            $statment->bindParam(":coupon_code", $coupon_code);

            $statment->execute();

            $coupon = $statment->fetch(PDO::FETCH_OBJ);

            if(empty($coupon)){
                return false;
            }

            if(self::isCouponExpired($coupon)){
                return false;
            }
            
            $this->id_coupon = intval($coupon->id_coupon);
            $this->coupon_code = $coupon->coupon_code;
            $this->discount = floatval($coupon->discount);
            $this->minimum_price = floatval($coupon->minimum_price);
            $this->created_at = $coupon->created_at;
            $this->expired_at = $coupon->expired_at;

            return $this;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public function isCouponExpired($coupon) {
        if(getDatetime() > $coupon->expired_at){
            return true;
        }
        return false;
    }

    public function getCouponId() {
        return $this->id_coupon;
    }

    public function getCouponCode() {
        return $this->coupon_code;
    }

    public function getDiscount() {
        return $this->discount;
    }

    public function getMinimumPrice() {
        return $this->minimum_price;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function getExpiredAt() {
        return $this->expired_at;
    }
}