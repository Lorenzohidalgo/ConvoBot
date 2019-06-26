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
            <h2> <i class="material-icons">view_list</i> View Team: {{ $team->team_name }}</h2>
            @include('components.alerts')

            <div class="jumbotron">
                    <h1 class="display-4">About the team!</h1>
            <p class="lead">This team was created the <b>{{ $creation_date }}</b>. At the moment it contains <b>{{ $team_members_count[0]->AmountOfUsers }}</b>  @if($team_members_count[0]->AmountOfUsers == 1) member @else members @endif.
                     @if($team_captain)   
                        The current captain of this team is: <b>  {{ $team_captain[1]->name }}</b>
                    @else 
                        The team has currently no captain assigned.
                    @endif</p>
                    
            </div>

            <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name of the Member</th>                  
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($team_members as $team_m)
                      <tr>
                        <th scope="row">{{ $team_m->id }}</th>
                        <td>{{ $team_m->name }}</td>                                         
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