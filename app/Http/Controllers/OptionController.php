<?php 
namespace App\Http\Controllers;
use Validator;
use Cache;
use App\Option;
use App\Location;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
 
class OptionController extends Controller
{
    public function manageStore(Option $option)
    {
 
        $locations = Location::all();
        $states = State::all();
        
        return view('backend/option/manage-store', compact('locations', 'states'));
    }

    public function pwaWebview(Option $option)
    {
        return view('backend/option/pwa-webview');
    }

    public function returnPolicy(Option $option)
    {
        return view('backend/option/return-policy');
    }
 
    public function privacyPolicy(Option $option)
    {
        return view('backend/option/privacy-policy');
    }

    public function termsAndConditions(Option $option)
    {
        return view('backend/option/terms-and-conditions');
    }

    public function aboutUs(Option $option)
    {
        return view('backend/option/about-us');
    }

    public function update(Request $request, Option $option)
    {
        $validator = Validator::make(request()->all(), [
            'option' => ['array'],
            'page' => ['array'],
        ]);
 
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
 
        DB::beginTransaction();
        try {
            if($request->option){
                if( hasPermission('manage.store') ){
                    foreach( $request->option as $key => $value){
                        setOption($key, $value);
                    }
                }   
            } 

            if($request->page){
                if( hasPermission('privacy.policy') || hasPermission('return.policy') || hasPermission('terms.and.conditions') || hasPermission('pwa.webview') ){
                    foreach( $request->page as $key => $value){
                        setOption($key, $value);
                    }
                } 
            }
 
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'alert' => [
                    'icon' => 'error',
                    'title' => 'Option',
                    'text' => 'Something went wrong.',
                ],
            ]);
        }
        DB::commit();
        return response()->json([
            'alert' => [
                'icon' => 'success',
                'title' => 'Option',
                'text' => 'Updated successfully.'
            ],
        ]);
    }
 
}
