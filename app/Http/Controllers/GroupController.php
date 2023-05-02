<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Validator;
use App\Traits\GeneralTrait;

class GroupController extends Controller
{
    use GeneralTrait;

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|string',
        ]);


        if($validator->fails()){
            return $this->returnError(422, $validator->errors()->all());
        }

        Group::create($data);
        return $this->returnSuccessMessage(200,'Group Created');
    }
}
