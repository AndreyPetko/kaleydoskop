<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class Keyval
 * @package App
 */
class Keyval extends Model {
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'keyval';
    /**
     * @var array
     */
    protected $fillable = ['key', 'value'];


    /**
     * @param $key
     * @return mixed
     */
    public static function findByKey($key) {
		return self::where('key', $key)->value('value');
	}


    /**
     * @return array
     */
    public static function getWholesaleContacts() {
		$contacts = [];

		$contacts['phone1'] = self::findByKey('w_phone_1');
		$contacts['phone2'] = self::findByKey('w_phone_2');
		$contacts['email'] = self::findByKey('w_email');

		return $contacts;
	}

    /**
     * @return array
     */
    public static function getRetailContacts() {
		$contacts = [];

		$contacts['phone1'] = self::findByKey('r_phone_1');
		$contacts['phone2'] = self::findByKey('r_phone_2');
		$contacts['email'] = self::findByKey('r_email');

		return $contacts;
	}

    /**
     * @param $request
     * @param $type
     */
    public static function updateContacts($request, $type) {
		DB::table('keyval')->where('key', $type . '_phone_1')->update(['value' => $request['phone1']]);
		DB::table('keyval')->where('key', $type . '_phone_2')->update(['value' => $request['phone2']]);
		DB::table('keyval')->where('key', $type . '_email')->update(['value' => $request['email']]);
	}

    /**
     * @return mixed
     */
    public static function getDeliveryPrices() {
		$prices = ['sam', 'kuryer', 'novaposhta', 'ukrposhta', 'autolux', 'novanal', 'ukrnal'];

		return self::whereIn('key', $prices)->lists('value', 'key');
	}

    /**
     * @param $prices
     */
    public static function updatePrices($prices) {
		foreach ($prices as $name => $price) {
			self::where('key', $name)->update(['value' => $price]);
		}
	}


}