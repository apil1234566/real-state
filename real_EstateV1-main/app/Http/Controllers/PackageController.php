<?php

namespace App\Http\Controllers;

use App\Package;
use App\Sales;
use App\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

require '../vendor/autoload.php';

use RemoteMerge\Esewa\Client;
use RemoteMerge\Esewa\Config;

class PackageController extends Controller
{
    public function create($id){
        $package = Package::find($id);
        $user = Auth::user();
        $today_date = Carbon::now()->format('Y-m-d');

        switch ($package->type) {
            case 1:
                $expire_date = Carbon::parse($today_date)->addMonth()->format('Y-m-d');
                break;
            case 2:
                $expire_date = Carbon::parse($today_date)->addMonths(3)->format('Y-m-d');
                break;
            case 3:
                $expire_date = Carbon::parse($today_date)->addMonths(6)->format('Y-m-d');
                break;
            case 4:
                $expire_date = Carbon::parse($today_date)->addYear()->format('Y-m-d');
                break;
            default:
                $expire_date = null;
                break;
        }
       
        return view('Backend.package.create',compact('package','user','expire_date','today_date'));

    }

    public function store(Request $request){

        $user_subscription = new UserSubscription();
        $user_subscription->user_id = $request->user_id;
        $user_subscription->package_id = $request->package_id;
        $user_subscription->start_date = $request->issue_date;
        $user_subscription->active = 1;

        $existing_subscription = UserSubscription::where('user_id', $request->user_id)
        ->where('active', 1)
        ->orderBy('created_at', 'desc')
        ->first();

        if ($existing_subscription) {
            $remaining_days = Carbon::parse($existing_subscription->end_date)->diffInDays(Carbon::now());
            $user_subscription->end_date = Carbon::parse($request->expire_date)->addDays($remaining_days);
        } else {
            $user_subscription->end_date = $request->expire_date;
        }

        $user_subscription->save();

        $package=Package::find($request->package_id);

        $sales=Sales::create([
            'sales_date'=> $request->issue_date,
            'sales_amount'=> $request->charge_amount,
            'property_id'=>$package->price,
            'user_id'=>Auth::id()

        ]);

        $successUrl = url('/success');
        $failureUrl = url('/failure');

        
        $config = new Config($successUrl, $failureUrl);
        $esewa = new Client($config);

        $esewa->process($user_subscription->id, $package->price, 0, 0, 0);
    }

    public function esewaPaySuccess()
    {
        $user_sub_id = $_GET['oid'] ?? null;
        $referenceId = $_GET['refId'] ?? null;
        $amount = $_GET['amt'] ?? null;

        // $user_subscription=UserSubscription::find($user_sub_id);
        // $user_subscription->active=1;
        // $user_subscription->save();

        return redirect()->route('property.index')->with('message', 'Subscription Added Successfully');
    }

    public function esewaPayFailed()
    {
        $sub_id = $_GET['pid'];

        return redirect()->route('property.index')->with('error', 'Payment Unsuccesful !');
    }

}
