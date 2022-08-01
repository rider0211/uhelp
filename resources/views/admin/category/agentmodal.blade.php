
	  		<!-- Assign to agent-->
			  <div class="modal fade"  id="addassigned" aria-hidden="true">
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
							<input type="hidden" name="assigned_name" id="assigned_name">

							<div class="modal-body">

								<div class="custom-controls-stacked d-md-flex" >
									<select multiple="multiple" class="form-control multiselect select2-show-search  select2" data-placeholder="Select Agent" name="assigned_user_id[]" id="username" >

									</select>
								</div>
								<div id="name"></div>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-secondary" id="btnsave"  >Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- End assign to agent  -->