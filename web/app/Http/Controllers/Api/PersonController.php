<?php
/**
 * MIT License
 *
 * Copyright (c) 2020 Carlos Cortes, Fabian Rojas y Wilber Navarro.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PersonResource;
use App\Person;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

/**
 * The Class PersonController
 * @package App\Http\Controllers\Api
 */
class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $people = Person::all();

        return response([
            'message'=>'Retrieved Successfully',
            'people'=>PersonResource::collection($people)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data,[
            'rut'=>'required|max:50|unique:people',
            'name'=>'required|max:255',
            'phone'=>'max:50',
            'email'=>'required|max:255'
        ]);

        if($validator->fails()){
            return response([
                'message'=>'Validation Error',
                'error'=>$validator->errors()
            ],412);
        }

        /** @noinspection PhpUndefinedMethodInspection */
        $person = Person::create($data);

        return response([
            'message'=>'Created Successfully',
            'persona'=>new PersonResource($person)
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param Person $person
     *
     * @return Response
     */
    public function show(Person $person)
    {
        return response([
            'message'=>'Created Successfully',
            'person'=>new PersonResource($person)
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Person  $person
     *
     * @return Response
     */
    public function update(Request $request, Person $person)
    {
        $data = $request->all();

        $validator = Validator::make($data,[
            'rut'=>'required|max:50',
            'name'=>'required|max:255',
            'phone'=>'max:50',
            'email'=>'required|max:255'
        ]);

        $person->update($request->all());


        return response([
            'message'=>'Updated Successfully',
            'person'=>new PersonResource($person)
        ],202);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Person $person
     *
     * @return Response
     * @throws Exception
     */
    public function destroy(Person $person)
    {
        $person->delete();

        return response([
            'message'=>'Deleted Successfully'
        ],201);
    }
}
