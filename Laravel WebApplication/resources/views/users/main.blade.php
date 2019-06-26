@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-xl">
      <h1 class="appPageHeader">USERS</h1>
      @component('components.section_options')  @endcomponent
      <div class="row">
        <div class="col-12">
          <div class="appBox">
            <h2> <i class="material-icons">view_list</i> View Users</h2>
            @include('components.alerts')
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Full name</th>
                  <th scope="col">Chat ID</th>
                  <th scope="col">E-mail</th>
                  <th scope="col">Team</th>
                  <th scope="col">Role</th>
                  <th scope="col">Status</th>
                  <th scope="col">Options</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $user)
                <tr>
                  <th scope="row">{{ $user->id }}</th>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->user_chat_id }}</td>
                  <td>{{ $user->email }}</td>
                  <td>
                    @if($user->linked)
                      @foreach ($user->linked->teams as $team) 
                      <li> {{ $team->team_name }} </li>
                      @endforeach
                    @endif
                  </td>
                  <td>{{ $user->role->role_name }}</td>
                  <td> @if($user->active = 1)  
                    @if($user->user_chat_id != 0) 
                    Active & Synced
                    @else
                    Active & NO Synced
                    @endif
                    @else
                    Disabled
                    @endif  
                  </td>
                  <td>
                    @if($user->id == Auth::user()->id)
                    <a type="button" href="{{ url('/users/'.$user->id.'/edit')  }}" class="btn btn-primary appUsersButts"><i class="material-icons">mode_edit</i></a>
                    @else
                    <a type="button" href="{{ url('/users/'.$user->id.'/edit')  }}" class="btn btn-primary appUsersButts"><i class="material-icons">mode_edit</i></a>
                    <form id="eraseUser" action="{{ route('users-delete', $user->id)  }}" method="POST">
                      @csrf
                      {{ method_field('DELETE') }}
                      <a type="button" href="javascript:$('#eraseUser').submit();"  onclick="return confirm('Do you trully wish to erase this user? This action cannot be back rolled ')" class="btn btn-danger appUsersButts"><i class="material-icons">delete_forever</i></a>
                    </form>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <div class="d-flex justify-content-center">
              {{$users}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection