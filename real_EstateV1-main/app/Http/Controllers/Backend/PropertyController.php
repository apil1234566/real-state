<?php

namespace App\Http\Controllers\Backend;

use App\City;
use App\Room;
use App\User;
use App\Place;
use App\Rating;
use App\Seeker;
use App\Category;
use App\Facility;
use App\Applicant;
use App\Property;
use App\Http\Controllers\Controller;
use App\Http\Helper\AppHelper;
use App\Package;
use App\PropertyImage;
use App\Sales;
use App\SystemCharge;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;


class PropertyController extends Controller

{
    private $default_pagination;
    private $upload_path;
    private $width;
    private $height;
    public function __construct()
    {
        $this->default_pagination = 25;

        $this->upload_path = public_path("images/property/");
        $this->width = 600;
        $this->height = 800;

        if (!File::isDirectory($this->upload_path)) {
            File::makeDirectory($this->upload_path, 0777, true, true);
        }
        $this->middleware(['owner'])->except(['show', 'addRating', 'recommendationMatrix']);
    }

    public function index()
    {
        $packages=Package::all();
        $properties = Property::where('user_id', auth()->id())->get();
        return view('backend.property.index', compact('properties', 'packages'));
    }

    public function create()
    {
        $user = Auth::user();
        $user_subscription = $user->activeSubscription();

        if ($user_subscription && !$user_subscription->hasExpired()) {
            $cities = City::all(['name', 'id']);
            $places = Place::all(['name', 'id']);
            $categories = Category::all();
            $facilities = Facility::all();
            $system_charge = SystemCharge::first();
            return view('backend.property.create', compact('cities', 'places', 'categories', 'facilities', 'system_charge'));
        } else {
            return redirect()->back()->with('error', 'You need an active subscription to create a property.');
        }
    }

    public function store(Request $request)
    {
       
        $this->validateRequest();
        $property = Property::create(array_merge(collect($this->validateRequest())->except(['images', 'property_plan', 'panoromic_image', 'property_area'])->toArray(), ['user_id' => Auth::user()->id]));
        $property->property_area = $request->property_area;
        $property->save();

       
        if ($request->hasFile('property_plan') && $property) {
            $img_tmp = $request->file("property_plan");
            $filename = time() . '_' . uniqid() . '.' . $img_tmp->getClientOriginalExtension();;
            Image::make($img_tmp->getRealPath())
                ->resize(1200,600)
                ->save($this->upload_path . $filename);
            $property->property_plan = $filename;
            $property->save();
        }
        if ($request->hasFile('panoromic_image') && $property) {
            $img_tmp2 = $request->file("panoromic_image");
            $filename2 = time() . '_' . uniqid() . '.' . $img_tmp2->getClientOriginalExtension();;
            Image::make($img_tmp2->getRealPath())
                ->resize(1200, 600)
                ->save($this->upload_path . $filename2);
            $property->panoromic_image = $filename2;
            $property->save();
        }

        if ($request->hasFile('images') && $property) {
            foreach ($request->file('images') as $img) {
                $propertyImage = new PropertyImage();
                $propertyImage->property_id = $property->id;

                $filename3 = time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();;
                Image::make($img->getRealPath())
                ->resize($this->width, $this->height)
                ->save($this->upload_path . $filename3);
                $propertyImage->image = $filename3;
                $propertyImage->save();
            }
        }

        $property->facilities()->attach($request->facilities);
        return redirect()->route('property.index')->with('message', 'Property Added Successfully');
    }


    public function show($id)
    {
        $property = Property::findOrFail($id);
    
        $user_id = Auth::id();
        $property_id = $property->id;
        $property = $property->load('facilities')->load('city'); 
        $uniqueKey = 'key_' . $property->id;
        if (!Session::has($uniqueKey)) {
            $property->views++;
            Session::put($uniqueKey, 1);
        }
        $property->save();

        $seeker = Seeker::where('user_id', \auth()->user()->id)->first();
        $rating = Rating::where('user_id', auth()->id())->where('property_id', $id)->first();
        if ($rating == null) {
            $rating = 0;
        }

        return view('backend.property.show', compact('property','rating'));
    }


    public function edit(Property $property)
    {
        $cities = City::all(['name', 'id']);
        $places = Place::all(['name', 'id']);
        $categories = Category::all();
        $facilities = Facility::all();
        return view('Backend.property.edit', compact('property', 'cities', 'places', 'categories', 'facilities'));
    }

    public function update(Request $request, Property $property)
    {
        $this->validateRequest();
        $property->update(array_merge(collect($this->validateRequest())->except(['images', 'property_plan', 'panoromic_image','property_area'])->toArray(), ['user_id' => Auth::user()->id]));
    
        if ($request->has('delete_images')) {
            $property->images()->whereIn('id', $request->input('delete_images'))->delete();
        }

        if ($request->hasFile('property_plan') && $property) {
            $img_tmp = $request->file("property_plan");
            $filename = time() . '_' . uniqid() . '.' . $img_tmp->getClientOriginalExtension();;
            Image::make($img_tmp->getRealPath())
                ->resize(1200, 600)
                ->save($this->upload_path . $filename);
            $property->property_plan = $filename;
            $property->save();
        }
        if ($request->hasFile('panoromic_image') && $property) {
            $img_tmp2 = $request->file("panoromic_image");
            $filename2 = time() . '_' . uniqid() . '.' . $img_tmp2->getClientOriginalExtension();;
            Image::make($img_tmp2->getRealPath())
                ->resize(1200, 600)
                ->save($this->upload_path . $filename2);
            $property->panoromic_image = $filename2;
            $property->save();
        }

        if ($request->hasFile('images') && $property) {
            foreach ($request->file('images') as $img) {
                $propertyImage = new PropertyImage();
                $propertyImage->property_id = $property->id;

                $filename3 = time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();;
                Image::make($img->getRealPath())
                    ->resize($this->width, $this->height)
                    ->save($this->upload_path . $filename3);
                $propertyImage->image = $filename3;
                $propertyImage->save();
            }
        }

        $property->facilities()->sync($request->facilities);
        Session::flash('success', 'property ' . AppHelper::DataUpdated);
        return redirect()->route('property.index');
    }

    public function destroy(Property $property)
    {

        DB::beginTransaction();
        try {
            $property_notifications = DB::table('notifications')
                ->where('type', 'App\Notifications\ApplicantNotification')
                ->where('data', 'like', '%"user_id":' . $property->user_id . '%')
                ->where('data', 'like', '%"id":' . $property->id . '%')
                ->get();

            foreach ($property_notifications as $property_notification) {
                $user1 = User::where('id', $property_notification->notifiable_id)->first();
                $user1->notifications->where('id', $property_notification->id)->first()->delete();
            }


            $property_applicants = Applicant::where('property_id', $property->id)->get();
            foreach ($property_applicants as $applicant) {
                $applicant->delete();
            }

            $property->applicants()->detach();
            $property->forceDelete();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error', $ex->getMessage());
        }
        return redirect()->back()->with('error', 'Property ' . AppHelper::DataDeleted);
    }

    //-------------------------------------------------rating and recommendation
    public function addRating(Request $request)
    {
        $rating = Rating::updateOrCreate(
            ['user_id' => $request->user_id, 'property_id' => $request->property_id, 'title' => $request->title],
            ['rating' => $request->rating,]
        );
    }

    public function recommendationMatrix()
    {
        $ratings = Rating::all();
        $matrix = array(); //matrix representation

        foreach ($ratings as $rating) {
            $users = User::where('id', $rating->user_id)->pluck('name')->toArray();
            foreach ($users as $user) {
                $matrix[$user][$rating->property['titleLimit']] = $rating['rating'];
            }
        }
        $properties = $this->getRecommendation($matrix, Auth::user()->name);

        //filter rated rooms array into rooms
        $temp_array = array();
        foreach ($ratings as $rating) {
            foreach ($properties as $t => $r) {
                if ($rating->title == $t) {
                    array_push($temp_array, $rating->property_id);
                }
            }
        }

        $recomend_properties = Property::whereIn('id', $temp_array)->where('deleted_at', null)->get();
        return view('room_seeker.recommendation', compact('recomend_properties'));
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
            if (array_key_exists($key, $matrix[$otherUser])) {
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

    public function validateRequest()
    {
        return request()->validate([
            'title' => 'required|string|min:2',
            'city_id' => 'required|numeric',
            'place_id' => 'required|numeric',
            'price' => 'required|min:3|numeric',
            'total_rooms' => 'required|numeric',
            'category_id' => 'required|numeric',
            'description' => 'required|string|min:10',
            'images' => 'sometimes|max:2048',
        ]);
    }
}
