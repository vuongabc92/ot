<?php

namespace King\Backend\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Option;

class MapController extends BackController{

    /**
     * Display map page
     *
     * @return Response
     */
    public function index() {

        $mapData = [
            'map_long'   => config('back.default_longitude'),
            'map_lat'    => config('back.default_latitude'),
            'map_widget' => ''
        ];
        $option  = Option::where('key', config('back.map_key'))->first();

        if ($option !== null) {
            $mapData = json_decode($option->value, true);
        }

        return view('backend::map.index', ['map_data' => $mapData]);
    }

    /**
     * Save map info
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return response
     */
    public function save(Request $request) {
        
        if ($request->isMethod('POST')) {

            $mapLong   = $request->get('map_long');
            $mapLat    = $request->get('map_lat');
            $mapWidget = $request->get('map_widget');
            $mapArray  = [
                'map_long'   => $mapLong,
                'map_lat'    => $mapLat,
                'map_widget' => $mapWidget
            ];
            
            $option = Option::where('key', config('back.map_key'))->first();

            if ($option === null) {
                $option = new Option;
            }
            
            $option->key   = config('back.map_key');
            $option->value = json_encode($mapArray, JSON_UNESCAPED_UNICODE);
            
            $option->save();

            return redirect(route('backend_map'));
        }
    }
}
