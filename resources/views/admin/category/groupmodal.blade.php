
				<!-- assign to group-->
				<div class="modal fade"  id="addassigneds" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" ></h5>
								<button  class="close" data-bs-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
							</div>
							<form method="POST" enctype="multipart/form-data" id="group_form" name="group_form">
								@csrf
								@honeypot
								<input type="hidden" name="category_id" id="category_id">
								<input type="hidden" name="category_name" id="category_name">

								<div class="modal-body">
									<div class="custom-controls-stacked d-md-flex" >
										<select multiple="multiple" class="form-control select2_modalcategory " data-placeholder="Select Group" name="group_id[]" id="groupname" >
										</select>
									</div>
									<div id="name"></div>
								</div>
								<div class="modal-footer">
									<button type="submit" class="btn btn-secondary" id="btngroup"  >{{trans('langconvert.admindashboard.save')}}</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- End asssigned to group  -->