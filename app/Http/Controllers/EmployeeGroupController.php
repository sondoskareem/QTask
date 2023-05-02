<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Validator;
use App\Traits\GeneralTrait;

class EmployeeGroupController extends Controller
{
    use GeneralTrait;

    public function store(Request $request){

        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'groupIds' => 'required|array|min:1',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:4|max:10',
        ]);

        if($validator->fails()){
            return $this->returnError(422, $validator->errors()->all());
        }

        $data['password'] = bcrypt($request->password);
        $data['isAdmin'] = 0;

        $emp = Employee::create($data);
        $emp->groups()->attach($request->groupIds);

        return $this->returnSuccessMessage(200,'Employee Created');

    }
}
