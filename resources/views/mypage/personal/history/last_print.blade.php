
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/tr/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta id="token" name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/news.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/simple-line-icons/simple-line-icons.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/uniform/css/uniform.default.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap-select/bootstrap-select.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap-toastr/toastr.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/select2/select2.css')}}"/>    
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap-datepicker/css/datepicker3.css')}}">
   
    <link rel="stylesheet" type="text/css" href="{{asset('css/plugins.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/components-rounded.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/frontend/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/frontend/style-responsive.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/frontend/themes/blue.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/themes/darkblue.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/lib.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/custom.css')}}" media="print">
    <link rel="stylesheet" type="text/css" href="{{asset('datatables/plugins/bootstrap/dataTables.bootstrap.css')}}"/>
   <style type="text/css">
   		.chart_kind{
   			float: left;
   		}
   		.chart_kind ul{
   			margin-left: -7%;
   		}
   		.chart_kind ul li{
   			float: left;
   			padding: 0 35px;
   		}
   		.chart_kind ul li.clast{
   			margin-left: 0%;
   		}
   		.chart-holder {
		  width: 120%;
		  height: 325px;
		}
   </style>
</head>
<body style='width: 21cm; height:29.7cm'>

<script src="{{asset('js/charts/Chart.js')}}"></script>
	<div align='left' name = "idprint">
		<div class="page-content-wrapper">
			<div class="page-content">
				<h3 class="page-title col-md-11">
					{{$current_season["year"]}}年度{{$current_season['season']}}末　読Qレポート<br>
					<small>{{$current_season['from'] . '～' . $current_season['to']}}</small>
				</h3>
				
				<h4 class="font-blue">
					今期まとめ　{{$current_season['to']}}現在
				</h4>
				
				<table class="table table-no-border">
					<tr>
						<td width="50%">現時点の読Q資格</td>
						<td width="50%">@if (isset($current_user)) {{$current_user->degree}} @endif</td>
					</tr>
					<tr name = "student_show" id = "student_show" style = "display:none">
						<td>今期目標達成率</td>
						<td>@if (isset($current_user)){{$current_user->target_percent}} @endif％</td>
					</tr>
					<tr>
						<td>今期得たポイント</td>
						<td>@if (isset($current_user)){{$current_user->threemonth_point}} @endifポイント</td>
					</tr>
					<tr>
						<td>合格ポイント</td>
						<td>@if (isset($current_user)){{$current_user->success_point}}  @endifポイント</td>
					</tr>
					<tr>
						<td>書籍登録ポイント</td>
						<td>@if (isset($current_user)){{$current_user->bookregister_point}}  @endifポイント</td>
					</tr>
					<tr>
						<td>ｸｲｽﾞ作成ポイント</td>
						<td>@if (isset($current_user)){{$current_user->quizregister_point}}  @endifポイント</td>
					</tr>
					<tr>
						<td>今期までの生涯ポイント</td>
						<td>@if (isset($current_user)){{$current_user->all_point}} @endifポイント</td>
					</tr>
					<tr>
						<td>昇級まであと</td>
						<td>@if (isset($current_user)){{$current_user->remain_point}} @endifポイント</td>
					</tr>
				</table>
				
				@if($current_user->role == config('consts')['USER']['ROLE']["PUPIL"] && $current_user->type == 0)
				<h4 class="font-blue">
					現在までの各期　目標達成率　（同学年全国平均との比較）
				</h4>
				<div class="portlet-body col-md-12">
					<canvas id="bar" width="617" height="300" style="width: 617px; height: 300px;"></canvas>
					<div class="legend">
						<div style="position: absolute; width: 70px; height: 40px; top: 14px; right: 13px; background-color: rgb(255, 255, 255); opacity: 0.85;"> </div>
						<table style="position:absolute;top:14px;right:13px;font-size:smaller;color:#545454">
						<tbody>
						<tr>
						<td class="legendColorBox">
						<div style="border:1px solid #ccc;padding:1px">
						<div style="width:4px;height:0;border:5px solid #d0cece;overflow:hidden">
						</div>
						</div>
						</td>
						<td class="legendLabel">全国平均</td>
						</tr>
						<tr>
						<td class="legendColorBox">
						<div style="border:1px solid #ccc;padding:1px">
						<div style="width:4px;height:0;border:5px solid #f8cbad;overflow:hidden">
							
						</div>
						</div>
						</td>
						<td class="legendLabel">自分</td>
						</tr>
						
						</tbody></table>
					</div>
				</div>
				@else
				<div class="portlet-title">
					<div class="caption">
						3カ月間で獲得するポイント推移<span style="font-size:12px">（同年代全国平均との比較）</span>
					</div>
				</div>
				<div class="portlet-body  col-md-12" style="height: 350px;">
					<div id="target-chart" class="dqtarget-chart chart-holder" style="width: 480px; height: 320px;"></div>
				</div>
				@endif
				
				
				<h4 class="font-blue">読書推進活動ランキング<span class="font-blue" style="font-size:12px">（同年代内順位）</span></h4>

				<table class="table table-bordered table-hover" style="margin-bottom:0px">
					<thead>
						<tr class="yellow" style="width:100%">
							<th style="width:28%">本の登録とクイズ作成</th>
							<th style="width:18%">自分の読書<br>推進ポイント</th>
							<th style="width:18%">市区町村内順位<br>（位/人）</th>
							<th style="width:18%">都道府県内順位<br>（位/人）</th>
							<th style="width:18%">全国順位<br>（位/人）</th>
						</tr>
					</thead>
					<tbody  style="text-align:center">
						<tr class="warning">
							<td class="align-middle">{{$current_season['season']}}{{$current_season['from_num'] . '～' . $current_season['to_num']}}<br>(今　四半期)</td>
							<td class="align-middle">{{$current_user->quiz_point}}</td>
							<td class="align-middle">{{$current_user->quizcity_rank}}</td>
							<td class="align-middle">{{$current_user->quizprovince_rank}}</td>
							<td class="align-middle">{{$current_user->quizcountry_rank}}</td>
						</tr>
						<tr >
							<td class="align-middle">{{$before_season['season']}}{{$before_season['from_num'] . '～' . $before_season['to_num']}}<br>(今　四半期)</td>
							<td class="align-middle">{{$current_user->quiz_point_before}}</td>
							<td class="align-middle">{{$current_user->quizcity_rank_before}}</td>
							<td class="align-middle">{{$current_user->quizprovince_rank_before}}</td>
							<td class="align-middle">{{$current_user->quizcountry_rank_before}}</td>
						</tr>
						<tr class="warning">
							<td class="align-middle">{{$current_season['year']}}年度<br>（今年度通算）</td>
							<td class="align-middle">{{$current_user->quiz_point_this}}</td>
							<td class="align-middle">{{$current_user->quizcity_rank_this}}</td>
							<td class="align-middle">{{$current_user->quizprovince_rank_this}}</td>
							<td class="align-middle">{{$current_user->quizcountry_rank_this}}</td>
						</tr>
						<tr >
							<td class="align-middle">{{$current_season['year']-1}}年度<br>（前年度）</td>
							<td class="align-middle">{{$current_user->quiz_point_last}}</td>
							<td class="align-middle">{{$current_user->quizcity_rank_last}}</td>
							<td class="align-middle">{{$current_user->quizprovince_rank_last}}</td>
							<td class="align-middle">{{$current_user->quizcountry_rank_last}}</td>
						</tr>
						<tr class="warning">
							<td class="align-middle">生涯<br>（現在まで累計）</td>
							<td class="align-middle">{{$current_user->quiz_point_all}}</td>
							<td class="align-middle">{{$current_user->quizcity_rank_all}}</td>
							<td class="align-middle">{{$current_user->quizprovince_rank_all}}</td>
							<td class="align-middle">{{$current_user->quizcountry_rank_all}}</td>
						</tr>
					</tbody>
				</table>
				<a href="{{url('/mypage/rank_bq')}}" class="news-block-btn font-blue-madison"  style="float:right;margin-bottom:20px">もっと見る</a>
				<div class="clearfix"></div>

				<div class="news-blocks white">
					<div class="row">
						<div class="col-md-12">
							<h4 class="font-blue">今期({{$current_season['from']}}～{{$current_season['to']}})読んだ本棚</h4>
						</div>
						
						<div class="col-md-12">
							<table class="table table-bordered table-hover" style="height: 200px;">
								<tbody class="text-md-center">
									<tr style="width:100%;height: 300px;"> 
										@for($i = 0; $i < 8 - count($myBooks); $i++)
										<td style="width:12%;"></td>
										@endfor
										@foreach($myBooks as $book)
										<?php $myBook = preg_split('/:/', $book) ; $color = '';
											 if(isset($myBook[2]) && $myBook[2] >= 0 && $myBook[2] <= 2) $color = '#ffb5fc'; //help.about_target.blade.php
											  elseif(isset($myBook[2]) && $myBook[2] > 2 && $myBook[2] <= 5) $color = '#facaca';//ff0000 
											  elseif(isset($myBook[2]) && $myBook[2] > 5 && $myBook[2] <= 8) $color = '#f9d195'; //FF9900
											  elseif(isset($myBook[2]) && $myBook[2] > 8 && $myBook[2] <= 11) $color = '#f6f99a'; //f4fd00
											  elseif(isset($myBook[2]) && $myBook[2] > 11 && $myBook[2] <= 15) $color = '#e1f98f'; //d6f432
											  elseif(isset($myBook[2]) && $myBook[2] > 15 && $myBook[2] <= 19) $color = '#92fab2'; //26a69a
											  elseif(isset($myBook[2]) && $myBook[2] > 19 && $myBook[2] <= 25) $color = '#a7d4fb'; //5C9BD1
											  elseif(isset($myBook[2]) && $myBook[2] > 25) $color = '#f0f5fa';	
										?>
										<td class="text-md-center background_print" style="width:12%;background-color:{{$color}} !important;padding-left:0px;padding-right:0px;">
											<div class="row col-md-12" style="writing-mode:vertical-rl;margin-left:0px;margin-right:0px;padding-left:0px;padding-right:0px;height:200px;">
												<h5 class="font_gogic text-md-left" style="align-self:center;line-height:1.5;font-family:HGP明朝B;">
													@if(isset($myBook[0])) {{ $myBook[0] }} @endif
												</h5>
											</div>
											<div class="row col-md-12" style="writing-mode:vertical-rl;margin-left:0px;margin-right:0px;padding-left:0px;padding-right:0px;height:100px;">
												<h5 class="font_gogic text-md-left" style="align-self:center;line-height:1.5;font-family:HGP明朝B;">
													@if(isset($myBook[1])) {{ $myBook[1] }} @endif
												</h5>
											</div>
										</td>
										@endforeach		
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="news-blocks lime">
							<h4 class="font-blue" style="font-size:17px">
								今期、登録して認定された本
							</h4>
							
							<table class="table table-no-border">
								@foreach($myAllowedBooks as $book)
								<tr>
									<td width="100%" style="text-align:center">{{$book}}</td>
								</tr>
								@endforeach
							</table>
						</div>
					</div>
					<div class="col-md-6">
						<div class="news-blocks lime">
							<h4 class="font-blue" style="font-size:17px">
								今期、クイズを作成した本
							</h4>
							
							<table class="table table-no-border">
								@foreach($myAllowedQuizes as $book)
								<tr>
									<td width="100%" style="text-align:center">{{$book}}</td>
								</tr>
								@endforeach
							</table>
						</div>
					</div>
				</div>
				<h4 class="font-blue">マイ読書量順位</h4>
				<div class="portlet box ">
					<div class="portlet-title">
						<div class="caption">
							現在までの、獲得ポイント順位<span style="font-size:12px">（同年代と競うグラフ）</span>
						</div>
					</div>
					<div class="portlet-title" style="min-height:18px">
						<div class="row">
							<table class="col-md-12">
								<tr class="text-md-center">
									<td width="10%"></td>
									<td width="30%" style="text-align: center!important;">四半期（3カ月間）</td>
									<td width="30%" style="text-align: center!important;">年度（1年間）</td>
									<td width="30%" style="text-align: center!important;">生涯</td>
								</tr>
							</table> 
						</div>
					</div>
					@if($current_user->type == 0)
					<div class="portlet-body" style="height: 350px;">
						<div style = 'font-size:8px;position:relative;left:50px;top:0px;text-align:left'>(pt)</div>
						<div style="width:10%;float:left;text-align:left;height: 300px;"><span style="color:blue;vertical-align:middle;">クラス</span></div>
						<div id="threemonth-chart1" style="width:30%; float:left;" class="chart-holder"></div>
						<div id="horizontal-chart1" style="width:30%; float:left;" class="chart-holder"></div>
						<div id="all-chart1" style="width:30%; float:left;" class="chart-holder"></div>
					</div>
					<div class="portlet-body" style="height: 350px;">
						<div style = 'font-size:8px;position:relative;left:50px;top:0px;text-align:left'>(pt)</div>
						<div style="width:10%;float:left;text-align:left;height: 300px;"><span style="color:blue;vertical-align:middle;">学年</span></div>
						<div id="threemonth-chart2" style="width:30%; float:left;" class="chart-holder"></div>
						<div id="horizontal-chart2" style="width:30%; float:left;" class="chart-holder"></div>
						<div id="all-chart2" style="width:30%; float:left;" class="chart-holder"></div>
					</div>
					@endif
					<div class="portlet-body" style="height: 350px;">
						<div style = 'font-size:8px;position:relative;left:50px;top:0px;text-align:left'>(pt)</div>
						<div style="width:10%;float:left;text-align:left;height: 300px;"><span style="color:blue;vertical-align:middle;">市区<br>町村内</span></div>
						<div id="threemonth-chart3" style="width:30%; float:left;" class="chart-holder"></div>
						<div id="horizontal-chart3" style="width:30%; float:left;" class="chart-holder"></div>
						<div id="all-chart3" style="width:30%; float:left;" class="chart-holder"></div>
					</div>
					<div class="portlet-body" style="height: 350px;">
						<div style = 'font-size:8px;position:relative;left:50px;top:0px;text-align:left'>(pt)</div>
						<div style="width:10%;float:left;text-align:left;height: 300px;"><span style="color:blue;vertical-align:middle;">都道<br>府県内</span></div>
						<div id="threemonth-chart4" style="width:30%; float:left;" class="chart-holder"></div>
						<div id="horizontal-chart4" style="width:30%; float:left;" class="chart-holder"></div>
						<div id="all-chart4" style="width:30%; float:left;" class="chart-holder"></div>
					</div>
					<div class="portlet-body" style="height: 350px;">
						<div style = 'font-size:8px;position:relative;left:50px;top:0px;text-align:left'>(pt)</div>
						<div style="width:10%;float:left;text-align:left;height: 300px;"><span style="color:blue;vertical-align:middle;">国内</span></div>
						<div id="threemonth-chart5" style="width:30%; float:left;" class="chart-holder"></div>
						<div id="horizontal-chart5" style="width:30%; float:left;" class="chart-holder"></div>
						<div id="all-chart5" style="width:30%; float:left;" class="chart-holder"></div>
					</div>
					<input type="hidden" id="currentSeason" name="currentSeason" value="{{$current_season['term']}}">
					<input type="hidden" id="arraySeason" name="arraySeason" value="{{$current_season['term']}}">
				</div>
			</div>
		</div>	
	</div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{asset('plugins/jquery.min.js')}}"></script>
<script src="{{asset('plugins/tether-master/dist/js/tether.min.js')}}" ></script>
<script type="text/javascript" src="{{asset('plugins/bootstrap-4.0.0-alpha.6-dist/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/jquery-migrate.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/jquery.blockui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/jquery.cokie.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/uniform/jquery.uniform.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/bootstrap-select/bootstrap-select.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.ja.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/jquery-inputmask/jquery.inputmask.bundle.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/fuelux/js/spinner.min.js')}}"></script>
<script src="{{asset('plugins/typeahead/typeahead.bundle.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('js/metronic.js')}}"></script>
<script type="text/javascript" src="{{asset('js/layout.js')}}"></script>
<script type="text/javascript" src="{{asset('js/demo.js')}}"></script>
<script type="text/javascript" src="{{asset('js/layout-frontend.js')}}"></script>
<script src="{{asset('js/components-dropdowns.js')}}"></script>

<script src="{{asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/charts/Chart.js')}}"></script>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{asset('plugins/flot/jquery.flot.min.js')}}"></script>
<script src="{{asset('plugins/flot/jquery.flot.resize.min.js')}}"></script>
<script src="{{asset('plugins/flot/jquery.flot.pie.min.js')}}"></script>
<script src="{{asset('plugins/flot/jquery.flot.stack.min.js')}}"></script>
<script src="{{asset('plugins/flot/jquery.flot.crosshair.min.js')}}"></script>
<script src="{{asset('plugins/flot/jquery.flot.categories.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/Theme.js')}}"></script>
<script src="{{asset('js/Charts.js')}}"></script>
<script src="{{asset('js/flot/jquery.flot.js')}}"></script>
<script src="{{asset('js/flot/jquery.flot.orderBars.js')}}"></script>
<script src="{{asset('js/charts-flotcharts.js')}}"></script>
<script src="{{asset('js/components-dropdowns.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/jqwidgets/styles/jqx.base.css')}}" type="text/css" />
<script type="text/javascript" src="{{asset('css/jqwidgets/jqxcore.js')}}"></script>
<script type="text/javascript" src="{{asset('css/jqwidgets/jqxdraw.js')}}"></script>
<script type="text/javascript" src="{{asset('css/jqwidgets/jqxchart.core.js')}}"></script>
<script type="text/javascript" src="{{asset('css/jqwidgets/jqxdata.js')}}"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<script type="text/javascript">
		ComponentsDropdowns.init();
        Metronic.init();
        Layout.init();
        LayoutFrontend.init();
        Demo.init();

		@if ($current_user->type == 0)
			@if (isset($grade) && $grade != 0)
				$("#student_show").css('display','');
			@else
				$("#student_show").css('display','none');
			@endif
		@else
			$("#student_show").css('display','none');
		@endif

		var current_year = new Date().getYear() + 1900;
		var point_now = 0;
		var point = [];
		var avg_now = 0;
		var avg = [];
		var current_season = $("#currentSeason").val();
		
		@if($current_user->type == 0)
			var barChartData = {
				labels : ["{{$current_user->threemonth_name1}}","{{$current_user->threemonth_name2}}","{{$current_user->threemonth_name3}}","{{$current_user->threemonth_name4}}"],
				datasets : [
					{
						fillColor : "#d0cece",
						strokeColor : "#d0cece",
						data : [{{$current_user->threemonth_point1}},{{$current_user->threemonth_point2}},{{$current_user->threemonth_point3}},{{$current_user->threemonth_point3}}]
					},
					{
						fillColor : "#f8cbad",
						strokeColor : "#f8cbad",
						data : [{{$current_user->mythreemonth_point1}},{{$current_user->mythreemonth_point2}},{{$current_user->mythreemonth_point3}},{{$current_user->mythreemonth_point4}}]
					}
				]
			};
			new Chart(document.getElementById("bar").getContext("2d")).Bar(barChartData);
		@else
			//Interactive Chart
	        $(function () {
	            if ($('#target-chart').size() != 1) {
	                return;
	            }

	            var pageviews = [
	                [1,{{$current_user->threemonth_point1}}],
	                [2,{{$current_user->threemonth_point2}}],
	                [3,{{$current_user->threemonth_point3}}],
	                [4,{{$current_user->threemonth_point4}}],
	                [5,{{$current_user->threemonth_point5}}],
	                [6,{{$current_user->threemonth_point6}}],
	                [7,{{$current_user->threemonth_point7}}],
	                [8,{{$current_user->threemonth_point8}}],
	            ];
	            var visitors = [
	                [1,{{$current_user->mythreemonth_point1}}],
	                [2,{{$current_user->mythreemonth_point2}}],
	                [3,{{$current_user->mythreemonth_point3}}],
	                [4,{{$current_user->mythreemonth_point4}}],
	                [5,{{$current_user->mythreemonth_point5}}],
	                [6,{{$current_user->mythreemonth_point6}}],
	                [7,{{$current_user->mythreemonth_point7}}],
	                [8,{{$current_user->mythreemonth_point8}}],
	            ];

	            var plot = $.plot($("#target-chart"), [{
	                data: pageviews,
	                label: "全国平均",
	                lines: {
	                    lineWidth: 1,
	                },
	                shadowSize: 0

	            }, {
	                data: visitors,
	                label: "自分",
	                lines: {
	                    lineWidth: 1,
	                },
	                shadowSize: 0
	            }], {
	                series: {
	                    lines: {
	                        show: true,
	                        lineWidth: 2,
	                        fill: true,
	                        fillColor: {
	                            colors: [{
	                                opacity: 0.05
	                            }, {
	                                opacity: 0.01
	                            }]
	                        }
	                    },
	                    points: {
	                        show: true,
	                        radius: 3,
	                        lineWidth: 1
	                    },
	                    shadowSize: 2
	                },
	                grid: {
	                    hoverable: true,
	                    clickable: true,
	                    tickColor: "#eee",
	                    borderColor: "#eee",
	                    borderWidth: 1
	                },
	                colors: ["#d0cece", "#d12610", "#52e136"],
	                xaxis: {
	                    ticks: 11,
	                    tickDecimals: 0,
	                    tickColor: "#eee",
	                    mode: '',
	                },
	                yaxis: {
	                    ticks: 11,
	                    tickDecimals: 0,
	                    tickColor: "#eee",
	                }
	            });
				$(".dqtarget-chart .tickLabels .xAxis").empty();
				$xstr = "<div class='tickLabel' style='position:absolute;text-align:center;left:-12px;top:300px;width:60px'>{{$current_user->threemonth_name1}}</div><div class='tickLabel' style='position:absolute;text-align:center;left:54px;top:300px;width:60px'>{{$current_user->threemonth_name2}}</div><div class='tickLabel' style='position:absolute;text-align:center;left:119px;top:300px;width:60px'>{{$current_user->threemonth_name3}}</div><div class='tickLabel' style='position:absolute;text-align:center;left:185px;top:300px;width:60px'>{{$current_user->threemonth_name4}}</div><div class='tickLabel' style='position:absolute;text-align:center;left:250px;top:300px;width:60px'>{{$current_user->threemonth_name5}}</div><div class='tickLabel' style='position:absolute;text-align:center;left:316px;top:300px;width:60px'>{{$current_user->threemonth_name6}}</div><div class='tickLabel' style='position:absolute;text-align:center;left:381px;top:300px;width:60px'>{{$current_user->threemonth_name7}}</div><div class='tickLabel' style='position:absolute;text-align:center;left:447px;top:300px;width:60px'>{{$current_user->threemonth_name8}}</div>";
				$(".dqtarget-chart .tickLabels .xAxis").html($xstr);

	            function showTooltip(x, y, contents) {
	                $('<div id="tooltip">' + contents + '</div>').css({
	                    position: 'absolute',
	                    display: 'none',
	                    top: y + 5,
	                    left: x + 15,
	                    border: '1px solid #333',
	                    padding: '4px',
	                    color: '#fff',
	                    'border-radius': '3px',
	                    'background-color': '#333',
	                    opacity: 0.80
	                }).appendTo("body").fadeIn(200);

	            }

	            var previousPoint = null;
	            /*$("#target-chart").bind("plothover", function(event, pos, item) {
	                $("#x").text(pos.x.toFixed(2));
	                $("#y").text(pos.y.toFixed(2));
	               
	                if (item) {
	                    if (previousPoint != item.dataIndex) {
	                        previousPoint = item.dataIndex;

	                        $("#tooltip").remove();
	                        var x = item.datapoint[0].toFixed(2),
	                            y = item.datapoint[1].toFixed(2);

	                        showTooltip(item.pageX, item.pageY, item.series.label + " of " + x + " = " + y);
	                    }
	                } else {
	                    $("#tooltip").remove();
	                    previousPoint = null;
	                }
	            });*/
	        });

		@endif

		$(function () {
			function showBar(tag, points_data, points_interval, member_interval, my_points, legend_text = '',axis_label = 'null'){
		 	  	var settings = {
					title:null,
					description: null,
					showLegend: true,
					showToolTips: false,
					enableAnimations: true,
					showBorderLine: false,
					legendLayout : { left:0 , top: 5, width:100, height:100, flow: 'vertical' },
					padding: { left: 0, top: 5, right: 20, bottom: 0 },
					source: points_data,
					xAxis:
					{
						dataField: 'x_point',
						gridLines: { visible: false },
						flip: true,
						minValue:0,
						unitInterval:points_interval,
						visible:true,
						labels:{
							angle:90,
							offset:{x:0,y:10}
						}
					},
					valueAxis:
					{
						flip: true,
						minValue:0,
						unitInterval:member_interval,
						labels: {
							visible: true,
							horizontalAlignment: 'left',
							formatFunction: function (value) {
								return parseInt(value);
							}
						},
						title: { text: axis_label,
	                    		horizontalAlignment:'right'
	                	}
					},
					colorScheme: 'scheme01',
					seriesGroups:
						[
							{
								type: 'column',
								orientation: 'horizontal',
								columnsGapPercent: 40,
								series: [
								{ dataField: 'value_member', displayText:legend_text, colorFunction: function (value, itemIndex, serie, group) {
												return (itemIndex == [Math.floor(my_points/points_interval)] ) ? '#FF0000' : '#0000ff';
								},
								labels: { 
	                                    visible: true,
	                                    horizontalAlignment : 'right',
	                                    offset: { x: 5, y: 0 }
	                             },
	                                formatFunction: function (value) {
	                                	if(value > 0)
	                                   		 return value;
	                                },
								   lineColor:'#0000ff',
								   lineWidth: 0.5
								}		
									]
							}
						]
				};

				// setup the chart
				$("#"+tag).jqxChart(settings);
		  	}
			var m_interval_num = 4;
			var p_interval_num = 15;
			var member_interval = 0;
			var points_interval = 0;
			@if($current_user->type == 0)		
				var myrank1 = 1;
				var myrank_pupils1 = 0;
				var top_point = 0;
				var top_member = 0;
				var my_points = 0;
				<?php foreach ($myrankPoints1 as $i => $rank ): ?>
						myrank_pupils1 = myrank_pupils1 + {{$rank->persons}};
						@if($rank->flag=='1')
							myrank1 = {{$i+1}};
							my_points = {{$rank -> dq_point}};
						@endif		
						top_point = Math.max(top_point, {{$rank->dq_point}});
				<?php endforeach ?>;
				points_interval = Math.floor(top_point / p_interval_num) + 1;
				var numofLevel = new Array(p_interval_num);
				for(var i = 0; i < p_interval_num; i++)
					numofLevel[i] = 0;
				<?php foreach ($myrankPoints1 as $i => $rank): ?>
					numofLevel[Math.floor({{$rank->dq_point}}/points_interval)]+={{$rank->persons}};
				<?php endforeach ?>;
				for(var i = 0; i < p_interval_num; i++)
					top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
				member_interval = Math.floor(top_member / m_interval_num) + 1;
				var points_data = [];
				for(var i = 0; i < p_interval_num; i++)
					points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
				points_data.push({x_point:-1, value_member:top_member + 1});
				//그라프가 꼭맞을 때 그 수값이 그라프안으로 들어가는 현상을 막기위해 그보다 큰 bar를 하나 보이지 않게 그린다.
				showBar("horizontal-chart1",points_data, points_interval, member_interval, my_points,myrank1+"位/"+myrank_pupils1+"人");


				var myrank2 = 1;
				var myrank_pupils2 = 0;
				var top_point = 0;
				var top_member = 0;
				var my_points = 0;
				<?php foreach ($myrankPoints2 as $i => $rank ): ?>
						myrank_pupils2 = myrank_pupils2 + {{$rank->persons}};
						@if($rank->flag=='1')
							myrank2 = {{$i+1}};
							my_points = {{$rank -> dq_point}};
						@endif		
						top_point = Math.max(top_point, {{$rank->dq_point}});
				<?php endforeach ?>;
				points_interval = Math.floor(top_point / p_interval_num) + 1;
				var numofLevel = new Array(p_interval_num);
				for(var i = 0; i < p_interval_num; i++)
					numofLevel[i] = 0;
				<?php foreach ($myrankPoints2 as $i => $rank): ?>
					numofLevel[Math.floor({{$rank->dq_point}}/points_interval)]+={{$rank->persons}};
				<?php endforeach ?>;
				for(var i = 0; i < p_interval_num; i++)
					top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
				member_interval = Math.floor(top_member / m_interval_num) + 1;
				var points_data = [];
				for(var i = 0; i < p_interval_num; i++)
					points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
				points_data.push({x_point:-1, value_member:top_member + 1});
				//그라프가 꼭맞을 때 그 수값이 그라프안으로 들어가는 현상을 막기위해 그보다 큰 bar를 하나 보이지 않게 그린다.
				showBar("horizontal-chart2",points_data, points_interval, member_interval, my_points,myrank2+"位/"+myrank_pupils2+"人");
			@endif

			var myrank3 = 1;
			var myrank_pupils3 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($myrankPoints3 as $i => $rank ): ?>
					myrank_pupils3 = myrank_pupils3 + {{$rank->persons}};
					@if($rank->flag=='1')
						myrank3 = {{$i+1}};
						my_points = {{$rank -> dq_point}};
					@endif		
					top_point = Math.max(top_point, {{$rank->dq_point}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($myrankPoints3 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->dq_point}}/points_interval)]+={{$rank->persons}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("horizontal-chart3",points_data, points_interval, member_interval, my_points,myrank3+"位/"+myrank_pupils3+"人");

			var myrank4 = 1;
			var myrank_pupils4 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($myrankPoints4 as $i => $rank ): ?>
					myrank_pupils4 = myrank_pupils4 + {{$rank->persons}};
					@if($rank->flag=='1')
						myrank4 = {{$i+1}};
						my_points = {{$rank -> dq_point}};
					@endif		
					top_point = Math.max(top_point, {{$rank->dq_point}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($myrankPoints4 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->dq_point}}/points_interval)]+={{$rank->persons}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("horizontal-chart4",points_data, points_interval, member_interval, my_points, myrank4+"位/"+myrank_pupils4+"人");

			var myrank5 = 1;
			var myrank_pupils5 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($myrankPoints5 as $i => $rank ): ?>
					myrank_pupils5 = myrank_pupils5 + {{$rank->persons}};
					@if($rank->flag=='1')
						myrank5 = {{$i+1}};
						my_points = {{$rank -> dq_point}};
					@endif		
					top_point = Math.max(top_point, {{$rank->dq_point}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($myrankPoints5 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->dq_point}}/points_interval)]+={{$rank->persons}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("horizontal-chart5",points_data, points_interval, member_interval, my_points, myrank5+"位/"+myrank_pupils5+"人");
			
			@if($current_user->type == 0)	
				var threemonthrank1 = 1;
			var threemonthrank_pupils1 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($threemonthrankPoints1 as $i => $rank ): ?>
					threemonthrank_pupils1 = threemonthrank_pupils1 + {{$rank->persons}};
					@if($rank->flag=='1')
						threemonthrank1 = {{$i+1}};
						my_points = {{$rank -> dq_point}};
					@endif		
					top_point = Math.max(top_point, {{$rank->dq_point}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($threemonthrankPoints1 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->dq_point}}/points_interval)]+={{$rank->persons}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("threemonth-chart1",points_data, points_interval, member_interval, my_points, threemonthrank1+"位/"+threemonthrank_pupils1+"人", '人');

			var threemonthrank2 = 1;
			var threemonthrank_pupils2 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($threemonthrankPoints2 as $i => $rank ): ?>
					threemonthrank_pupils2 = threemonthrank_pupils2 + {{$rank->persons}};
					@if($rank->flag=='1')
						threemonthrank2 = {{$i+1}};
						my_points = {{$rank -> dq_point}};
					@endif		
					top_point = Math.max(top_point, {{$rank->dq_point}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($threemonthrankPoints2 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->dq_point}}/points_interval)]+={{$rank->persons}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("threemonth-chart2",points_data, points_interval, member_interval, my_points, threemonthrank2+"位/"+threemonthrank_pupils2+"人", '人');
		@endif

			var threemonthrank3 = 1;
			var threemonthrank_pupils3 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($threemonthrankPoints3 as $i => $rank ): ?>
					threemonthrank_pupils3 = threemonthrank_pupils3 + {{$rank->persons}};
					@if($rank->flag=='1')
						threemonthrank3 = {{$i+1}};
						my_points = {{$rank -> dq_point}};
					@endif		
					top_point = Math.max(top_point, {{$rank->dq_point}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($threemonthrankPoints3 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->dq_point}}/points_interval)]+={{$rank->persons}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("threemonth-chart3",points_data, points_interval, member_interval, my_points, threemonthrank3+"位/"+threemonthrank_pupils3+"人", '人');
	
			var threemonthrank4 = 1;
			var threemonthrank_pupils4 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($threemonthrankPoints4 as $i => $rank ): ?>
					threemonthrank_pupils4 = threemonthrank_pupils4 + {{$rank->persons}};
					@if($rank->flag=='1')
						threemonthrank4 = {{$i+1}};
						my_points = {{$rank -> dq_point}};
					@endif		
					top_point = Math.max(top_point, {{$rank->dq_point}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($threemonthrankPoints4 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->dq_point}}/points_interval)]+={{$rank->persons}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("threemonth-chart4",points_data, points_interval, member_interval, my_points, threemonthrank4+"位/"+threemonthrank_pupils4+"人", '人');

	
			var threemonthrank5 = 1;
			var threemonthrank_pupils5 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($threemonthrankPoints5 as $i => $rank ): ?>
					threemonthrank_pupils5 = threemonthrank_pupils5 + {{$rank->persons}};
					@if($rank->flag=='1')
						threemonthrank5 = {{$i+1}};
						my_points = {{$rank -> dq_point}};
					@endif		
					top_point = Math.max(top_point, {{$rank->dq_point}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($threemonthrankPoints5 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->dq_point}}/points_interval)]+={{$rank->persons}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("threemonth-chart5",points_data, points_interval, member_interval, my_points, threemonthrank5+"位/"+threemonthrank_pupils5+"人", '人');

			//
			@if($current_user->type == 0)
				var allrank1 = 1;
			var allrank_pupils1 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($allrankPoints1 as $i => $rank ): ?>
					allrank_pupils1 = allrank_pupils1 + {{$rank->persons}};
					@if($rank->flag=='1')
						allrank1 = {{$i+1}};
						my_points = {{$rank -> dq_point}};
					@endif		
					top_point = Math.max(top_point, {{$rank->dq_point}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($allrankPoints1 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->dq_point}}/points_interval)]+={{$rank->persons}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("all-chart1",points_data, points_interval, member_interval, my_points, allrank1+"位/"+allrank_pupils1+"人");

			var allrank2 = 1;
			var allrank_pupils2 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($allrankPoints2 as $i => $rank ): ?>
					allrank_pupils2 = allrank_pupils2 + {{$rank->persons}};
					@if($rank->flag=='1')
						allrank2 = {{$i+1}};
						my_points = {{$rank -> dq_point}};
					@endif		
					top_point = Math.max(top_point, {{$rank->dq_point}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($allrankPoints2 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->dq_point}}/points_interval)]+={{$rank->persons}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("all-chart2",points_data, points_interval, member_interval, my_points, allrank2+"位/"+allrank_pupils2+"人");
		@endif
			
			var allrank3 = 1;
			var allrank_pupils3 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($allrankPoints3 as $i => $rank ): ?>
					allrank_pupils3 = allrank_pupils3 + {{$rank->persons}};
					@if($rank->flag=='1')
						allrank3 = {{$i+1}};
						my_points = {{$rank -> dq_point}};
					@endif		
					top_point = Math.max(top_point, {{$rank->dq_point}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($allrankPoints3 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->dq_point}}/points_interval)]+={{$rank->persons}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("all-chart3",points_data, points_interval, member_interval, my_points, allrank3+"位/"+allrank_pupils3+"人");

			
			var allrank4 = 1;
			var allrank_pupils4 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($allrankPoints4 as $i => $rank ): ?>
					allrank_pupils4 = allrank_pupils4 + {{$rank->persons}};
					@if($rank->flag=='1')
						allrank4 = {{$i+1}};
						my_points = {{$rank -> dq_point}};
					@endif		
					top_point = Math.max(top_point, {{$rank->dq_point}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($allrankPoints4 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->dq_point}}/points_interval)]+={{$rank->persons}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("all-chart4",points_data, points_interval, member_interval, my_points, allrank4+"位/"+allrank_pupils4+"人");

			
			var allrank5 = 1;
			var allrank_pupils5 = 0;
			var top_point = 0;
			var top_member = 0;
			var my_points = 0;
			<?php foreach ($allrankPoints5 as $i => $rank ): ?>
					allrank_pupils5 = allrank_pupils5 + {{$rank->persons}};
					@if($rank->flag=='1')
						allrank5 = {{$i+1}};
						my_points = {{$rank -> dq_point}};
					@endif		
					top_point = Math.max(top_point, {{$rank->dq_point}});
			<?php endforeach ?>;
			points_interval = Math.floor(top_point / p_interval_num) + 1;
			var numofLevel = new Array(p_interval_num);
			for(var i = 0; i < p_interval_num; i++)
				numofLevel[i] = 0;
			<?php foreach ($allrankPoints5 as $i => $rank): ?>
				numofLevel[Math.floor({{$rank->dq_point}}/points_interval)]+={{$rank->persons}};
			<?php endforeach ?>;
			for(var i = 0; i < p_interval_num; i++)
				top_member = top_member > numofLevel[i]?top_member:numofLevel[i];
			member_interval = Math.floor(top_member / m_interval_num) + 1;
			var points_data = [];
			for(var i = 0; i < p_interval_num; i++)
				points_data.push({x_point:i * points_interval, value_member:numofLevel[i]});
			points_data.push({x_point:-1, value_member:top_member + 1});
			showBar("all-chart5",points_data, points_interval, member_interval, my_points, allrank5+"位/"+allrank_pupils5+"人");

		});

		$(document).ready(function(){
			window.onbeforeprint = beforeprint;
			window.onafterprint = afterprint;
			setTimeout(function(){
				
                window.print();
               location.href="javascript:history.go(-1)";
               //location.href="/mypage/last_report";
           },2000);
			
			
		});
		var initBody;
		function beforeprint(){
			initBody = document.body.innerHTML;
			document.body.innerHTML = idprint.innerHTML;
		}
		function afterprint(){
			
			document.body.innerHTML = initBody;
			location.href="javascript:history.go(-1)";
			//location.href = "/mypage/last_report";
		}
		
	</script>
