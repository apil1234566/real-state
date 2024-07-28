<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Room;
use App\Applicant;
use Illuminate\Http\Request;
use App\Http\Helper\AppHelper;
use Illuminate\Support\Facades\DB;
use App\Notifications\ApplicantNotification;
use App\Notifications\ApplicationIsAddedNotification;
use App\Owner;
use App\Property;
use App\Seeker;

class ApplicantController extends Controller
{
    public function create($id)
    {
        $property = Property::findOrFail($id);
        return view('applicant.create', compact('property'));
    }

    public function store(Request $request, $property_id)
    {
        $seekerExists = Seeker::where('user_id', \auth()->id())->exists();

        $ownerExists = Owner::where('user_id', \auth()->id())->exists();

        if ($seekerExists || $ownerExists) {

            $this->validate($request, [
                'message' => 'required|string|min:10'
            ]);
            DB::beginTransaction();
            try {
                $applicant = Applicant::create([
                    'user_id' => \auth()->id(),
                    'message' => $request->message,
                    'property_id' => $property_id
                ]);
                $applicant->properties()->attach($property_id);
                $property_ownmer = Property::where('id', $property_id)->first()->user()->select(['id', 'name', 'email'])->first();
                $Property = Property::where('id', $property_id)->select(['id', 'title', 'user_id', 'created_at'])->first();
                if (\Notification::send($property_ownmer, new ApplicationIsAddedNotification($Property))) {
                    return back();
                }
                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return redirect()->back()->with('error', $ex->getMessage());
            }
            return redirect()->route('seeker_room')->with('success', 'Application sent successfully');
        } else{
            return redirect()->route('seeker_profile', \auth()->user()->name)->with('error', 'Create Profile to perform this action!');
        }
    }

    public function viewApplicants($user_id, $property_id)
    {
        $applicants = Property::findOrFail($property_id)->applicants;
        $applicant_count = $applicants->count();

        $hired = $applicants->filter(function ($applicant, $key) {
            return $applicant->status == 'approved';
        });
        if ($applicant_count == 0 || $hired->isEmpty()) {
            $hired_status = 0;
        } else {
            $hired_status = 1;
        }

        return view('applicant.room_applicants', compact('applicants', 'property_id', 'hired_status'));
    }

    public function hire($user_id, $property_id)
    {
        DB::beginTransaction();
        try {
            $applicant = Applicant::where('user_id', $user_id)->where('property_id', $property_id)->first();
            $applicant->status = 'approved';
            $applicant->save();

            //get applicants who are not hired
            $unhired_applicants = Property::find($property_id)->applicants()->whereNotIn('status', ['hired'])->pluck('user_id')->toArray();

            //change the status of unhired candidates from pending to rejected
            DB::table('applicants')
                ->where('property_id', $property_id)
                ->whereIn('user_id', $unhired_applicants)
                ->update(['status' => 'rejected']);

            //sending notification

            $users_array = [];
            array_push($users_array, $user_id);

            //all_users_array gives hired+rejected users (so we can send notification to all users)
            $all_users_array = array_merge($users_array, $unhired_applicants);

            $users = User::whereIn('id', $all_users_array)->get();
            /*   $applicant_all = Applicant::where('room_id', $room_id)->whereIn('user_id', $all_users_array)->get();*/

            $room = Room::where('id', $property_id)->select(['id', 'title', 'user_id', 'created_at'])->first();

            if (\Notification::send($users, new ApplicantNotification($room))) {
                return back();
            }
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex->getMessage());
            return redirect()->back()->with('error', $ex->getMessage());
        }

        return redirect()->route('seeker_room')->with('success', 'Applicant  request is accepted');
    }

    public function reject($user_id, $property_id)
    {
        $applicant = Applicant::where('user_id', $user_id)->where('proper$property_id', $property_id)->first();
        $applicant->status = 'rejected';
        $applicant->save();
        return redirect()->route('seeker_room')->with('success', 'Applicant  request is rejected');
    }
}
