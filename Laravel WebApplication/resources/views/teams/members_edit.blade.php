@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-xl">
    <h1 class="appPageHeader">{{ $team->team_name }}</h1>
      @component('components.section_options')  @endcomponent
      <div class="row">
        <div class="col-12">
          <div class="appBox">
          <h2> <i class="material-icons">view_list</i> View Team: {{ $team->team_name }} - <a type="button" href="{{ route('teams-edit', $team->id) }}" class="btn btn-light">Back to List of Teams</a></h2>
            @include('components.alerts')


            <div class="jumbotron">
                    <h3 class="display-4">Add member to Team</h3>
                    <form id="addMember" action="{{ route('team-member-add', $team->id)  }}" method="POST">
                            @csrf
                    <input type="hidden" name="tm_team_id" value="1">
                    <select  name="tm_user_id" class="form-control" id="exampleFormControlSelect1">
                            @foreach ($add_team_members as $add_member)
                            <option value="{{ $add_member->id }}"> {{ $add_member->name }}   </option>
                            @endforeach
                        </select>                    
                    <hr class="my-4">
                    
                    <a type="submit" href="javascript:$('#addMember').submit();" class="btn btn-primary btn-lg" role="button">Add User to Team</a>
                    </form>
            </div>


            <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name of the Member</th>
                        <th scope="col">Options</th>
                  
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($team_members as $team_m)
                      <tr>
                        <th scope="row">{{ $team_m->id }}</th>
                        <td>{{ $team_m->name }}</td>
                        <td> 
                                <form id="eraseMember" action="{{ route('team-member-delete', ['id'=>$team_m->membershipId,'teamid'=>$team->id])  }}" method="POST">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <a type="submit" href="javascript:$('#eraseMember').submit();" onclick="return confirm('Do you trully wish to erase this user? This action cannot be back rolled ')" class="btn btn-danger appTeamsButts"><i class="material-icons">delete_forever</i></a>
                                    
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