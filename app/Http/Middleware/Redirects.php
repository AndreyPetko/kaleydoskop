<?php
/**
 * Created by PhpStorm.
 * User: andreypetko
 * Date: 11/5/17
 * Time: 18:29
 */

namespace App\Http\Middleware;


use Illuminate\Auth\Guard;


/**
 * Class Redirects
 * @package App\Http\Middleware
 */
class Redirects
{

    const BASE_URL = 'http://kaleydoskop-vishivki.com.ua';
    /**
     * @var Guard
     */
    protected $auth;

//    const FROM_TO = [
//        '/osnov.php?idraz=101' => '/oplata-dostavka',
//        '/osnov.php?idraz=122' => '/about',
//        '/osnov.php?idraz=106' => '/contacts',
//        '/osnov.php?idraz=126' => '/brends',
//        '/show_cat2.php?grid=50000' => '/new-products',
//        '/show_proz.php?idproz=2' => '/brend-products/zolotoe-runo',
//        '/show_proz.php?idproz=1' => '/brend-products/Riolis',
//        '/show_proz.php?idproz=3' => '/brend-products/DIMENSIONS',
//        '/show_proz.php?idproz=4' => '/brend-products/chudesnaya-igla',
//        '/show_proz.php?idproz=5' => '/brend-products/BUCILLA',
//        '/show_proz.php?idproz=6' => '/brend-products/krasa-%D1%96-tvorch%D1%96stb',
//        '/show_proz.php?idproz=7' => '/brend-products/russkij-favorit',
//        '/show_proz.php?idproz=8' => '/brend-products/anchor',
//        '/show_proz.php?idproz=10' => '/brend-products/char%D1%96vna-mitb',
//        '/show_proz.php?idproz=11' => '/brend-products/kroshe',
//        '/show_proz.php?idproz=12' => '/brend-products/russkaya-iskusnicza'
//    ];

    /**
     * Redirects constructor.
     * @param Guard $auth
     */
    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    /**
     * @param $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next){
        $uri = $request->getRequestUri();

        $excel = \App::make('excel');

        $redirectUrls = [];

        $excel->load('file.xlsx', function($reader) use (&$redirectUrls) {

            $list = $reader->all()->all();

            foreach ($list as $item) {
                $cols = $item->all();
                $from = str_replace(self::BASE_URL, '', $cols['old']);
                $to = str_replace(self::BASE_URL, '', $cols['new']);

                if($from !== '' && $to !== '') {
                    $redirectUrls[$from] = $to;
                }
            }
        });
        
        $to = $redirectUrls[$uri] ?? null;

        if($to) {
            return redirect($to, 301);
        }

        return $next($request);
    }

}