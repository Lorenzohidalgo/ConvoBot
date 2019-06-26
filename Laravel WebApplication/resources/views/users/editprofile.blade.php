@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-xl">
    <h1 class="appPageHeader">{{ $data->name }}</h1>

    @component('components.section_options')  @endcomponent
     
 
    <div class="appBox profileBox titleWithPadding p-0" style="margin-bottom: 20px;">
            <div class="row">
                <div class="col-4">
                   <div class="infoTitleArea">
                      YOUR INFORMATION
                    </div>
                </div>
                <div class="col-8 infoArea">
                    <form action="{{ route('profile-update', $data->id)  }}" method="POST">
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
                            <label for="exampleInputEmail1">Full name</label>
                            <input  value="{{ $data->name }}" class="form-control" name="name">
                        </div>  
                        <div class="form-group">
                                <label for="exampleInputEmail1">Email adress</label>
                                <input  value="{{ $data->email }}" class="form-control" name="email">
                        </div> 
                        <div class="form-group">
                                <label for="exampleInputEmail1">Chat ID</label>
                                <input  value="{{ $data->user_chat_id }}" class="form-control" name="user_chat_id">
                                <small>The default value when no valid Chat ID has been linked is 0</small>    
                        </div> 
                        <div class="form-group">
                                <label for="exampleInputEmail1">Password</label>
                                <input  type="password" value="" class="form-control" name="password">
                        </div> 
                        <div class="form-group">
                                <label for="exampleInputEmail1">Confirm password</label>
                                <input type="password" value="" class="form-control" name="password_confirmation">
                        </div>
                        <button type="submit" style="margin-top: 50px;" class="btn btn-primary btn-lg btn-block">Update my profile!</button>
                    </form>
                </div>       
            </div>
        </div>         
       
     
    </div>
  </div>
</div>
@endsection