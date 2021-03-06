<?php

/**
 * FrontendController
 *
 * @author vuongabc92@gmail.com
 */

namespace King\Frontend\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\City;
use App\Models\Store;
use App\Models\Product;
use App\Models\User;

class HomeController extends FrontController
{
    public function index()
    {
        return view('frontend::home.index');
    }

    /**
     * @todo Search city by name
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxSearchLocation(Request $request) {

        //Only accept ajax request
        if ($request->ajax()) {

            $city_name = $request->get('location_keyword');
            $results   = locations(trim($city_name));

            return pong(1, ['data' => $results]);
        }
    }

    /**
     * @todo Save location by session
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id City id
     *
     * @return Redirect
     */
    public function selectLocation($id) {

        $id = (int) $id;
        if ( ! is_null(City::find($id))) {

            Session::put(_const('SESSION_LOCATION'), $id);
            Session::save();
        }

        return redirect(route('front_home'));
    }


    public function ajaxSearch(Request $request, $keyword) {

        if ($request->ajax() && $request->isMethod('GET') && trim($keyword) !== '') {

            $stores   = Store::where('name', 'LIKE', "%{$keyword}%")->take(10)->get(['slug', 'name']);
            $products = Product::where('name', 'LIKE', "%{$keyword}%")->take(10)->get(['id', 'name']);
            $users    = User::where('first_name', 'LIKE', "%{$keyword}%")
                                ->orWhere('last_name', 'LIKE', "%{$keyword}%")
                                ->orWhere('user_name', 'LIKE', "%{$keyword}%")
                                ->take(10)->get(['user_name', 'first_name', 'last_name']);

            return pong(1, ['data' => [
                'stores' => $stores,
                'products' => $products,
                'users' => $users,
            ]]);
        }

    }
}