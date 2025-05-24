<?php

use Spatie\Valuestore\Valuestore;
use Modules\Core\Packages\Setting\Setting;



if (!function_exists('slugAr')) {
    /**
     * The Current dir
     *
     * @param  string  $locale
     */
    function slugAr($string, $separator = '-')
    {
        if (is_null($string)) {
            return "";
        }

        // Remove spaces from the beginning and from the end of the string
        $string = trim($string);

        // Lower case everything
        // using mb_strtolower() function is important for non-Latin UTF-8 string | more info: https://www.php.net/manual/en/function.mb-strtolower.php
        $string = mb_strtolower($string, "UTF-8");;

        // Make alphanumeric (removes all other characters)
        // this makes the string safe especially when used as a part of a URL
        // this keeps latin characters and arabic charactrs as well
        $string = preg_replace("/[^a-z0-9_\s\-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]#u/", "", $string);

        // Remove multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);

        // Convert whitespaces and underscore to the given separator
        $string = preg_replace("/[\s_]/", $separator, $string);

        return $string;
    }
}

if (!function_exists('base64')) {
    function base64($imgUrl)
    {

        $folder = 'uploads/api';

        $path   = $imgUrl;
        $type   = '.jpg';
        $imgname = md5(rand() * time()) . '.' . $type;

        // Get new name of image Url & Path of folder to save in it
        $fname = $folder . '/' . $imgname;
        $img = Image::make($path);

        // End of this proccess
        $img->save($fname);

        return $fname;
    }
}
// Get Setting Values
if (!function_exists('setting')) {
    function setting($key, $index = null)
    {
        $value = null;
        $setting = Valuestore::make(storage_path('app/settings.json'));

        return data_get($setting->get($key), $index);
    }
}

if (!function_exists('color_theme')) {

    function color_theme($category)
    {
        return $category ? $category->color : '';
    }
}


// Active Dashboard Menu
if (!function_exists('array_pluck')) {
    function array_pluck($object, $index)
    {
        return $object->pluck($index)->toArray();
    }
}


if (!function_exists('setValidationAttributes')) {

    function setValidationAttributes(array $attributes, $local = 'ar')
    {
        if (config('core.validation-attributes.' . $local)) {
            $attributes += (array)config('core.validation-attributes.' . $local);
            Illuminate\Support\Facades\Config::set('core.validation-attributes.' . $local, $attributes);
        }
    }
}

// Active Dashboard Menu
if (!function_exists('active_menu')) {
    function active_menu($routeNames)
    {
        $routeNames = (array) $routeNames;
        return in_array(request()->segment(3), $routeNames) ? 'active' : '';
    }
}

if (!function_exists('active')) {
    function active($routeName)
    {

        return Route::currentRouteName() == $routeName ? 'active' : '';
    }
}

if (!function_exists('calculateOfferAmountByPercentage')) {
    function calculateOfferAmountByPercentage($productPrice, $offerPercentage)
    {
        $percentageResult = (floatval($offerPercentage) * floatval($productPrice)) / 100;
        return floatval($productPrice) - $percentageResult;
    }
}


if (!function_exists('active_slide_menu')) {
    function active_slide_menu($routeNames)
    {
        $response = [];
        foreach ((array)$routeNames as $name) {
            array_push($response, active_menu($name));
        }

        return in_array('active', $response) ? 'active open' : '';
    }
}

if (!function_exists('active_profile')) {

    function active_profile($route)
    {
        return (Route::currentRouteName() == $route) ? 'active' : '';
    }
}

// GET THE CURRENT LOCALE
if (!function_exists('locale')) {

    function locale()
    {
        return app()->getLocale();
    }
}

// CHECK IF CURRENT LOCALE IS RTL
if (!function_exists('is_rtl')) {

    function is_rtl($locale = null)
    {

        $locale = ($locale == null) ? locale() : $locale;

        if (in_array($locale, config('rtl_locales'))) {
            return 'rtl';
        }

        return 'ltr';
    }
}


if (!function_exists('slugfy')) {
    /**
     * The Current dir
     *
     * @param string $locale
     */
    function slugfy($string, $separator = '-')
    {
        $url = trim($string);
        $url = strtolower($url);
        $url = preg_replace('|[^a-z-A-Z\p{Arabic}0-9 _]|iu', '', $url);
        $url = preg_replace('/\s+/', ' ', $url);
        $url = str_replace(' ', $separator, $url);

        return $url;
    }
}


// if (! function_exists('path_without_domain')) {
//     /**
//      * Get Path Of File Without Domain URL
//      *
//      * @param string $locale
//      */
//     function path_without_domain($path)
//     {
//         return parse_url($path, PHP_URL_PATH);
//     }
// }


if (!function_exists('path_without_domain')) {
    /**
     * Get Path Of File Without Domain URL
     *
     * @param string $locale
     */
    function path_without_domain($path)
    {
        $url = $path;
        $parts = explode("/", $url);
        array_shift($parts);
        array_shift($parts);
        array_shift($parts);
        $newurl = implode("/", $parts);

        return $newurl;
    }
}

if (!function_exists('int_to_array')) {
    /**
     * convert a comma separated string of numbers to an array
     *
     * @param string $integers
     */
    function int_to_array($integers)
    {
        return array_map("intval", explode(",", $integers));
    }
}


if (!function_exists('combinations')) {

    function combinations($arrays, $i = 0)
    {

        if (!isset($arrays[$i])) {
            return array();
        }

        if ($i == count($arrays) - 1) {
            return $arrays[$i];
        }

        // get combinations from subsequent arrays
        $tmp = combinations($arrays, $i + 1);

        $result = array();

        // concat each array from tmp with each element from $arrays[$i]
        foreach ($arrays[$i] as $v) {
            foreach ($tmp as $t) {
                $result[] = is_array($t) ?
                    array_merge(array($v), $t) :
                    array($v, $t);
            }
        }

        return $result;
    }
}


if (!function_exists('htmlView')) {
    /**
     * Access the OrderStatus helper.
     */
    function htmlView($content)
    {
        return
            '<!DOCTYPE html>
           <html lang="en">
             <head>
               <meta charset="utf-8">
               <meta http-equiv="X-UA-Compatible" content="IE=edge">
               <meta name="viewport" content="width=device-width, initial-scale=1">
               <link href="css/bootstrap.min.css" rel="stylesheet">
               <!--[if lt IE 9]>
                 <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
                 <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
               <![endif]-->
             </head>
             <body>
               ' . $content . '
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
               <script src="js/bootstrap.min.js"></script>
             </body>
           </html>';
    }
}


if (!function_exists('currency')) {
    /**
     * The Current currency
     *
     * @param string $currency
     */
    function currency($price)
    {
        if (session()->get('currency'))
            return convertCurrency($price) . ' ' . currentCurrency();

        return convertCurrency($price) . ' ' . currentCurrency();
    }
}

if (!function_exists('convertCurrency')) {
    /**
     * The Convert Price
     *
     * @param string $price
     */
    function convertCurrency($price)
    {
        if (session()->get('currency'))
            return (round(($price * session()->get('currency')['rate']) / 5) * 5);

        if (Request::header('Currency-Rate'))
            return (round(($price * \Request::header('Currency-Rate')) / 5) * 5);

        return round($price);
    }
}

if (!function_exists('currentCurrency')) {
    /**
     * The Current currentCurrency
     *
     * @param string $currentCurrency
     */
    function currentCurrency()
    {
        if (session()->get('currency'))
            return session()->get('currency')['code'];

        if (Request::header('Currency-Rate'))
            return \Request::header('Currency-Code');

        return setting('default_currency');
    }
}

if (!function_exists('ajaxSwitch')) {

    function ajaxSwitch($model, $url, $switch = 'status', $open = 1, $close = 0)
    {
        return view('apps::dashboard.components.ajax-switch', compact('model', 'url', 'switch', 'open', 'close'))->render();
    }
}

if (!function_exists('checkRouteLocale')) {
    function checkRouteLocale($model, $slug)
    {
        if ($array = $model->getTranslations("slug")) {
            $locale = array_search($slug, $array);
            return $locale == locale();
        }
        return true;
    }
}

if (!function_exists('is_new_row')) {
    function is_new_row($barcode_details, $loop_count)
    {
        $stickers_in_one_row = $barcode_details->stickers_in_one_row ?? 0;
        return ($stickers_in_one_row == 1 || ($loop_count % $stickers_in_one_row) == 1) ? true : false;
    }
}

if (!function_exists('is_end_row')) {
    function is_end_row($barcode_details, $loop_count)
    {
        return ($barcode_details->stickers_in_one_row == 1 || ($loop_count % $barcode_details->stickers_in_one_row) == 0) ? true : false;
    }
}

if (!function_exists('is_new_paper')) {
    function is_new_paper($barcode_details, $loop_count)
    {
        if ($barcode_details->is_continuous) {
            return $loop_count == 1;
        }
        return (
                //  ( $barcode_details->is_continuous && is_new_row($barcode_details, $loop_count) ) ||
                 ($barcode_details->stickers_in_one_sheet  && ($loop_count % $barcode_details->stickers_in_one_sheet == 1 ||$barcode_details->stickers_in_one_sheet == 1)) ||
                 (!$barcode_details->is_continuous && $barcode_details->stickers_in_one_sheet && ($loop_count % $barcode_details->stickers_in_one_sheet == 1 || $barcode_details->stickers_in_one_sheet == 1))
                );
    }
}


if (!function_exists('countMaxOrders')) {
    function countMaxOrders()
    {
        $checkDate = setting('other','max_orders_start_at') && Carbon\Carbon::parse(setting('other','max_orders_start_at')) <= Carbon\Carbon::now();

        if($checkDate || !setting('other','max_orders_start_at')){
            $counter = setting('other','current_orders_counted') ? setting('other','current_orders_counted') + 1 : 1;
            $value = setting('other');
            $value['current_orders_counted'] = $counter;

            app('setting')->put('other', $value);
        }
    }
}


if (!function_exists(function: 'canOrderStatus')) {
    function canOrderStatus()
    {
       if((setting('other','max_orders') && setting('other','max_orders') <= setting('other','current_orders_counted')) || !setting('other','selling_on_site')){
            return false;
       }

       return true;
    }
}

if (!function_exists('is_paper_end')) {
    function is_paper_end($barcode_details, $loop_count)
    {
        if ($barcode_details->is_continuous) {
            return false;
        }

        return $barcode_details->stickers_in_one_sheet && (
                //  ($barcode_details->is_continuous && ($loop_count % $barcode_details->stickers_in_one_row == 0))  ||
                 ($barcode_details->is_continuous&& $barcode_details->stickers_in_one_sheet && ($loop_count % $barcode_details->stickers_in_one_sheet == 0 || $barcode_details->stickers_in_one_sheet== 1))
                 || (!$barcode_details->is_continuous && ($loop_count % $barcode_details->stickers_in_one_sheet == 0))
            );
    }
}

if (!function_exists('is_first_row')) {
    function is_first_row($barcode_details, $loop_count)
    {
        return ((!$barcode_details->is_continuous) && ($loop_count % $barcode_details->stickers_in_one_sheet) <= $barcode_details->stickers_in_one_row) ||
            ($barcode_details->is_continuous && ($loop_count <= $barcode_details->stickers_in_one_row));
    }
}


if (!function_exists('getDaysArray')) {
     function getDaysArray($start,$end){
        $start = strtotime($start);
        $end = strtotime($end);
        $datesArr = [];
        while ($start <= $end){
            $datesArr[] = date('Y-m-d',$start);
            $start = strtotime('+1 day',$start);
        }
        return $datesArr;
    }
}

// =============================================
