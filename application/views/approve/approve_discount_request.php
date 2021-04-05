<!DOCTYPE html>
<html>
	<head>
		<title><?= $title ?></title>
        <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('assets/vendor/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="jumbotron text-center">
			<h1><?= $companyInfo->company_name_1 ?></h1>
			<p><?= $companyInfo->company_address_1 ?></p> 
		</div>

		<div class="container">
			<form class="form-horizontal" id="approve_form" name="approve_form" action="<?= base_url('approve/approved_requested_discount') ?>" method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th colspan="2" class="text-center">Information About Requested Discount</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td width="150px">Branch Name</td>
									<td>
										<?= $discountInfo->branchName ?>
										<input type="hidden" name="token_key" value="<?= $discountInfo->token_key ?>">
									</td>
								</tr>

								<tr>
									<td width="150px">Token Number</td>
									<td>
										<?= $discountInfo->token_number ?>
									</td>
								</tr>

								<tr>
									<td width="150px">Requested Discount</td>
									<td>
										<?= $discountInfo->discount ?>
										<input class="form-control" type="hidden" name="approved_discount" value="<?= $discountInfo->discount ?>">
									</td>
								</tr>

								<?php if ($discountInfo->status == 0): ?>
									<tr>
										<td colspan="2" align="right">
											<a class="btn btn-danger btn-lg" href="<?= base_url('approve/reject_request_discount/'.$discountInfo->token_key) ?>">Reject</a>
											<button type="submit" class="btn btn-success btn-lg">Approved</button>
										</td>
									</tr>									
								<?php else: ?>
									<tr>
										<td width="150px">Request Status</td>
										<td><?= $discountInfo->status == 1 ? 'Approved' : 'Rejected' ?></td>
									</tr>

									<?php if ($discountInfo->status == 1): ?>
										<tr>
											<td width="150px">Approved Discount</td>
											<td><?= $discountInfo->approved_discount ?></td>
										</tr>
									<?php endif ?>									
								<?php endif ?>
							</tbody>
						</table>
					</div>
				</div>
			</form>
		</div>
        <script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
        <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
	</body>
</html>