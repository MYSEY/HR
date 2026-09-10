<table>
    <tr>
        <td colspan="11" align="center">
            <img src="{{ public_path('admin/img/logo/commalogo1.png') }}" height="100"><br>
            <strong> 
                @if ($data->kpi_form)
                    {{$data->kpi_form}}
                @endif
                @if ($data->pa_form)
                    {{$data->pa_form}}
                @endif
            </strong><br>
            <span style="font-size: 11px !important">ប្រចាំឆ្នាំ៖ {{ \Carbon\Carbon::parse($data->to_date)->format('Y') }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td colspan="3">(ពីថ្ងៃខែឆ្នាំ៖ {{ \Carbon\Carbon::parse($data->from_date)->format('d/m/Y') }}</td>
        <td colspan="4" align="left">ដល់ថ្ងៃខែឆ្នាំ៖ {{ \Carbon\Carbon::parse($data->to_date)->format('d/m/Y') }})</td>
    </tr>
    <tr style="background-color:chartreuse;"><td colspan="11" style="font-weight: bold;">ផ្នែកទី១៖ ព័ត៌មានទូទៅរបស់បុគ្គលិក</td></tr>

    <tr>
        <td>អត្តលេខធ្វើការ៖</td>
        <td colspan="3">{{ $data->number_employee }}</td>
        <td colspan="5" align="left">ថ្ងៃខែឆ្នាំចូលបម្រើការងារ៖ {{\Carbon\Carbon::parse($data->date_of_commencement)->format('d/m/Y')}}</td>
        <td colspan="2" align="left">ការិយាល័យ/សាខា ៖ {{$data->branch_name_kh}}</td>
    </tr>
    <tr>
        <td>ឈ្មោះបុគ្គលិក៖</td>
        <td colspan="3">{{ $data->employee_name_kh }}</td>
        <td colspan="5" align="left">រយៈពេលបម្រើការក្នុងមុខងារបច្ចុប្បន្ន (ខែ) ៖ {{ \Carbon\Carbon::parse($data->date_of_commencement)->diffInMonths(\Carbon\Carbon::parse($data->to_date)) }}</td>
        <td colspan="2" align="left">កូដការិយាល័យ៖ 000</td>
    </tr>
    <tr>
        <td>តួនាទី៖</td>
        <td colspan="3">{{ $data->positions_name_kh }}</td>
        <td colspan="5"></td>
        <td colspan="2" align="left">ឈ្មោះប្រធានគ្រប់គ្រងផ្ទាល់ ៖ {{$data->line_manager_name_kh}}</td>
    </tr>
    <tr style="background-color:chartreuse;"><td colspan="11" style="font-weight: bold;">ផ្នែកទី២៖ ការកំណត់គោលដៅ និងផែនការថ្មី</td></tr>
    <tr>
        <td colspan="2" style="font-weight: bold;">សូចនាករសមទ្ធិកម្មគន្លឹះ</td>
        <td colspan="2" style="font-weight: bold;">គោលដៅ/ផែនការ</td>
        <td colspan="5" style="font-weight: bold;">ការវាស់វែង</td>
        <td colspan="2" style="font-weight: bold;">ការវាយតម្លៃ ៖</td>
    </tr>
</table>

<table>
    <thead>
        <tr style="background-color: #f2f2f2; font-weight: bold;">
            <th style="font-weight: bold;">(KPI)</th>
            <th style="font-weight: bold;">ពណ៌នាផែនការសកម្មភាព (Action Plan)</th>
            <th style="font-weight: bold;">គោលដៅ</th>
            <th style="font-weight: bold;">Progress</th>
            <th style="font-weight: bold;">% ទម្ងន់</th>
            <th style="font-weight: bold;">ពិន្ទុសម្រេចបាន (Score Achieved)</th>
            <th style="font-weight: bold;">ពិន្ទុ (Score)</th>
            <th style="font-weight: bold;">បុគ្គលិកផ្ទាល់</th>
            <th style="font-weight: bold;">ប្រធានផ្ទាល់</th>
            <th style="font-weight: bold;">កត្តាដែលងាយស្រួល និងលំបាក</th>
            <th style="font-weight: bold;">យោបល់/កំណត់សម្គាល់</th>
        </tr>
    </thead>
    <tbody>
        @php $totalWeight = 0; $totalsByTitleId = [];@endphp

        @foreach ($data->titles as $title)
            <tr style="background-color: #f2f2f2; font-weight: bold;">
                <td colspan="11" align="center" style="font-weight: bold;">{{ $title->title }}</td>
            </tr>

            @foreach ($title->purposes as $purpose)
                <tr style="background-color: #fafafa;">
                    <td colspan="11" style="font-weight: bold;">{{ $purpose->name }}</td>
                </tr>
                @foreach ($purpose->performanceDetail as $detail)
                    @php
                        $totalWeight += (float) $detail->weight;
                        $titleId = $detail->title_id;
                        if (!isset($totalsByTitleId[$titleId])) {
                            $totalsByTitleId[$titleId] = [
                                'total_score' => 0,
                                'total_personnel_score' => 0,
                                'total_direct_chairman' => 0,
                            ];
                        }
                        $totalsByTitleId[$titleId]['total_score'] += (float) ($detail->score ?? 0);
                        $totalsByTitleId[$titleId]['total_personnel_score'] += (float) ($detail->score_live_staff ?? 0);
                        $totalsByTitleId[$titleId]['total_direct_chairman'] += (float) ($detail->score_direct_chairman ?? 0);

                        $currentTitleTotal = $totalsByTitleId[$title->id] ?? [
                            'total_score' => 0,
                            'total_personnel_score' => 0,
                            'total_direct_chairman' => 0,
                        ];
                    @endphp
                    <tr>
                        <td>{!! nl2br(e($detail->key_kpi)) !!}</td>
                        <td>{!! nl2br(e($detail->action_plan)) !!}</td>
                        <td>
                            @php
                                $typeArray = explode('_', $detail->goal_type);
                                $type = $typeArray[0] ?? 'number';
                                $symbol = '';
                                if ($type == 'percent') {
                                    $symbol = '%';
                                } elseif ($type == 'currency') {
                                    $symbol = '$';
                                } elseif ($type == 'number') {
                                    $symbol = '';
                                }
                            @endphp

                            @foreach ($detail->performanceGoals as $key => $pGoal)
                                <span>
                                    {{ "ពិន្ទុ " . ($key + 1) . " = " . $pGoal->from . $symbol . " ដល់ " . $pGoal->to . $symbol }}
                                </span><br>
                            @endforeach
                        </td>
                        <td>{{ $detail->progress }}</td>
                        <td>{{ $detail->weight }}</td>
                        <td>{{ $detail->score_achieved }}</td>
                        <td>{{ $detail->score }}</td>
                        <td>{{ $detail->score_live_staff }}</td>
                        <td>{{ $detail->score_direct_chairman }}</td>
                        <td>{{ $detail->easy_difficult_factors }}</td>
                        <td>{{ $detail->comment }}</td>
                    </tr>
                @endforeach
            @endforeach
            <tr class="total">
                 <td colspan="4" align="right" style="font-weight: bold;">សរុប = </td>
                 <td></td>
                 <td></td>
                 <td>
                    {{ number_format($currentTitleTotal['total_score'], 2) }}
                 </td>
                 <td>
                    {{ number_format($currentTitleTotal['total_personnel_score'], 2) }}
                 </td>
                 <td>
                     {{ number_format($currentTitleTotal['total_direct_chairman'], 2) }}
                 </td>
                 <td colspan="2"></td>
            </tr>
        @endforeach

        <tr style="font-weight: bold; background-color: #d9ead3;">
            <td colspan="4" align="right" style="font-weight: bold;">សរុបរួម (Total)</td>
            <td>{{ $totalWeight }}%</td>
            <td></td>
            <td>{{ $data->total_score ?? 0 }}</td>
            <td>{{ $data->total_score_live_staff ?? 0 }}</td>
            <td>{{ $data->total_score_direct_chairman ?? 0 }}</td>
            <td colspan="2"></td>
        </tr>
        <tr><td colspan="11" style="font-weight: bold;">ផ្នែកទី៣៖ ការវាយតម្លៃលើសមត្ថភាព (ប្រើនៅពេលវាយតម្លៃការងារ)</td></tr>
        <tr>
            <th rowspan="4">កម្រិតពិន្ទុ៖</th>
            <td colspan="7">លើសពីកម្រិតសមត្ថភាព/ចំណេះដឹងដែលទាមទារ</td>
            <td colspan="3">ប្រហាក់ប្រហែល រឺត្រូវនឹងកម្រិតសមត្ថភាព/ចំណេះដឹងដែលទាមទារ</td>
        </tr>
        <tr>
            <td colspan="7">៥ = ឆ្នើម (អនុវត្តន៍ការងារលើសផែនការ>20%)​</td>
            <td colspan="3">៣ = មធ្យម (អនុវត្តន៍ការងារគ្រប់ផែនការ)</td>
        </tr>
        <tr>
            <th rowspan="2" colspan="7">៤ = ល្អ (អនុវត្តន៍ការងារលើសផែនការ>10%)</th>
            <td colspan="3">២ = ត្រូវកែលម្អ​ (ក្រោមផែនការ)</td>
        </tr>
        <tr>
            <td colspan="3">១=  ខ្សោយ (ក្រោមផែនការ)</td>
        </tr>
        <tr><td colspan="11" style="font-weight: bold;">ផ្នែកទី៤៖ លទ្ធផលវាយតម្លៃសរុប  (ប្រើនៅពេលវាយតម្លៃការងារ)</td></tr>
        @php
            $overallResults = '';
            $color = '';
            $score = (float) $data->total_score_direct_chairman;
            if ($score === 0.00) {
                $overallResults = '';
            } else if ($score < 2) {
                $overallResults = 'ខ្សោយ_(ក្រោមផែនការ២០%)';
                $color = 'red';
            } else if ($score <= 2.99) {
                $overallResults = 'ត្រូវកែលម្អ_(ក្រោមផែនការ១០%)';
                $color = 'orange';
            } else if ($score <= 3.99) {
                $overallResults = 'មធ្យម_(អនុវត្តន៍ការងារគ្រប់ផែនការងារ)';
                $color = 'info';
            } else if ($score <= 4.99) {
                $overallResults = 'ល្អ_(អនុវត្តន៍ការងារលើសផែនការងារ១០%)';
                $color = 'lightgreen';
            } else {
                $overallResults = 'ឆ្នើម_(អនុវត្តន៍ការងារលើសផែនការ២០%)';
                $color = 'green';
            }
        @endphp
        <tr>
            <th rowspan="2" colspan="8">% ពិន្ទុវាយតម្លៃតាមគោលដៅ</th>
            <td colspan="2" align="center" style="font-weight: bold; background-color: #FFCCFF">លទ្ធផលរួម</td>
            <td align="center" style="font-weight: bold; background-color: #FFCCFF">កម្រិតពិន្ទុ៖</td>
        </tr>
        <tr>
            <td colspan="2" align="center" style="color: red">{{$overallResults}}</td>
            <td align="center" style="color: red">{{ $data->total_score_direct_chairman ?? 0 }}</td>
        </tr>
       <tr><td colspan="11" style="font-weight: bold;">ផ្នែកទី៥៖ យោបល់ និងសំណូមពរទូទៅរបស់បុគ្គលិក  (ប្រើនៅពេលវាយតម្លៃការងារ)</td></tr>
        <tr>
            <td colspan="3"style="font-weight: bold;">ក-ចំណុចខ្លាំង</td>
            <td colspan="4" align="center" style="font-weight: bold;">ចំនុចដែលត្រូវប្រែ និងអភិវឌ្ឍន៍បុគ្គលិក </td>
            <td colspan="4" align="center" style="font-weight: bold;">បំណងប្រាថ្នា និងផែនការអភិវឌ្ឍន៍មុខតំណែងក្នុងគ្រឹះស្ថានមីក្រូ ខេមា (រយៈពេល ៣ ទៅ ៥ ឆ្នាំ)</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="4"></td>
            <td colspan="4"></td>
        </tr>
    </tbody>
</table>
