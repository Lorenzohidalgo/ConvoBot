@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-xl">
      <h1 class="appPageHeader">CREATE USER</h1>
      @component('components.section_options')  @endcomponent
      <div class="row">
        <div class="col-12">
          <div class="appBox">
            <h2> <i class="material-icons">add_circle</i> Create new user</h2>
            @include('components.alerts')   
            <form action="{{ route('users-store')  }}" method="POST">
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
                <input  value="" class="form-control" name="name" placeholder="Enter the full name of the user">
                <small class="form-text text-muted">E.g. John Doe or Lorenzo Hidalgo Gadea - The name must not be a nickname!</small>
              </div>
              <div class="form-group">
                <label for="email">E-mail adress</label>
                <input value="" class="form-control" name="email"  placeholder="Enter a valid e-mail adress">
                <small  class="form-text text-muted">This adress is going to be used for the user as a credential to log in into the cloud account</small>
              </div>
              <div class="form-group">
                <label for="chatuserid">Chat User ID</label>
                <input value="0" class="form-control" name="user_chat_id" placeholder="Enter a valid chat user id">
                <small class="form-text text-muted">The cloud account will be linked to this particular Chat User ID - If none provided, the account won't be able to sync statistic data</small>
              </div>
              <div class="form-group">
                <label for="chatuserid">User Role</label>
                <select  name="user_role_id" class="form-control">
                  @foreach ($listofroles as $role)
                  <option value="{{ $role->role_id }}"> {{ $role->role_name }}   </option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="chatuserid">Password</label>
                <input type="password" value="" class="form-control" name="password" placeholder="Enter a strong password">
                <small class="form-text text-muted">The password will allow the user to log in in the cloud</small>
              </div>
              <div class="form-group">
                <label for="chatuserid">Confirm the password</label>
                <input type="password" value="" class="form-control"  name="password_confirmation" placeholder="Re-enter the password">
                <small class="form-text text-muted">We just want to make sure you didn't misspell your own password :)</small>
              </div>
              <input type="hidden" name="active" value="1">
              <button type="submit" style="margin-top: 50px;" class="btn btn-primary btn-lg btn-block">Everything filled, let's create the user!</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection