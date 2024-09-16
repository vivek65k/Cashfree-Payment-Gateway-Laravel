<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pay Now</title>
	<script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
</head>
<body onload="payment()">
	<input type="hidden" id="paymentSessionId" value="{{$payment_session_id}}">

<script type="text/javascript">
	function payment(){
		var cashfree= Cashfree({
			mode:'sandbox' //or production
		});
		let checkoutoptions={
			paymentSessionId: document.getElementById("paymentSessionId").value,
			redirectTarget:"_self" //(_self, _blank,_top)
		}
		cashfree.checkout(checkoutoptions);
	}
</script>
</body>
</html>