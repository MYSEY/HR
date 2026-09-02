<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <title>Email Template</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <table>
        <tr>
            <td style="padding: 20px;">
                <p style="font-size: 18px; font-weight: bold;">{{ $data["mail_message"]->subject }}</p>
                <div style="font-size: 16px; line-height: 1.6; color: #333;">
                    {!! nl2br(e($data["mail_message"]->message)) !!}
                </div>
                <br>
                <table width="90%" style="border-collapse: collapse; font-size: 14px; color: #333;">
                    <thead>
                        <tr>
                            <th style="border: 1px solid #ccc; padding: 8px; background-color: #f5f5f5; text-align: center; font-weight: bold;">
                                From Date
                            </th>
                            <th style="border: 1px solid #ccc; padding: 8px; background-color: #f5f5f5; text-align: center; font-weight: bold;">
                                To Date
                            </th>
                            <th style="border: 1px solid #ccc; padding: 8px; background-color: #f5f5f5; text-align: center; font-weight: bold;">
                                Day Taken
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border: 1px solid #ccc; padding: 8px; text-align: center;">{{ $data['start_date'] }}</td>
                            <td style="border: 1px solid #ccc; padding: 8px; text-align: center;">{{ $data['end_date'] }}</td>
                            <td style="border: 1px solid #ccc; padding: 8px; text-align: center;">{{ $data['number_of_day'] }}</td>
                        </tr>
                    </tbody>
                </table>

                 {{-- <div style="font-size: 16px; line-height: 1.6; color: #333;">
                    Really appreciate for your approval.
                </div> --}}

                <p style="margin-top: 20px; font-weight: bold;">Best Regards,</p>
                <strong>{{$data["staff_request"]->employee_name_en }}</strong>
                <p style="margin: 0;">{{ $data["staff_request"]->position->name_english }}</p>
                
                <table width="100%" cellpadding="0" cellspacing="0">
                    {{-- <tr>
                        <td>
                            <img src="{{ asset('D:\Projects\HR\public\admin\img\logo\logo_camma.png')}}" alt="Camma Logo" style="width: 100%; max-width: 248px; height: auto; margin: 0 auto;">
                        </td>
                    </tr> --}}
                    <tr>
                        <td style="font-size: 14px; color: #555;">
                            <strong>Address:</strong> {{ $data["staff_request"]->branch->address }}<br>
                            <strong>Tel:</strong> (+855) {{ $data["staff_request"]->personal_phone_number }} | (+855) {{$data["staff_request"]->agency_phone_number}}<br>
                            <strong>Website:</strong> <a href="https://www.camma.com.kh" style="color: #007bff; text-decoration: none;">www.camma.com.kh</a><br>
                            <strong>Facebook:</strong> <a href="https://www.facebook.com/Camma.MFI" style="color: #007bff; text-decoration: none;">facebook.com/Camma.MFI</a>
                        </td>
                    </tr>
                </table>
                @if ($btn_approve == true)
                    <div style="text-align: center; margin-top: 20px;">
                        <a href="{{ url('http://hrms.camma.com:9090/HR_Production/public/leaves/admin') }}" 
                        style="background-color: #007bff; color: #ffffff; text-decoration: none; padding: 12px 20px; font-size: 16px; border-radius: 5px; display: inline-block;">
                            Click Here
                        </a>
                    </div>
                @endif
            </td>
        </tr>
    </table>
</body>
</html>
