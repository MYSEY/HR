<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    {{-- <meta name="viewport"> --}}
    <title>HRMS</title>
</head>
<body>
    <h2 style="font-size: 18px; font-weight: bold;">
        <p style="line-height:1.6;">
            Request KPI/PA
        </p>
    </h2>
    <div style="font-size: 16px; line-height: 1.6; color: #333;">
        <p style="line-height:1.6;">
            Dear Respective Management,
        </p>
        <P>
            I would like to summit you for the KPI/PA and please kindly review and consider to approve accordingly.
Should you need any further information, please do not hesitate to let me know.
        </P>
    </div>
    <p style="margin-top: 20px; font-weight: bold;">Best Regards,</p>
    <div style="text-align: center; margin-top: 20px;">
        @php
            $segments = request()->segments();
            array_pop($segments); // remove the last one
            $cleanUrl = url(implode('/', $segments));
        @endphp
        <a href="{{ $cleanUrl }}"
        style="background-color: #007bff; color: #ffffff; text-decoration: none; padding: 12px 20px; font-size: 16px; border-radius: 5px; display: inline-block;">
            Click Here
        </a>
    </div>
</body>
</html>