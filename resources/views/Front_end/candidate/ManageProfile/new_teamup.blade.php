@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Candidate List')
@section('pageheader', 'Candidate List')
@section('content')

    <div id="content">
        @include('Front_end.candidate.ManageProfile.team_request_modal')
        <div class="container">
            <div class="row">
                @include('Front_end.candidate.ManageProfile.left_menu')
                <div class="col-lg-9 col-md-9 col-xs-12">
                    <div class="job-alerts-item">
                        <div class="page-login-form box mb-1" id="searchDiv">
                            <div class="alert alert-danger print-error-msg" style="display:none;">
                                <ul></ul>
                            </div>
                            <form id="searchForm" class="login-form">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <div class="form-group">
                                            <div class="input-icon">
                                                <i class="fa fa-search"></i>
                                                {{ csrf_field() }}
                                                <input type="hidden" id="search_teamID" name="search_teamID" value="">
                                                <input type="hidden" id="teamid" name="teamid"
                                                    value="{{ isset($teamID) ? $teamID : '' }}">
                                                <input type="hidden" id="edit_team_type" name="edit_team_type"
                                                    value="{{ isset($team_details[0]->team_id) ? 'old' : 'new' }}">
                                                <input type="hidden" id="edit_team_id" name="edit_team_id"
                                                    value="{{ isset($teamID) ? $teamID : '' }}">
                                                <input type="text" id="searchCandidate" class="form-control"
                                                    name="searchCandidate" value="" placeholder="Search Candidate">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <a href="{{ route('front_end-candidate-teamup-list-view') }}"
                                            class="btn btn-common btn-sm"><i class="fa fa-caret-left"></i> Go Back</a>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="input-icon">
                                                <i class="fa fa-search"></i>
                                                {{-- <input type="hidden" id="search_teamID" name="search_teamID" value=""> 
                                                <input type="hidden" id="teamid" name="teamid" value="{{ isset($teamID) ? $teamID : '' }}">
                                                <input type="hidden" id="edit_team_type" name="edit_team_type" value="{{ isset($team_details[0]->team_id) ? 'old' : 'new' }}">
                                                <input type="hidden" id="edit_team_id" name="edit_team_id" value="{{ isset($teamID) ? $teamID : '' }}"> --}}
                                                <select class="form-control" id="searchByCategory" name="searchByCategory"
                                                    required>
                                                    <option class="custom-select" value="">---- Search By Category ----</option>
                                                    @if (isset($categories))
                                                        @foreach ($categories as $category)
                                                            <option class="custom-select" value='{{ $category->id }}'>
                                                                {{ $category->industry_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="input-icon">
                                                <i class="fa fa-search"></i>
                                                <select class="form-control" id="searchBySkill" name="searchBySkill"
                                                    required>
                                                    <option class="custom-select" value="">---- Search By Skill ---- </option>
                                                    @if (isset($alljobskills))
                                                        @foreach ($alljobskills as $skill)
                                                            <option class="custom-select" value='{{ $skill->id }}'
                                                                data-id="{{ $skill->jobskill }}">{{ $skill->jobskill }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="CandidateList">
                            @include('Front_end.candidate.ManageProfile.team_candidate_list')
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection
    @section('footersection')
        <script type="text/javascript" src="{{ asset('assets/front_end/js/candidate/teamup.js') }}"></script>
        <script>
            $(document).ready(function() {
                var edit_team_id = $('#edit_team_id').val();
                if (edit_team_id != '' && edit_team_id != null) {
                    $("#AddMember").html('Team Rename');
                }
            });
        </script>
        <script src="//cdn.ckeditor.com/4.7.3/full-all/ckeditor.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                CKEDITOR.replace('descriptionTeamReq', {
                    customConfig: "{{ asset('assets/admin/custom_config.js') }}"
                });
                CKEDITOR.config.allowedContent = true;
                CKEDITOR.config.extraAllowedContent = 'p(*)[*]{*};span(*)[*]{*};div(*)[*]{*};li(*)[*]{*};ul(*)[*]{*}';
            });
        </script>

    @endsection
