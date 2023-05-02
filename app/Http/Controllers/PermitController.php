<?php

namespace App\Http\Controllers;

use App\Models\Permit;
use Illuminate\Http\Request;
use Validator;
use App\Traits\GeneralTrait;

class PermitController extends Controller
{

    use GeneralTrait;

    public function __construct()
    {
        $this->middleware('emp', ['only' => ['store']]);
        $this->middleware('admin', ['only' => ['index' , 'edit']]);
    }

    public function index()
    {
        $Permit = Permit::select('start_date','end_date' ,'numberOfDays', 'reason' , 'photo' , 'description' , 'user_id' )
        ->with(['employee' => function ($q) {
            $q->select('id', 'name', 'email');
        }])->get();


        return $this->returnData(200,'permit',$Permit);

    }



    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'reason' => 'required|string|in:Sickness,Travel,OtherReasons',
            'photo' => 'required_if:reason,==,Sickness|image|mimes:jpeg,png,jpg,gif,svg|max:204',
            'description' => 'required_if:reason,==,OtherReasons',
        ]);


        if($validator->fails()){
            return $this->returnError(422, $validator->errors()->all());
        }

        if($request->photo){
            $data['photo'] = $request->photo->store('permit','public');
         }


        $formatted_dt1=\Carbon\Carbon::parse($request->start_date);
        $formatted_dt2=\Carbon\Carbon::parse($request->end_date);
        $date_diff=$formatted_dt1->diffInDays($formatted_dt2);

        $data['numberOfDays'] =$date_diff;


        $data['user_id'] = auth()->user()->id;
        Permit::create($data);
        return $this->returnSuccessMessage(200,'Permit Created');
    }



    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:permits,id',
            'approval' => 'required|boolean',
        ]);

        if($validator->fails()){
            return $this->returnError(422, $validator->errors()->all());
        }

        $Permit = Permit::findOrfail($request->id);

        $Permit->approval = $request->approval ;
        $Permit->update();
        return $this->returnSuccessMessage(200,'Successfully Updated');

    }


}
