@extends('layout')

@section('styles')
    <style type="text/css">
    	.btn{
    		margin-bottom: 10px;
    	}
    	.form-group{
    		margin-left: 0px;
    		margin-right: 0px;
    		margin-bottom: 30px;
    	}
    </style>
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
                        >   <a href="{{url('/top')}}">協会トップ</a>
                    </li>
                    <li class="hidden-xs">
                        > 会員検索
                    </li>
                </ol>
            </div>
        </div>
    </div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="page-head">
				<div class="page-title">
					<h3>会員検索 : （マイ書斎閲覧、連絡帳へ個別メッセージ）</h3>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<ul class="nav nav-pills">
						<li @if(!isset($act)) class="active" @endif><a data-toggle="pill" href="#single">1名（1団体）を検索する場合</a></li>
						<li @if(isset($act) && $act == 'several') class="active" @endif><a data-toggle="pill" href="#several">複数の会員を検索する場合（ひとつ以上入力または選択）</a></li>
					</ul>
					<div class="tab-content">
						<div id="single" class="tab-pane fade  @if(!isset($act)) in active @endif">
							
								<form class="form-horizontal" action="{{url('/admin/mem_search_result')}}" method="post" id="mem-search-form">
									{{ csrf_field() }}
									<div class="form-group"  style="margin-top: 30px;">
										<label class="offset-md-1 control-label col-md-1" style="color:white">読Qネーム</label>
										<div class="col-md-2"><input type='text' class="form-control" id="username" name="username" value="{{ old('username') }}"></div>
										<label class="control-label col-md-1" style="color:white">姓</label>
										<div class="col-md-2"><input type='text' class="form-control" id="firstname" name="firstname" value="{{ old('firstname') }}"></div>
										<label class="control-label col-md-1" style="color:white">名</label>
										<div class="col-md-2"><input type='text' class="form-control" id="lastname" name="lastname" value="{{ old('lastname') }}"></div>
									</div>
								</form>
								<div class="row">
									<div class="offset-md-3 col-md-5 text-md-center">
									<span class="form-control-feedback">
										@if ($errors->has('nouser'))
										<span class="offset-md-3 col-md-5 text-md-center" style="color:#ff005e;font-size:16px">
										{{ $errors->first('nouser') }}
										</span>	
										@endif
									</span>															
									</div>
								</div>
								<div class="row">
									<div class="offset-md-3 col-md-5 text-md-center">
										<button id="next_btn1" class="btn btn-primary">実　行</button>	
										<button type="button" class=" btn btn-danger btn_cancel" >キャンセル</button>														
									</div>
								</div>
								<table class="table table-striped table-bordered table-hover dataTable no-footer">
									<thead>
										<tr class="blue text-md-center">
											<th colspan="5" style="padding:0px;border:0.1px solid #ddd;vertical-align:middle;" width="15%">連絡帳メッセージ個別送信履歴</th>
										</tr>
										<tr class="blue text-md-center">
											<th rowspan="2" style="padding:0px;border:1px solid #ddd;vertical-align:middle;" width="15%">日時</th>
											<th style="padding:0px;vertical-align:middle;" width="15%">発信者</th>
											<th colspan="2" style="padding:0px;border:1px solid #ddd;vertical-align:middle;">宛　　先</th>
											<th rowspan="2" style="padding:0px;border:1px solid #ddd;vertical-align:middle;" width="50%">文面</th>
										</tr>
										<tr class="blue text-md-center">
											<th style="padding:0px;vertical-align:middle;">協会員ID</th>
											<th style="padding:0px;vertical-align:middle;" width="10%">読Ｑネーム</th>
											<th style="padding:0px;vertical-align:middle;" width="10%">名前・団体名</th>
											
										</tr>
									</thead>
									
									<tbody class="text-md-center">
										@foreach($messages1 as $message)
											<tr>
												<td style="vertical-align:middle;">{{$message->created_at}}</td>
												<td style="vertical-align:middle;">@if(isset($message->adminname) && $message->adminname != '' && $message->adminname !== null){{$message->adminname}} @else 協会 @endif</td>
												<td style="vertical-align:middle;">@if(isset($message->username) && $message->username != '' && $message->username !== null) 
																						@if($message->role != config('consts')['USER']['ROLE']['GROUP'] && $message->role != config('consts')['USER']['ROLE']['ADMIN'])
																							<a href="{{url('mypage/other_view/' . $message->to_id)}}" class="font-blue">{{$message->username}} </a>
																						@else
																							{{$message->username}}
																						@endif
																				   @endif</td>
												<td style="vertical-align:middle;">@if($message->role == config('consts')['USER']['ROLE']['AUTHOR']){{$message->firstname_nick.' '.$message->lastname_nick}}
													@elseif($message->role == config('consts')['USER']['ROLE']['GROUP']) {{$message->group_name}}
													@else {{$message->firstname.' '.$message->lastname}}
													@endif</td>
												<td class="text-md-left" style="vertical-align:middle;"><?php echo $message->content ?></td>
											</tr>	
										@endforeach
									</tbody>
								</table>
								<div class="form-group"  style="text-align:right;">
									<a href="{{url('/admin/messages1')}}" class="news-block-btn font-white-madison" style="color:#ffffff;">もっと見る</a>
								</div>
						</div>
						<div id="several" class="tab-pane fade @if(isset($act) && $act == 'several')in active @endif">
							<form class="form form-horizontal" action="{{url('/admin/several_search_result')}}" id="search-form" method="post">
								{{ csrf_field() }}
								<div class="row" style="margin-top: 30px;">
									<div class="row col-md-12" >
										<div class="col-md-4">
											<label class="col-form-label col-md-4 text-md-right" style="color:white">都道府県</label>
											<div class="col-md-8"><input type='text' class="form-control" id="address1" name="address1" value="{{old('address1')}}" placeholder="神奈川県"></div>										
										</div>
										<div class="col-md-4">
											<label class="col-form-label col-md-4 text-md-right" style="color:white">市区郡町村</label>
											<div class="col-md-8"><input type='text' class="form-control" id="address2" name="address2" value="{{old('address2')}}" placeholder="横浜市青葉区"></div>										
										</div>
										<div class="col-md-4" >
											<label class="col-form-label col-md-4 text-md-right" style="color:white">性別</label>
											<div class="col-md-8">
												<select class="form-control select2me" name="gender" id="gender" placeholder="選択...">
													<option></option>
													<option value="2" @if(old('gender') == 2) selected @endif>男</option>
													<option value="1" @if(old('gender') == 1) selected @endif>女</option>
												</select>
											</div>
										</div>
									</div>
									<div class="row col-md-12" style="margin-top: 10px;">
										
										<div class="col-md-4">
											<label class="col-form-label col-md-4 text-md-right" style="color:white">
												級
											</label>
											<div class="col-md-8">
												<select class="form-control select2me" name="rank" id="rank" placeholder="選択...">
													<option></option>
													<option value="11" @if(old('rank') == 11) selected @endif>10級</option>
													<option value="10" @if(old('rank') == 10) selected @endif>9級</option>
													<option value="9" @if(old('rank') == 9) selected @endif>8級</option>
													<option value="8" @if(old('rank') == 8) selected @endif>7級</option>
													<option value="7" @if(old('rank') == 7) selected @endif>6級</option>
													<option value="6" @if(old('rank') == 6) selected @endif>5級</option>
													<option value="5" @if(old('rank') == 5) selected @endif>4級</option>
													<option value="4" @if(old('rank') == 4) selected @endif>3級</option>
													<option value="3" @if(old('rank') == 3) selected @endif>2級</option>
													<option value="2" @if(old('rank') == 2) selected @endif>1級</option>
													<option value="1" @if(old('rank') == 1) selected @endif>初段</option>
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<label class="col-form-label col-md-4 text-md-right" style="color:white">
												会員種類
											</label>
											<div class="col-md-8">
												<select class="form-control select2me" name="action" id="action" placeholder="選択...">
													<option></option>
													<option id="action1" value="1" @if(old('action') == 1) selected @endif>一般</option>
													<option id="action2" value="2" @if(old('action') == 2) selected @endif>監修者</option>
													<option id="action3" value="3" @if(old('action') == 3) selected @endif>著者</option>
													<option id="action4" value="4" @if(old('action') == 4) selected @endif>生徒</option>
													<option id="action5" value="5" @if(old('action') == 5) selected @endif>教師（代表、IT担当、司書を除く）</option>
													<option id="action6" value="6" @if(old('action') == 6) selected @endif>代表（校長など）</option>
													<option id="action7" value="7" @if(old('action') == 7) selected @endif>IT担当者</option>
													<option id="action8" value="8" @if(old('action') == 8) selected @endif>司書</option>
													<option id="action9" value="9" @if(old('action') == 9) selected @endif>団体（学校）</option>
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<label class="col-form-label col-md-4 text-md-right" style="color:white">
												年代
											</label>
											<div class="col-md-8">
												<select class="form-control select2me" name="years" id="years" placeholder="選択...">
													<option></option>
													<option id="years1" value="1" @if(old('years') == 1) selected @endif>小学生</option>
													<option id="years2" value="2" @if(old('years') == 2) selected @endif>中学生</option>
													<option id="years3" value="3" @if(old('years') == 3) selected @endif>高校生</option>
													<option id="years4" value="4" @if(old('years') == 4) selected @endif>大学生</option>
													<option value="5" @if(old('years') == 5) selected @endif>１０代</option>
													<option value="6" @if(old('years') == 6) selected @endif>２０代</option>
													<option value="7" @if(old('years') == 7) selected @endif>３０代</option>
													<option value="8" @if(old('years') == 8) selected @endif>４０代</option>
													<option value="9" @if(old('years') == 9) selected @endif>５０代</option>
													<option value="10" @if(old('years') == 10) selected @endif>６０代</option>
													<option value="11" @if(old('years') == 11) selected @endif>７０代</option>
													<option value="12" @if(old('years') == 12) selected @endif>８０代以降全ての年代</option>
												</select>
											</div>
										</div>				
									</div>
								</div>
							</form>

							<div class="row">
							<div class="offset-md-3 col-md-5 text-md-center">
								<span class="form-control-feedback">
									@if ($errors->has('nouser'))
									<span class="offset-md-3 col-md-5 text-md-center" style="color:#ff005e;font-size:16px">
									{{ $errors->first('nouser') }}
									</span>	
									@endif
								</span>															
								</div>
							</div>
							<div class="row">
								<div class="offset-md-3 col-md-5 text-md-center">
									<button id="next_btn2" class="btn btn-primary">実　行</button>	
									<button type="button" class=" btn btn-danger btn_cancel" >キャンセル</button>														
								</div>
							</div>
							<table class="table table-striped table-bordered table-hover dataTable no-footer">
								<thead>
									<tr class="blue text-md-center">
										<th colspan="10" style="padding:0px;border:0.1px solid #ddd;vertical-align:middle;" width="100%">連絡帳メッセージ 一斉送信履歴</th>
									</tr>
									<tr class="blue">
										<th rowspan="2" style="padding:0px;vertical-align:middle;" width="8%">日時</th>
										<th rowspan="2" style="padding:0px;vertical-align:middle;" width="10%">協会員ID</th>
										<th colspan="6" style="padding:0px;border:1px solid #ddd;vertical-align:middle;">送信先検索条件</th> 
										<th rowspan="2" style="padding:0px;vertical-align:middle;" width="30%">文面</th>
										<th rowspan="2" style="padding:0px;;vertical-align:middle;" width="10%">人数</th>
									</tr>
									<tr class="blue">
										 <th style="padding:0px;vertical-align:middle;" width="9%">都道府県</th>
										<th style="padding:0px;vertical-align:middle;" width="9%">市区郡町村</th>
										<th style="padding:0px;vertical-align:middle;" width="6%">性別</th>
										<th style="padding:0px;vertical-align:middle;" width="6%">級</th>
										<th style="padding:0px;vertical-align:middle;" width="7%">会員種別</th>
										<th style="padding:0px;vertical-align:middle;" width="6%">年代</th> 
									</tr>
								</thead>

								<tbody class="text-md-center">
									@foreach($messages2 as $message)
									    
										<tr>
											<td style="vertical-align:middle;">{{$message->created_at}}</td>
											<td style="vertical-align:middle;">@if(isset($message->adminname) && $message->adminname != '' && $message->adminname !== null){{$message->adminname}} @else 協会 @endif</td>
											<td style="vertical-align:middle;">@if(isset($message->search_address1)){{$message->search_address1}} @endif</td>
											<td style="vertical-align:middle;">@if(isset($message->search_address1)){{$message->search_address2}} @endif</td>
											<td style="vertical-align:middle;">@if(isset($message->search_gender)) {{$message->search_gender}} @endif</td>
											<td style="vertical-align:middle;">@if(isset($message->search_rank)){{$message->search_rank}} @endif</td>
											<td style="vertical-align:middle;">@if(isset($message->search_action)) {{$message->search_action}} @endif</td>
											<td style="vertical-align:middle;">@if(isset($message->search_year)) {{$message->search_year}} @endif</td>
											<td class="text-md-left" style="vertical-align:middle;"><?php echo $message->content ?></td>
											<td style="vertical-align:middle;">@if(isset($message->message_ct) && $message->message_ct == 1)	
																					@if($message->role != config('consts')['USER']['ROLE']['GROUP'] && $message->role != config('consts')['USER']['ROLE']['ADMIN'])
																						<a href="{{url('mypage/other_view/' . $message->to_id)}}" class="font-blue">{{$message->username}} </a>
																					@else
																						{{$message->username}}
																					@endif
																				 @else 
																				 	{{$message->message_ct}} 
																				 @endif</td>
										</tr>	
									@endforeach
								</tbody>
							</table>
							<div class="form-group"  style="text-align:right;">
								<a href="{{url('/admin/messages2')}}" class="news-block-btn font-white-madison" style="color:#ffffff;">もっと見る</a>
							</div>
						</div>
						
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12" style="margin-top:8px">
					<a href="{{url('/top')}}" class="btn btn-info pull-right" role="button">協会トップへ戻る</a>
				</div>
			</div>
		</div>
	</div>

<div id="alertModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
        	<h4 class="modal-title"><strong>エラー</strong></h4>
      	</div>
      	<div class="modal-body">
        	<span id="alert_text"></span>
     	</div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-info" >確　認</button>
        </div>
    </div>
  </div>
</div>
@stop
@section('scripts')
 <script>
	   $(document).ready(function(){
	   		$("#next_btn1").click(function(){
	   			
   				if ($("#username").val() == null || $("#username").val() == ''){
	                if(($("#firstname").val() == null || $("#firstname").val() == '') && ($("#lastname").val() == null || $("#lastname").val() == '')){
		                $("#alert_text").html("{{config('consts')['MESSAGES']['USERNAME_REQUIRED']}}");
		                $("#alertModal").modal();
		                $("#username").focus();
		                return;
		            }

		            if(($("#firstname").val() == null || $("#firstname").val() == '') && ($("#lastname").val() !== null && $("#lastname").val() != '')){
		    		
		                $("#alert_text").html("{{config('consts')['MESSAGES']['FIRSTNAME_REQUIRED']}}");
		                $("#alertModal").modal();
		                $("#firstname").focus();
		                return;
			    	    
			    	}

			    	if(($("#lastname").val() == null || $("#lastname").val() == '') && ($("#firstname").val() !== null && $("#firstname").val() != '')){
		    		    $("#alert_text").html("{{config('consts')['MESSAGES']['LASTNAME_REQUIRED']}}");
		                $("#alertModal").modal();
		                $("#lastname").focus();
		                return;
			    	     
			    	}
	    	    } 
		    	$("#mem-search-form").submit();
	   			
			});	
			
			$("#next_btn2").click(function(){
	   			//if($('#several').hasClass('active')){

	   				if($("#address1").val() == '' && $("#address2").val() == '' && $("#gender").val() == '' && $("#rank").val() == '' && $("#action").val() == '' && $("#years").val() == ''){
	   					
   						$("#alert_text").html("{{config('consts')['MESSAGES']['SEARCH_REQUIRED']}}");
		                $("#alertModal").modal();
		                return;
	   					
	   					
	   					
	   				}
	   				/*if($("#address1").val() == null || $("#address1").val() != ''){
	   					if($("#address2").val() == null || $("#address2").val() == ''){
	   						$("#alert_text").html("{{config('consts')['MESSAGES']['ADDRESS2_REQUIRED']}}");
			                $("#alertModal").modal();
			                return;
	   					}
	   				}

	   				if($("#address2").val() == null || $("#address2").val() != ''){
	   					if($("#address1").val() == null || $("#address1").val() == ''){
	   						$("#alert_text").html("{{config('consts')['MESSAGES']['ADDRESS1_REQUIRED']}}");
			                $("#alertModal").modal();
			                return;
	   					}
	   				}*/

	   				$("#search-form").submit();
	   			//}
			});

			$('#action').change(function(){
   				if ($('#action').val() == 4) {
   					$("#years1").attr("disabled", false);
   					$("#years2").attr("disabled", false);
   					$("#years3").attr("disabled", false);
   					$("#years4").attr("disabled", false);
   				}else{
   					$("#years1").attr("disabled", true);
   					$("#years2").attr("disabled", true);
   					$("#years3").attr("disabled", true);
   					$("#years4").attr("disabled", true);
   				}
   			});
   			$('#years').change(function(){
   				if ($('#years').val() == 1 || $('#years').val() == 2 || $('#years').val() == 3 || $('#years').val() == 4) {
   					$("#action1").attr("disabled", true);
   					$("#action2").attr("disabled", true);
   					$("#action3").attr("disabled", true);
   					$("#action5").attr("disabled", true);
   					$("#action6").attr("disabled", true);
   					$("#action7").attr("disabled", true);
   					$("#action8").attr("disabled", true);
   					$("#action9").attr("disabled", true);
   				}else{
   					$("#action1").attr("disabled", false);
   					$("#action2").attr("disabled", false);
   					$("#action3").attr("disabled", false);
   					$("#action5").attr("disabled", false);
   					$("#action6").attr("disabled", false);
   					$("#action7").attr("disabled", false);
   					$("#action8").attr("disabled", false);
   					$("#action9").attr("disabled", false);
   				}
   			});	

   			$('.btn_cancel').click(function(){
				//location.reload();
				$("input").val('');
				var rank = $("#rank").select2();
				var action = $("#action").select2();
				var years = $("#years").select2();
				var gender = $("#gender").select2();
				rank.select2('val', ""); //初期化
				action.select2('val', ""); //初期化
				years.select2('val', ""); //初期化
				gender.select2('val', ""); //初期化
				/*$(".form-control").each(function(index, item){
					$(item).val("");
				})
				
				if ($("select[name=rank]").val()== 1){
					$(".param").each(function(index, item){
						if($(item).val() == '')
							$(item).val("0");
					})
					$("input[name=total_chars]").val("");
					$("input[name=point]").val(0);
				}

				var isChecked = $(this).parent().hasClass("checked")?true:false;
		    	$(".checkboxes").parent().removeClass("checked");*/
			});	
		});
 </script>
@stop