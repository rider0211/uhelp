				<!-- Assigned Tickets to Agent-->
				<div class="modal fade sprukosearch"  id="addassigned" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" ></h5>
								<button  class="close" data-bs-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
							</div>
							<form method="POST" enctype="multipart/form-data" id="assigned_form" name="assigned_form">
								@csrf
								@honeypot

								<input type="hidden" name="assigned_id" id="assigned_id">
								<div class="modal-body">

									<div class="custom-controls-stacked d-md-flex" >
										<select class="form-control select2_modalassign" data-placeholder="Select Agent" name="assigned_user_id" id="username" >

										</select>
									</div>
									<span id="AssignError" class="text-danger"></span>
								</div>
								<div class="modal-footer">
									<button type="submit" class="btn btn-secondary" id="btnsave"  >{{trans('langconvert.admindashboard.save')}}</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- End Assigned Tickets to Agent  -->