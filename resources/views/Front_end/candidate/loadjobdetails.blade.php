@php
$result = $data->count(); @endphp

@if($result > 0)
<input type="hidden" id="numberOfRecord" name="numberOfRecord" value="<?php echo isset($numberOfRecord) ? $numberOfRecord : 0 ?>">
@foreach ($data as $key => $row)
<span class="single_job_list" data-id="{{$row->id}}" style="z-index: -1;">
    <div class="card bg-light " style=" display: flex; flex-direction: column; justify-content: space-between; padding: 15px 15px; border: none; border-top:2px solid #80808061;border-radius:0">
        <div class="card-body p-0 mb-2">
            <div class="company_details">
                <div class="primarydetail">
                    <img src="<?php echo $row->companylogo ? $row->companylogo :  asset('assets/front_end/images/noimage.jpg')  ?>" class="img-thumbnail" style="width: 20%;height: 80px;float:left;margin-right:10px;object-fit: cover" />
                    <p style=" font-weight:500;color:black;">{{ ucfirst($row->jobtitle) }}</p>
                    <p style="color: #26ae61;">{{ ucfirst($row->companyname) }}</p>
                    <p>{{$row->state }} , {{$row->country }}</p>
                </div>
                <div class="harticon">
                    @if (Auth::guard('candidate')->check())
                    <button id="make_Favourite" type="button" class="save-icon" style="z-index: 9999;">
                        <p><i class="fa fa-heart fa-2x favourite make_favourite{{$row->id}} {{$row->wishlist_id  ? 'text-success'  : '' }}" {{$row->wishlist_id  ? 'data-status = 1'  : 'data-status = 0' }} aria-hidden="true" id="favourite" data-id="{{$row->id}}"></i></p>
                    </button>
                    @endif
                    @if(!Auth::guard('employers')->user() && !Auth::guard('candidate')->user())
                    <a href="{{ route('front_end-signup') }}" class="save-icon" style="z-index: 9999;">
                        <p><i class="fa fa-heart fa-2x" aria-hidden="true" id="favourite"></i></p>
                    </a>
                    @endif
                    @if(Auth::guard('employers')->check())
                    <a href='javascript:void(0)' class="save-icon" style="cursor: not-allowed;z-index: 9999">
                        <p><i class="fa fa-heart fa-2x" aria-hidden="true" id="favourite"></i></p>
                    </a>
                    @endif
                </div>


            </div>
            <div class="mt-2">
                <p>{{strip_tags(substr($row->jobdescription,0,100)) }}...</p>
            </div>
        </div>

        <div class="cardfooter">
            <div>
                @php
                $oldDate = $row->created_at;
                $newDate = date("F j, Y", strtotime($oldDate));
                @endphp
                <p>{{$newDate}}</p>
            </div>
            <div class="applynow">
                @php
                $find_candidate = DB::table('appliedjobs')
                ->select('appliedjobs.*')
                ->where('candidate_id', Auth::guard('candidate')->id())
                ->where('job_id', $row->id)
                ->first();
                if($find_candidate == '' && $find_candidate == null){
                $button_text = 'Apply Now';
                }else{
                $button_text = 'Applied';
                }
                @endphp
                @if (Auth::guard('candidate')->check())
                <a href="javascript:void(0)" id="apply_job" data-id="{{$row->id}}" class="btn-apply " style="padding: 5px 10px;float:right;line-height:1">{{$button_text}}</a>
                @endif
                @if(!Auth::guard('employers')->user() && !Auth::guard('candidate')->user())
                <a href="{{ route('front_end-signup') }}" class="btn-apply " style="padding: 5px 10px;float:right;line-height:1">Apply Now</a>
                @endif
                @if(Auth::guard('employers')->check())
                <a href="javascript:void(0)" style="cursor: not-allowed;" class="btn-apply " style="padding: 5px 10px;float:right;line-height:1">{{$button_text}}</a>
                @endif
            </div>
        </div>



        <!-- <hr/> -->
    </div>

</span>

@endforeach
@endif
