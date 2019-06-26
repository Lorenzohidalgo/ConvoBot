@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-xl">
      <h1 class="appPageHeader">EDIT USER</h1>
      @component('components.section_options')  @endcomponent
      <div class="row">
        <div class="col-12">
          <div class="appBox">
            <h2> <i class="material-icons">mode_edit</i> Currently editing user: {{ $user->name }}</h2>
            @include('components.alerts')   
            <form action="{{ route('users-update', $user->id)  }}" method="POST">
              @csrf
              @if ($errors->any())
              <div class="alert alert-danger" style="margin-top: 10px; margin-bottom: 10px;">
                <ul style="margin-bottom: 0px; padding-left: 0px;">
                  <b> Upss! We were not able to edit the users data due to following errors: </b>
                  @foreach ($errors->all() as $error)
                  <li style="margin-left: 30px;">{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif
              <div class="form-group">
                <label for="nameofuser">Full Name</label>
                <input  value="{{ $user->name }}" class="form-control" name="name" placeholder="Enter the full name of the user">
                <small class="form-text text-muted">E.g. John Doe or Lorenzo Hidalgo Gadea - The name must not be a nickname!</small>
              </div>
              <div class="form-group">
                <label for="email">E-mail adress</label>
                <input value="{{ $user->email }}" class="form-control" name="email"  placeholder="Enter a valid e-mail adress">
                <small  class="form-text text-muted">This adress is going to be used for the user as a credential to log in into the cloud account</small>
              </div>
              <div class="form-group">
                <label for="chatuserid">Chat User ID</label>
                <input value="{{ $user->user_chat_id }}" class="form-control" name="user_chat_id" placeholder="Enter a valid chat user id">
                <small class="form-text text-muted">The cloud account will be linked to this particular Chat User ID - If none provided, the account won't be able to sync statistic data</small>
              </div>
              <div class="form-group">
                <label for="chatuserid">User Role</label>
                <div class="row">
                  <div class="col">
                    <h6><b>Current role:</b></h6>
                    <div class="alert alert-info" role="alert">
                      {{ $user->role->role_name }}
                    </div>
                  </div>
                  <div class="col">
                    <h6><b>New role:</b></h6>
                    @if(Auth::user()->user_role_id == 1 || Auth::user()->user_role_id == 4 )
                    @if(Auth::user()->id == $user->id)
                    <div class="alert alert-light" role="alert">
                            You can't change your own role
                    </div>
                    @else
                    <select  name="user_role_id" class="form-control" id="exampleFormControlSelect1">
                      @foreach ($listofroles as $role)
                      <option value="{{ $role->role_id }}"> {{ $role->role_name }}   </option>
                      @endforeach
                    </select>
                    @endif
                    @endif
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="chatuserid">Password</label>
                <div class="alert alert-warning" role="alert">
                  @if(Auth::user()->id == $user->id)
                  In order to change your own password you will have to do it through your profile options.
                  @else
                  For security and privacy reasons, only the user itself it's allowed to edit the password of the account.
                  @endif
                </div>
              </div>
              <div class="form-group">
                <label for="chatuserid">User Status</label>
                <div class="row">
                  <div class="col">
                    <h6><b>Current Status:</b></h6>
                    @if($user->active == 1) 
                    <div class="alert alert-success" role="alert">
                      User is active
                    </div>
                    @elseif($user->active == 2)
                    <div class="alert alert-danger" role="alert">
                      User was disabled
                    </div>
                    @endif
                  </div>
                  <div class="col">
                    <h6><b>New Status:</b></h6>
                    @if(Auth::user()->user_role_id == 1 || Auth::user()->user_role_id == 4 )
                    @if(Auth::user()->id == $user->id)
                    <div class="alert alert-light" role="alert">
                            You can't disable yourself
                    </div>
                    @else
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                      @if($user->active == 1)
                      <label class="btn btn-secondary active">
                      <input type="radio" name="active" value="1" autocomplete="off" checked> Keep enabled
                      </label>
                      <label class="btn btn-secondary">
                      <input type="radio" name="active" value="2" autocomplete="off"> Disable user
                      </label>
                    </div>
                    @elseif($user->active == 2)
                    <label class="btn btn-secondary active">
                    <input type="radio" name="active" value="2" autocomplete="off" checked> Keep disabled
                    </label>
                    <label class="btn btn-secondary">
                    <input type="radio" name="active" value="1" autocomplete="off"> Enable
                    </label>
                    @endif
                    @endif
                    @endif


                  </div>
                  
                </div>
              </div>
          
          <button type="submit" style="margin-top: 50px;" class="btn btn-primary btn-lg btn-block">Everything ok, let's edit!</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection