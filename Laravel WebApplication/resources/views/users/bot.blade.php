@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-xl">
      <h1 class="appPageHeader">BOT USERS</h1>
      @component('components.section_options')  @endcomponent
      <div class="row">
        <div class="col-12">
          <div class="appBox">
            <h2> <i class="material-icons">view_list</i> View Bot Users</h2>
            @include('components.alerts')
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Full name</th>
                  <th scope="col">Chat ID</th>
                  <th scope="col">Team</th>
                  <th scope="col">Role</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($botusers as $user)
                <tr>
                  <th scope="row">{{ $user->id }}</th>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->user_chat_id }}</td>
                  <td>
                    @foreach ($user->teams as $team) 
                    <li> {{ $team->team_name }} </li>
                    @endforeach    
                  </td>
                  <td>{{ $user->role->role_name }}</td>
                  <td> @if($user->active == 1)
                    Active
                    @elseif($user->active == 2)
                    Deleted
                    @else
                    Disabled
                    @endif
                    @if($user->linked)
                     - {{ $user->linked->email }}
                    @endif
                  </td>
                  <td>
                    @if($user->id == Auth::user()->id)
                    <a type="button" href="{{ url('/users/bot/'.$user->id.'/edit')  }}" class="btn btn-primary appUsersButts"><i class="material-icons">mode_edit</i></a>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <div class="d-flex justify-content-center">
              {{$botusers}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection