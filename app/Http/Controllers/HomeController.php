<?php

namespace App\Http\Controllers;


use Request;
use Redirect;
use Auth;
use DB;
use Session;
use Cookie;
use Response;
use Mail;

use App\Helper;
use App\Feedback;
use App\Product;
use App\Ftp;
use App\Cart;
use App\Slide;
use App\Brend;
use App\Category;
use App\Subcategory;
use App\Attribute;
use App\Review;
use App\MyDate;
use App\MyCookie;
use App\Breadcrumbs;
use App\Intake;
use App\Sendmail;
use App\Wishlist;
use App\Comparison;
use App\Text;
use App\File;
use App\Keyval;


class HomeController extends Controller {

	/**
	 * { function_description }
	 */
	public function __construct() {
		$this->request = Request::all();
		unset($this->request['_token']);
	}

	/**
	 * Gets the index.
	 *
	 * @return     <type>  The index.
	 */
	public function getIndex() {
		$data['mainSlides'] = Slide::getOrderMainSlides();
		$data['recProducts'] = Product::getRecommended(4);
		$data['newProducts'] = Product::getNew($skip = 0, $take = 8);


		foreach ($data['newProducts'] as $product) {
			if($product->images) {
				foreach ($product->images as $image) {
					$product->image = $image->url;
					break;
				}
			}
		}

		$data['brends'] = Brend::getItemsWithLogo();

		$data['recProducts'] = Product::setWholesalePrice($data['recProducts'], 1);
		$data['newProducts'] = Product::setWholesalePrice($data['newProducts'], 1);

        $data['catalog'] = Category::getCatalog();

        $data['mainTitle'] = strip_tags(Text::getItem('title-main'));

        
		return view('site.index', $data);
	}

	/**
	 * Gets the new products.
	 *
	 * @return     <type>  The new products.
	 */
	public function getNewProducts() {
		$products = Product::getNew(52);

		foreach ($products as $product) {
			$product = Product::setWholesalePrice($product);
			foreach ($product->images as $image) {
				$product->image = $image->url;
				break;
			}
		}

		$breadcrumbs = ['/new-products' => 'Новинки'];


		return view('site.newList', compact('products', 'breadcrumbs'));
	}

	/**
	 * Gets the about.
	 *
	 * @return     <type>  The about.
	 */
	public function getAbout() {
		$textVar = Text::getItem('about');

		$title = 'О компании';
		$breadcrumbs = ['/about' => 'О компании'];

		return view('site.simpleTextPage')->with('textVar', $textVar)->with('title', $title)->with('breadcrumbs', $breadcrumbs);
	}

	/**
	 * Gets the wholesalers.
	 *
	 * @return     <type>  The wholesalers.
	 */
	public function getWholesalers() {
		if(!Auth::check() || Auth::user()->role == 'retail' || Auth::user()->role == 'admin') {
			$textVar = Text::getItem('wholesalersAll');
		} else {
			$textVar = Text::getItem('wholesalersOnly');
		}

		$files = File::all();

		$breadcrumbs = ['/wholesalers' => 'Оптовикам'];

		return view('site.wholesalers', compact('textVar', 'breadcrumbs', 'files'));
	}


	/**
	 * Gets the product.
	 *
	 * @param      string  $url    The url
	 *
	 * @return     <type>  The product.
	 */
	public function getProduct($url = '') {
		if($url == '') {
			return view('site.noproduct');
		}



		$data['product'] = Product::getByUrl($url);


		$data['category'] = Category::getByProductId($data['product']->id);

		if($data['category']) {
			$data['subcategories'] = Subcategory::getByCategoryId($data['category']->id);
		}

		$data['images'] = Product::getImagesById($data['product']->id);

		$data['reviews'] = Review::getProductReview($data['product']->id);

		$data['reviews'] = MyDate::changeFormat($data['reviews']);

		$data['withProducts'] = Product::getWith($data['product']->id);


		$data['next'] = $data['reviews']->nextPageUrl();
		$data['prev'] = $data['reviews']->previousPageUrl();

		$data['watched'] = Product::getWatched($data['product']->id);


		$data['countReviews'] = Review::getCountByProductId($data['product']->id);

		$wishObj = Wishlist::getInstance();
		$data['product']->wish = $wishObj->check($data['product']->id);

		$compObj = Comparison::getInstance();
		$data['product']->comp = $compObj->check($data['product']->id);

		$data['attributes'] = Product::getProductAttributes($data['product']->id);

		$cookie = MyCookie::addItem($data['product']->id);

		$cookie = Cookie::make('watched', $cookie , '99999');

		Cookie::queue($cookie);

		$bread = Breadcrumbs::getInstance('product');
		$data['breadcrumbs'] = $bread->generate($data['product']);

		$data['product'] = Product::setWholesalePrice($data['product']);


		if($data['withProducts']) {
			$data['withProducts'] = Product::setWholesalePrice($data['withProducts'], 1);
		}

		if($data['watched']) {
			$data['watched'] = Product::setWholesalePrice($data['watched'], 1);
		}



		if($data['category'] && $data['category']->id == 39) {
			return view('site.threadProduct', $data);
		} else {
			return view('site.product', $data);
		}
	}


	// public function getCategory($url) {

	// 	if($url != Session::get('categoryUrl')) {
	// 		Session::forget('filter');
	// 		Session::forget('brends');
	// 		Session::forget('subcatId');
	// 		Session::forget('startPrice');
	// 		Session::forget('stopPrice');
	// 	}


	// 	if(isset($_GET['subcategory'])) {
	// 		Session::put('subcatId', $_GET['subcategory']);
	// 	}

	// 	Session::put('categoryUrl', $url);


	// 	if(Session::get('sortType')) {
	// 		$sortType = Session::get('sortType');
	// 	} else {
	// 		$sortType = 'name';
	// 	}

	// 	$data['category']  = Category::getByUrl($url);
	// 	$data['subcategories'] = Subcategory::getByCategoryId($data['category']->id);

	// 	$data['products'] = Product::getBySessionFilter($url, 2);

	// 	$data['attributesValues'] = Attribute::getValues('category', $data['category']->id);


	// 	$data['maxPrice'] = Product::getMaxCategoryPrice($data['category']->id);

	// 	$bread = Breadcrumbs::getInstance('category');
	// 	$data['breadcrumbs'] = $bread->generate($data['category']);

	// 	$data['brends'] = Brend::getByCategoryId($data['category']->id);


	// 	if($data['category']->id == 39) {
	// 		$data['theads'] = 1;
	// 	}

	// 	return view('site.category', $data);
	// }


	/**
	 * Gets the category.
	 *
	 * @param      <type>  $url    The url
	 *
	 * @return     <type>  The category.
	 */
	public function getCategory($url)
	{
		$category = Category::getByUrl($url);
		$subcategories = Subcategory::getByCategoryId($category->id);

		return view('site.subcategories', compact('subcategories', 'category'));
	}


	/**
	 * Gets the subcategory.
	 *
	 * @param      <type>        $url      The url
	 * @param      \App\Product  $product  The product
	 *
	 * @return     <type>        The subcategory.
	 */
	public function getSubcategory($url, Product $product) {

		if($url != Session::get('categoryUrl')) {
			Session::forget('filter');
			Session::forget('brends');
			Session::forget('subcatId');
			Session::forget('startPrice');
			Session::forget('stopPrice');
		}


		if(Session::get('sortType')) {
			$sortType = Session::get('sortType');
		} else {
			$sortType = 'name';
		}

		$subcategory = Subcategory::where('url', $url)->first();
		$data['subcategoryUrl'] = $subcategory->url;

		Session::put('subcatId', $subcategory->id);

		$data['category'] = Category::find($subcategory->category_id);

		if($data['category']->isThread()) {
			Session::put('showCount', 9999999);
		} else {
			if(Session::get('showCount') == 9999999) {
				Session::put('showCount', 9);
			}
		}

		$data['subcategories'] = Subcategory::getByCategoryId($data['category']->id);
		$data['products'] = Product::getBySessionFilter($data['category']->url, 2);
		$data['attributesValues'] = Attribute::getValues('category', $data['category']->id);


		$data['maxPrice'] = Product::getMaxCategoryPrice($data['category']->id);

		$bread = Breadcrumbs::getInstance('category');
		$data['breadcrumbs'] = $bread->generate($data['category']);

		$data['brends'] = Brend::getByCategoryId($data['category']->id);


		if($data['category']->isThread()) {
			$data['theads'] = 1;
			$data['allProducts'] = $product->getAllSubcategoryProducts($subcategory->id);
		}


		return view('site.category', $data);
	}

	/**
	 * Posts an add threads to card.
	 *
	 * @param      \App\Product  $productEntity  The product entity
	 *
	 * @return     <type>        ( description_of_the_return_value )
	 */
	public function postAddThreadsToCard(Product $productEntity)
	{
		$products = $this->request['products'];

		$products = $productEntity->filterZeroCount($products);

		$cart = Cart::getInstance(1);

		$cart->addList($products);

		return Redirect::back()->with('addToCard', 1);;
	}


	/**
	 * Posts an add review.
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function postAddReview() {
		if($this->request['name'] == 'Admin') {
			if(!Auth::check() || Auth::user()->role != 'admin') {
				return Redirect::back();
			}
		}

		Review::create($this->request);
		return Redirect::back();
	}

	/**
	 * Gets the search.
	 *
	 * @param      string  $query  The query
	 *
	 * @return     <type>  The search.
	 */
	public function getSearch($query = '') {
		$products = Product::search($query);

		// $products = Wishlist::setWishToProducts($products);
		$breadcrumbs = ['/search' => 'Поиск'];

		return view('site.search')->with('products', $products)->with('query', $query)->with('breadcrumbs', $breadcrumbs);
	}

	/**
	 * Posts an add intake message.
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function postAddIntakeMessage() {
		Intake::addItem($this->request);
		return Redirect::back();
	}



	/**
	 * Gets the ftp file.
	 */
	public function getFtpFile() {
		$result = Ftp::getFile();

		if($result) {
			Ftp::addItems();
		}
	}

	/**
	 * Gets the cartesian.
	 *
	 * @return     <type>  The cartesian.
	 */
	public function getCart() {
		$cart = Cart::getInstance();
		$cartInfo = $cart->getProductsAndTotal();
		$products = $cartInfo[0];
		$total = $cartInfo[1];
		$breadcrumbs = ['/cart' => 'Корзина'];
		$deliveryPrices = Keyval::getDeliveryPrices();
		$deliveryPricesStr = json_encode($deliveryPrices->toArray());
		return view('site.cart', compact('products', 'total', 'breadcrumbs', 'deliveryPricesStr'));
	}

	/**
	 * Posts a send feedback.
	 *
	 * @param      \App\Feedback  $feedback  The feedback
	 *
	 * @return     <type>         ( description_of_the_return_value )
	 */
	public function postSendFeedback(Feedback $feedback) {
		if(Auth::check() && Auth::user()->role == 'wholesaler') {
			$this->request['user_type'] = 'wholesaler';
		} else {
			$this->request['user_type'] = 'retail';
		}


		$this->request['type'] = 'feedback';
		$feedback->create($this->request);
		return Redirect::back()->with('feedback', 1);
	}

	/**
	 * Posts an add callback.
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function postAddCallback() {

		$email = 'andreypetko3@gmail.com';

		Mail::send('emails.callback', ['name' => $this->request['name'], 'phone' => $this->request['phone']], function($message) use ($email)
		{
			$message->to($email, 'Kaleydoskop')->subject('Новый обратный звонок!');
		});

		Feedback::create(['name' => $this->request['name'], 'phone' => $this->request['phone'], 'type' => 'callback']);
		return Redirect::back()->with('callback', 1);
	}

	/**
	 * Posts an add sendmail.
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function postAddSendmail() {
		if(Auth::check()) {
			$user_id = Auth::user()->id;
		} else {
			$user_id = 0;
		}

		Sendmail::subEmail($this->request['email'], $user_id);

		return Redirect::back()->with('sub',1);
	}


	public function getWishlist() {
		$wishlistObj = Wishlist::getInstance();
		$wishlist = $wishlistObj->get();

		$compObj = Comparison::getInstance();
		$complist = $compObj->getIds();


		$wishlist = Product::setComp($wishlist,$complist);

		$breadcrumbs = ['/dashboard' => 'Личный кабинет','/wishlist' => 'Список желаний'];
		return view('site.wishlist')->with('wishlist', $wishlist)->with('breadcrumbs', $breadcrumbs);
	}

	public function getContacts() {
		$breadcrumbs = ['/contacts' => 'Контакты'];

		if(Auth::check() &&  (Auth::user()->role == 'wholesaler' || Auth::user()->role == 'ander' ))  {
			$contacts = Keyval::getWholesaleContacts();
		} else {
			$contacts = Keyval::getRetailContacts();
		}



		return view('site.contacts')->with('breadcrumbs', $breadcrumbs)->with('contacts', $contacts);
	}

	public function getBrends() {
		$brends = Brend::all();
		$breadcrumbs = ['/brends' =>  'Бренды'];
		return view('site.brends')->with('brends', $brends)->with('breadcrumbs', $breadcrumbs);
	}

	public function getBrend($url) {
		$brends = Brend::all();
		$brend = Brend::getByUrl($url);
		$breadcrumbs = ['/brends' => 'Бренды', '/ds' => $brend->name];
		return view('site.singleBrend')->with('brend', $brend)->with('brends', $brends)->with('breadcrumbs', $breadcrumbs);
	}

	public function getBrendProducts($url) {
		if($url != Session::get('brendUrl')) {
			Session::forget('brendFilter');
			Session::forget('subcat');
			Session::forget('brendsShowCount');
			Session::forget('brendsShowType');
			Session::forget('brendMinPrice');
			Session::forget('brendMaxPrice');
		}

		Session::put('brendUrl', $url);

		$brend = Brend::getByUrl($url);
		$maxPrice = Product::getMaxBrendPrice($brend->id);
		$brendAttributes = Attribute::getValues('brend',$brend->id);
		$products = Product::getBySessionBrendFilter($url, 2);


		$subcategories = Subcategory::getBrendItems($brend->id);

		$brends = Brend::getNotThreads();

		$breadcrumbs = ['/brends' => 'Бренды', '/brend/' . $url => $brend->name, '/pr' => 'Товары'];

		return view('site.brendFilter')->with('brend', $brend)
		->with('maxPrice', $maxPrice)
		->with('brendAttributes', $brendAttributes)
		->with('products', $products)
		->with('brends', $brends)
		->with('breadcrumbs', $breadcrumbs)
		->with('subcategories', $subcategories);
	}


	public function getComparison(){
		$compObj = Comparison::getInstance();
		$compIds = $compObj->getIds();

		$arrid = Attribute::getByProductsIds($compIds);
		$attributes = Attribute::getByNamesByProductsIds($arrid);

		$products = Product::getAttributesComp($compIds);


		// var_dump($products);


		return view('site.comparision')->with('attributes', $attributes)->with('products', $products);
	}

	public function getComparisonDelete($productId) {
		$compObj = Comparison::getInstance();
		$compObj->delete($productId);
		return Redirect::to('/comparison');
	}

	public function getClearComparison() {
		$comparison = Comparison::getInstance();
		$comparison->clearList();
		return Redirect::back();
	}


	public function getCatalog() {
		$catalog = Category::getCatalog();
		$breadcrumbs = ['/catalog' => 'Каталог'];
		return view('site.catalog')->with('catalog', $catalog)->with('breadcrumbs', $breadcrumbs);
	}


	public function getThreads() {

		return view('site.threads');
	}

	public function getResetPassword() {
		return view('auth.password');
	}

	public function getOplataDostavka() {
		if(Auth::check() && Auth::user()->role == 'wholesaler') {
			$textVar = Text::getItem('oplata-dostavka-opt');
		} else {
			$textVar = Text::getItem('oplata-dostavka');
		}

		$title = 'Оплата и доставка';

		$breadcrumbs = ['/oplata-dostavka' => 'Оплата и доставка'];

		return view('site.simpleTextPage')->with('textVar', $textVar)->with('breadcrumbs', $breadcrumbs)->with('title', $title);
	}

	public function getUnsubscribe($id) {
		Sendmail::deleteItem('id', $id);

		return view('site.unsub-success');
	}

	public function getXml() {
		$products = Ftp::generateArrayFromXml('Ostatki.xml');

		array_walk($products, function(&$product){
    // переводим в транслит
			$str = Helper::rus2translit($product['name']);

    // в нижний регистр
			$str = strtolower($str);
    // заменям все ненужное нам на "-"
			$str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
    // удаляем начальные и конечные '-'
			$str = trim($str, "-");

			$product['url'] = $str;

		});



		$result = Product::updateByArray($products);

		if($result) {
			echo 'Обновление прошло успешно';
		}
	}


	public function getDownload($fileId) {
		$item = File::find($fileId);
		$file= public_path(). "/download/" . $item->name;
		$headers = array(
			'Content-Type: application/octet-stream',
			);
		return Response::download($file, $item->name, $headers);
	}


}