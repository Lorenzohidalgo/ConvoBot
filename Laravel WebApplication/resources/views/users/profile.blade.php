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
                        @include('components.alerts') 
                        <div class="form-group">
                            <label for="exampleInputEmail1">Full name</label>
                            <h3>{{ $data->name }}</h3>
                        </div>  
                        <div class="form-group">
                                <label for="exampleInputEmail1">Email adress</label>
                                <h3>{{ $data->email }}</h3>
                        </div> 
                        <div class="form-group">
                                <label for="exampleInputEmail1">Chat ID</label>
                               
                                @if($data->user_chat_id == 0)
                                <div class="alert alert-warning" role="alert">
                                        <p> Your account hasn't been synced with any chat id. Add a valid <b>Chat ID</b> in order to be able to access to your <b>convos</b> and <b>statistics</b></p>
                                        <hr>
                                        <p class="mb-0">Don't know your <b>Chat ID</b>? - Contact <b>@myidbot</b> on Telegram to get your <b>Chat ID</b> </p>
                                      </div>
                                @else
                                <h3>{{ $data->user_chat_id }}</h3>
                                @endif
                                
                        </div> 
                </div>       
            </div>
        </div>         
       
     
    </div>
  </div>
</div>
@endsection