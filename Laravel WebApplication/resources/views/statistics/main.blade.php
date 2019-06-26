@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-xl">
      <h1 class="appPageHeader">STATISTICS</h1>
      <div class="appBox titleWithPadding p-0" style="margin-bottom: 20px;">
    <div class="row">
        <div class="col-3">
            <h2> <i class="material-icons">poll</i> Statistics</h2>
        </div>
        <div class="col-9">
            <ul class="sectionOptions">
                @foreach($teams as $tm)
                <li> 
                    <a href="{{ url('/statistics/'.$tm->id) }}" class="{{ $tm_id == $tm->id ? 'active' : '' }}">
                        <i class="material-icons">people</i> {{$tm->team_name}}
                    </a> 
                </li>
                @endforeach
                @if(Route::currentRouteName() == 'statistics-show')
                <li> 
                    <a href="{{ route('statistics-main') }}" class="{{ Route::currentRouteName() != 'statistics-show' ? 'active' : '' }}">
                        <i class="material-icons">keyboard_return</i> Return to Global Statistics
                    </a> 
                </li>
                @endif
            </ul>
        </div>                      
    </div>   
</div>
      <div class="row">
        <div class="col-12">
          <div class="appBox">
            <center>
              @if($tm_id == -1)
              <h1>Global Statistics</h1>
              @else
              <h1>{{$team_data[0]}} Statistics</h1>
              @endif
            </center>
            @include('components.alerts')
            <br>
            <br>
            <h4>Basic Information<i class="material-icons" id="basiscs" onclick="toggle('basic', 'basiscs')">expand_less</i></h4>
            <div id="basic">
              <table class="table">
                <tr>
                  <th scope="row" style="text-align:center;">Active Users</th>
                  <td>{{$team_data[1]}}</td>
                  <th scope="row" style="text-align:center;">Total Users</th>
                  <td>{{$team_data[2]}}</td>                
                </tr>
                <tr>
                  <th scope="row" style="text-align:center;">Convocations</th>
                  <td>{{$team_data[3]}}</td>
                  <th scope="row" style="text-align:center;">Responses</th>
                  <td>{{$team_data[4]}}</td>                
                </tr>
              </table>
            </div>
            <br>
            @if($team_data[3] == 0 || $team_data[4] == 0)
            <br><br>
            <center><h4>Statistics unavailable</h4></center>
            @else
            <h4>Convocations<i class="material-icons" id="i_C" onclick="toggle('d_C', 'i_C')">expand_less</i></h4>
            <div id="d_C">
            {!! $conf_chart->container() !!}
            </div>
            <br>
            <h4>Convocations per Cancel Types<i class="material-icons" id="i_CT" onclick="toggle('d_CT', 'i_CT')">expand_less</i></h4>
            <div id="d_CT">
            {!! $can_chart->container() !!}
            </div>
            <br>
            <h4> Convocations per Training Type <i class="material-icons md-dark" onclick="toggle_chart(this, 'chart6')">poll</i><i class="material-icons md-dark md-inactive" onclick="toggle_table(this, 'table6', 'dt_6')">table_chart</i><i class="material-icons" id="i_CpTT" onclick="toggle('d_CpTT', 'i_CpTT')">expand_less</i></h4>
            <div id="d_CpTT">
            <div id="chart6">
            {!! $ttc_chart->container() !!}
            </div>
            <br>
            <div id="table6" style="display:none;">
              <table id="dt_6" title="Response per Training Type" class="table table-bordered dt-responsive" cellspacing="0" width=100%>
                <thead>
                  <th>TRAINING TYPE</th>
                  <th>CONFIRMED</th>
                  <th>CANCELLED</th>
                  <th>TOTAL</th>
                </thead>
                <tbody>
                @for ($i = 0; $i < count($ttc_data[0]); $i++)
                    <tr>
                      <td>
                        @if($i < count($ttc_data[0]))
                        {{$ttc_data[0][$i]}}
                        @else
                        0
                        @endif
                      </td>
                      <td>
                        @if($i < count($ttc_data[2]))
                        {{$ttc_data[2][$i]}}
                        @else
                        0
                        @endif
                      </td>
                      <td>
                        @if($i < count($ttc_data[3]))
                        {{$ttc_data[3][$i]}}
                        @else
                        0
                        @endif
                      </td>
                      <td>
                        @if($i < count($ttc_data[1]))
                        {{$ttc_data[1][$i]}}
                        @else
                        0
                        @endif
                      </td>
                    </tr>
                  @endfor
                </tbody>
                <tfoot>
                  <th>DAYTIME</th>
                  <th>AVERAGE</th>
                  <th>MINIMUM</th>
                  <th>MAXIMUM</th>
                </tfoot>
              </table>
            </div>
            </div>

            <br>
            <h4>Users per Convocations <i class="material-icons md-dark" onclick="toggle_chart(this, 'chart7')">poll</i><i class="material-icons md-dark md-inactive" onclick="toggle_table(this, 'table7', 'dt_7')">table_chart</i><i class="material-icons" id="i_UpC" onclick="toggle('d_UpC', 'i_UpC')">expand_less</i></h4>
            <div id="d_UpC">
            <div id="chart7">
            {!! $upc_chart->container() !!}
            </div>
            <br>
            <div id="table7" style="display:none;">
              <table id="dt_7" title="Response per Training Type" class="table table-bordered dt-responsive" cellspacing="0" width=100%>
                <thead>
                  <th>CONVOCATION ID</th>
                  <th>CONVOCATION DATE</th>
                  <th>USERS</th>
                </thead>
                <tbody>
                @for ($i = 0; $i < count($upc_data[0]); $i++)
                    <tr>
                      <td>
                        @if($i < count($upc_data[2]))
                        {{$upc_data[2][$i]}}
                        @else
                        0
                        @endif
                      </td>
                      <td>
                        @if($i < count($upc_data[0]))
                        {{$upc_data[0][$i]}}
                        @else
                        0
                        @endif
                      </td>
                      <td>
                        @if($i < count($upc_data[1]))
                        {{$upc_data[1][$i]}}
                        @else
                        0
                        @endif
                      </td>
                    </tr>
                  @endfor
                </tbody>
                <tfoot>
                  <th>CONVOCATION DATE</th>
                  <th>DAYTIME</th>
                  <th>AVERAGE</th>
                </tfoot>
              </table>
            </div>
            </div>

            <br>
            <h4>Responses<i class="material-icons" id="i_RT" onclick="toggle('d_RT', 'i_RT')">expand_less</i></h4>
            <div id="d_RT">
            {!! $acc_chart->container() !!}
            </div>

            <br>
            <h4> Responses per Training Type <i class="material-icons md-dark" onclick="toggle_chart(this, 'chart5')">poll</i><i class="material-icons md-dark md-inactive" onclick="toggle_table(this, 'table5', 'dt_5')">table_chart</i><i class="material-icons" id="i_RpTT" onclick="toggle('d_RpTT', 'i_RpTT')">expand_less</i></h4>
            <div id="d_RpTT">
            <div id="chart5">
            {!! $ttm_chart->container() !!}
            </div>
            <br>
            <div id="table5" style="display:none;">
              <table id="dt_5" title="Response per Training Type" class="table table-bordered dt-responsive" cellspacing="0" width=100%>
                <thead>
                  <th>TRAINING TYPE</th>
                  <th>ACCEPTED</th>
                  <th>DENIED</th>
                  <th>TOTALS</th>
                </thead>
                <tbody>
                @for ($i = 0; $i < count($ttm_data[0]); $i++)
                    <tr>
                      <td>
                        @if($i < count($ttm_data[0]))
                        {{$ttm_data[0][$i]}}
                        @else
                        0
                        @endif
                      </td>
                      <td>
                        @if($i < count($ttm_data[2]))
                        {{$ttm_data[2][$i]}}
                        @else
                        0
                        @endif
                      </td>
                      <td>
                        @if($i < count($ttm_data[3]))
                        {{$ttm_data[3][$i]}}
                        @else
                        0
                        @endif
                      </td>
                      <td>
                        @if($i < count($ttm_data[1]))
                        {{$ttm_data[1][$i]}}
                        @else
                        0
                        @endif
                      </td>
                    </tr>
                  @endfor
                </tbody>
                <tfoot>
                  <th>DAYTIME</th>
                  <th>AVERAGE</th>
                  <th>MINIMUM</th>
                  <th>MAXIMUM</th>
                </tfoot>
              </table>
            </div>
            </div>
            
            <br>
            <h4> Responses per Weekday <i class="material-icons md-dark" onclick="toggle_chart(this, 'chart2')">poll</i><i class="material-icons md-dark md-inactive" onclick="toggle_table(this, 'table1', 'dt_1')">table_chart</i><i class="material-icons" id="i_RpD" onclick="toggle('d_RpD', 'i_RpD')">expand_less</i></h4>
            <div id="d_RpD">
            <div id="chart2">
            {!! $chart2->container() !!}
            </div>
            <br>
            <div id="table1" style="display:none;">
              <table id="dt_1" title="Responses per Day" class="table table-bordered dt-responsive" cellspacing="0" width=100%>
                <thead>
                  <th>DAY</th>
                  <th>ACCEPTED</th>
                  <th>DENIED</th>
                  <th>TOTAL RESPONSES</th>
                </thead>
                <tbody>
                @for ($i = 0; $i < count($chart2_data[0]); $i++)
                    <tr>
                      <td>
                        @if($i < count($chart2_data[0]))
                        {{$chart2_data[0][$i]}}
                        @else
                        0
                        @endif
                      </td>
                      <td>
                        @if($i < count($chart2_data[2]))
                        {{$chart2_data[2][$i]}}
                        @else
                        0
                        @endif
                      </td>
                      <td>
                        @if($i < count($chart2_data[3]))
                        {{$chart2_data[3][$i]}}
                        @else
                        0
                        @endif
                      </td>
                      <td>
                        @if($i < count($chart2_data[1]))
                        {{$chart2_data[1][$i]}}
                        @else
                        0
                        @endif
                      </td>
                    </tr>
                  @endfor
                </tbody>
                <tfoot>
                  <th>DAY</th>
                  <th>ACCEPTED</th>
                  <th>DENIED</th>
                  <th>TOTAL</th>
                </tfoot>
              </table>
            </div>
            </div>

            <br>
            <h4> Responses per Training Day <i class="material-icons md-dark" onclick="toggle_chart(this, 'chart3')">poll</i><i class="material-icons md-dark md-inactive" onclick="toggle_table(this, 'table2', 'dt_2')">table_chart</i><i class="material-icons" id="i_RpTD" onclick="toggle('d_RpTD', 'i_RpTD')">expand_less</i></h4>
            <div id="d_RpTD">
            <div id="chart3">
            {!! $chart3->container() !!}
            </div>
            <br>
            <div id="table2" style="display:none;">
              <table id="dt_2" title="Responses per Day" class="table table-bordered dt-responsive" cellspacing="0" width=100%>
                <thead>
                  <th>TRAINING DAY</th>
                  <th>ACCEPTED</th>
                  <th>DENIED</th>
                  <th>TOTAL RESPONSES</th>
                </thead>
                <tbody>
                @for ($i = 0; $i < count($chart3_data[0]); $i++)
                    <tr>
                      <td>
                        @if($i < count($chart3_data[0]))
                        {{$chart3_data[0][$i]}}
                        @else
                        0
                        @endif
                      </td>
                      <td>
                        @if($i < count($chart3_data[2]))
                        {{$chart3_data[2][$i]}}
                        @else
                        0
                        @endif
                      </td>
                      <td>
                        @if($i < count($chart3_data[3]))
                        {{$chart3_data[3][$i]}}
                        @else
                        0
                        @endif
                      </td>
                      <td>
                        @if($i < count($chart3_data[1]))
                        {{$chart3_data[1][$i]}}
                        @else
                        0
                        @endif
                      </td>
                    </tr>
                  @endfor
                </tbody>
                <tfoot>
                  <th>DAY</th>
                  <th>ACCEPTED</th>
                  <th>DENIED</th>
                  <th>TOTAL</th>
                </tfoot>
              </table>
            </div>
            </div>

            <br>
            <h4> Response Time per Daytime <i class="material-icons md-dark" onclick="toggle_chart(this, 'chart4')">poll</i><i class="material-icons md-dark md-inactive" onclick="toggle_table(this, 'table3', 'dt_3')">table_chart</i><i class="material-icons" id="i_RTpD" onclick="toggle('d_RTpD', 'i_RTpD')">expand_less</i></h4>
            <div id="d_RTpD">
            <div id="chart4">
            {!! $chart4->container() !!}
            </div>
            <br>
            <div id="table3" style="display:none;">
              <table id="dt_3" title="Response Time per Daytime" class="table table-bordered dt-responsive" cellspacing="0" width=100%>
                <thead>
                  <th>DAYTIME</th>
                  <th>AVERAGE</th>
                  <th>MINIMUM</th>
                  <th>MAXIMUM</th>
                </thead>
                <tbody>
                @for ($i = 0; $i < count($chart4_data[0]); $i++)
                    <tr>
                      <td>
                        @if($i < count($chart4_data[0]))
                        {{$chart4_data[0][$i]}}H
                        @else
                        0
                        @endif
                      </td>
                      <td>
                        @if($i < count($chart4_data[2]))
                        {{CarbonInterval::seconds($chart4_data[2][$i])->cascade()->format('%r%H:%I:%S')}}
                        @else
                        0
                        @endif
                      </td>
                      <td>
                        @if($i < count($chart4_data[3]))
                        {{CarbonInterval::seconds($chart4_data[3][$i])->cascade()->format('%r%H:%I:%S')}}
                        @else
                        0
                        @endif
                      </td>
                      <td>
                        @if($i < count($chart4_data[1]))
                        {{CarbonInterval::seconds($chart4_data[1][$i])->cascade()->format('%r%H:%I:%S')}}
                        @else
                        0
                        @endif
                      </td>
                    </tr>
                  @endfor
                </tbody>
                <tfoot>
                  <th>DAYTIME</th>
                  <th>AVERAGE</th>
                  <th>MINIMUM</th>
                  <th>MAXIMUM</th>
                </tfoot>
              </table>
            </div>
            </div>

            <br>
            <h4> Responses per Users <i class="material-icons md-dark" onclick="toggle_chart(this, 'chart8')">poll</i><i class="material-icons md-dark md-inactive" onclick="toggle_table(this, 'table8', 'dt_8')">table_chart</i><i class="material-icons" id="i_RpU" onclick="toggle('d_RpU', 'i_RpU')">expand_less</i></h4>
            <div id="d_RpU">
            <div id="chart8">
            {!! $rpu_chart->container() !!}
            </div>
            <br>
            <div id="table8" style="display:none;">
              <table id="dt_8" title="Responses per Day" class="table table-bordered dt-responsive" cellspacing="0" width=100%>
                <thead>
                  <th>USER</th>
                  <th>ACCEPTED</th>
                  <th>DENIED</th>
                  <th>TOTAL</th>
                  <th>A. & Can.</th>
                  <th>D. & Can.</th>
                </thead>
                <tbody>
                @for ($i = 0; $i < count($rpu_data[0]); $i++)
                    <tr>
                      <td>
                        @if($i < count($rpu_data[0]))
                        {{$rpu_data[0][$i]}}
                        @else
                        0
                        @endif
                      </td>
                      <td>
                        @if($i < count($rpu_data[2]))
                        {{$rpu_data[2][$i]}}
                        @else
                        0
                        @endif
                      </td>
                      <td>
                        @if($i < count($rpu_data[3]))
                        {{$rpu_data[3][$i]}}
                        @else
                        0
                        @endif
                      </td>
                      <td>
                        @if($i < count($rpu_data[1]))
                        {{$rpu_data[1][$i]}}
                        @else
                        0
                        @endif
                      </td>
                      <td>
                        @if($i < count($rpu_data[4]))
                        {{$rpu_data[4][$i]}}
                        @else
                        0
                        @endif
                      </td>
                      <td>
                        @if($i < count($rpu_data[5]))
                        {{$rpu_data[5][$i]}}
                        @else
                        0
                        @endif
                      </td>
                    </tr>
                  @endfor
                </tbody>
                <tfoot>
                  <th>USER</th>
                  <th>ACCEPTED</th>
                  <th>DENIED</th>
                  <th>TOTAL</th>
                  <th>A. & Can.</th>
                  <th>D. & Can.</th>
                </tfoot>
              </table>
            </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
function toggle(div_id, i_id) {
  var x = document.getElementById(div_id);
  var i = document.getElementById(i_id);
  if (x.style.display === "none") {
    x.style.display = "block";
    i.innerHTML = "expand_less";
  } else {
    x.style.display = "none";
    i.innerHTML = "expand_more";
  }
}

function toggle_chart(el, id) {
  var x = document.getElementById(id);
  if (x.style.display === "none") {
    x.style.display = "block";
    el.setAttribute('class', 'material-icons md-dark');
  } else {
    x.style.display = "none";
    el.setAttribute('class', 'material-icons md-dark md-inactive');
  }
}

function toggle_table(el, id, tid) {
  var x = document.getElementById(id);
  if (x.style.display === "none") {
      x.style.display = "block";
      $("#".concat(tid)).DataTable()
          .columns.adjust()
          .responsive.recalc();
      el.setAttribute('class', 'material-icons md-dark');
  } else {
      x.style.display = "none";
      el.setAttribute('class', 'material-icons md-dark md-inactive');
  }
}
</script>
{!! $conf_chart->script() !!}
{!! $can_chart->script() !!}
{!! $ttc_chart->script() !!}
{!! $upc_chart->script() !!}
{!! $acc_chart->script() !!}
{!! $ttm_chart->script() !!}
{!! $chart2->script() !!}
{!! $chart3->script() !!}
{!! $chart4->script() !!}
{!! $rpu_chart->script() !!}
@endsection