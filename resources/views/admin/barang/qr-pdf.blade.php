<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cetak QR Code</title>
    <style>
        body {
            font-family: sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .qr {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="qr">
        {!! $qrCode !!}
    </div>
</body>
</html>
