
<div id="print_appointed_letter" hidden>
    <div class="card-header">
        <div>
            <div style="text-align: center" class="font-title">
                <label class="title" style="font-size: 14px;font-family: Khmer OS Muol Pali">ខេមា មីក្រូហិរញ្ញវត្ថុ លីមីតធីត</label><br>
                <label style="font-size: 10px;font-family:Copperplate Gothic Bold">Camma Microfinance Limited</label><br>
                <img style="width: 10% ;height: 1.2%;font-family: Copperplate Gothic Bold"alt='White' id="image_logo_print" src="http://127.0.0.1:8000/admin/img/icon.PNG">
            </div>
            <div style="margin-top: -65px; margin-left: -6%">
                <img style="width:auto;height: 10%;"alt='White' id="image_logo_print"
                    src="http://127.0.0.1:8000/admin/img/logo/cammalogo.png">
            </div>
        </div>
    </div>
    <br>
    <div style="display:flex;" class="set-font">
        <div style="width: 487%;">
            <table style="width:100%">
                <tr>
                    <td class="table_tr" style="font-size: 14px;font-family: Khmer OS Battambang">
                        ការិយាល័យកណ្តាល
                    </td>
                </tr>
                <tr>
                    <td class="table_tr" style="font-size: 14px;font-family: Khmer OS Battambang">
                        <strong>លេខៈ ខមល-នធមរ ......../២.......</strong>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <br>
    <div style="display: flex; justify-content: flex-end; width: 100%; position: relative;">
        <div class="payslip-title-center">
            <div style="
                    position: absolute;
                    right: 0;
                    top: -80% !important;
                    transform: translateY(-50%);
                    width: 2.8cm; 
                    height: 1.6cm; 
                    border: 1px solid #9c4543;
                    box-sizing: border-box; 
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 5px; 
                    text-align: center;
                    background-color: #fafafa;
                    flex-shrink: 0;
                ">
                <span style="
                    font-size: 9pt; 
                    line-height: 1.3; 
                    color: #000; 
                    font-family: 'Arial', 'Siemreap', sans-serif;
                    font-weight: bold;
                ">
                    HRM-021
                    <br><br>
                    <span style="font-size: 8pt; font-weight: normal;">Doc No:.............</span>
                </span>
            </div>
            <?php
                // ១. បង្កើតទិន្នន័យសម្រាប់បកប្រែជាភាសាខ្មែរ
                $khmer_numbers = ['០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩'];
                $khmer_months = [
                    1 => 'មករា', 2 => 'កុម្ភៈ', 3 => 'មីនា', 4 => 'មេសា', 5 => 'ឧសភា', 6 => 'មិថុនា',
                    7 => 'កក្កដា', 8 => 'សីហា', 9 => 'កញ្ញា', 10 => 'តុលា', 11 => 'វិច្ឆិកា', 12 => 'ធ្នូ'
                ];
                $day   = date('d'); 
                $month = (int)date('m');
                $year  = date('Y');
                $khmer_day = str_replace(range(0, 9), $khmer_numbers, $day);
                $year_short = substr($year, 2, 2); 
                $khmer_year_short = str_replace(range(0, 9), $khmer_numbers, $year_short);

                $khmer_month_name = $khmer_months[$month];
            ?>
            <label class="label-subs">
                <strong>រាជធានីភ្នំពេញ ថ្ងៃទី{{$khmer_day}}..ខែ{{$khmer_month_name}}..ឆ្នាំ២០{{$khmer_year_short}}</strong>
            </label><br><br><br>
        </div>
    </div>
    <br>
    <div class="font-sub-title">
        <label class="label-sub" style="font-size: 14px;font-family:Khmer OS Muol Light">លិខិតតែងតាំង</label>
    </div><br><br>
    <div style="display:flex;" class="set-font">
        <div style="width: 487%;">
            <div class="style-table">
                <div>
                    <table style="width:100%">
                        <tr>
                            <td class="table_tr" style="white-space: nowrap !important"><strong>យោង ៖</strong></td>
                        </tr>
                    </table>
                </div>
                <div>
                    <table style="width:100%">
                        <tr>
                            <td class="table_tr" style="white-space: nowrap !important">
                                - តម្រូវការចាំបាច់របស់គ្រឹះស្ថាន ខេមា មីក្រូហិរញ្ញវត្ថុ លីមីតធីត ។
                            </td>
                        </tr>
                        <tr>
                            <td class="table_tr" style="white-space: nowrap !important">
                                - លទ្ធផលសម្ភាសន៍របស់បេក្ខជន/បេក្ខនារី ចុះថ្ងៃទី.<strong class="pr_contract_day"></strong>..ខែ.<strong class="pr_contract_month"></strong>..ឆ្នាំ<strong class="pr_contract_year"></strong>។
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div style="text-align: center;">
                <label class="label-sub" style="font-size: 14px;font-family:Khmer OS Muol Light">គ្រឹះស្ថាន ខេមា មីក្រូហិរញ្ញវត្ថុ សម្រេច ៖</label>
            </div>
            <br>
            <div class="style-table">
                <div>
                    <table style="width:100%">
                        <tr>
                            <td class="table_tr" style="white-space: nowrap !important"><strong>ប្រការ ១.</strong></td>
                        </tr>
                    </table>
                </div>
                <div>
                    <table style="width:100%">
                        <tr>
                            <td class="table_tr">
                                តែងតាំង <strong class="pr_mr_or_mrs"></strong> <strong class="pr_name"></strong> តួនាទីជា <strong class="pr_position"></strong> នៅកម្រិតទី...<strong class="level"></strong>...ប្រចាំ...<strong class="pr_branch"></strong>... និងក្រោមការគ្រប់គ្រងផ្ទាល់របស់...<strong class="pr_line_manager_position"></strong>............។
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="style-table">
                <div>
                    <table style="width:100%">
                        <tr>
                            <td class="table_tr" style="white-space: nowrap !important"><strong>ប្រការ ២.</strong></td>
                        </tr>
                    </table>
                </div>
                <div>
                    <table style="width:100%">
                        <tr>
                            <td class="table_tr">
                                <strong>បុគ្គលិក</strong> ត្រូវខិតខំប្រឹងប្រែងអនុវត្តន៍ទៅតាមបទពិពណ៌នាការងារ និងគោរពតាមបទបញ្ជាផ្ទៃក្នុង និងច្បាប់នានា របស់គ្រឹះស្ថាន ខេមា មីក្រូហិរញ្ញវត្ថុ លីមីតធីត។ ចំណែកប្រាក់បៀវត្ស និងអត្ថប្រយោជន៍ ផ្សេងៗដែល <strong>បុគ្គលិក</strong> នឹងទទួលបានគឺអាស្រ័យទៅតាមគោលការណ៍របស់គ្រឹះស្ថាន  ខេមា មីក្រូហិរញ្ញវត្ថុ លីមីតធីត។
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
           
            <div class="style-table">
                <div>
                    <table style="width:100%">
                        <tr>
                            <td class="table_tr" style="white-space: nowrap !important"><strong>ប្រការ ៣.</strong></td>
                        </tr>
                    </table>
                </div>
                <div>
                    <table style="width:100%">
                        <tr>
                            <td class="table_tr" style="white-space: nowrap !important">
                                ការតែងតាំងនេះប្រសិទ្ធភាពចាប់ពីថ្ងៃទី..<strong class="pr_join_day"></strong>..ខែ<strong class="pr_join_month"></strong>..ឆ្នាំ<strong class="pr_join_year"></strong>... នេះទៅ។ 
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="style-table">
                <div>
                    <table style="width:100%">
                        <tr>
                            <td class="table_tr" style="white-space: nowrap !important"><strong>ប្រការ ៤.</strong></td>
                        </tr>
                    </table>
                </div>
                <div>
                    <table style="width:100%">
                        <tr>
                            <td class="table_tr">
                                បុគ្គលិកគ្រប់ផ្នែកទាំងអស់ត្រូវចូលរួមសហការដើម្បី <strong>បុគ្គលិកខាងលើ</strong> អនុវត្តភារកិច្ចប្រកបដោប្រសិទ្ធភាពខ្ពស់បំផុត។
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <br><br>
            <div style="display: flex">
                <div class="payslip-title-center" >
                <div style="
                        position: absolute;
                        right: 1;
                        transform: translateY(-50%);
                        width: 3.8cm; 
                        height: 2.6cm; 
                        box-sizing: border-box; 
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        padding: 5px; 
                        text-align: center;
                        background-color: #fafafa;
                        flex-shrink: 0;
                    ">
                    <span style="
                        font-size: 10pt; 
                        line-height: 1.3;
                        font-family:  Khmer OS Muol Light, serif;
                    ">
                        អគ្គនាយកប្រតិបត្តិ
                        <br><br><br><br>
                        <span style="font-weight: bold; font-family:  Khmer OS Muol Light, serif;" class="pr_ceo">  </span>
                    </span>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>