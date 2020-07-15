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
use Illuminate\Http\Request;

/**
 * The Class PersonController
 * @package App\Http\Controllers\Api
 */
class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personas = Persona::all();  //SELECT * FROM personas

        return response([
            'message'=>'Retrieved Succesfully',
            'personas'=>PersonaResource::collection($personas) //se manda un listado de personas segun las reglas en Resource
        ]);
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

        $validator = Validator::make($data,[
            'rut'=>'required|max:50',
            'name'=>'required|max:255',
            'phone'=>'max:50',
            'email'=>'required|max:255'

        ]);

        if($validator.fails()){
            return response([
                'message'=>'Validation Error',
                'error'=>$validator.errors()
            ],412);
        }

        /** @noinspection PhpUndefinedMethodInspection */
        $persona = Persona::create($data);

        return response([
            'message'=>'Created Succesfully',
            'persona'=>new PersonaResource($persona)
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function show(Persona $persona)
    {
        return response([
            'message'=>'Created Succesfully',
            'persona'=>new PersonaResource($persona)
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Persona $persona)
    {
        $persona->update($request->all());
        return response([
            'message'=>'Updated Succesfully',
            'persona'=>new PersonaResource($persona)
        ],202);

        //Necesario hacer validacion
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function destroy(Persona $persona)
    {
        $persona->delete();

        return response([
            'message'=>'Deleted Succesfully'
        ],201);
    }
}
