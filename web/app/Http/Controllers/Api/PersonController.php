<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TODO: Change the personal data that will be retrieved with PersonResource
        $persons = Person::all();
        return response([
           'message' => 'Retrieved Successfully',
           'personas' => $persons
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'rut' => 'required|max:12',
            'name' => 'required|max:255',
            'lastname' => 'required:max:255',
            "phone" => 'required:max:12',
            'email' => 'required:rfc,dns|required|max:255'
        ]);

        // Precondition Failed
        if ($validator->fails()){
            return response([
                'message' => 'Validator Error',
                'error' => $validator->errors()
            ], 412);
        }

        $person = Person::created($data);

        // Created
        // TODO: Change the personal data that will be retrieved with PersonResource
        return response([
            'message' => 'Created Successfully',
            'person' => $person
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person)
    {
        // TODO: Change the personal data that will be retrieved with PersonResource
        return response([
            'message' => 'Retrieved Successfully',
            'person' => $person
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $person)
    {
        $person->update($request->all());

        // TODO: Change the personal data that will be retrieved with PersonResource
        return response([
            'message' => 'Updated Successfully',
            'person' => $person
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {

        $person->delete();

        // TODO: Change the personal data that will be retrieved with PersonResource
        return response([
            'message' => 'Deleted'
        ], 200);
    }
}
