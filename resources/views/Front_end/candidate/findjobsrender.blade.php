<!-- <table class="table table-hover" style="text-align:center;margin-top: 10px;"> -->
@php $result = $data->count(); @endphp
@if ($result > 0)
    <div class="row">
        <div class="col-sm-5 scrollable" style="float:left;overflow-y: auto;height: 600px; ">
            <input type="hidden" id="scrollablePage" name="scrollablePage" value="1">

            <!-- <div class="col-sm-5"> -->
            <!-- <hr/> -->
            @foreach ($data as $key => $row)
                <span class="single_job_list" data-id="{{ $row->id }}" style="z-index: -1;">
                    <div class="card bg-light singlejobcard "
                        style=" display: flex; flex-direction: column; justify-content: space-between; padding: 15px 15px; border: none; border-top:2px solid #80808061;border-radius:0">
                        <div class="card-body p-0 mb-2">
                            <div class="company_details">
                                <div class="primarydetail">
                                    <img src="<?php echo $row->companylogo ? $row->companylogo : asset('assets/front_end/images/noimage.jpg'); ?>" class="img-thumbnail"
                                        style="width: 20%;height: 80px;float:left;margin-right:10px;object-fit: cover" />
                                    <p style=" font-weight:500;color:black;">{{ ucfirst($row->jobtitle) }}</p>
                                    <p style="color: #26ae61;">{{ ucfirst($row->companyname) }}</p>
                                    <p>{{ $row->state }} , {{ $row->country }}</p>
                                </div>
                                <div class="harticon">
                                    @if (Auth::guard('candidate')->check())
                                        <button id="make_Favourite" type="button" class="save-icon"
                                            style="z-index: 9999;">
                                            <p><i class="fa fa-heart fa-2x favourite make_favourite{{ $row->id }} {{ $row->wishlist_id ? 'text-success' : '' }}"
                                                    {{ $row->wishlist_id ? 'data-status = 1' : 'data-status = 0' }}
                                                    aria-hidden="true" id="favourite" data-id="{{ $row->id }}"></i>
                                            </p>
                                        </button>
                                    @endif
                                    @if (!Auth::guard('employers')->user() && !Auth::guard('candidate')->user())
                                        <a href="{{ route('front_end-signup') }}" class="save-icon"
                                            style="z-index: 9999;">
                                            <p><i class="fa fa-heart fa-2x" aria-hidden="true" id="favourite"></i></p>
                                        </a>
                                    @endif
                                    @if (Auth::guard('employers')->check())
                                        <a href='javascript:void(0)' class="save-icon"
                                            style="cursor: not-allowed;z-index: 9999">
                                            <p><i class="fa fa-heart fa-2x" aria-hidden="true" id="favourite"></i></p>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-2">
                                <p>{{ strip_tags(substr($row->jobdescription, 0, 100)) }}...</p>
                            </div>
                        </div>

                        <div class="cardfooter">
                            <div>
                                @php
                                    $oldDate = $row->created_at;
                                    $newDate = date('F j, Y', strtotime($oldDate));
                                @endphp
                                <p>{{ $newDate }}</p>
                            </div>
                            <div class="applynow">
                                @php
                                    $find_candidate = DB::table('appliedjobs')
                                        ->select('appliedjobs.*')
                                        ->where('candidate_id', Auth::guard('candidate')->id())
                                        ->where('job_id', $row->id)
                                        ->first();
                                    if ($find_candidate == '' && $find_candidate == null) {
                                        $button_text = 'Apply Now';
                                    } else {
                                        $button_text = 'Applied';
                                    }
                                @endphp
                                @if (Auth::guard('candidate')->check())
                                    <button href="javascript:void(0)" id="apply_job"
                                        data-id="{{ isset($row->id) ? $row->id : '' }}" class="btn-apply"
                                        style="padding: 5px 10px;float:right;line-height:1" <?php echo isset($button_text) && $button_text == 'Applied' ? 'disabled' : '' ?>>
                                        {{ isset($button_text) ? $button_text : '' }}</button>
                                @endif
                                @if (!Auth::guard('employers')->user() && !Auth::guard('candidate')->user())
                                    <a href="{{ route('front_end-signup') }}" class="btn-apply "
                                        style="padding: 5px 10px;float:right;line-height:1">Apply Now</a>
                                @endif
                                @if (Auth::guard('employers')->check())
                                    <a href="javascript:void(0)" style="cursor: not-allowed;" class="btn-apply "
                                        style="padding: 5px 10px;float:right;line-height:1">{{ isset($button_text) ? $button_text : '' }}</a>
                                @endif
                            </div>
                        </div>
                        <!-- <hr/> -->
                    </div>
                </span>
            @endforeach


        </div>
        <div class="col-sm-7 jobData">
        </div>
    </div>

@else
    <div id="notfound">
        <div class="notfound">
            <div class="notfound-404">
                <h1>Oops!</h1>
                <h2>JOB YOU ARE LOOKING CAN BE FOUND</h2>
            </div>
            <a href="{{route('front_end-find-jobs-view')}}">SEE ALL JOB</a>
        </div>
    </div>
@endif

<!-- <thead>
            <th>Jobs Title</th>
            <th>Positions</th>
            <th>State</th>
            <th>Job Type</th>
            <th>Apply Now</td>
            <th>Make Favourite</td>
        
    </thead>
    <tbody>
        {{-- @php $result = $data->count(); @endphp --}}
        
        @if ($result > 0)
        @foreach ($data as $key => $row)

            <tr>
                <td> <a class="" href='{{ route('front_end-job_details_view', ['job_id' => $row->id]) }}'> {{ ucfirst($row->jobtitle) }} </a></td>
                <td><span class="btn-open">{{ $row->positions }} Open Jobs</span></td>
                <td><i class="lni-map-marker" style="color:#26ae61"></i>{{ $row->state }}</td>
                <td> {{ ucfirst($row->jobtype) }}</td>
                <td>
                    @php
                        $find_candidate = DB::table('appliedjobs')
                            ->select('appliedjobs.*')
                            ->where('candidate_id', Auth::guard('candidate')->id())
                            ->where('job_id', $row->id)
                            ->first();
                        if ($find_candidate == '' && $find_candidate == null) {
                            $button_text = 'Apply Now';
                        } else {
                            $button_text = 'Applied';
                        }
                    @endphp
                         @if (Auth::guard('candidate')->check())
                             <a href="javascript:void(0)" id="apply_job" data-id="{{ $row->id }}" class="btn-apply">{{ $button_text }}</a>
                        @endif
                        @if (!Auth::guard('employers')->user() && !Auth::guard('candidate')->user())
                            <a href='{{ route('front_end-signup') }}' class="btn-apply">Apply Now</a>
                        @endif
                        @if (Auth::guard('employers')->check())
                            <a href="javascript:void(0)" style="cursor: not-allowed;" class="btn-apply">{{ $button_text }}</a>
                        @endif
                </td>
                <td>
                        @if (Auth::guard('candidate')->check())
                            <button id="make_Favourite" type="button" class="save-icon">
                                    <p><i class="fa fa-heart fa-2x favourite make_favourite{{ $row->id }} {{ $row->wishlist_id ? 'text-success' : '' }}" {{ $row->wishlist_id ? 'data-status = 1' : 'data-status = 0' }}  aria-hidden="true" id="favourite" data-id="{{ $row->id }}"></i></p>
                            </button> 
                         @endif
                         @if (!Auth::guard('employers')->user() && !Auth::guard('candidate')->user())
                            <a href='{{ route('front_end-signup') }}' class="save-icon"><p><i class="fa fa-heart fa-2x" aria-hidden="true" id="favourite"></i></p></a>
                        @endif
                        @if (Auth::guard('employers')->check())
                        <a href='javascript:void(0)' class="save-icon" style="cursor: not-allowed;"><p><i class="fa fa-heart fa-2x" aria-hidden="true" id="favourite"></i></p></a>
                        @endif
                </td>
            </tr>   
            @endforeach
            {{ csrf_field() }}  
            {!! $data->links() !!}
@else
             <tr><td colspan="6">No Jobs Found</td></tr>   
        @endif
    </tbody> -->
<!-- </table> -->
<script>
    var firstid = <?php echo isset($data[0]->id) ? $data[0]->id : ''; ?>
</script>
