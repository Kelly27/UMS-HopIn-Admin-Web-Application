@extends('layouts.app_layout')

@section('title')
<i class="menu-i material-icons">announcement</i><b style="font-size: large;">Announcement Manager</b>
@endsection

@section('content_style')
<link rel="stylesheet" type="text/css" href="{{asset('css/announcement.css')}}">
@endsection

@section('content')
    <div class="createAnnoucementPage createPage container-fluid contentPage">
        <div class="row">
            <div class="col-sm-10">
                <h3>Create Announcement</h3>
            </div>
            @php
            if(Request::segment(3) == 'edit'){
                $url = 'updateAnnouncement';
            }
            else if(Request::segment(3) == 'create'){
                $url = 'storeAnnouncement';
            }

            @endphp
            {{ Form::open(['url' => route($url, ['id' => Request::segment(2)]), 'method' => 'post']) }}
            <div class="col-sm-2" style="padding-top: 20px;">
                <a href="#"><button class="btn basic-btn submit-btn">Submit</button></a>
            </div>
        </div>
        <div class="inputForm">
            <div class="row">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="col-sm-12">
                    <h5>Title</h5>
                    @if(isset($title))
                        {{Form::text('title', $title)}}
                    @else
                        {{Form::text('title')}}
                    @endif
                    <h5>Content</h5>
                    @if(isset($content))
                        {{Form::textarea('content', $content, ['size' => '110x10'])}}
                    @else
                        {{Form::textarea('content', null, ['size' => '110x10'])}}
                    @endif
                </div>
            </div>
            {{ Form::close()}}
        </div>
    </div>
@endsection

@section('script')
<script type="text/javascript" src="{{asset('js/tinymce/js/tinymce/tinymce.min.js')}}"></script>
<script type="text/javascript">
    tinymce.init({
        selector: 'textarea',
        plugins : 'advlist autolink link image lists charmap print preview',
        skin: 'lightgray'
    });

</script>
@endsection