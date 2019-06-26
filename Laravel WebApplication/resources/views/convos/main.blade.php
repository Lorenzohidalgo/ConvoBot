@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-xl">
      <h1 class="appPageHeader">Convocations</h1>
      @component('components.section_options')  @endcomponent
      <div class="row">
        <div class="col-12">
          <div class="appBox">
            <h2> <i class="material-icons">view_list</i> View Convocations</h2>
            @include('components.alerts')
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Date</th>
                  <th scope="col">Text</th>
                  <th scope="col">Sender</th>
                  <th scope="col">Team</th>
                  <th scope="col">Status</th>
                  <th scope="col">Options</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($convos as $convo)
                <tr>
                  <th scope="row">{{ $convo->CON_ID }}</th>
                  <td>{{ $convo->CON_DATE }}</td>
                  <td>{{ $convo->CON_TEXT }}</td>
                  <td>{{ $convo->sender->name }}</td>
                  <td>{{ $convo->team->team_name }}</td>
                  <td>{{ $convo->CON_STATUS }}</td>
                  <td><a type="button" href="{{ url('/convocations/'.$convo->CON_ID.'')  }}" class="btn btn-secondary appTeamsButts"><i class="material-icons">remove_red_eye</i></a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <div class="d-flex justify-content-center">
              {{$convos}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection