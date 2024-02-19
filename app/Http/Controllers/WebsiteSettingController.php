<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\WebSetting;
use Exception;
use Illuminate\Support\Facades\Auth;
class WebsiteSettingController extends Controller
{
    public function saveSetting(Request $request){
        try{

          $keys = array_keys($request->except('_token'));
          $values = array_values($request->except('_token'));

          $ActivityLogs = new ActivityLog;
          $ActivityLogs->user_id = Auth::id();
          $ActivityLogs->title = "Update WebSetting";
          $ActivityLogs->description = "Update WebSetting By  ".Auth::user()->first_name."  ".Auth::user()->last_name;
          $ActivityLogs->save();

          foreach($values as $i=>$item){
            $exsit_data = WebSetting::where('field_key',$keys[$i] )->first();
            if($exsit_data){
                $exsit_data->field_key = $keys[$i];
                $exsit_data->field_value= $item;
                $exsit_data->update();
                $response['message']='Data Updated Succesfully!';
            }else{
                WebSetting::create([
                'field_key' => $keys[$i],
                'field_value' => $item,
              ]);
            $response['message']='Data Inserted Succesfully!';
          }
        }


          $response['success'] = true;
          $response['status_code'] = 200;
          return $response;

        }catch (Exception $e) {

          throw new Exception($e->getMessage());
        }
      }
}
