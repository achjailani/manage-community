<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CrewResource;
use App\Crew;

class CrewController extends Controller
{

    public function getListCrew(){
    	
    	return CrewResource::collection(
    			     Crew::paginate()
    		);

    }

    public function createCrewData(Request $request){

    	$attributes = $request->json()->all();
    	
        $this->validator($attributes)->validate();

    	Crew::create($attributes);

    	return response(
    			new CrewResource(
    				Crew::latest()->first())
    		);
    }

    public function getCrewById($crewId){

        return response(
            new CrewResource(
                    Crew::findOrFail($crewId)
            )
        );
    }

    public function updateSingleCrewData(Request $request, $crewId){

        $attributes = $request->json()->all();

        $this->validate($attributes)->validate();
        
        Crew::findOrFail($crewId)
                   ->update($attributes);

        return response(
            new CrewResource(
                Crew::findOrFail($crewId)
            )
        );            
    }

    public function deleteSingleCrewData($crewId){
    	
        Crew::findOrFail($crewId)
                       ->delete();   

        return response()->json("successfully deleted!");

    }

    public function validator(array $data)
    {
        return Validator::make($data,[
            'community_id' => 'required|numeric|max:20',
            'position_id' => 'required|numeric|max:20',
            'name'  => 'required|string|max:50',
            'email' => 'required|string|max:50|email',
            'phone' => 'required|max:12|numeric',
            'status' => 'required|string|max:20'
        ]);
    }
}
