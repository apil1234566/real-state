<?php

namespace App\Http\Controllers;

use App\City;
use App\Place;
use App\Room;
use App\Category;
use App\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SeekerRoomController extends Controller
{
    public function index()
    {
        $excluding_ids = DB::table('properties')
        ->join('applicants', 'properties.id', '=', 'applicants.property_id')
        ->where('applicants.status', 'hired') // Specify 'applicants.status' here
        ->orWhere('applicants.status', '')    // Specify 'applicants.status' here
        ->pluck('applicants.property_id');

        $cities = City::all(['name', 'id']);
        $places = Place::all(['name', 'id']);
        $categories = Category::all();
        $properties = Property::with('city')->with('place')->with('category')
        ->whereNotIn('id', $excluding_ids->toArray())
        ->select(['id', 'title', 'price', 'city_id', 'place_id', 'category_id', 'created_at'])
        ->paginate(10);

        return view('room_seeker.all_room', compact('properties', 'categories', 'cities', 'places'));
    }

    public function allRoomAjax(Request $request)
    {
        /*if ($request->cityId == 0) {
            $rooms = Room::with('city')->with('place')->with('category')
                ->where('category_id', $request->categoryId)
                ->get(['id', 'title', 'price', 'city_id', 'place_id', 'category_id', 'created_at']);
            return $resp = array(
                'success' => true,
                'message' => "Rooms",
                'data' => $rooms
            );
        }*/

        /* if ($request->cityId != 0 && $request->categoryId != 0) {
             $query = Room::with('city')->with('place')->with('category')
                 ->where('city_id', $request->cityId)
                 ->where('category_id', $request->categoryId);
             if ($request->placeId != 0) {
                 $query->where('place_id', $request->placeId);
             }
             $rooms = $query->get(['id', 'title', 'price', 'city_id', 'place_id', 'category_id', 'created_at']);;

             return $resp = array(
                 'success' => true,
                 'message' => "Rooms",
                 'data' => $rooms
             );
         }*/

        $excluding_ids =  DB::table('properties')
            ->join('applicants', 'properties.id', '=', 'applicants.property_id')
            ->where('applicants.status', 'hired') // Specify 'applicants.status' here
            ->orWhere('applicants.status', '')    // Specify 'applicants.status' here
            ->pluck('applicants.property_id');

        $query = Property::with('city')->with('place')->with('category')->whereNotIn('id', $excluding_ids->toArray());
        if ($request->cityId != 0) {
            $query->where('city_id', $request->cityId);
        }
        if ($request->placeId != 0) {
            $query->where('place_id', $request->placeId);
        }
        if ($request->categoryId != 0) {
            $query->where('category_id', $request->categoryId);
        }
        $properties = $query->get(['id', 'title', 'price', 'city_id', 'place_id', 'category_id', 'created_at']);
        return $resp = array(
            'success' => true,
            'message' => "Properties",
            'data' => $properties
        );
    }

    public function allRoomSearch()
    {
        $categories = Category::all();
        $rooms = Room::with('city')
            ->with('place')->with('category')
            ->select(['id', 'title', 'price', 'city_id', 'place_id', 'category_id', 'created_at'])->paginate(10);
        return view('room_seeker.index', compact('rooms', 'categories'));
    }

    public function seekerRoom()
    {
        $id = auth()->id();
        $properties = DB::table('applicants')
            ->join('properties', 'applicants.property_id', '=', 'properties.id')
            ->when($id, function ($query) use ($id) {
                return $query->where('applicants.user_id', $id);
            })->select(['properties.id', 'properties.title', 'applicants.status', 'properties.created_at'])
            ->paginate(5);
        // dd($properties);
        return view('room_seeker.my_rooms', compact('properties'));
    }
}
