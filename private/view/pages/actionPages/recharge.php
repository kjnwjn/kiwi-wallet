<div class="container mt-5">
	<header class="text-center bg-light text-primary py-3 my-4 rounded">
		<h3 class="display-5 font-weight-bold mb-1 ">RECHARGE</h3>
	</header>

	<div class="row">
		<div class="col-md-6 col-lg-8 left-content">
			<div class="table-responsive">
				<form id="form" method="POST" onSubmit="return false" novalidate>
					<table class="table transfer">
						<tr>
							<td>Card ID</td>
							<td>
								<input id="card_id" name="card_id" type="number" placeholder="111111" required />
							</td>
						</tr>
						<tr>
							<td>Expire Day</td>
							<td>
								<input id="expiredDay" name="expiredDay" type="text" placeholder="14/02" required />
							</td>
						</tr>

						<tr>
							<td>CVV</td>
							<td>
								<input id="cvv" name="cvv" type="text" placeholder="411" required />
							</td>
						</tr>

						<tr>
							<td>Money</td>
							<td>
								<input id="money" name="money" type="number" min=0  placeholder="500000" required onChange="checkMoney()"/>
							</td>
						</tr>
						<tr class="error-message text-danger"></tr>


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
					<a href="#">info</a>
					<p>user</p>
				</div>
			</div>
			<div>
				<ul class="menu menu-info">

				</ul>
			</div>
		</div>
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
	const url = 'http://localhost/api/service/recharge'
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
	renderData(urlUserProfile)
	// function actionRecharge(){
	// }
	submitformAction(url, 'POST');
	$('.btn-removeAll').click(function() {
		$('#card_id').val('')
		$('#expiredDay').val('')
		$('#cvv').val('')
		$('#money').val('')

	})
</script>
