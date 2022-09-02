<div class="container mt-5">

	<header class="text-center bg-light text-primary py-3  rounded my-4">
		<h3 class="display-5 font-weight-bold mb-1 ">TRANSFER TRANSACTIONS</h3>
	</header>
	<div class="row">
		<div class="col-md-6 col-lg-8 left-content">
			<div class="table-responsive">
				<form id="form" method="POST" onSubmit="return false" novalidate>
					<table class="table transfer">
						<tr>
							<td>Receiver PhoneNumber</td>
							<td>
								<input id="phoneRecipient" name="phoneRecipient" type="text" placeholder="0123456789" required onChange="userDetails()" />
							</td>
						</tr>
						<tr class="nameRecipients"></tr>
						<tr>
							<td>How much ?</td>
							<td>
								<input id="money" name="money" type="number" min=0 placeholder="5000000" required onChange="checkMoney()"/>
							</td>
						</tr>
						<tr class="error-message text-danger"></tr>

						<tr>
							<td>Cost Bearder</td>
							<td class="d-flex">
								<select class="custom-select" id="costBearer" name="costBearer">
									<option selected>Options</option>
									<option value="sender" selected>Sender</option>
									<option value="receiver">Receiver</option>
								</select>

							</td>
						</tr>

						<tr>
							<td>Description</td>
							<td>
								<input id="note" name="note" type="text" placeholder="Transfer for job" required />
							</td>
						</tr>


					</table>
					<button type="submit" class="btn btn-success">Success</button>
					<button class="btn btn-info btn-removeAll">Reset</button>
				</form>
			</div>
		</div>
		<div class="col-md-6 col-lg-4 right-content">
			<div class="row">
				<div class="col-3">
					<img src="../../../../public/assest/img/1-male.jpg" alt="">
				</div>
				<div class="col-9 user-infomation">
					<a href="<? getenv('BASE_URL') ?>profile">info</a>
					<p>Pham Nhat Anh</p>
				</div>
			</div>
			<div>
				<ul class="menu menu-info">

				</ul>
			</div>
		</div>
	</div>
	<div class="clear">

	</div>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="/main.js"> </script>
<script>

function checkMoney(){
		if($('#money').val() < 0){
			$('.error-message').html(`<td ></td><td >Invalid money value</td>`)
			$('.btn-success').attr("disabled", true);
		}else{
			$('.error-message').html('')
			$(":submit").removeAttr("disabled");
		}
	}
	const form = $('#form')
	const url = 'http://localhost/api/service/transfer'
	const urlUserDetails = 'http://localhost/api/account/user-details/'
	const urlUserProfile = 'http://localhost/api/account/profile/'

	function renderData(url = '') {
		fetch(url)
			.then(response => response.json())
			.then(response => {
				if (response.status == true) {
					$('.user-infomation').html(`
						<a href="http://localhost/profile">info</a>
						<p>${response.response.fullname}</p>
					`)
					$('.menu-info').html(`
						<li><span>${response.response.email}</span></li>
						<li><span>${response.response.gender}</span></li>
						<li><span>${response.response.address}</span></li>
						<li><span>${response.response.wallet} .VNĐ</span></li>
					`)
				}
			})

	}

	function userDetails() {
		fetch(urlUserDetails + $('#phoneRecipient').val())
			.then(response => response.json())
			.then(response => {
				if (response.status == true) {
					$('.nameRecipients').html(`
						<td>Receiver</td>
						<td><span class="text-success">${response.response.fullname}</span></td>
					
					`)
				} else {
					$('.nameRecipients').html(`
					
					<td>Receiver</td>
					<td><span class="text-danger">No user match!</span></td>
			
			`)
				}
			})
	}
	renderData(urlUserProfile)
	
	submitformAction(url, 'POST');
	$('.btn-removeAll').click(function() {
		$('#phoneRecipient').val('')
		$('#money').val('')
		$('#costBearer').val('sender')
		$('#note').val('')
		$('.nameRecipients').html(``)
	})
</script>