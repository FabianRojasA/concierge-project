<?php

namespace App\Http\Controllers;

use App\Http\Resources\PersonaResource;
use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonControlller extends Controller
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
