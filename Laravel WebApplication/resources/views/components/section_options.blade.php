


<div class="appBox titleWithPadding p-0" style="margin-bottom: 20px;">
    <div class="row">
        <div class="col-3">

           @if(Route::currentRouteName() == 'users-main' || Route::currentRouteName() == 'users-create' || Route::currentRouteName() == 'users-edit' || Route::currentRouteName() == 'users-bot')
           <h2> <i class="material-icons">apps</i> Manage Users</h2>
           @elseif(Route::currentRouteName() == 'profile-view' || Route::currentRouteName() == 'profile-edit')
           <h2> <i class="material-icons">apps</i> Options</h2>     
           @elseif(Route::currentRouteName() == 'teams-main' || Route::currentRouteName() == 'teams-create' || Route::currentRouteName() == 'teams-edit' || Route::currentRouteName() == 'teams-show' || Route::currentRouteName() == 'teams-members')
           <h2> <i class="material-icons">apps</i> Manage Teams</h2>
           @elseif(Route::currentRouteName() == 'convo-main' || Route::currentRouteName() == 'convo-show')
           <h2> <i class="material-icons">apps</i> Convocations</h2> 
           @endif

        </div>
        <div class="col-9">
                <ul class="sectionOptions">
                        @if(Route::currentRouteName() == 'users-main' || Route::currentRouteName() == 'users-create' || Route::currentRouteName() == 'users-edit' || Route::currentRouteName() == 'users-bot')
                        <li> 
                                <a href="{{ route('users-main') }}" class="{{ Route::currentRouteName() == 'users-main' ? 'active' : '' }} {{ Route::currentRouteName() == 'users-edit' ? 'active' : '' }}">
                                  <i class="material-icons">view_list</i> View Users
                                </a> 
                        </li>
                        <li> 
                                <a href="{{ route('users-create') }}" class="{{ Route::currentRouteName() == 'users-create' ? 'active' : '' }}">
                                  <i class="material-icons">add_circle</i> Create User
                                </a>
                        </li>
                        <li> 
                                <a href="{{ route('users-bot') }}" class="{{ Route::currentRouteName() == 'users-bot' ? 'active' : '' }}">
                                  <i class="material-icons">view_list</i> View Bot Users
                                </a>
                        </li>
                        @elseif(Route::currentRouteName() == 'profile-view' || Route::currentRouteName() == 'profile-edit' )
                        <li> 
                              <a href="{{ route('profile-view') }}" class="{{ Route::currentRouteName() == 'profile-view' ? 'active' : '' }}">
                                <i class="material-icons">view_list</i> View Profile
                              </a> 
                        </li>
                        <li> 
                              <a href="{{ route('profile-edit') }}" class="{{ Route::currentRouteName() == 'profile-edit' ? 'active' : '' }}">
                                 <i class="material-icons">mode_edit</i> Edit Profile
                              </a> 
                        </li>
                        @elseif(Route::currentRouteName() == 'convo-main' || Route::currentRouteName() == 'convo-show')
                        <li> 
                              <a href="{{ route('profile-edit') }}" class="{{ Route::currentRouteName() == 'convo-main' ? 'active' : '' }}">
                                 <i class="material-icons">view_list</i> View Convocations
                              </a> 
                        </li>
                        @if(Route::currentRouteName() == 'convo-show')
                        <li> 
                                <a href="{{ route('convo-main') }}" class="{{ Route::currentRouteName() == 'convo-show' ? 'active' : '' }}">
                                           <i class="material-icons">keyboard_return</i> Return to Convocations
                                </a> 
                        </li>
                        @endif
                        
                        @elseif(Route::currentRouteName() == 'teams-main' || Route::currentRouteName() == 'teams-edit' || Route::currentRouteName() == 'teams-create' || Route::currentRouteName() == 'teams-show' || Route::currentRouteName() == 'teams-members')
                        <li> 
                              <a href="{{ route('teams-main') }}" class="{{ Route::currentRouteName() == 'teams-main' ? 'active' : '' }} ">
                                <i class="material-icons">view_list</i> View Teams
                              </a> 
                        </li>
                        <li> 
                              <a href="{{ route('teams-create') }}" class="{{ Route::currentRouteName() == 'teams-create' ? 'active' : '' }}">
                                 <i class="material-icons">add_circle</i> Create Team
                              </a> 
                        </li>
                        @if(Route::currentRouteName() == 'teams-show' || Route::currentRouteName() == 'teams-edit' )
                        <li> 
                                <a href="{{ route('teams-main') }}" class="{{ Route::currentRouteName() == 'teams-show' ? 'active' : '' }} {{ Route::currentRouteName() == 'teams-edit' ? 'active' : '' }}">
                                           <i class="material-icons">keyboard_return</i> Return to Teams
                                </a> 
                        </li>
                     
                        @endif
                        @endif
                </ul>
        </div>
                                       
    </div>   
</div>