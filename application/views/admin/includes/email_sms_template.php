<div id="customerCustmMsgSMS" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body">
				<div class="tabbable">
					<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
						<li class="active"><a data-toggle="tab" href="#TAB1"><i class="green ace-icon far fa-envelope-open bigger-120"></i> Email Template</a>
						</li>
						<li> <a data-toggle="tab" href="#TAB2"><i class="green ace-icon far fa-comment-alt bigger-120"></i> SMS Template</a> </li>
						<li class="pull-right mr10">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</li>
					</ul>
					<div class="tab-content">
						<div id="TAB1" class="tab-pane in active">
							<form class="form-horizontal sendCustmEml" role="form">
								<input type="hidden" name="type" value="2"/>
								<input type="hidden" class="t_CID" name="CID" value=""/>
								<input type="hidden" name="isActivate" value=""/>
								<table class="table table-striped table-bordered table-hover">
									<tr>
										<th width="20%">Email Template List</th>
										<td width="75%">
											<select onChange="getCustomEmailSMSTemplate(this.value, 2)" class="selectpicker emailTemplLsngM" title="Select existing email template from the list" data-live-search="true" data-width="100%" data-size="8">
												<option value="add" data-icon="glyphicon-plus">&nbsp; Add more template</option>
												<option value="0" data-icon="glyphicon-pencil">&nbsp; Custom text</option>
												<?php
												$templtLstAry = getTemplateEnSList('2');
												foreach ( $templtLstAry as $templtLst ) {
													$lblName = $templtLst->title ? $templtLst->title : $templtLst->default_title;
													echo '<option value="' .$templtLst->id. '">' . $lblName . '</option>';
												}
												?>
											</select>
										</td>
										<td class="text-center" width="5%">
											<a onclick="refreshTemplateList(2)" class="blue" data-tooltip="tooltip" title="" href="javascript:;" data-original-title="Refresh / Reset <br> template list"> <i class="ace-icon fas fa-sync-alt bigger-130"></i></a>
										</td>
									</tr>
								</table>
								<div class="row">
									<div class="col-md-6">
										<label class="required">To</label>
										<div class="bootInputTag disableMouse">
											<input disabled type="text" class="form-control toEmal" data-role="tagsinput" disabled required/>
										</div>
									</div>
									<div class="col-md-6">
										<label>CC / BCC</label>
										<div class="bootInputTag">
											<input name="cc" type="text" class="form-control" data-role="tagsinput">
										</div>
									</div>
								</div><br>
								<div class="row">
									<div class="col-md-12">
										<label class="required">Subject</label>
										<input name="subject" class="form-control" type="text" required>
									</div>
								</div><br>
								<div class="row">
									<div class="col-md-12">
										<label class="required">Message</label>
										<textarea name="message" rows="8" class="summernote"></textarea>
									</div>
								</div>
								<div class="TmpltFtAr pt0">
									<button type="button" class="btn btn-sm btn-inverse" data-dismiss="modal"><span class="bigger-110">Close</span></button>
									<button onClick="updateCustomerStatus();" type="button" data-tooltip="tooltip" title="Activate this customer <br> witout confirmation" class="btn btn-sm btn-primary actBtnCA"> <i class="ace-icon fas fa-check bigger-110"></i> <span> Activate only</span></button>
									<button type="submit" data-tooltip="tooltip" title="Activate this customer <br> with confirmation"  class="btn btn-sm btn-success sndBtnSE"> <i class="ace-icon far fa-envelope bigger-110"></i> <span> Activate and send</span></button>
								</div>
							</form>
						</div>
						<div id="TAB2" class="tab-pane">
							<form class="form-horizontal sendCustmSMS" role="form">
								<input type="hidden" name="type" value="1"/>
								<input type="hidden" class="t_CID" name="CID" value=""/>
								<input type="hidden" name="isActivate" value=""/>
								<table class="table table-striped table-bordered table-hover">
									<tr>
										<th width="20%">SMS Template List</th>
										<td width="75%">
											<select onChange="getCustomEmailSMSTemplate(this.value, 1)" class="selectpicker smsTemplLsngM" title="Select existing SMS template from the list" data-live-search="true" data-width="100%" data-size="8">
												<option value="add" data-icon="glyphicon-plus">&nbsp; Add more template</option>
												<option value="0" data-icon="glyphicon-pencil">&nbsp; Custom text</option>
												<?php
												$templtLstAry = getTemplateEnSList('1');
												foreach ( $templtLstAry as $templtLst ) {
													$lblName = $templtLst->title ? $templtLst->title : $templtLst->default_title;
													echo '<option value="' . $templtLst->id . '">' . $lblName . '</option>';
												}
												?>
											</select>
										</td>
										<td class="text-center" width="5%">
											<a onclick="refreshTemplateList(1)" class="blue" data-tooltip="tooltip" title="Refresh / Reset <br> template list" href="javascript:;"> <i class="ace-icon fas fa-sync-alt bigger-130"></i></a>
										</td>
									</tr>
								</table>
								<div class="row">
									<div class="col-md-6">
										<label class="required">SMS To Number</label>
										<div class="bootInputTag disableMouse">
											<input type="text" class="form-control toSMS" data-role="tagsinput" disabled required/>
										</div>
									</div>
									<div class="col-md-6">
										<label class="required">SMS from Number / Code</label>
										<div class="bootInputTag">
											<input type="text" maxlength="12" name="subject" class="form-control" data-role="tagsinput" required/>
										</div>
									</div>
								</div><br>
								<div class="row">
									<div class="col-md-12">
										<label class="required">Message</label>
										<textarea name="sms" rows="5" class="form-control"></textarea>
									</div>
								</div>
								<div class="TmpltFtAr">
									<button type="button" class="btn btn-sm btn-inverse" data-dismiss="modal"><span class="bigger-110">Close</span></button>
									<button onClick="updateCustomerStatus();" type="button" data-tooltip="tooltip" title="Activate this customer <br> witout confirmation" class="btn btn-sm btn-primary actBtnCA"> <i class="ace-icon fas fa-check bigger-110"></i> <span> Activate only</span></button>
									<button type="submit" data-tooltip="tooltip" title="Activate this customer <br> with confirmation"  class="btn btn-sm btn-success sndBtnSE"> <i class="ace-icon far fa-comment-alt bigger-110"></i> <span> Activate and SMS</span></button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>