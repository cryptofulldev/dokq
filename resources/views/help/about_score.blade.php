@extends('layout')
@section('styles')
    <style>
    	.table tr td{
    		text-align: center;
    	}
    </style>
@stop
@section('breadcrumb')
	<div class="breadcum">
	    <div class="container">
	        <ol class="breadcrumb">
	            <li>
	                <a href="{{url('/')}}">
	                	読Qトップ
	                </a>
	            </li>
	            <li class="hidden-xs">
                	<a href="{{url('/about_site')}}"> > 読Qとは</a>
	            </li>
	            <li class="hidden-xs">
                	<a href="#"> > 読Ｑの使い方</a>
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="row">
				<div class="col-md-12" style="margin-bottom:1%">
					<span class="" style="color: #80b8e6; border-bottom: 5px solid #feb8ce; font-size: 300%; font-weight: bolder; text-stroke:#feb8ce; text-shadow: 2px 2px 0px #FFFFFF, 5px 4px 0px rgba(0,0,0,0.15), 8px 0px 3px #feb8ce; padding-right: 10%">読Ｑの使い方&nbsp;&nbsp;&nbsp;</span>
				</div>
			</div>
			<iframe class="iframe_help_score" src="{{asset('/manual/guide_site.pdf')}}"></iframe>
		</div>
	</div>
@stop
@section('scripts')
    
@stop