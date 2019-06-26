<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/frappe-charts@1.1.0/dist/frappe-charts.min.iife.js"></script>


    <script src="{{ asset('js/pace.min.js') }}" defer></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('css/pace.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/colreorder/1.5.1/css/colReorder.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/scroller/2.0.0/css/scroller.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-colvis-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/cr-1.5.0/fh-3.1.4/r-2.2.2/rg-1.1.0/sc-2.0.0/datatables.min.css" />
    <style>
    .dataTables_scrollHeadInner {
        width: 100% !important;
        padding: 0 !important;
    }
    .material-icons.md-dark { color: rgba(0, 0, 0, 0.54); }
    .material-icons.md-dark.md-inactive { color: rgba(0, 0, 0, 0.26); }
    </style>
</head>
<body>
    <div id="app">

        <div class="wrapper">
            <!-- Sidebar  -->
            <nav id="sidebar">
                <ul class="list-unstyled components">
                    <div class="logoContainerBlack">
                        <img src="{{ asset('css/img/logoBlack.png') }}">
                     </div>
                     <li class="{{ Route::currentRouteName() == 'convo-main' ? 'active' : '' }}">
                        <a href="{{ route('convo-main') }}">Convocations</a>
                    </li>
                    @if(Auth::user()->user_role_id == 1 || Auth::user()->user_role_id == 4 )
                    <li class="{{ Route::currentRouteName() == 'users-main' ? 'active' : '' }} {{ Route::currentRouteName() == 'users-create' ? 'active' : '' }} {{ Route::currentRouteName() == 'users-edit' ? 'active' : '' }}">
                        <a href="{{ route('users-main') }}">Users</a>
                    </li>
                    <li class="{{ Route::currentRouteName() == 'teams-main' ? 'active' : '' }} {{ Route::currentRouteName() == 'teams-show' ? 'active' : '' }} {{ Route::currentRouteName() == 'teams-create' ? 'active' : '' }} {{ Route::currentRouteName() == 'teams-edit' ? 'active' : '' }} {{ Route::currentRouteName() == 'teams-members' ? 'active' : '' }}">
                            <a href="{{ route('teams-main') }}">Teams</a>
                    </li>
                    @else
                    <li class="{{ Route::currentRouteName() == 'teams-main' ? 'active' : '' }}">
                            <a href="{{ route('teams-main') }}">Team</a>
                    </li>
                    @endif
                   
                    <li class="{{ Route::currentRouteName() == 'statistics-main' ? 'active' : '' }}">
                        <a href="{{ route('statistics-main') }}">Statistics</a>
                    </li>
                    <li>
                        
                    </li>
                </ul>

                <ul class="list-unstyled CTAs">
                    <li>
                        <button type="button" id="dismiss" class="btn btn-light closeMenuButton">Close Menu</button>
                    </li>
                </ul>

                <div class="menuBarBottomAnimationCt">
                    <div class="menuBarBottomAnimation">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 40" preserveAspectRatio="none">  
                            <path d="">
                            <animate attributeName="d" begin="0s" dur="999999999s" repeatCount="indefinite" values="
                                M0,0 C200,7.11236625e-15 200,40 400,40 C600,40 800,0 1000,0 L1000,50 L0,50 L0,0 Z;
                                M0,40 C200,40 400,0 600,0 C800,0 800,40 1000,40 L1000,50 L0,50 L0,40 Z;
                                M0,30 C200,30 200,0 400,0 C600,0 800,40 1000,40 L1000,50 L0,50 L0,30 Z;
                                M0,0 C200,7.11236625e-15 200,40 400,40 C600,40 800,0 1000,0 L1000,50 L0,50 L0,0 Z;"></animate>
                            </path>
                        </svg>
                    </div>
                </div>
        
              
            </nav>
    
            <!-- Page Content  -->
            <div id="content" class="appTopHeader">
                <nav class="navbar navbar-expand-md navbar-light topNavBotCloudApp">
                    <div class="container">
                        <a class="navbar-brand smallLogoNav" href="{{ url('/') }}">
                            <img src="{{ asset('css/img/logoWhite.png') }}">
                        </a>

        
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <!-- Left Side Of Navbar -->
                            <ul class="navbar-nav mr-auto">
        
                            </ul>
        
                            <!-- Right Side Of Navbar -->
                            <ul class="navbar-nav ml-auto">
                                <!-- Authentication Links -->

                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle appUserButton" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            {{ Auth::user()->name }} <span class="caret"></span>
                                        </a>
        
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('profile-view') }}">
                                                 Your Profile
                                             </a>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
        
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                    <li class="nav-item" id="sidebarCollapse" >
                                            <div id="nav-icon0" >
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                            </div>                                         
                                    </li>
   
                            </ul>
                        </div>
                    </div>
                </nav>



                <main class="py-4 fade-in">
                    
                    @yield('content')
                </main>
            </div>
        </div>
    
        <div class="overlay"></div>
 
    </div>
    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
    <script
			  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
			  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
			  crossorigin="anonymous"></script>
		
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-colvis-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/cr-1.5.0/fh-3.1.4/r-2.2.2/rg-1.1.0/sc-2.0.0/datatables.min.js"></script>
    <script language="JavaScript" type="text/javascript">
        $(document).ready(function() {
            var IDs = [];
            $('[id^="dt_"]').each(function() {
                IDs.push(this.id);
            });
            jQuery.each(IDs, function() {
                var title = $("#".concat(this)).attr("title");
                var table = $("#".concat(this)).DataTable({
                    colReorder: true,
                    responsive: true,
                    dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                    lengthMenu: [
                        [10, 25, 50, -1],
                        ['10 rows', '25 rows', '50 rows', 'Show all']
                    ],
                    buttons: [{
                        extend: 'colvis',
                        columns: ':gt(0)',
                        text: '<i class="fa fa-columns"></i>',
                        titleAttr: 'Filter Columns'
                    }, {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o"></i>',
                        title: title,
                        titleAttr: 'Excel'
                    }, {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf-o"></i>',
                        title: title,
                        titleAttr: 'PDF'
                    }],
                    initComplete: function() {
                        this.api().columns().every(function() {
                            var column = this;
                            var select = $('<select><option value=""></option></select>')
                                .appendTo($(column.footer()).empty())
                                .on('change', function() {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    column
                                        .search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                                });

                            column.data().unique().sort().each(function(d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>')
                            });
                        });
                    },
                    scrollY: '50vmin',
                    scrollCollapse: true,
                    scroller: true
                });
            });
            $('[id^="i_"]').each(function() {
                $("#".concat(this.id)).click();
            });
        });
    </script>



</body>
</html>
