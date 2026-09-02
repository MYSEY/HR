<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    {{-- <meta name="viewport"> --}}
    <title>{{$data["data"]["title"]}}</title>
    <style>
        body {
            font-family: 'Khmer OS Battambang', Tahoma, sans-serif;
            font-size: 14px;
            background-color: #f9f9f9;
            padding: 20px;
            color: #000;
        }
        table {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            font-size: 14px;
            font-family: 'Khmer OS Battambang', Tahoma, sans-serif;
        }
        h2 {
            margin-bottom: 10px;
        }
        p, ul, li, label {
            font-size: 14px;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <table style="max-width:600px; margin:0 auto;  padding:20px;">
        <tr>
            <td>
                <h2 style="color:green; margin-bottom:10px;">{{$data["data"]["title"]}}</h2>
                @php
                    $day = \Carbon\Carbon::parse($data["data"]["date"])->format('d');
                    $month = \Carbon\Carbon::parse($data["data"]["date"])->format('M');
                    $year = \Carbon\Carbon::parse($data["data"]["date"])->format('Y');
                @endphp
                @if ($data["data"]["status"] == "pending")
                    <p style="line-height:1.6;">
                        សូមគោរពជូនថ្នាក់គ្រប់គ្រង ខ្ញុំបាទ/នាងខ្ញុំស្នើសុំការអនុម័តចំណាយក្នុងប្រព័ន្ធ ដូចបានរៀបរាប់ជូនខាងក្រោម៖
                    </p>
                    <ul style="line-height:1.8;">
                        <li>កាលបរិច្ឆេទស្នើសុំ៖ ថ្ងៃទី {{$day}} ខែ {{$month}} ឆ្នាំ {{$year}}</li>
                        <li>កម្មវត្ថុ៖ {{$data["data"]["subject"]}}</li>
                        <li>ចំនួនទឹកប្រាក់សរុប៖ {{$data["data"]["amount_usd"] ? "$ ".$data["data"]["amount_usd"].", ": ""}}{{ $data["data"]["amount_kh"] ? "៛ ".$data["data"]["amount_kh"] : ""}}</li>
                        <li>ឈ្មោះអ្នកស្នើសុំ៖ {{$data["data"]["request_by"]}}</li>
                    </ul>
                    <p style="margin-top:20px;">
                        អាស្រ័យដូចបានជម្រាបជូនខាងលើ សូមថ្នាក់គ្រប់គ្រងមេត្តាពិនិត្យ និងសម្រេចដោយក្តីអនុគ្រោះ។
                        សូមថ្នាក់គ្រប់គ្រងមេត្តាទទួលនៅការគោរពដ៏ខ្ពង់ខ្ពស់អំពីខ្ញុំបាទ/នាងខ្ញុំ ។
                    </p>
                @endif
                @if ($data["data"]["status"] == "reject")
                    <p style="line-height:1.6;">
                        សូមគោរពជូនថ្នាក់គ្រប់គ្រង និងបុគ្គលិក ដែលបានធ្វើការស្នើសុំចំណាយហើយត្រូវបានច្រានចោល ដោយមូលហេតុ ដូចបានរៀបរាប់ជូនខាងក្រោម៖
                    </p>
                    <ul style="line-height:1.8;">
                        <li>កាលបរិច្ឆេទស្នើសុំ៖ ថ្ងៃទី {{$day}} ខែ {{$month}} ឆ្នាំ {{$year}}</li>
                        <li>មូលហេតុ៖ {{$data["data"]["reason"]}}</li>
                        <li>អ្នកបដិសេធ៖ {{$data["data"]["review"]}}</li>
                    </ul>
                    <p style="margin-top:20px;">
                        សូមគោរពជូនលោកគ្រូ/អ្នកគ្រូ ដែលបានធ្វើការស្នើសុំចំណាយ សូមធ្វើការកែតម្រូវដោយប្រុងប្រយ័ត្ន និងត្រឹមត្រូវដើម្បីចេញចំណាយឲ្យបានទាន់ពេលវេលា។ 
                        សូមអរគុណ!
                    </p>
                @endif
                @if ($data["data"]["status"] == "approve")
                    <p style="line-height:1.6;">
                        សូមគោរពជូនថ្នាក់គ្រប់គ្រង និងបុគ្គលិក ដែលបានធ្វើការស្នើសុំចំណាយលេខ Tracking 
                    </p>
                    <label >ID {{$data["data"]["tracking_id"]}} ត្រូវបានអនុម័ត។</label>
                @endif
            </td>
        </tr>
    </table>
</body>
</html>
