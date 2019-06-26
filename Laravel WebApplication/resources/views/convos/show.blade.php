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
            <h2> <i class="material-icons">view_list</i>Convocation Information</h2>
            @include('components.alerts')
            <br>
            <center>
            <h3>Information:</h3>
            <br>
            <table class="table">
                <tr>
                    <th scope="row" style="text-align:center;">ID</th>
                    <td>{{$convocation->CON_ID}}</td>
                    <th scope="row" style="text-align:center;">DATE</th>
                    <td>{{date('H:i d-m-Y', strtotime($convocation->CON_DATE))}}</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align:center;">TEAM</th>
                    <td>{{$convocation->team->team_name}}</td>
                    <th scope="row" style="text-align:center;">SENDER</th>
                    <td>{{$convocation->sender->name}}</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align:center;">TEXT</th>
                    <td colspan="3">{{$convocation->CON_TEXT}}</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align:center;">STATUS</th>
                    <td style="text-align:center;">
                        @if($convocation->CON_STATUS)
                        {{$convocation->CON_STATUS}}
                        @if($convocation->cancel)
                         - {{$convocation->cancel->CT_NAME}}
                        @endif
                        @else
                        OPEN
                        @endif
                    </td>
                    @if($convocation->training)
                    <th scope="row" style="text-align:center;">TRAINING TYPE</th>
                    <td style="text-align:center;">
                        {{$convocation->training->TT_NAME}}
                    </td>
                    @else
                    <td colspan="2"></td>
                    @endif
                </tr>
            </table>
            <br>
            <h3>Responses:</h3>
            <br>
            <table class="table">
                <td>
                    <table class="table">
                        <tr>
                        <th scope="row" style="text-align:center;">ACCEPTED: ({{count($convocation->accepted)}})</th>
                        </tr>
                        @foreach ($convocation->accepted as $accepted)
                        <tr><td style="text-align:center;">{{$accepted->sender->name}}</td></tr>  
                        @endforeach
                    </table>
                </td>
                <td>
                    <table class="table">
                        <tr>
                        <th scope="row" style="text-align:center;">DENIED: ({{count($convocation->denied)}})</th>
                        </tr>
                        @foreach ($convocation->denied as $denied)
                        <tr><td style="text-align:center;">{{$denied->sender->name}}</td></tr>  
                        @endforeach
                    </table>
                </td>                
            </table>
            <br>
                      
            @if($convocation->alignment)
            <h3>Alignment:</h3>
            <table width=33% style="border: 2px solid black;">
                <tr>
                    <th scope="row" style="text-align:center;">TIM</th>
                    <td colspan="2" style="text-align:center;" bgcolor="#ffe6b3">
                        @if($convocation->alignment->TIM)
                        {{$convocation->alignment->TIM->name}}
                        @else
                        -
                        @endif
                    </td>
                </tr>
                <tr>
                    <th scope="row" style="text-align:center;">1</th>
                    <td style="text-align:center;" bgcolor="#99e699">
                        @if($convocation->alignment->E1)
                        {{$convocation->alignment->E1->name}}
                        @else
                        -
                        @endif
                    </td>
                    <td style="text-align:center;" bgcolor="#ff8080">
                        @if($convocation->alignment->B1)
                        {{$convocation->alignment->B1->name}}
                        @else
                        -
                        @endif
                    </td>
                </tr>
                <tr>
                    <th scope="row" style="text-align:center;">2</th>
                    <td style="text-align:center;" bgcolor="#99e699">
                        @if($convocation->alignment->E2)
                        {{$convocation->alignment->E2->name}}
                        @else
                        -
                        @endif
                    </td>
                    <td style="text-align:center;" bgcolor="#ff8080">
                        @if($convocation->alignment->B2)
                        {{$convocation->alignment->B2->name}}
                        @else
                        -
                        @endif
                    </td>
                </tr>
                <tr>
                    <th scope="row" style="text-align:center;">3</th>
                    <td style="text-align:center;" bgcolor="#99e699">
                        @if($convocation->alignment->E3)
                        {{$convocation->alignment->E3->name}}
                        @else
                        -
                        @endif
                    </td>
                    <td style="text-align:center;" bgcolor="#ff8080">
                        @if($convocation->alignment->B3)
                        {{$convocation->alignment->B3->name}}
                        @else
                        -
                        @endif
                    </td>
                </tr>
                <tr>
                    <th scope="row" style="text-align:center;">4</th>
                    <td style="text-align:center;" bgcolor="#99e699">
                        @if($convocation->alignment->E4)
                        {{$convocation->alignment->E4->name}}
                        @else
                        -
                        @endif
                    </td>
                    <td style="text-align:center;" bgcolor="#ff8080">
                        @if($convocation->alignment->B4)
                        {{$convocation->alignment->B4->name}}
                        @else
                        -
                        @endif
                    </td>
                </tr>
            </table>
            @endif
            </center>
            </div>      
        </div>
      </div>
    </div>
  </div>
</div>
@endsection