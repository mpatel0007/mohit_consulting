@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Blog Detail')
@section('pageheader', 'Blog Detail')
@section('content')
    <div id="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-xs-12">
                    <div class="blog-post">
                    
                        <div class="post-thumb">
                            <a href="#"><img class="img-fulid" src="{{ asset('assets/admin/blogs/blog_details/'.$blogData->image.'') }}" alt="blog Image"></a><div class="hover-wrap"></div>
                        </div>

                        <div class="post-content">
                            <h3 class="post-title">{{$blogData->title}}</h3>
                            <div class="meta">
                                <span class="meta-part"><i class="lni-user"></i> By Admin</span>
                                @php
                                    $oldDate = $blogData->created_at;
                                    $newDate = date("F j, Y", strtotime($oldDate));  
                                @endphp
                                <span class="meta-part"><i class="lni-calendar"></i> {{$newDate}}</span>
                            </div>
                           <p>{!! $blogData->description !!}</p>
                        </div>
                    </div>
                </div>

                <aside id="sidebar" class="col-lg-4 col-md-12 col-xs-12">
                    <div class="widget">
                        <h5 class="widget-title">Recent Post</h5>
                        <div class="widget-popular-posts widget-box">
                            <ul class="posts-list">
                                @foreach ($allBlog as $Blog)                            
                                <li>
                                    @php
                                        $oldDate = $blogData->created_at;
                                        $CreatedDate = date("F j, Y", strtotime($oldDate));  
                                    @endphp
                                    <div class="widget-content">
                                        <a href="{{ route('front_end-blog_details', ['blogId' => $Blog['id']]) }}">{{$Blog['title']}}</a>
                                        <span><i class="lni-calendar"></i> {{$CreatedDate}}</span>
                                    </div>
                                    <div class="clearfix"></div>
                                </li>                                    
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="widget" style="display:none;">
                        <h5 class="widget-title">Tags</h5>
                        <div class="tag widget-box">
                            <a href="#"> Jobpress</a>  
                            <a href="#"> Recruiter</a>
                            <a href="#"> Interview</a>
                            <a href="#"> Employee</a>
                            <a href="#"> Labor</a>
                            <a href="#"> HR</a>
                            <a href="#"> Salary</a>
                            <a href="#"> Employer</a>
                        </div>
                    </div>
                </aside>

            </div>
        </div>
    </div>
@endsection
@section('footersection')
    {{-- <script type="text/javascript" src="{{ asset('assets/front_end/js/candidate/findjobs.js') }}"></script> --}}
@endsection
