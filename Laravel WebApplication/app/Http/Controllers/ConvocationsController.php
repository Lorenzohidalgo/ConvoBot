<?php

namespace App\Http\Controllers;

use App\Convocations;
use App\Con_Response;
use Auth;
use Illuminate\Http\Request;

class ConvocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->user_role_id == 1 or Auth::user()->user_role_id == 4){
            $data['convos']=Convocations::orderBy('CON_DATE', 'desc')->paginate(10);
        }else{
            $data['convos']=Convocations::orderBy('CON_DATE', 'desc')->where('CON_USER_ID', Auth::user()->user_chat_id)->paginate(10);
        }
        return view('convos.main', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Convocations  $convocations
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['convocation'] = Convocations::where('CON_ID', '=', $id)->firstOrFail();
        return view('convos.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Convocations  $convocations
     * @return \Illuminate\Http\Response
     */
    public function edit(Convocations $convocations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Convocations  $convocations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Convocations $convocations)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Convocations  $convocations
     * @return \Illuminate\Http\Response
     */
    public function destroy(Convocations $convocations)
    {
        //
    }
}
