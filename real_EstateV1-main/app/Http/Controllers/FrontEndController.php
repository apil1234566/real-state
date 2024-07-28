<?php

namespace App\Http\Controllers;

use App\City;
use App\Room;
use App\Place;
use App\Category;
use App\Owner;
use App\Property;
use App\Rating;
use App\Testimonial;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FrontEndController extends Controller
{
    public function index()
    {
        $agents = Owner::all();
        $properties = Property::orderBy('created_at', 'desc')->get();
        $testimonials = Testimonial::where('approved',1)->orderBy('created_at', 'desc')->get();
        return view('welcome', compact('properties', 'agents','testimonials'));
    }

    public function properties()
    {
        $properties = Property::orderby('created_at', 'Desc')->paginate(6);
        return view('frontend.properties', compact('properties'));
    }

    public function agents()
    {
        $agents = Owner::orderby('created_at', 'Desc')->paginate(6);
        return view('frontend.agents', compact('agents'));
    }

    public function propertyDetail($property_id)
    {

        $property = Property::find($property_id);
        $uniqueKey = 'key_' . $property->id;
        if (!Session::has($uniqueKey)) {
            $property->views++;
            Session::put($uniqueKey, 1);
        }
        $property->save();

        $ratings = Rating::where('property_id', $property->id)->pluck('rating');
        $avgRating = $ratings->avg();
        return view('frontend.property_single', compact('property', 'avgRating'));
    }

    public function agentDetail($agent_id)
    {
        $agent=Owner::find($agent_id);
        // dd($agent->user->id);
        $properties=Property::where('user_id',$agent->user->id)->get();
        return view('frontend.agent_detail', compact('agent','properties'));
    }

    public function panoromic($property_id)
    {
        $property = Property::find($property_id);
        return view('frontend.panoromic', compact('property'));
    }

    public function search_room()
    {
        $rooms = Room::where([
            'city_id' => request()->city_id,
            'place_id' => request()->place_id
        ])->get();

        return view('frontend.search_room', compact('rooms'));
    }

    public function search_Property()
    {
        $searchKeyword = request()->keyword;

        $properties = Property::whereHas('city', function ($query) use ($searchKeyword) {
            $query->where('name', 'like', '%' . $searchKeyword . '%');
            })
            ->orWhereHas('category', function ($query) use ($searchKeyword) {
                $query->where('name', 'like', '%' . $searchKeyword . '%');
            })
            ->orWhereHas('place', function ($query) use ($searchKeyword) {
                $query->where('name', 'like', '%' . $searchKeyword . '%');
            })
            ->orWhereHas('facilities', function ($query) use ($searchKeyword) {
                $query->where('name', 'like', '%' . $searchKeyword . '%');
            })
            ->orWhere('title', 'like', '%' . $searchKeyword . '%')
            ->orWhere('price', 'like', '%' . $searchKeyword . '%')
            ->orWhere('description', 'like', '%' . $searchKeyword . '%')
            ->orWhere('property_area', 'like', '%' . $searchKeyword . '%')
            ->paginate(25);

        $agents = Owner::whereHas('user', function ($query) use ($searchKeyword) {
            $query->orWhere('name', 'like', '%' . $searchKeyword . '%')
                ;
        })
        ->whereHas('city', function ($query) use ($searchKeyword) {
            $query->where('name', 'like', '%' . $searchKeyword . '%');
        })
        ->orWhereHas('place', function ($query) use ($searchKeyword) {
            $query->where('name', 'like', '%' . $searchKeyword . '%');
        })
        ->orWhere('phone', 'like', '%' . $searchKeyword . '%')
        ->orWhere('description', 'like', '%' . $searchKeyword . '%')
        ->paginate(25);


        return view('frontend.search', compact('properties','agents', 'searchKeyword'));
    }


    public function recommendationMatrix()
    {
        $ratings = Rating::all();
        $matrix = array(); // Matrix representation

        // Populate the matrix with ratings
        foreach ($ratings as $rating) {
            $users = User::where('id', $rating->user_id)->pluck('name')->toArray();
            foreach ($users as $user) {
                $matrix[$user][$rating->property['titleLimit']] = $rating['rating'];
            }
        }

        // Debugging: Output the contents of $matrix for inspection
        // dd($matrix);

        // Get recommendations based on the matrix
        $authUserName = Auth::user()->name;
        $properties = $this->getRecommendation($matrix, $authUserName);

        // Filter rated rooms array into rooms
        $temp_array = array();
        foreach ($ratings as $rating) {
            foreach ($properties as $t => $r) {
                if ($rating->title == $t) {
                    array_push($temp_array, $rating->property_id);
                }
            }
        }

        // Retrieve properties based on the filtered IDs
        $properties = Property::whereIn('id', $temp_array)->where('deleted_at', null)->get();

        // Return the properties to the view
        return view('frontend.properties', compact('properties'));
    }




    function getRecommendation($matrix, $authUser)
    {
        $total = array(); //for upper part of formula
        $simSum = array(); //for lower part of formula
        $ranks = array();

        foreach ($matrix as $otherUser => $val) {

            //not checking similarity of user with itself
            if ($otherUser !== $authUser) {
                $sim = $this->similarityDistance($matrix, $authUser, $otherUser);

                //main formula part
                foreach ($matrix[$otherUser] as $key => $value) {
                    //making sure that only similar room are checked
                    if (!array_key_exists($key, $matrix[$authUser])) {
                        //initalizing total value
                        if (!array_key_exists($key, $total)) {
                            $total[$key] = 0;
                        }

                        $total[$key] += $matrix[$otherUser][$key] * $sim;

                        if (!array_key_exists($key, $simSum)) {
                            $simSum[$key] = 0;
                        }

                        $simSum[$key] += $sim;
                    }
                }
            }
        }

        //div num with dino
        foreach ($total as $key => $value) {
            $ranks[$key] = $value / $simSum[$key];

            array_multisort($ranks, SORT_DESC);
        }

        //  dd($ranks);
        return $ranks;
    }

    function similarityDistance($matrix, $authUser, $otherUser) //checks similarity of auth user with other user
    {
        $similarity = array();
        $sum = 0;

        //check that two users have similar items ie room rating [$key = room title]
        foreach ($matrix[$authUser] as $key => $value) {
            if (isset($matrix[$otherUser][$key])) {
                $similarity[$key] = 1;
            }
        }



        if ($similarity == 0) {
            return 0;
        }

        foreach ($matrix[$authUser] as $key => $value) {
            if (array_key_exists($key, $matrix[$otherUser])) {
                $sum = $sum + pow($value - $matrix[$otherUser][$key], 2);
            }
        }

        //dd(1/ (1+sqrt($sum))*100);
        return 1 / (1 + sqrt($sum));
        // var_dump (1/(1+sqrt($sum)));


    } //end of function

}
