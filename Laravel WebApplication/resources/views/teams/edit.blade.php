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
            <h2> <i class="material-icons">mode_edit</i> Edit Team: {{ $team->team_name }}</h2>
            @include('components.alerts')

            <form action="{{ route('teams-update', $team->id)  }}" method="POST">
                @csrf
            
                @if ($errors->any())
                <div class="alert alert-danger" style="margin-top: 10px; margin-bottom: 10px;">
                  <ul style="margin-bottom: 0px; padding-left: 0px;">
                    <b> Upss! We were not able to edit this team's data due to following errors: </b>
                    @foreach ($errors->all() as $error)
                    <li style="margin-left: 30px;">{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
                @endif

            <div class="form-group">
                <label for="nameofuser">Name of the Team</label>
                <input  value="{{ $team->team_name }}" class="form-control" name="team_name" placeholder="Enter the name of the team">
                <small class="form-text text-muted">E.g. The Row Killers, Beasts in boats... (numbers are allowed)</small>
            </div>

            <div class="form-group">
                <label for="nameofuser">Description of the Team</label>
                <textarea   class="form-control" name="team_desc" placeholder="Enter a short description of the team">{{ $team->team_desc }}</textarea>
                <small class="form-text text-muted">E.g. The Row Killers, Beasts in boats... (numbers are allowed)</small>
            </div>

            <a style="margin-top: 50px; margin-bottom: 40px;" href="{{ route('teams-members', $team->id)  }}" class="btn btn-secondary btn-lg btn-block">Manage Members</a>
            <div class="form-group">
                <label for="chatuserid">Team Captain</label>
                <div class="row">
                  <div class="col">
                    <h6><b>Current captain:</b></h6>
                    <div class="alert alert-info" role="alert">
                      @if($currentTeamCaptain)
                      {{ $currentTeamCaptain->name }}
                      @endif
                    </div>
                  </div>
                  <div class="col">
                    <h6><b>New Captain:</b></h6>

                    <select  name="team_capt_id" class="form-control" id="exampleFormControlSelect1">
                      @foreach ($teamCaptains as $teamCaptain)
                      <option value="{{ $teamCaptain->id }}"> {{ $teamCaptain->name }}   </option>
                      @endforeach
                    </select>

                  </div>
                </div>
              </div>
              
              <button type="submit" style="margin-top: 60px;"  class="btn btn-primary btn-lg btn-block">Everything ok, let's edit!</button>
            </form>


          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection