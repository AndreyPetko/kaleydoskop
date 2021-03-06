<?php

namespace App;
use App\MyCookie;
use App\cartClasses\AuthCart;
use App\cartClasses\GuestCart;
use Auth;
use Cookie;
use DB;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cart
 * @package App
 */
class Cart extends Model {
    /**
     * @var string
     */
    protected $table = 'carts';
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'product_id', 'count'];


    /**
     * @return AuthCart|GuestCart
     */
    public static function getInstance() {
		if(Auth::check()) {
			return new AuthCart;
		} else {
			return new GuestCart;
		}
	}

    /**
     * @param $user_id
     */
    public static function clearUserList($user_id) {
		DB::table('carts')->where('user_id', $user_id)->delete();
	}

    /**
     *
     */
    public static function cookieToCart() {
		$cart = Cookie::get('cart');
		if($cart) {
			foreach ($cart as $product_id => $count) {
				if($product_id != 0) {
					$cartObj = self::getInstance();
					$cartObj->add($product_id, $count);
				}
			}
		}

		MyCookie::clearCart();
	}

}