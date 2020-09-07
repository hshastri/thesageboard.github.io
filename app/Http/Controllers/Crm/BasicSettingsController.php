<?php

namespace App\Http\Controllers\Crm;

use App\BasicSetting;
use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BasicSettingsController extends Controller
{
    public function payment_settings(Request $request){
        if(!$_POST){
            $setting = BasicSetting::all();
            $result=[];
            foreach ($setting as $value){
                $result[$value->key] = $value->value;
            }
            return view('crm.setting.payment',compact('result'));
        }else{
            foreach ($request->item as $key => $value){
                if($value==null){
                    flash('No correction setting has been detected')->error();
                    return back();
                }
                $sdelete = BasicSetting::where('key',$key);
                $cnt           = $sdelete->count();
                if($cnt==1){
                    $sdelete->delete();
                }

                $basic = new BasicSetting();
                $basic->key = $key;
                $basic->value = $value;
                $basic->save();
            }
            flash('Settings Update Successfully')->success();
            return back();
        }
    }


    public function business_settings(Request $request){

        if(!$_POST){
            $setting = BasicSetting::all();
            $result=[];
            foreach ($setting as $value){
                $result[$value->key] = $value->value;
            }
            $categories = Category::where('status','Active')->orderBy('created_at', 'desc')->get();
            return view('crm.setting.business',compact('result','categories'));
        }else{
            //dd($request->all());
            foreach ($request->item as $key => $value){
                if($value==null){
                    flash('No correction setting has been detected')->error();
                    return back();
                }
                $sdelete = BasicSetting::where('key',$key);
                $cnt           = $sdelete->count();
                if($cnt==1){
                    $sdelete->delete();
                }

                $basic = new BasicSetting();
                $basic->key = $key;
                $basic->value = $value;
                $basic->save();
            }
            flash('Settings Update Successfully')->success();
            return back();
        }
    }

    public function policy_settings(Request $request){
        if(!$_POST){
            $result='Please Add Policy';
            $setting = BasicSetting::where('key','policy_settings')->first();
            if($setting){
                $result= $setting->value;
            }
            return view('crm.setting.policy',compact('result'));
        }else{
            foreach ($request->item as $key => $value){
                if($value==null){
                    flash('No correction setting has been detected')->error();
                    return back();
                }
                $sdelete = BasicSetting::where('key',$key);
                $cnt           = $sdelete->count();
                if($cnt==1){
                    $sdelete->delete();
                }

                $basic = new BasicSetting();
                $basic->key = $key;
                $basic->value = $value;
                $basic->save();
            }
            flash('Settings Update Successfully')->success();
            return back();
        }
    }
}
