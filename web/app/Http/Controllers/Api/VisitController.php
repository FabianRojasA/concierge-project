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
use App\Visit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\VisitResource;

/**
 * Class VisitController
 * @package App\Http\Controllers\Api
 */
class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visits = Visit::all();

        return response([
            'message' => 'Restrieved Successfully',
            'visits' => VisitResource::collection($visits)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'rut' => 'required|max:50',
            'name' => 'required|max:255',
            'adress' => 'required|max:255',
            'date' => 'required|max:255',
            'relationship' => 'required|in:CLOSE RELATIVE,VISITOR,ENTERPRISE',
            'type'=>'max:255'
        ]);

        if($validator->fails()){
            return response([
                'message'=>'Validation Error',
                'error'=>$validator->errors()
            ],412);
        }

        /** @noinspection PhpUndefinedMethodInspection */
        $visit = Visit::create($data);

        return response([
            'message'=>'Created Successfully',
            'visit'=>new VisitResource($visit)
        ],201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function show(Visit $visit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visit $visit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visit $visit)
    {
        //
    }

    /**
     * Display all visits sorted by date in ascending order
     * @return \Illuminate\Http\Response
     *
     */
    public function visits()
    {
        $visitsDate = Visit::orderBy('date','ASC')->get();

        return response([
            'message' => 'Restrieved Successfully',
            'visits' => VisitResource::collection($visitsDate)
        ]);
    }

    /**
     *
     * Display all the visits to a house or apartment
     * @param Request $request
     * @return mixed
     */
    public function toAdress($adress)
    {
        $visitsAdress = Visit::where('adress',$adress)->get();

        if(count($visitsAdress) == 0){
            return response([
                'message' => 'No visits to the adress',
            ]);
        }

        return response([
            'message' => 'Restrieved Successfully',
            'visits' => VisitResource::collection($visitsAdress)
        ]);

    }
}
