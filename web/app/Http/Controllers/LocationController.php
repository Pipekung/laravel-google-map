<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Location;
use GoogleMaps;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function pin() {
        return view('location/pin');
    }

    public function area(Request $request) {
        $areas = Area::select('title')->distinct()->orderBy('title', 'asc')->get();
        return view('location/area', [
            'name' => $request->input('name'),
            'areas' => $areas,
        ]);
    }

    public function get_pin() {
        $locations = Location::all();
        return $locations;
    }

    public function get_area(Request $request) {
        $name = $request->input('name');
        if (empty($name)) {
            $locations = Area::all();
        } else {
            $locations = Area::where('title', '=', $name)->get();
        }
        return $locations;
    }
}
