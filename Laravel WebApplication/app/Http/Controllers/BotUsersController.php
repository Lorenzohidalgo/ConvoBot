<?php

namespace App\Http\Controllers;

use App\Bot_Users;
use Illuminate\Http\Request;

class BotUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['botusers']=Bot_Users::paginate(10);
        return view('users.bot', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bot_Users  $bot_Users
     * @return \Illuminate\Http\Response
     */
    public function show(Bot_Users $bot_Users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bot_Users  $bot_Users
     * @return \Illuminate\Http\Response
     */
    public function edit(Bot_Users $bot_Users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bot_Users  $bot_Users
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bot_Users $bot_Users)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bot_Users  $bot_Users
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bot_Users $bot_Users)
    {
        //
    }
}
