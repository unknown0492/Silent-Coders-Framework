	<!-- Confirm Modal -->
	<button style="margin: 10px 0px 10px 0px; margin-left: 0px;" type="button" class="btn blue hidden" 
	        id="show_confirm_modal" data-toggle="modal" href="#confirm_modal"><i class="fa fa-trash-o"></i> Modal</button>
	<div class="modal fade bs-modal-sm" id="confirm_modal" tabindex="-1"
		role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm box green">
			<div class="modal-content">
				<div class="modal-header bg-blue bg-font-blue">
					<button type="button" class="close" data-dismiss="modal"
						aria-hidden="true"></button>
					<h4 class="modal-title" id="confirm-modal-title">Modal Title</h4>
				</div>
				<div class="modal-body text-center" id="confirm-modal-message">Modal body goes here</div>
				<div class="modal-footer">
					<center>
						<button data-dismiss="modal" type="button" class="btn green"
							id="confirm-modal-positive-button">Yes</button>
						<button data-dismiss="modal" type="button" class="btn red" id="confirm-modal-negative-button">No</button>
					</center>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!--/ Confirm Modal -->
	
	
	
	<!-- Infinite Progress Modal -->
	<button style="margin: 10px 0px 10px 0px; margin-left: 0px;" type="button" class="btn blue hidden" 
	        id="show_iprogress_modal" data-toggle="modal" href="#infinite_progress_modal"><i class="fa fa-trash-o"></i> Modal</button>
	<div class="modal fade bs-modal-sm" id="infinite_progress_modal" tabindex="-1"
		role="dialog" aria-hidden="true">
		<button data-dismiss="modal" type="button" class="btn hidden" id="dismiss-ipmodal">No</button>
		
		<div class="modal-dialog modal-sm box green">
			<div class="modal-body text-center" id="confirm-modal-message" style="margin-top: 200px;">
				<center>
					<img src="images/small-loading.gif" style="height:50px" /><br />
					<span id="iprogress-message" style="color: white; font-size: 16px;  ">Loading...</span>		
				</center>
			</div>
		</div>
	</div>
	<!--/ Infinite Progress Modal -->