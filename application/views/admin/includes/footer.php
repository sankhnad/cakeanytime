<div class="footer">
	<div class="footer-inner">
		<div class="footer-content">
			<span class="blue bolder">POCHI</span> Admin &copy;
			<?=date('Y')?>
		</div>
	</div>
</div> 
<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"> 
	<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"> </i>
</a>

<!-- Change Password -  Modal -->
<div id="changePassMod" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Change Password</h4>
			</div>
			<form class="form-horizontal" id="adminUpdatePas" role="form">
				<div class="modal-body">
					<table class="table table-bordered">
						<tbody>
							<tr>
								<th width="40%" class="pass">Old Password</th>
								<td>
									<input type="password" class="form-control oPassword" autocomplete="off" name="oPass" placeholder="Enter old password">
								</td>
							</tr>
							<tr>
								<th class="pass">New Password</th>
								<td class="posR">
									<input type="password" onBlur="$('.passValida').hide();" autocomplete="off" onKeyUp="validatePassword(this.value, this)" class="form-control nPassword" placeholder="Enter New Password">
									<div class="passValida"></div>
								</td>
							</tr>
							<tr>
								<th class="pass">Confirm Password</th>
								<td class="posR">
									<input type="password" onBlur="$('.passValida').hide();" autocomplete="off" onKeyUp="validatePassword(this.value, this)" class="form-control cPassword" name="nPass" placeholder="Confirm New Password">
									<div class="passValida"></div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-inverse" data-dismiss="modal"><span class="bigger-110">Close</span></button>
					<button type="submit" class="btn btn-sm btn-success"> <i class="ace-icon fas fa-save bigger-110"></i> <span class="bigger-110 no-text-shadow">Update</span>
				</div>
			</form>
		</div>
	</div>
</div>


<!-- Customer Quick View -  Modal -->
<div id="customerQuickVwTbl" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Quick View</h4>
			</div>
			<form class="form-horizontal" role="form">
				<div class="modal-body">
					<div class="text-center"><img width="20%" class="qUAAvtar" src="" /></div>
					<table class="table table-bordered">
						<tbody>
							<tr>
								<th width="20%">Name</th>
								<td width="30%" class="cuName"></td>
								<th width="20%">Account No</th>
								<td width="30%" class="cuAccountNo"></td>
							</tr>
							<tr>
								<th>Username</th>
								<td class="cuUsername"></td>
								<th>Profile ID</th>
								<td class="cuProfileID"></td>
								
							</tr>
							<tr>
								<th>Email</th>
								<td class="cuEmail"></td>
								<th>KYC Type</th>
								<td class="cuKYCType"></td>
								
							</tr>
							<tr>
								<th>Phone</th>
								<td class="cuPhone"></td>
								<th>KYC ID Number</th>
								<td class="cuKYCID"></td>
							</tr>
							<tr>
								<th>Gender</th>
								<td class="cuGender"></td>
								<th>KYC Status</th>
								<td class="cuKYCStatus"><span class="badge"></span></td>
							</tr>
							<tr>
								<th>Profile Type</th>
								<td class="cuProfileType"></td>
								<th>Registered On</th>
								<td class="cuRegDate"></td>
							</tr>
							<tr>
								<th>Customer Status</th>
								<td class="cuCustStatus"><span class="badge"></span></td>
								<th>Last Login</th>
								<td class="cuLastLogin"></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-inverse" data-dismiss="modal"><span class="bigger-110">Close</span></button>
					<a target="_blank" href="" class="btn btn-sm btn-primary viewModbC"> <i class="ace-icon fas fa-eye bigger-110"></i> <span class="bigger-110"> Detailed View</a>
				</div>
			</form>
		</div>
	</div>
</div>


<!-- KYC Rejection Reason -  Modal -->
<div id="rejectReasonMod" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Reject KYC</h4>
			</div>
			<div class="modal-body">
				<label class="required">Rejection Reason</label>
				<textarea class="form-control"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-inverse" data-dismiss="modal"><span class="bigger-110">Close</span></button>
				<button type="button" data-model='0' data-type='0' class="btn btn-sm btn-danger kycacptDecFn"> <i class="ace-icon fas fa-times bigger-110"></i> <span class="bigger-110 no-text-shadow"> Reject KYC</span></button>
			</div>
		</div>
	</div>
</div>

