<?php
$jobTypes = explode(",", $data['job_details']->jobtype);
// echo '<pre>';
// print_r($data);
// die;
?>

<div class="card" style="border: none;">
    <div class="card-body" >
        <div class="details_header">
            <div class="companyface">
                <img class="img-thumbnail" src="<?php echo $data['job_details']->companylogo ? $data['job_details']->companylogo :  asset('assets/front_end/images/noimage.jpg') ?>" style="width: 20%;height: 121px;float:left;margin-right:10px;object-fit: cover" />
                <div class="company_primary_details">
                    <p style=" font-weight:500;color:black;">{{ ucfirst($data['job_details']->jobtitle) }}</p>
                    <p style="color: #26ae61;">{{ ucfirst($data['job_details']->companyname) }}</p>
                    <p>{{$data['job_details']->state }} , {{$data['job_details']->country }}</p>
                </div>

                <div class="applynowbtn">
                    @php
                    $find_candidate = DB::table('appliedjobs')
                        ->select('appliedjobs.*')
                        ->where('candidate_id', Auth::guard('candidate')->id())
                        ->where('job_id', $data['job_details']->id)
                        ->first();
                    if($find_candidate == '' && $find_candidate == null){
                    $button_text = 'Apply Now';
                    }else{
                    $button_text = 'Applied';
                    }
                    @endphp
                    @if (Auth::guard('candidate')->check())
                    <a href="javascript:void(0)" id="apply_job" data-id="{{ $data['job_details']->id}}" class="btn-apply " style="padding: 5px 10px;float:right;line-height:1">{{$button_text}}</a>
                    @endif
                    @if(!Auth::guard('employers')->user() && !Auth::guard('candidate')->user())
                    <a href="{{ route('front_end-signup') }}" class="btn-apply " style="padding: 5px 10px;float:right;line-height:1">Apply Now</a>
                    @endif
                    @if(Auth::guard('employers')->check())
                    <a href="javascript:void(0)" style="cursor: not-allowed;" class="btn-apply " style="padding: 5px 10px;float:right;line-height:1">{{$button_text}}</a>
                    @endif
                </div>
            </div>
        </div>
        <hr style="margin-top: 4rem;" />
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Job Type
                <span>
       
                    <?php
                    foreach ($jobTypes as $jobType) {
                        if ($jobType == "fulltime") {
                            $jobType = "full-time";
                        }
                        if ($jobType == "parttime") {
                            $jobType = "part-time";
                        }
                    ?>
                        <span class=<?php echo $jobType ?>><?php echo strtoupper($jobType) ?></span>
                    <?php
                    }
                    ?>
                </span>


            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Positions
                <span class="" style="line-height:21px ;margin:  0;margin-right: -6px;">{{ $data['job_details']->positions }}
                    @if($data['job_details']->positions > 1)
                    @php
                    $str = "Open Jobs";
                    @endphp
                    @else
                    @php
                    $str = "Open Job";
                    @endphp
                    @endif
                    {{$str}}
                </span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Salary
                <span class="" style="line-height:21px ;margin:  0;margin-right: -6px;">${{ $data['job_details']->salary }} </span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Address
                <span><i class="lni-map-marker" style="color:#26ae61"> </i>{{ $data['job_details']->country }} / {{ $data['job_details']->state }} /
                    @php $cityy = ''; @endphp
                    @foreach ($data['job_city'] as $k => $city)
                    @php
                    $cityy .=$city->city;
                    @endphp

                    @if($k != (count($data['job_city'])-1))
                    @php
                    $cityy .= " & ";
                    @endphp
                    @endif
                    @endforeach
                    {{ $cityy }}
                </span>
            </li>
        </ul>
        <div class="jobfulldesc mt-3 container">
            <h6 class="mb-3" style="color: black;">Description</h6>
            <p>{{strip_tags($data['job_details']->jobdescription) }}</p>
        </div>
    </div>
</div>