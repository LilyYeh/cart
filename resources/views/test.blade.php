<!DOCTYPE html>
<html lang="zh-tw">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" />
    <title>test</title>
</head>

<body>
    <script src="https://payment-stage.ecpay.com.tw/Scripts/SP/ECPayPayment_1.0.0.js"
            data-MerchantID="2000132"
            data-SPToken="{{$SPToken}}"
            data-PaymentType="CREDIT"
            data-PaymentName="信用卡"
            data-CustomerBtn="0" >
    </script>
    <script src="https://payment-stage.ecpay.com.tw/Scripts/SP/ECPayPayment_1.0.0.js"
            data-MerchantID="2000132"
            data-SPToken="{{$SPToken}}"
            data-PaymentType="ATM"
            data-PaymentName="自動櫃員機"
            data-CustomerBtn="0" >
    </script>
    <script src="https://payment-stage.ecpay.com.tw/Scripts/SP/ECPayPayment_1.0.0.js"
            data-MerchantID="2000132"
            data-SPToken="{{$SPToken}}"
            data-PaymentType="CVS"
            data-PaymentName="超商代碼"
            data-CustomerBtn="0" >
    </script>
</body>
</html>
