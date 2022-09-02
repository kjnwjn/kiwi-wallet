<div class="container mt-5">
	<header class="text-center bg-light text-primary py-3 rounded">
		<h3 class="display-5 font-weight-bold mb-1 ">BUY PHONE CARD</h3>
	</header>

	<div class="table-responsive">
		<table class="table ">
			<thead class="thead-light">
				<form id="form" method="POST" onSubmit="return false" novalidate>


					<div class="form-group">
						<label for="mno">Mobie Network Operater</label>
						<select id="mno" name="mno" class="form-control">
							<option value="viettel" selected>Viettel</option>
							<option value="mobifone">MobiFone</option>
							<option value="vinaphone">Vinaphone</option>

						</select>
						<div class="valid-feedback"></div>

					</div>

					<div class="form-group">
						<label for="phoneCardType">Value</label>
						<select id="phoneCardType" name="phoneCardType" class="form-control">
							<option value="10000">10.000</option>
							<option value="20000">20.000</option>
							<option value="50000">50.000</option>
							<option value="100000">100.000</option>

						</select>
						<div class="valid-feedback"></div>

					</div>


					<div class="form-group">
						<label for="amount">Amount</label>
						<select id="amount" name="amount" class="form-control">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
						</select>
						<div class="valid-feedback"></div>

					</div>


					<button type="submit" class="btn btn-success pl-4 pr-4" >Mua thẻ</button>
					<button type="reset" class="btn btn-info btn-removeAll pl-4 pr-4">Reset</button>
				</form>
			</thead>

		</table>
	</div>

</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="/main.js"></script>
<script>
	const form = $('#form')
	const url = 'http://localhost/api/service/buyPhoneCards'


	submitformAction(url, 'POST');
	
	$('.btn-removeAll').click(function() {
		$('#mno').val('')
		$('#phoneCardType').val('')
		$('#amount').val('')

	})
</script>