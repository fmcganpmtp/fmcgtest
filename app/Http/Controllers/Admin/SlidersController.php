<?php

namespace App\Http\Controllers\Admin; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;
use DB;
use App\Models\Slider;
use App\Models\Sliderimage;
use App\Models\MobileSlider;
use App\Models\MobileSliderimage;
class SlidersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    //display sliders content
    public function index(Request $request)
    {
        //data per page 
    	$sliders = Slider::latest()->paginate(30);
        $slider_image_data = Sliderimage::all();
        
        $mobile_sliders = MobileSlider::latest()->paginate(30);
        $mobile_slider_image_data = MobileSliderimage::all();

        return view('admin.sliders.index',compact('sliders','slider_image_data','mobile_sliders','mobile_slider_image_data'))->with('i', ($request->input('page', 1) - 1) * 30);
    }
    //display creation form of slider
    public function create()
    {
        return view('admin.sliders.create');
    }
    //save new slider data
    public function store(Request $request)
    { 
        //data validation
    	$this->validate($request, [
          'slider_title' =>  'required',
          'image.0' => 'required|mimes:jpeg,jpg,webp,png,svg|max:2048',
        ]);
        //save slider data
        $data1=Slider::create([
            'name'=>$request->slider_title,
        ]);

        $last_inserted_id = $data1->id;
        $counter = 0;
        //file save to server folder
        if($request->file('image')) {
            foreach($request->file('image') as $key=>$image_file){
                $fileName = time().$image_file->getClientOriginalName();
                $image_file->move(public_path('/assets/uploads/sliders/'), $fileName);
                //new slider image  data ceration
                Sliderimage::create([
                    'slider_id'=>$last_inserted_id,
                    'image'=>$fileName,
                   /* 'title' =>$request->title_on_image[$counter],
                    'description' =>$request->description[$counter],*/
                    'target' =>$request->image_target[$counter],
                    'display_order' =>$request->display_order[$counter], 
                ]);
                $counter++;
            }
        }

        return redirect()->route('admin.sliders')->with('success','Sliders added successfully');
    }
    //display single slider data in page
    public function show( $id = null)
    {
        $slider_data = Slider::find($id);
        $slider_images = Sliderimage::where('slider_id',$id)->get()->all();
        return view('admin.sliders.show',compact('slider_data','slider_images'));
    }
    public function ajaxtiny(Request $request)
    {
        $file_path = app_path().'/images/news/';

        $file = $request->file('file');

        $fileName = time().'.'.$request->file->extension();

        $request->file->move(public_path('/assets/uploads/tiny/'), $fileName);
        $data['location'] = '../../assets/uploads/tiny/'.$fileName;
        echo json_encode($data);
    }
    //display edit form of slider
    public function edit($id = null)
    {
        $slider_data= Slider::find($id);
        $slider_images = Sliderimage::where('slider_id',$id)->get()->all();
        return view('admin.sliders.edit',compact('slider_data','slider_images'));
    }
    //update slider modifing data
    public function update(Request $request, $id = null)
    {
        //data validation
        $this->validate($request, [
            'slider_title' =>  'required',
        ]);
        //update slider
        $data1=Slider::find($id)->update([
          'name'=>$request->slider_title,
        ]);

        $file = $request->file('image');
        $counter=0;
        if($file){
            foreach($request->file('image') as $image_file){
                $fileName=time().$image_file->getClientOriginalName();
                $image_file->move(public_path('/assets/uploads/sliders/'), $fileName);
                Sliderimage::create([
                    'slider_id'=>$id,
                    'image'=>$fileName,
                   /* 'title' =>$request->title_on_image[$counter],
                    'description' =>$request->description[$counter],*/
                    'target' =>$request->image_target[$counter],
                    'display_order' =>$request->display_order[$counter],
                ]);
                $counter++;
            }

        }
        
        
        $old_image_id = $request->old_image_id;
        $counter=0;
        //loop update slider data
        if($old_image_id){
            foreach($request->old_image_id as $image_id){
             
                
                Sliderimage::find($image_id)->update([
                    'target' =>$request->old_image_target[$counter],
                    'display_order' =>$request->old_display_order[$counter],
                ]);
                $counter++;
            }
        }
        return redirect()->route('admin.sliders')->with('success','Sliders updated successfully');
    }
    
    
    public function updateSliderimage(Request $request)
    { 
        $id = request("id");
        $extension = request("image_original")->extension(); 
        $fileName = "slider" . time() . "." . $extension;
       
        $destinationPath = public_path() . "/assets/uploads/sliders/";
        request("image_original")->move($destinationPath, $fileName);
        $data = [
            "image" => $fileName,
        ];
        $update = DB::table("sliderimages")
            ->where("id", $id)
            ->update($data);
        if ($update) {
            $response["success"] = true;
            $response["message"] = "Success! Record Updated Successfully.";
            $response["image_path"] = "/assets/uploads/sliders/" . $fileName;
        } else {
            $response["success"] = false;
            $response["message"] = "Error! Record Not Updated.";
        }
        return $response;
    }
    
    
    
    
    
    
    
    //delete slider and image
    public function destroy($id = null)
    { 
        $gallery = Sliderimage::where('slider_id', $id)->get()->all();
        foreach($gallery as $type){
            $file_path = public_path('/assets/uploads/sliders/').$type->image;
            File::delete($file_path);
        }
        Slider::find($id)->delete();
        Sliderimage::where('slider_id', $id)->delete();
        return redirect()->route('admin.sliders')->with('success','Slider deleted successfully');
    }

    //ajax request update status of slider
    public function updateactiveslider(Request $request)
    { 
        $id=$request->id;
        $status=$request->status;
        //status changing
        DB::table('sliders')->update(['show_home'=>'No']);
        $Slider = Slider::find($id)->update(['show_home'=>$status]);
         echo json_encode($Slider);  
    }
    public function updateactivesliderNetwork(Request $request)
    { 
        $id=$request->id;
        $status=$request->status;
        //status changing
        DB::table('sliders')->update(['show_network'=>'No']);
        $Slider = Slider::find($id)->update(['show_network'=>$status]);
         echo json_encode($Slider);  
    }
    // remove only image in server
    public function removeMedia(Request $request)
    { 
        $gallery= Sliderimage::find($request->id);
        if(!empty($gallery)){
            $file_path = public_path('/assets/uploads/sliders/').$gallery->image;
            File::delete($file_path);
        }
        Sliderimage::find($request->id)->delete();
        $message = "Successfully deleted";
        $ajax_status = 'success';
        $return_array = array('ajax_status'=>$ajax_status,'message' =>$message );
        return response()->json($return_array);
    }

}
