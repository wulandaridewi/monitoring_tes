<div class="row mt-0 mt-lg-8">
	<div class="col-xl-12">
		<!--begin::Charts Widget 5-->
		<!--begin::Card-->
		<div class="card card-custom gutter-b">
			<!--begin::Card header-->
			<div class="card-header h-auto border-0">
				<div class="card-title py-5">
					<h3 class="card-label">
						<span class="d-block text-dark font-weight-bolder">Registration</span>
						<span class="d-block text-muted mt-2 font-size-sm">Document Or Non Document </span>
					</h3>
				</div>
				<div class="card-toolbar">
					<!-- <ul class="nav nav-pills nav-pills-sm nav-dark-75" role="tablist">
						<li class="nav-item">
							<a class="nav-link py-2 px-4" data-toggle="tab" href="#kt_charts_widget_2_chart_tab_1">
								<span class="nav-text font-size-sm">Month</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link py-2 px-4" data-toggle="tab" href="#kt_charts_widget_2_chart_tab_2">
								<span class="nav-text font-size-sm">Week</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link py-2 px-4 active" data-toggle="tab" href="#kt_charts_widget_2_chart_tab_3">
								<span class="nav-text font-size-sm">Day</span>
							</a>
						</li>
					</ul> -->
				</div>
			</div>
			<!--end:: Card header-->
			<!--begin::Card body-->
			<div class="card-body">
				<div class="row">
					<div class="col-lg-8">
						<div id="chart_regis_id" style="min-height: 365px;"></div>
					<div class="resize-triggers"><div class="expand-trigger"><div style="width: 790px; height: 366px;"></div></div><div class="contract-trigger"></div></div></div>
					<div class="col-lg-4 d-flex flex-column">
						<!--begin::Engage Widget 2-->
						<div class="flex-grow-1 bg-primary p-8 rounded-xl flex-grow-1 bgi-no-repeat" style="background-position: calc(100% + 0.5rem) bottom; background-size: auto 70%; background-image: url(assets/media/svg/humans/custom-3.svg)">

							<h4 class="text-inverse-danger mt-2 font-weight-bolder">Detail Registration</h4>
							<p class="text-inverse-danger my-6">See the registration document 
							<br>in more detail each period.</p>
							<a href="<?= base_url('report/report_regis/home') ?>" class="btn btn-warning font-weight-bold py-2 px-6">View</a>
						</div>
						<!--end::Engage Widget 2-->
					</div>
				</div>
			</div>
			<!--end:: Card body-->
		</div>
		<!--end:: Card-->
		<!--end:: Charts Widget 5-->
	</div>
</div>


<div class="row">
	<div class="col-xl-7">
		<div class="card card-custom card-shadowless gutter-b">
		<!--begin::Header-->
		<div class="card-header border-0 py-5">
			<h3 class="card-title align-items-start flex-column">
				<span class="card-label font-weight-bolder text-dark">New Registrations Document</span>
				<span class="text-muted mt-3 font-weight-bold font-size-sm">Registration <?php echo date('d-M-Y', strtotime('-7 days', strtotime(date("d-M-Y")))); ?> s/d <?php echo date("d-M-Y"); ?></span>
			</h3>
			<div class="card-toolbar">
				<!-- <a href="#" class="btn btn-info font-weight-bolder font-size-sm mr-3">New Report</a>
				<a href="#" class="btn btn-danger font-weight-bolder font-size-sm">Create</a> -->
			</div>
		</div>
		<!--end::Header-->
		<!--begin::Body-->
		<div class="card-body pt-0 pb-3 container-fluid py-2">
			<div class="tab-content">
				<!--begin::Table-->
				<div class="table-responsive" style="max-height: 500px;overflow-y:auto;">
					<table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
						<thead>
							<tr class="text-left text-uppercase">
	                            <th style="min-width: 250px" class="pl-7">
	                                <span>Owner</span>
	                            </th>
								<th>Register ID</th>
								<th>Status</th>
								<th>Type</th>
								<th>Document Description</th>
	<!-- 							<th>Service</th>
	 -->							<th>Create Date</th>
								
							</tr>
						</thead>
						<tbody>
							<?php 

								foreach ($getListRegis as $key => $value) {
									$register_doc_id = trim($value['register_doc_id']);
				                    $type            = trim($value['type']);
				                    $doc_description = trim($value['doc_description']);
				                    $name            = trim($value['name']);
				                    $department      = trim($value['department']);
				                    $create_date     = date('d-m-Y H:i:s',strtotime($value['create_date']));
				                    $doc_status      = trim($value['doc_status']);
				                    $register_status = trim($value['register_status']);
				                    $delivery_status = trim($value['delivery_status']);
									$name_file_image = trim($value['name_file_image']);
							?>
							<tr>
								<td class="pl-0 py-8">
									<div class="d-flex align-items-center">
										<div class="symbol symbol-50 symbol-light mr-4">
											<span class="symbol-label">
												<img src="<?= base_url('assets/media/svg/avatars/'.$name_file_image) ?>" class="h-75 align-self-end" alt="">
												
											</span>
										</div>
										<div>
											<a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg"><?php echo $name; ?></a>
											<span class="text-muted font-weight-bold d-block"><?php echo $department; ?></span>
										</div>
									</div>
								</td>
								<td>
									<span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo $register_doc_id; ?></span>
								</td>

								<td class="pr-0 text-left">
									<span class="text-dark-75 font-weight-bolder d-block font-size-lg">
										<?php 
									if($register_status == 0){
	                    				echo "<a class='label label-lg label-light-warning label-inline'>Progress</a>";
	                				}else if($register_status == 2){
	                    				echo "<a class='label label-lg label-light-warning label-inline'>Progress</a>";
	                				}else if($register_status == 1){
	                    				echo "<a class='label label-lg label-light-primary label-inline'>Done</a>";
	                				}
	                				 ?></span>
								</td>
								<td>
									<span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php if($type=="DOC_IN"){ echo "Incoming Document";} else if($type=="DOC_OUT") {
										echo "Outgoing Document";
									} ; ?></span>
								</td>
								<td>
									<span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo $doc_description; ?></span>
								</td>
								<!-- <td>
									<span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo $doc_status; ?></span>
								</td> -->
								<td>
									<span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo $create_date; ?></span>
								</td>
							</tr>
						<?php } ?>
							
						</tbody>
					</table>
				</div>
				<!--end::Table-->
			</div>
		</div>
		<!--end::Body-->
	</div>
	</div>
	<div class="col-xl-5">
		<div class="card card-custom gutter-b card-stretch">
			<!--begin::Header-->
			<div class="card-header border-0 pt-5">
				<h3 class="card-title align-items-start flex-column">
					<span class="card-label font-weight-bolder text-dark">Container</span>
					<span class="text-muted mt-3 font-weight-bold font-size-sm">Document size information in the container</span>
				</h3>
			</div>
			<!--end::Header-->
			<!--begin::Body-->
			<div class="card-body pt-2 pb-0">
				<!--begin::Table-->
				<div class="table-responsive" style="max-height: 500px;overflow-y:auto;">
					<table class="table table-borderless table-vertical-center">
						<thead>
							<tr>
								<th class="p-0" style="width: 30px"></th>
								<th class="p-0" style="width: 70px"></th>
								<th class="p-0" style="width: 60px"></th>
							</tr>
						</thead>
						<tbody>		
							<?php
							 function formatSizeUnits($bytes)
							    {
							        if ($bytes >= 1048576)
							        {
							            $bytes = number_format($bytes / 1048576, 2) . ' GB';
							        }
							        elseif ($bytes >= 1024)
							        {
							            $bytes = number_format($bytes / 1024, 2) . ' MB';
							        }
							        else 
							        {
							            $bytes = $bytes . ' KB';
							        }

							        return $bytes;
							}
								foreach ($getSizeContainer as $key => $value) {
									$folder_name = trim($value['folder_name']);
									$size = trim($value['size']);													
							?>
							<tr>
								<td class="pl-0 py-5">
									<div class="symbol symbol-45 symbol-light-primary mr-2">
										<span class="symbol-label">
											<span class="svg-icon svg-icon-2x svg-icon-primary">
												<!--begin::Svg Icon | path:/metronic/theme/html/demo7/dist/assets/media/svg/icons/Shopping/Box2.svg-->
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24"></rect>
														<path d="M4,9.67471899 L10.880262,13.6470401 C10.9543486,13.689814 11.0320333,13.7207107 11.1111111,13.740321 L11.1111111,21.4444444 L4.49070127,17.526473 C4.18655139,17.3464765 4,17.0193034 4,16.6658832 L4,9.67471899 Z M20,9.56911707 L20,16.6658832 C20,17.0193034 19.8134486,17.3464765 19.5092987,17.526473 L12.8888889,21.4444444 L12.8888889,13.6728275 C12.9050191,13.6647696 12.9210067,13.6561758 12.9368301,13.6470401 L20,9.56911707 Z" fill="#000000"></path>
														<path d="M4.21611835,7.74669402 C4.30015839,7.64056877 4.40623188,7.55087574 4.5299008,7.48500698 L11.5299008,3.75665466 C11.8237589,3.60013944 12.1762411,3.60013944 12.4700992,3.75665466 L19.4700992,7.48500698 C19.5654307,7.53578262 19.6503066,7.60071528 19.7226939,7.67641889 L12.0479413,12.1074394 C11.9974761,12.1365754 11.9509488,12.1699127 11.9085461,12.2067543 C11.8661433,12.1699127 11.819616,12.1365754 11.7691509,12.1074394 L4.21611835,7.74669402 Z" fill="#000000" opacity="0.3"></path>
													</g>
												</svg>
												<!--end::Svg Icon-->
											</span>
										</span>
									</div>
								</td>
								<td class="pl-0">
									<a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg"><?php echo $folder_name; ?></a>
								</td>
								<td class="text-left pr-0">
									<span class="text-dark-75 font-weight-bolder font-size-lg"><?php echo formatSizeUnits($size); ?></span>
								</td>
							</tr>

							<?php } ?>					
							
						</tbody>
					</table>
				</div>
				<!--end::table-->
			</div>
			<!--begin::Body-->
		</div>
	</div>
</div>
<script type="text/javascript">
	var t=document.getElementById("chart_regis_id");
	if(t){
		var e={
			series:[
			// {
			// 	name:"Document",data:[44,55,57,56,61,58,44,55,57,56,61,58]
			// },
			<?php
		         $val2="";
		        foreach ($getDocRegis as $value) {
		            $val2 .= '{name:"Document",data: [' . $value['pointJan'] . ',' . $value['pointFeb'] . ',' . $value['pointMar'] . ',' . $value['pointApr'] . ',' . $value['pointMei'] . ',' . $value['pointJuni'] . ',' . $value['pointJuli'] . ',' . $value['pointAgu'] . ',' . $value['pointSep'] . ',' . $value['pointOkt'] . ',' . $value['pointNov'] . ',' . $value['pointDes'] . ']},';
		        }
		        echo $val2 = rtrim($val2, ',');
		    ?>
			,
			<?php
		         $val3="";
		        foreach ($getNonDocRegis as $value3) {
		            $val3 .= '{name:"Non Document",data: [' . $value3['pointJan'] . ',' . $value3['pointFeb'] . ',' . $value3['pointMar'] . ',' . $value3['pointApr'] . ',' . $value3['pointMei'] . ',' . $value3['pointJuni'] . ',' . $value3['pointJuli'] . ',' . $value3['pointAgu'] . ',' . $value3['pointSep'] . ',' . $value3['pointOkt'] . ',' . $value3['pointNov'] . ',' . $value3['pointDes'] . ']},';
		        }
		        echo $val3 = rtrim($val3, ',');
		    ?>
			// {
			// 	name:"Non Document",data:[76,85,101,98,87,105,76,85,101,98,87,105]
			// }
			],
				chart:{
					type:"bar",
					height:350,
					toolbar:{
						show:!1}
					},
				plotOptions:{
					bar:{
						horizontal:!1,
						columnWidth:["30%"],
						endingShape:"rounded"}
					},legend:{show:!1},
				dataLabels:{
					enabled:!1},
				stroke:{
					show:!0,
					width:2,
					colors:["transparent"]},
				xaxis:{
					categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
					//categories:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Okt","Nov","Des"],
					axisBorder:{
						show:!1},
					axisTicks:{
						show:!1},
					labels:{
						style:{
							colors:"#B5B5C3",fontSize:"12px",fontFamily:KTApp.getSettings()["font-family"]}}},yaxis:{labels:{style:{colors:"#B5B5C3",fontSize:"12px",fontFamily:KTApp.getSettings()["font-family"]}}},fill:{opacity:1},states:{normal:{filter:{type:"none",value:0}},hover:{filter:{type:"none",value:0}},active:{allowMultipleDataPointsSelection:!1,filter:{type:"none",value:0}}},tooltip:{style:{fontSize:"12px",fontFamily:KTApp.getSettings()["font-family"]},y:{formatter:function(t){return""+t+""}}},colors:["#FFA800","#8950FC"],grid:{borderColor:"#ECF0F3",strokeDashArray:4,yaxis:{lines:{show:!0}}}};new ApexCharts(t,e).render()
	}
</script>