<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<table id="rental-export" style="border-collapse: collapse; width: 100%; font-family: 'Khmer OS Battambang', 'Kantumruy Pro', sans-serif; font-size: 11px;">
    <!-- Section សម្រាប់ Logo និង VAT TIN ខាងលើ -->
    <tr>
        <td colspan="19" style="font-size: 14pt; font-family: 'Khmer OS Muol Pali', 'Khmer OS Muol Light', sans-serif; font-weight: bold; color: #FF0000; text-align: center; vertical-align: middle;">
            ខេមា​ មីក្រូហិរញ្ញវត្ថុ លីមីតធីត
        </td>
    </tr>
    <!-- Subtitle Khmer OS Muol Light -->
    <tr>
        <td colspan="19" style="font-size: 12pt; font-family: 'Khmer OS Muol Light', 'Khmer OS Muol', sans-serif; color: #000000; text-align: center; vertical-align: middle;">
            តារាងលម្អិតការគណនាថ្លៃជួលម៉ូតូ និងTablet/Ipad បុគ្គលិក
        </td>
    </tr>
    <tr>
        @php
            $khmerMonths = [
                1 => 'មករា', 2 => 'កុម្ភៈ', 3 => 'មីនា', 4 => 'មេសា', 
                5 => 'ឧសភា', 6 => 'មិថុនា', 7 => 'កក្កដា', 8 => 'សីហា', 
                9 => 'កញ្ញា', 10 => 'តុលា', 11 => 'វិច្ឆិកា', 12 => 'ធ្នូ'
            ];
            $monthNumber = \Carbon\Carbon::parse($date)->format('n');
            $yearNumber = \Carbon\Carbon::parse($date)->format('Y');
        @endphp
        <td colspan="19" style="font-weight: bold; color: #000; text-align: center;">សម្រាប់ខែ{{$khmerMonths[$monthNumber] ?? '' }} ឆ្នាំ{{$yearNumber }}</td>
    </tr>
    <tr>
        <td colspan="19" style="border: none; text-align: left; font-size: 12pt; font-weight: bold; color: #000; padding: 5px 0;">
            VAT TIN: L001-107008408
        </td>
    </tr>

    <tr>
        <td colspan="19" style="border: none; height: 15px;"></td>
    </tr>

    <!-- Table Header -->
    <thead>
        <!-- Row 1: Header ជួរលើ -->
        <tr style="background-color: #f2f2f2;">
            <th rowspan="2" style="border: 1px solid #000; background-color: #EFEFEF; font-weight: bold; text-align: center; vertical-align: middle;">ល.រ</th>
            <th rowspan="2" style="border: 1px solid #000; background-color: #EFEFEF; font-weight: bold; text-align: center; vertical-align: middle;">អត្តលេខ<br/>បុគ្គលិក</th>
            <th rowspan="2" style="border: 1px solid #000; background-color: #EFEFEF; font-weight: bold; text-align: center; vertical-align: middle;">នាម និង<br/>គោត្តនាម</th>
            <th rowspan="2" style="border: 1px solid #000; background-color: #EFEFEF; font-weight: bold; text-align: center; vertical-align: middle;">ភេទ</th>
            <th rowspan="2" style="border: 1px solid #000; background-color: #EFEFEF; font-weight: bold; text-align: center; vertical-align: middle;">តួនាទី</th>
            <th rowspan="2" style="border: 1px solid #000; background-color: #EFEFEF; font-weight: bold; text-align: center; vertical-align: middle;">ទីតាំងការងារ</th>
            <th rowspan="2" style="border: 1px solid #000; background-color: #EFEFEF; font-weight: bold; text-align: center; vertical-align: middle;">ចំនួនថ្ងៃធ្វើការ</th>
            <th rowspan="2" style="border: 1px solid #000; background-color: #EFEFEF; font-weight: bold; text-align: center; vertical-align: middle;">ចំនួនខែ(ខែទី១)</th>
            <th rowspan="2" style="border: 1px solid #000; background-color: #EFEFEF; font-weight: bold; color: #FF0000; text-align: center; vertical-align: middle;">ចំនួនថ្ងៃនៅសល់ (កាត់<br/>កម្រៃជួលអាល់ប៊ុម)<br/>(ខែទី២)</th>
            <th rowspan="2" style="border: 1px solid #000; background-color: #EFEFEF; font-weight: bold; color: #FF0000; text-align: center; vertical-align: middle;">ចំនួនច្បាប់បុគ្គលិក/<br/>ចំនួនថ្ងៃត្រូវចាត់ទុក<br/>បុគ្គលិក</th>
            <th rowspan="2" style="border: 1px solid #000; background-color: #FFFF00; font-weight: bold; text-align: center; vertical-align: middle;">ថ្លៃជួលម៉ូតូ<br/>បុគ្គលិកគោល</th>
            <th rowspan="2" style="border: 1px solid #000; background-color: #FFFF00; font-weight: bold; text-align: center; vertical-align: middle;">ថ្លៃជួល<br/>Tablet/Ipadគោល</th>
            <th rowspan="2" style="border: 1px solid #000; background-color: #EFEFEF; font-weight: bold; text-align: center; vertical-align: middle;">ថ្លៃជួលម៉ូតូ(កាត់កម្រៃ<br/>កាត់កម្រៃបុគ្គលិកតាម<br/>ចំនួនច្បាប់)</th>
            <th rowspan="2" style="border: 1px solid #000; background-color: #EFEFEF; font-weight: bold; text-align: center; vertical-align: middle;">ថ្លៃជួលម៉ូតូ(កាត់កម្រៃ<br/>ថ្ងៃអាល់ប៊ុម)<br/>(ខែទី២)</th>
            <th colspan="3" style="border: 1px solid #000; background-color: #EFEFEF; font-weight: bold; text-align: center; vertical-align: middle;">ថ្លៃជួលទទួលបានមុនកាត់ពន្ធ</th>
            <th rowspan="2" style="border: 1px solid #000; background-color: #EFEFEF; font-weight: bold; text-align: center; vertical-align: middle;">ពន្ធលើថ្លៃជួលសរុប 10%($)</th>
            <th rowspan="2" style="border: 1px solid #000; background-color: #EFEFEF; font-weight: bold; text-align: center; vertical-align: middle;">ថ្លៃជួលសរុប<br/>ទទួលបានបន្ទាប់ពី<br/>កាត់ពន្ធ($)</th>
        </tr>

        <!-- Row 2: Sub-Header -->
        <tr style="background-color: #f2f2f2;">
            <th style="border: 1px solid #000; background-color: #EFEFEF; font-weight: bold; text-align: center; vertical-align: middle;">ថ្លៃជួលម៉ូតូ<br/>បុគ្គលិក</th>
            <th style="border: 1px solid #000; background-color: #EFEFEF; font-weight: bold; text-align: center; vertical-align: middle;">ថ្លៃជួល<br/>Tablet/Ipad</th>
            <th style="border: 1px solid #000; background-color: #EFEFEF; font-weight: bold; text-align: center; vertical-align: middle;">ថ្លៃជួលទទួលបានសរុប<br/>មុនកាត់ពន្ធ($)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $item)
            @php
                $total_working_day = 0;
                $leave_days = 0;
                $leave_amount = 0;
                $motor_price = 0;
                $motor_amount = 0;
                $tablet_price = 0;
                $table_amount = 0;
                if (!empty($item->details)) {
                    foreach ($item->details as $detail) {
                        if ($detail->type == "motorcycle") {
                            $total_working_day  = $detail->total_work_day ?? 0;
                            $motor_price        = $detail->price ?? 0;
                            $leave_days         = $detail->total_leave_days ?? 0;
                            $leave_amount       = $detail->leave_amount ?? 0;
                            $motor_amount       = $detail->amount ?? 0;
                        }
                        if ($detail->type == "tablet") {
                            $tablet_price       = $detail->price ?? 0;
                            $table_amount       = $detail->amount ?? 0;
                        }
                    }
                }
            @endphp
        <tr>
            <td style="border: 1px solid #000; text-align: center; vertical-align: middle;">{{ $key + 1 }}</td>
            <td style="border: 1px solid #000; text-align: center; vertical-align: middle;">{{ $item->user->number_employee ?? '' }}</td>
            <td style="border: 1px solid #000; text-align: left; vertical-align: middle;">{{ $item->user->employee_name_kh ?? '' }}</td>
            <td style="border: 1px solid #000; text-align: center; vertical-align: middle;">{{ $item->user->gender->name_khmer ?? '' }}</td>
            <td style="border: 1px solid #000; text-align: left; vertical-align: middle;">{{ $item->user->position->name_khmer ?? '' }}</td>
            <td style="border: 1px solid #000; text-align: center; vertical-align: middle;">{{ $item->user->branch->branch_name_en ?? '' }}</td>
            <td style="border: 1px solid #000; text-align: center; vertical-align: middle;">{{ $total_working_day ?? 0 }}</td>
            <td style="border: 1px solid #000; text-align: center; vertical-align: middle;">1</td>
            <td style="border: 1px solid #000; color: #FF0000; text-align: center; vertical-align: middle;">0</td>
            <td style="border: 1px solid #000; color: #FF0000; text-align: center; vertical-align: middle;">{{ $leave_days ?? 0 }}</td>
            <td style="border: 1px solid #000; background-color: #FFFF00; font-weight: bold; text-align: right; vertical-align: middle;">{{ $motor_price ?? 0 }}</td>
            <td style="border: 1px solid #000; background-color: #FFFF00; font-weight: bold; text-align: right; vertical-align: middle;">{{ $tablet_price ?? 0 }}</td>
            <td style="border: 1px solid #000; text-align: right; vertical-align: middle;">{{ $leave_amount ?? 0 }}</td>
            <td style="border: 1px solid #000; text-align: right; vertical-align: middle;">0</td>
            <td style="border: 1px solid #000; text-align: right; vertical-align: middle;">{{ $motor_amount ?? 0 }}</td>
            <td style="border: 1px solid #000; text-align: right; vertical-align: middle;">{{ $table_amount ?? 0 }}</td>
            <td style="border: 1px solid #000; font-weight: bold; text-align: right; vertical-align: middle;">{{ $item->total_amount_usd ?? 0 }}</td>
            <td style="border: 1px solid #000; text-align: right; vertical-align: middle;">{{ $item->total_tax_fee_usd ?? 0 }}</td>
            <td style="border: 1px solid #000; font-weight: bold; text-align: right; vertical-align: middle;">{{ $item->total_net_amount_usd ?? 0 }}</td>
        </tr>
        @endforeach
    </tbody>

    <!-- Table Footer - Total Row -->
    @php
        $startRow = 8; // ជួរចាប់ផ្តើមទិន្នន័យដំបូងក្នុង Excel (Header មាន 5 ជួរ)
        $count = count($data);
        $endRow = $startRow + $count - 1; // ជួរចុងក្រោយនៃទិន្នន័យ
    @endphp
    <tfoot>
        <tr style="background-color: #EFEFEF; font-weight: bold;">
            <td colspan="10" style="border: 1px solid #000; text-align: center; vertical-align: middle; font-weight: bold;">សរុប (Total)</td>
            <td style="border: 1px solid #000; text-align: right; vertical-align: middle; font-weight: bold;">=SUM(K{{ $startRow }}:K{{ $endRow }})</td>
            <td style="border: 1px solid #000; text-align: right; vertical-align: middle; font-weight: bold;">=SUM(L{{ $startRow }}:L{{ $endRow }})</td>
            <td style="border: 1px solid #000; text-align: right; vertical-align: middle; font-weight: bold;">=SUM(M{{ $startRow }}:M{{ $endRow }})</td>
            <td style="border: 1px solid #000; text-align: right; vertical-align: middle; font-weight: bold;">=SUM(N{{ $startRow }}:N{{ $endRow }})</td>
            <td style="border: 1px solid #000; text-align: right; vertical-align: middle; font-weight: bold;">=SUM(O{{ $startRow }}:O{{ $endRow }})</td>
            <td style="border: 1px solid #000; text-align: right; vertical-align: middle; font-weight: bold;">=SUM(P{{ $startRow }}:P{{ $endRow }})</td>
            <td style="border: 1px solid #000; text-align: right; vertical-align: middle; font-weight: bold;">=SUM(Q{{ $startRow }}:Q{{ $endRow }})</td>
            <td style="border: 1px solid #000; text-align: right; vertical-align: middle; font-weight: bold;">=SUM(R{{ $startRow }}:R{{ $endRow }})</td>
            <td style="border: 1px solid #000; text-align: right; vertical-align: middle; font-weight: bold;">=SUM(S{{ $startRow }}:S{{ $endRow }})</td>
        </tr>
    </tfoot>
</table>

</body>
</html>