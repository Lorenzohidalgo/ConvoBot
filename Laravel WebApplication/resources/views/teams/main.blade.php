@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-xl">
      <h1 class="appPageHeader">TEAMS</h1>
      @component('components.section_options')  @endcomponent
      <div class="row">
        <div class="col-12">
          <div class="appBox">
            <h2> <i class="material-icons">view_list</i> View Teams</h2>
            @include('components.alerts')
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name of the Team</th>
                  <th scope="col">Description of the Team</th>
                  <th scope="col">Members</th>
                  <th scope="col">Captain</th>
                  <th scope="col">Options</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($teams as $team)
                <tr>
                  <th scope="row">{{ $team->id }}</th>
                  <td>{{ $team->team_name }}</td>
                  <td>{{ $team->team_desc }}</td>
                  <td>{{ $team->AmountOfUsers }}  </td>
                  <td>{{ $team->CaptainName }}  </td>
                  <td>
                        <a type="button" href="{{ url('/teams/'.$team->id.'')  }}" class="btn btn-secondary appTeamsButts"><i class="material-icons">remove_red_eye</i></a>
                        <a type="button" href="{{ url('/teams/'.$team->id.'/edit')  }}" class="btn btn-primary appTeamsButts"><i class="material-icons">mode_edit</i></a>
                        <form  action="{{ route('users-delete', $team->id)  }}" method="POST">
                          @csrf
                          {{ method_field('DELETE') }}
                          <a type="button"  href="javascript:$('#eraseTeam').submit();" onclick="return confirm('Do you trully wish to erase this user? This action cannot be back rolled ')" class="btn btn-danger appTeamsButts"><i class="material-icons">delete_forever</i></a>
                        </form>

                        

                      </td>                   
                </td>                  
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection