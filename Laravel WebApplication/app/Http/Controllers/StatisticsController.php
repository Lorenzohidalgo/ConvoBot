<?php

namespace App\Http\Controllers;

use App\cr;
use Auth;
use Route;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Charts\Frappe;
use App\Convocations;
use App\Con_Response;
use App\Bot_Users;
use App\Cancel_Type;
use App\Training_Type;
use App\Team;
use Carbon\CarbonInterval;

class StatisticsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function show($tm_id)
    {
        $team_data = collect([]);
        if($tm_id == -1){
            $filter = "(SELECT `CR_USER_ID`,`CR_DATE`,`CR_MSG`,`CON_ID`,`CON_DATE`,`CON_START_DATE`,`CON_END_DATE`,`CON_USER_ID`,`CON_TEAM_ID`,`CON_STATUS`,`CON_TT`,`CON_CT` FROM `con__responses` AS CR LEFT JOIN `convocations` AS CON ON CR.CR_CON_ID = CON.CON_ID WHERE CON.CON_STATUS IS NOT NULL) AS T";
            $team_data->push(0);
            $team_data->push(DB::select("
            SELECT COUNT(DISTINCT(tm_user_id)) as AmountOfUsers
            FROM team_members
            ")[0]->AmountOfUsers);
            $team_data->push(DB::select("
            SELECT COUNT(DISTINCT(CR_USER_ID)) as AmountOfUsers
            FROM (SELECT `CR_USER_ID`,`CR_DATE`,`CR_MSG`,`CON_ID`,`CON_DATE`,`CON_START_DATE`,`CON_END_DATE`,`CON_USER_ID`,`CON_TEAM_ID`,`CON_STATUS`,`CON_TT`,`CON_CT` FROM `con__responses` AS CR LEFT JOIN `convocations` AS CON ON CR.CR_CON_ID = CON.CON_ID) AS T")[0]
            ->AmountOfUsers);
            $team_data->push(DB::select("
            SELECT COUNT(DISTINCT(CON_ID)) as AmountOfUsers
            FROM (SELECT `CR_USER_ID`,`CR_DATE`,`CR_MSG`,`CON_ID`,`CON_DATE`,`CON_START_DATE`,`CON_END_DATE`,`CON_USER_ID`,`CON_TEAM_ID`,`CON_STATUS`,`CON_TT`,`CON_CT` FROM `con__responses` AS CR LEFT JOIN `convocations` AS CON ON CR.CR_CON_ID = CON.CON_ID) AS T")[0]
            ->AmountOfUsers);
            $team_data->push(DB::select("
            SELECT COUNT(*) as AmountOfUsers
            FROM (SELECT `CR_USER_ID`,`CR_DATE`,`CR_MSG`,`CON_ID`,`CON_DATE`,`CON_START_DATE`,`CON_END_DATE`,`CON_USER_ID`,`CON_TEAM_ID`,`CON_STATUS`,`CON_TT`,`CON_CT` FROM `con__responses` AS CR LEFT JOIN `convocations` AS CON ON CR.CR_CON_ID = CON.CON_ID) AS T")[0]
            ->AmountOfUsers);
        }else{
            $filter = "(SELECT `CR_USER_ID`,`CR_DATE`,`CR_MSG`,`CON_ID`,`CON_DATE`,`CON_START_DATE`,`CON_END_DATE`,`CON_USER_ID`,`CON_TEAM_ID`,`CON_STATUS`,`CON_TT`,`CON_CT` FROM `con__responses` AS CR LEFT JOIN `convocations` AS CON ON CR.CR_CON_ID = CON.CON_ID WHERE CON.CON_TEAM_ID = $tm_id AND CON.CON_STATUS IS NOT NULL) AS T";
            $team_data->push(Team::find($tm_id)->team_name);
            $team_data->push(DB::select("
            SELECT COUNT(bot__users.id) as AmountOfUsers
            FROM 
            (
            SELECT tm_user_id
            FROM team_members
            WHERE tm_team_id = ".$tm_id."   
            ) AS MatchingMembers
            INNER JOIN bot__users
            ON MatchingMembers.tm_user_id = bot__users.id
            ")[0]->AmountOfUsers);
            $team_data->push(DB::select("
            SELECT COUNT(DISTINCT(CR_USER_ID)) as AmountOfUsers
            FROM (SELECT `CR_USER_ID`,`CR_DATE`,`CR_MSG`,`CON_ID`,`CON_DATE`,`CON_START_DATE`,`CON_END_DATE`,`CON_USER_ID`,`CON_TEAM_ID`,`CON_STATUS`,`CON_TT`,`CON_CT` FROM `con__responses` AS CR LEFT JOIN `convocations` AS CON ON CR.CR_CON_ID = CON.CON_ID WHERE CON.CON_TEAM_ID = $tm_id) AS T")[0]
            ->AmountOfUsers);
            $team_data->push(DB::select("
            SELECT COUNT(DISTINCT(CON_ID)) as AmountOfUsers
            FROM (SELECT `CR_USER_ID`,`CR_DATE`,`CR_MSG`,`CON_ID`,`CON_DATE`,`CON_START_DATE`,`CON_END_DATE`,`CON_USER_ID`,`CON_TEAM_ID`,`CON_STATUS`,`CON_TT`,`CON_CT` FROM `con__responses` AS CR LEFT JOIN `convocations` AS CON ON CR.CR_CON_ID = CON.CON_ID WHERE CON.CON_TEAM_ID = $tm_id) AS T")[0]
            ->AmountOfUsers);
            $team_data->push(DB::select("
            SELECT COUNT(*) as AmountOfUsers
            FROM (SELECT `CR_USER_ID`,`CR_DATE`,`CR_MSG`,`CON_ID`,`CON_DATE`,`CON_START_DATE`,`CON_END_DATE`,`CON_USER_ID`,`CON_TEAM_ID`,`CON_STATUS`,`CON_TT`,`CON_CT` FROM `con__responses` AS CR LEFT JOIN `convocations` AS CON ON CR.CR_CON_ID = CON.CON_ID WHERE CON.CON_TEAM_ID = $tm_id) AS T")[0]
            ->AmountOfUsers);
        }

        if(Auth::user()->user_role_id == 1 or Auth::user()->user_role_id == 4){
            $teams=Team::all();
        }else{
            $teams=Auth::user()->linked->teams;
        }

        $acc_data = collect([]);
        $acc_data->push(DB::select("SELECT COUNT(*) AS COUNT FROM $filter WHERE `CR_MSG` LIKE 'ACCEPTED'")[0]->COUNT);
        $acc_data->push(DB::select("SELECT COUNT(*) AS COUNT FROM $filter WHERE `CR_MSG` NOT LIKE 'ACCEPTED'")[0]->COUNT);
        
        $acc_data->push(Con_Response::all()->where('CR_MSG', '!=', 'ACCEPTED')->count());
        $acc_chart = new Frappe;
        $acc_chart->labels(['Accepted', 'Denied']);
        $acc_chart->dataset('Responses', 'percentage', $acc_data)->color('green');      
        $acc_chart->options(['colors' => ['#00ff00', 'red'], 'height'=>100]);

        $conf_data = collect([]);
        $res = (DB::select("SELECT COUNT(DISTINCT(CON_ID)) AS COUNT, CON_STATUS FROM $filter GROUP BY CON_STATUS ORDER BY CON_STATUS DESC;"));
        foreach ($res as $key) {
            $conf_data->push($key->COUNT);
        }
        $conf_chart = new Frappe;
        $conf_chart->labels(['Confirmed', 'Cancelled']);
        $conf_chart->dataset('Responses', 'percentage', $conf_data)->color('green');      
        $conf_chart->options(['colors' => ['#00ff00', 'red'], 'height'=>100]);

        $can_data = collect([]);
        $can_labels = collect([]);
        $res = (DB::select("SELECT COUNT(DISTINCT(CON_ID)) AS COUNT, CON_CT FROM $filter WHERE CON_CT IS NOT NULL GROUP BY CON_CT;"));
        
        foreach ($res as $key) {
            $can_data->push($key->COUNT);
            $can_labels->push(Cancel_Type::all()->where('CT_ID', $key->CON_CT)->first()->CT_NAME);
        }
        $can_chart = new Frappe;
        $can_chart->labels($can_labels);
        $can_chart->dataset('Responses', 'percentage', $can_data)->color('purple');   
        $can_chart->options(['colors' => ['#00ff00', 'light-blue'], 'height'=>100]);

        $totals = collect([]);
        $totals_m = collect([]);
        $accepted = collect([]);
        $denied = collect([]);
        $confirmed = collect([]);
        $cancelled = collect([]);
        $labels = collect([]);
        foreach (Training_Type::all() as $key) {
            $totals->push(DB::select("SELECT COUNT(DISTINCT(CON_ID)) AS C FROM $filter WHERE CON_TT = $key->TT_ID;")[0]->C);
            $totals_m->push(DB::select("SELECT COUNT(*) AS C FROM $filter WHERE CON_TT = $key->TT_ID;")[0]->C);
            $accepted->push(DB::select("SELECT COUNT(*) AS C FROM $filter WHERE CON_TT = $key->TT_ID AND CR_MSG LIKE 'ACCEPTED';")[0]->C);
            $denied->push(DB::select("SELECT COUNT(*) AS C FROM $filter WHERE CON_TT = $key->TT_ID AND CR_MSG NOT LIKE 'ACCEPTED';")[0]->C);
            $confirmed->push(DB::select("SELECT COUNT(DISTINCT(CON_ID)) AS C FROM $filter WHERE CON_TT = $key->TT_ID AND CON_STATUS LIKE 'CONFIRMED';")[0]->C);
            $cancelled->push(DB::select("SELECT COUNT(DISTINCT(CON_ID)) AS C FROM $filter WHERE CON_TT = $key->TT_ID AND CON_STATUS NOT LIKE 'CONFIRMED';")[0]->C);
            $labels->push($key->TT_NAME);
        }
        
        $ttc_chart = new Frappe;
        $ttc_chart->labels($labels);
        $ttc_chart->dataset('Total', 'line', $totals)->color('blue');
        $ttc_chart->dataset('Confirmed', 'bar', $confirmed)->color('green');
        $ttc_chart->dataset('Cancelled', 'bar', $cancelled)->color('red');
        $ttc_data = collect([]);
        $ttc_data->push($labels);
        $ttc_data->push($totals);
        $ttc_data->push($confirmed);
        $ttc_data->push($cancelled);

        $ttm_chart = new Frappe;
        $ttm_chart->labels($labels);
        $ttm_chart->dataset('Total', 'line', $totals_m)->color('blue');
        $ttm_chart->dataset('Accepted', 'bar', $accepted)->color('green');
        $ttm_chart->dataset('Denied', 'bar', $cancelled)->color('red');
        $ttm_data = collect([]);
        $ttm_data->push($labels);
        $ttm_data->push($totals_m);
        $ttm_data->push($accepted);
        $ttm_data->push($denied);

        $data = collect(DB::select("SELECT DATE_FORMAT(`CR_DATE`, '%W') AS DAY_NAME, COUNT(*) AS COUNT FROM $filter GROUP BY DATE_FORMAT(`CR_DATE`, '%W') ORDER BY DATE_FORMAT(`CR_DATE`, '%w')"));
        $chart2_data = collect([]);
        $days=collect([]);
        $nums=collect([]);
        foreach ($data as $day) {
            $days->push($day->DAY_NAME);
            $nums->push($day->COUNT);
        }
        $chart2_data->push($days);
        $chart2_data->push($nums);
        $chart2 = new Frappe;
        $chart2->labels($days);
        $chart2->dataset('Total Responses', 'line', $nums)->color('blue');

        $data = collect(DB::select("SELECT DATE_FORMAT(`CR_DATE`, '%W') AS DAY_NAME, COUNT(*) AS COUNT FROM $filter WHERE `CR_MSG` LIKE 'ACCEPTED' GROUP BY DATE_FORMAT(`CR_DATE`, '%W') ORDER BY DATE_FORMAT(`CR_DATE`, '%w')"));
        $nums=collect([]);
        foreach ($data as $day) {
            $nums->push($day->COUNT);
        }
        $chart2_data->push($nums);
        $chart2->dataset('Accepted', 'bar', $nums)->color('green');
        
        $data = collect(DB::select("SELECT DATE_FORMAT(`CR_DATE`, '%W') AS DAY_NAME, COUNT(*) AS COUNT FROM $filter WHERE `CR_MSG` NOT LIKE 'ACCEPTED' GROUP BY DATE_FORMAT(`CR_DATE`, '%W') ORDER BY DATE_FORMAT(`CR_DATE`, '%w')"));
        $nums=collect([]);
        foreach ($data as $day) {
            $nums->push($day->COUNT);
        }
        $chart2_data->push($nums);
        $chart2->dataset('Denied', 'bar', $nums)->color('red');
        $chart2->options(['barOptions'=>['spaceratio'=>0.2]]);

        $data = collect(DB::select("SELECT DATE_FORMAT(`CON_DATE`, '%W %H:%i') AS DAY_NAME, COUNT(*) AS COUNT FROM $filter GROUP BY DATE_FORMAT(`CON_DATE`, '%W %H:%i') ORDER BY DATE_FORMAT(`CON_DATE`, '%w')"));
        $chart3_data = collect([]);
        $days=collect([]);
        $nums=collect([]);
        foreach ($data as $day) {
            $days->push($day->DAY_NAME);
            $nums->push($day->COUNT);
        }
        $chart3 = new Frappe;
        $chart3->labels($days);
        $chart3_data->push($days);
        $chart3->dataset('Total Responses', 'line', $nums)->color('blue');
        $chart3_data->push($nums);
        $data = collect(DB::select("SELECT DATE_FORMAT(`CON_DATE`, '%W %H:%i') AS DAY_NAME, COUNT(*) AS COUNT FROM $filter WHERE `CR_MSG` LIKE 'ACCEPTED' GROUP BY DATE_FORMAT(`CON_DATE`, '%W %H:%i') ORDER BY DATE_FORMAT(`CON_DATE`, '%w')"));
        $nums=collect([]);
        foreach ($data as $day) {
            $nums->push($day->COUNT);
        }
        $chart3_data->push($nums);
        $chart3->dataset('Accepted', 'bar', $nums)->color('green');
        
        $data = collect(DB::select("SELECT DATE_FORMAT(`CON_DATE`, '%W %H:%i') AS DAY_NAME, COUNT(*) AS COUNT FROM $filter WHERE `CR_MSG` NOT LIKE 'ACCEPTED' GROUP BY DATE_FORMAT(`CON_DATE`, '%W %H:%i') ORDER BY DATE_FORMAT(`CON_DATE`, '%w')"));
        $nums=collect([]);
        foreach ($data as $day) {
            $nums->push($day->COUNT);
        }
        $chart3_data->push($nums);
        $chart3->dataset('Denied', 'bar', $nums)->color('red');
        $chart3->options(['barOptions'=>['spaceratio'=>0.2]]);


        $data = collect(DB::select("SELECT DATE_FORMAT(`CON_START_DATE`, '%W %H') AS DAY_NAME, MAX(TIMESTAMPDIFF(SECOND,`CON_START_DATE`, `CR_DATE`)) AS DIFF FROM $filter WHERE `CR_USER_ID` != `CON_USER_ID` GROUP BY DATE_FORMAT(`CON_START_DATE`, '%W %H') ORDER BY DATE_FORMAT(`CON_START_DATE`, '%w %H')"));
        $chart4_data = collect([]);
        $days=collect([]);
        $nums=collect([]);
        foreach ($data as $day) {
            $days->push($day->DAY_NAME);
            $nums->push($day->DIFF);
        }
        $chart4 = new Frappe;
        $chart4->labels($days);
        $chart4_data->push($days);
        $chart4->dataset('Maximum', 'line', $nums)->color('orange');
        $chart4_data->push($nums);
        $data = collect(DB::select("SELECT DATE_FORMAT(`CON_START_DATE`, '%W %H') AS DAY_NAME, CAST(ROUND(AVG(TIMESTAMPDIFF(SECOND,`CON_START_DATE`, `CR_DATE`)))AS UNSIGNED) AS DIFF FROM $filter WHERE `CR_USER_ID` != `CON_USER_ID` GROUP BY DATE_FORMAT(`CON_START_DATE`, '%W %H') ORDER BY DATE_FORMAT(`CON_START_DATE`, '%w %H')"));
        $nums=collect([]);
        foreach ($data as $day) {
            $nums->push($day->DIFF);
        }
        $chart4_data->push($nums);
        $chart4->dataset('Average', 'line', $nums)->color('light-blue');
        
        $data = collect(DB::select("SELECT DATE_FORMAT(`CON_START_DATE`, '%W %H') AS DAY_NAME, MIN(TIMESTAMPDIFF(SECOND,`CON_START_DATE`, `CR_DATE`)) AS DIFF FROM $filter WHERE `CR_USER_ID` != `CON_USER_ID` GROUP BY DATE_FORMAT(`CON_START_DATE`, '%W %H') ORDER BY DATE_FORMAT(`CON_START_DATE`, '%w %H')"));
        $nums=collect([]);
        foreach ($data as $day) {
            $nums->push($day->DIFF);
        }
        $chart4_data->push($nums);
        $chart4->dataset('Minimum', 'line', $nums)->color('light-green');
        $chart4->options(['barOptions'=>['spaceratio'=>0.2]]);

        
        $labels =  collect([]);
        $con_id =  collect([]);
        $users =  collect([]);
        foreach (DB::select("select DATE_FORMAT(CON_DATE, '%d/%m/%y') AS CON, CON_ID, COUNT(*) AS C from $filter where (CON_STATUS LIKE 'CONFIRMED') AND (CR_MSG LIKE 'ACCEPTED') GROUP BY DATE_FORMAT(CON_DATE, '%m/%d/%y') ASC;") as $res) {
            $labels->push($res->CON);
            $con_id->push($res->CON_ID);
            $users->push($res->C);
        }
        $upc_chart = new Frappe;
        $upc_chart->labels($labels);
        $upc_chart->dataset('Users', 'line', $users)->color('blue');
        $upc_data =  collect([]);
        $upc_data->push($labels);
        $upc_data->push($users);
        $upc_data->push($con_id);

        $rpu_chart = new Frappe;
        $rpu_data =  collect([]);
        $labels =  collect([]);
        $acc =  collect([]);
        $den =  collect([]);
        $total =  collect([]);
        $den_can =  collect([]);
        $acc_con = collect([]);
        foreach (DB::select("select DISTINCT(CR_USER_ID) from $filter;") as $u) {
            # code...Bot_Users::all()
            $id = $u->CR_USER_ID;
            $labels->push(Bot_Users::all()->where('user_chat_id', $id)->first()->name);
            $acc->push(DB::select("select COUNT(*) AS C from $filter WHERE CR_USER_ID = $id AND CR_MSG LIKE 'ACCEPTED';")[0]->C);
            $den->push(DB::select("select COUNT(*) AS C from $filter WHERE CR_USER_ID = $id AND CR_MSG NOT LIKE 'ACCEPTED';")[0]->C);
            $total->push(DB::select("select COUNT(*) AS C from $filter WHERE CR_USER_ID = $id;")[0]->C);
            $den_can->push(DB::select("select COUNT(*) AS C from $filter WHERE CR_USER_ID = $id AND CR_MSG LIKE 'DENIED' AND CON_STATUS LIKE 'CANCELLED' AND CON_CT=1;")[0]->C);
            $acc_con->push(DB::select("select COUNT(*) AS C from $filter WHERE CR_USER_ID = $id AND CR_MSG LIKE 'ACCEPTED' AND CON_STATUS LIKE 'CANCELLED' AND CON_CT=1;")[0]->C);
        }
        $rpu_data->push($labels);
        $rpu_data->push($total);
        $rpu_data->push($acc);
        $rpu_data->push($den);
        $rpu_data->push($acc_con);
        $rpu_data->push($den_can);

        $rpu_chart->labels($labels);
        $rpu_chart->dataset('Total', 'line', $total)->color('blue');
        $rpu_chart->dataset('Accepted', 'bar', $acc)->color('green');
        $rpu_chart->dataset('Denied', 'bar', $den)->color('red');
        $rpu_chart->dataset('A. & Can.', 'line', $acc_con)->color('green');
        $rpu_chart->dataset('D. & Can.', 'line', $den_can)->color('red');
        

        return view("statistics.main", compact('team_data', 'can_chart','ttc_chart','ttc_data','ttm_chart','ttm_data', 'conf_chart', 'acc_chart', 'chart2', 'chart2_data', 'chart3', 'chart3_data', 'chart4', 'chart4_data','upc_chart', 'upc_data', 'teams', 'tm_id', 'rpu_chart', 'rpu_data'));
     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return app('App\Http\Controllers\StatisticsController')->show(-1);
        /*
        $base_table = DB::table('con__responses')
            ->leftJoin('convocations', 'con__responses.CR_CON_ID', '=', 'convocations.CON_ID')
            ->select(['CR_ID','CR_USER_ID','CR_DATE','CR_MSG','CON_ID','CON_DATE','CON_START_DATE','CON_END_DATE','CON_USER_ID','CON_TEAM_ID','CON_STATUS','CON_TT','CON_CT'])
            ->get();        
        return $base_table;*/
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function edit(cr $cr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cr $cr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function destroy(cr $cr)
    {
        //
    }
}
