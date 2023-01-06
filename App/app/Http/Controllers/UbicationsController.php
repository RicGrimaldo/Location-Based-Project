<?php

namespace App\Http\Controllers;

use App\Models\Ubication;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class UbicationsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $files = Storage::disk('public')->files('Files');
        return view('admin.ubications.ubications', compact('files'));
    }

    public function list(){
        $ubications = Ubication::orderBy('tag')->simplePaginate(5);
        $ubications->withPath('/Ubications');
        return view('admin.ubications.list', compact('ubications'));
    }

    public function destroy(Ubication $ubication){
        $ubication->delete();
        return redirect()->route('ubications.list')->with('delete', 'ok');
    }
    
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'tag' => 'required|unique:ubications',
            'file' => '',
            'file_type' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'text' => '',
        ],
        [
            'tag.unique' => 'La etiqueta ya existe, intente con otra distinta.'
        ]
    );
        
        if($validator->fails()) {
            // In the case the user insert a tag that already exists
            return response()->json($validator->messages(), 422);
        }

        //  In the case that a file is selected, there will be no path.
        if(!empty($request->text)) {
            $path = null;
        }
        else{
            //  In the case that a server's file is selected, therefore, the path already exists
            if(isset($request->selectedFilePath)) $path = $request->selectedFilePath;
            else{
                //  The path will be created when the file is uploaded to the server
                $org_file_name = $request->file('file')->getClientOriginalName();
                $extension = pathinfo($org_file_name, PATHINFO_EXTENSION);
                $objExtensions = array('gltf','glb');
                //  To generate an original name for gltf and glb files
                if(in_array($extension, $objExtensions)){
                    $new_name = (string) Str::uuid() . '.' . pathinfo($org_file_name, PATHINFO_EXTENSION);
                    $tmp_path = $request->file('file')->storeAs('public/Files', $new_name);
                    $path = Storage::url($tmp_path);
                }
                else{ 
                    $tmp_path = $request->file('file')->store('public/Files');
                    $path = Storage::url($tmp_path);
                }
            }
        }
        //  The new ubication will be saved
        $id = Ubication::create(
            [
                'tag' => $request->tag, 
                'file' => $path,
                'file_type' => $request->file_type,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'text' => $request->text,
            ]
        );
        return response()->json([
            'filename' => $request->filename,
            'file_type' => $request->file_type,
            'tag' => $request->tag,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'text' => $request->text,
        ]);
    }
    
    
    public function compare(Request $request){
        $latitudeFrom = $request->latitude;
        $longitudeFrom = $request->longitude;
        $ubications = Ubication::all();
        $response = "success";
        $result = 0;
        foreach($ubications as $ubication){
            $result = $this->twopoints_on_earth($latitudeFrom, $longitudeFrom, 
                                    $ubication->latitude, $ubication->longitude);
            //  The ubication need to be at least 5 mts away from another ubication 
            if($result < 5){
                return response()->json(["error" => "Es necesaria una distancia mínima de 5 metros entre ubicaciones. La ubicación más cercana se encuentra a " . $result . " metros"],
                404);
            }
        }
        return response()->json([
            'response' => $response,
            'latitudOrigen' => $latitudeFrom,
            'longitudOrigen' => $longitudeFrom,
        ]);
    }
    
    //  Given latitude and longitude in degrees, this method calculates the distance between two points on the earth.
    private function twopoints_on_earth($latitudeFrom, $longitudeFrom,
                                    $latitudeTo,  $longitudeTo)
    {
        $long1 = deg2rad($longitudeFrom);
        $long2 = deg2rad($longitudeTo);
        $lat1 = deg2rad($latitudeFrom);
        $lat2 = deg2rad($latitudeTo);
            
        //Haversine Formula
        $dlong = $long2 - $long1;
        $dlati = $lat2 - $lat1;
            
        $val = pow(sin($dlati/2),2)+cos($lat1)*cos($lat2)*pow(sin($dlong/2),2);
            
        $res = 2 * asin(sqrt($val));
            
        $radius = 3958.756;
            
        //  The result is in miles, converted to meters
        return ($res*$radius) * 1609.34;
    }

}
