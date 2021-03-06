@extends('layout')

@section('styles')
    
@stop
@section('breadcrumb')
	<div class="breadcum">
	    <div class="container-fluid">
	    	<div class="row">
		        <ol class="breadcrumb">
		            <li>
		                <a href="{{url('/')}}">
		                	読Qトップ
		                </a>
		            </li>
		            <li class="hidden-xs">
			            > 	<a href="{{url('/top')}}">協会トップ</a>
		            </li>
		            <li class="hidden-xs">
	                	> 退会手続き中リスト		

		            </li>
		        </ol>
	        </div>
	    </div>
	</div>
@stop
@section('contents')

	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">退会手続き中リスト</h3>
			<div class="row">
				<div class="col-md-12">
					@if(isset($message))
					<div class="alert alert-info alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
						<strong>お知らせ!</strong>
						<p>
							{{$message}}
						</p>
					</div>
					@endif
					<table class="table table-hover table-bordered">
					    <thead>
					      <tr  class="bg-primary">
					        <th>退会連絡日</th>
					        <th>氏名</th>
					        <th>読Qネーム</th>
					        <th>年齢</th>
					        <th>級</th>
					        <th>入会日</th>
					        <th>分類</th>
					        <th>都道府県</th>
                            <th>メールアドレス</th>
                            <th>paypal停止日</th>
                            <th>完了メール送信</th>
                            <th>送信日</th>
					      </tr>
					    </thead>
					    <tbody class="text-md-center">
							@foreach ($users as $user)
							<tr class="text-md-center">
								<td class="align-middle col-md-1">{{ with(date_create($user->escape_date))->format('Y/m/d') }}</td>
								<td class="align-middle col-md-1"><a id="user_a" href="{{url('mypage/other_view/' . $user->id)}}" class="font-blue" oncontextmenu="handleRightClick('{{$user->id}}','{{$user->email}}','{{$user->active}}'); return false;">@if($user->isAuthor()){{ $user->fullname_nick() }}@else{{ $user->fullname() }}@endif</a></td>
								<td class="align-middle col-md-1">{{ $user->username }}</td>
								<td class="align-middle col-md-1">{{ date_diff(date_create($user->birthday ), date_create('today'))->y }}</td>
								<td class="align-middle col-md-1">{{$user->level}}</td>
								<td class="align-middle">{{$user->replied_date2? with(date_create($user->replied_date2))->format('Y/m/d'): ""}}</td>
								<td class="align-middle col-md-1">{{config('consts')['USER']['TYPE'][$user->role]}}</td>
								<td class="align-middle col-md-1">{{ $user->address1."  ".$user->address2 }}</td>
								<td class="align-middle"><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
								<td class="align-middle">
									@if ($user->paypal_stop_date != null)
									<input required type="text" readonly="true" name="paypal_stop_date" value="{{ $user->paypal_stop_date }}" id="paypal_stop_date" user_id="{{$user->id}}" class="big-form-control date-picker paypal_stop_date" placeholder="（西暦を２回タップして選択）">
									@else
									<input required type="text" readonly="true" name="paypal_stop_date" value="{{ old('paypal_stop_date') }}" id="paypal_stop_date" user_id="{{$user->id}}" class="big-form-control date-picker paypal_stop_date" placeholder="（西暦を２回タップして選択）">
									@endif
									@if ($errors->has('paypal_stop_date'))
									<span class="form-control-feedback">
										<span>{{ $errors->first('paypal_stop_date') }}</span>
									</span>
									@endif
								</td>
								<td class="align-middle">
									@if (!$user->unsubscribe_date) 
									<a class="btn btn-email btn-warning" href="#" user_id="{{$user->id}}" style="padding-top: 0; padding-bottom:0; color: #FFF; font-weight:600">送信</a>
									@else
									{{"送信済"}}
									@endif
								</td>
								<td class="align-middle">{{$user->unsubscribe_date? with(date_create($user->unsubscribe_date))->format('Y/m/d'): ""}}</td>
								
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<div id="popup" style="display:none;z-index:1000;">
               <div id="email_tag" style="padding:5px;padding-left:10px;padding-right:10px;text-align:center;"><a href='#' >Eメールを送る</a></div>  
               <div id="userdata_tag" style="padding:5px;padding-left:10px;padding-right:10px;text-align:center;"><a  href="javascript:;" style='pointer-events:none;color:#757b87;'>データ画面へ遷移</a></div>    
		    </div>	
			<div class="row">
				<div class="col-md-12">
					<a href="{{url('/top')}}" class="btn btn-info pull-right" role="button">協会トップへ戻る</a>
				</div>
			</div>
		</div>
	</div>

@stop
@section('scripts')
	<script type="text/javascript">
	 function handleRightClick(user_id, user_email, user_active) {
            
		//$("#testvalue").html(user_id);  
		//mailto(user_email);
		var str="<a href='mailto:"+user_email+"' style='color:#757b87;'>Eメールを送る</a>"	
		$("#email_tag").html(str);
		
		if(user_active == 1){
			$("#userdata_tag").attr('disabled', true);
		}
		var str="<a href='/admin/personaldata/"+user_id+"' style='color:#757b87;'>データ画面へ遷移</a>"	
			$("#userdata_tag").html(str);
     };
         
	$(function () {
		var $contextMenu = $("#contextMenu");
		$("body").click(function(){
			$("#popup").hide();
		});
		$("body").on("contextmenu", "a#user_a", function(e) {
		    $contextMenu.css({
		      display: "block",
		      left: e.pageX,
		      top: e.pageY
		    });
		   
		    $("#popup").show();
		    $("#popup").css("position","absolute");
		    $("#popup").css("left",e.pageX-30);
		    $("#popup").css("top",e.pageY-120);
		    return false;
		});

		$(".btn-email").on("click", function(e){
			e.preventDefault();
			var user_id = $(this).attr("user_id");
			var paypal_stop_date = "";
			//  href="{{url('/admin/unsubscribe_email/'.$user->id)}}"
			$(".paypal_stop_date").each(function () {
				var user = $(this).attr("user_id");
				if (user == user_id) {
					paypal_stop_date = $(this).val();
				}
			})
			var info = {
				_token: $('meta[name="csrf-token"]').attr('content'),
				paypal_stop_date: paypal_stop_date
			}
			var err = "<?php echo config('consts')['MESSAGES']['EMAIL_SERVER_ERROR'] ?>";
			var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/admin/unsubscribe_email/" + $(this).attr('user_id');
			$.ajax({
				type: "get",
				url: post_url,
				data: info,
				beforeSend: function (xhr) {
					var token = $('meta[name="csrf-token"]').attr('content');
					if (token) {
								return xhr.setRequestHeader('X-CSRF-TOKEN', token);
					}
				},
				success: function (response){
					console.log("response", response);
					if(response.success == true){
						location.reload();
					} else {
						window.alert(err);
					}
				}
			});
		});

	});
	$("#phone").inputmask("mask", {
		"mask": "<?php echo config('consts')['PHONE_MASK'] ?>"
	});

	var handleDatePickers = function () {
		if (jQuery().datepicker) {
				$('.date-picker').datepicker({
						rtl: Metronic.isRTL(),
						orientation: "left",
						autoclose: true,
						language: 'ja'
				});
		}
	}

	handleDatePickers();

</script>
	<script type="text/javascript" src="{{asset('js/group/group.js')}}"></script>
@stop