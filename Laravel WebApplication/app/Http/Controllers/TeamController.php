<?php

namespace App\Http\Controllers;

use App\Team;
use App\Convo;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Bot_Users;
use Illuminate\Http\Request;
use App\TeamMembers;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

     $teams = DB::select("
                SELECT id, team_name, team_desc, team_capt_id, CaptainName, AmountOfUsers
                FROM
                (
                SELECT *
                FROM 
                (
                    SELECT teams.id, 
                    teams.team_name, 
                    teams.team_desc, 
                    teams.team_capt_id as team_capt_id, 
                    IFNULL(bot__users.name, 'No Captain')  as CaptainName
                    FROM teams
                    LEFT JOIN bot__users
                    ON teams.team_capt_id = bot__users.id
                
                ) AS baseInfoTeams
                LEFT JOIN 
                (
                    SELECT COUNT(tm_user_id) as AmountOfUsers, teams.id as team_id
                    FROM teams
                    INNER JOIN team_members
                    ON teams.id = team_members.tm_team_id
                    GROUP BY team_id    
                ) AS countOfMembers
                ON baseInfoTeams.id = countOfMembers.team_id    
                ) AS FinalQuery
                ");


    return view('teams.main', compact('teams'));
 
     
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

    public function storeNewMember($teamid, Request $request)
    {
      
     
        
        //TeamMembers::create($request->all());

        TeamMembers::create([
            'tm_team_id' => $teamid,
            'tm_user_id' => $request['tm_user_id']
        ]);



        return redirect()->route("teams-members", [$teamid])->with('success', 'Member was sucessfully deleted');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team = Team::find($id);

        $creation_date = date('d-m-Y', strtotime($team->created_at));

        $team_captain = Bot_Users::all()->where('id', '=', $team->team_capt_id);

        $team_members_count = DB::select("
        SELECT COUNT(bot__users.id) as AmountOfUsers
        FROM 
        (
        SELECT tm_user_id
        FROM team_members
        WHERE tm_team_id = ".$id."   
        ) AS MatchingMembers
        INNER JOIN bot__users
        ON MatchingMembers.tm_user_id = bot__users.id
        ");
        
        $team_members = DB::select("
        SELECT bot__users.id, bot__users.name, bot__users.active, bot__users.user_chat_id
        FROM 
        (
        SELECT tm_user_id
        FROM team_members
        WHERE tm_team_id = ".$id."   
        ) AS MatchingMembers
        INNER JOIN bot__users
        ON MatchingMembers.tm_user_id = bot__users.id
        ORDER BY bot__users.id ASC
        ");
        return view('teams.show', compact('team', 'creation_date', 'team_captain', 'team_members', 'team_members_count'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = Team::findOrFail($id);
        $currentTeamCaptain = Bot_Users::find($team->team_capt_id);
        $teamCaptains = Bot_Users::all('name', 'id');



    
        return view('teams.edit', compact('team', 'teamCaptains', 'currentTeamCaptain'));
    }

    public function updateMembersEdit($id)
    {   
        $team = Team::findOrFail($id);

        $team_members = DB::select("
        SELECT MatchingMembers.id as membershipId, bot__users.id, bot__users.name, bot__users.active, bot__users.user_chat_id
        FROM 
        (
        SELECT tm_user_id, id
        FROM team_members
        WHERE tm_team_id = ".$id."   
        ) AS MatchingMembers
        INNER JOIN bot__users
        ON MatchingMembers.tm_user_id = bot__users.id
        ORDER BY bot__users.id ASC
        ");

        $add_team_members = DB::select("
        SELECT bot__users.name, bot__users.id
        FROM bot__users
        LEFT JOIN team_members
        ON bot__users.id = team_members.tm_user_id
        WHERE tm_team_id != ".$id."  OR ISNULL(tm_team_id)
        ");



        return view('teams.members_edit', compact('team', 'team_members', 'add_team_members'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
            
        
        $TeamsDataToReplace = request()->validate([
            'team_name' => 'required|unique:teams,team_name,'.$id,
            'team_desc' => 'required|min: 10',
            'team_capt_id' => 'required|integer|min: 0'
       ]);
     
        Team::where('id' ,$id)->first()->update($TeamsDataToReplace);

        return redirect()->route("teams-main", [$id])->with('success', 'All changes to your profile have been made');
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        //
    }

    public function Memberdestroy($id, $teamid)
    {
        TeamMembers::destroy($id);

        return redirect()->route("teams-members", [$teamid])->with('success', 'Member was sucessfully deleted');
    }

}
