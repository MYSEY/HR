
<div id="print_appointment_resolution" hidden>
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
                        <strong>លេខៈ ខមល......../២.......</strong>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <br>
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
                    HRM-022
                    <br><br>
                    <span style="font-size: 8pt; font-weight: normal;">Doc No:.............</span>
                </span>
            </div>
            <label class="label-subs">
                <strong>រាជធានីភ្នំពេញ ថ្ងៃទី{{$khmer_day}}..ខែ{{$khmer_month_name}}..ឆ្នាំ២០{{$khmer_year_short}}</strong>
            </label><br><br><br>
        </div>
    </div>
    <br>
    <div class="font-sub-title">
        <label class="label-sub" style="font-size: 14px;font-family:Khmer OS Muol Light">សេចក្តីសម្រេច</label><br>
        <label class="label-sub" style="font-size: 14px;font-family:Khmer OS Muol Light">ស្តីពី</label>
    </div><br><br>
    <div style="margin-left: 12%">
        <label class="label-sub" style="font-size: 14px;font-family:Khmer OS Muol Light">ការតែងតាំង <span class="pr_mr_or_mrs"></span>  ...</strong> <strong class="pr_name"></strong>...ជា ...<strong class="pr_position"></strong>...</label><br>
    </div><br>
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
                                - លក្ខន្តិកៈរបស់គ្រឹះស្ថាន ខេមា មីក្រូហិរញ្ញវត្ថុ លីមីតធីត ។
                            </td>
                        </tr>
                        <tr>
                            <td class="table_tr" style="white-space: nowrap !important">
                                - លិខិតតែងតំាងលេខៈខមល ......./២...... ចុះថ្ងៃ{{$khmer_day}}..ខែ{{$khmer_month_name}}..ឆ្នាំ២០{{$khmer_year_short}}។
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div style="text-align: center;">
                <label class="label-sub" style="font-size: 14px;font-family:Khmer OS Muol Light">សម្រេច</label>
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
                                <strong class="pr_mr_or_mrs"></strong> <strong class="pr_name"></strong> តួនាទីជា <strong class="pr_position"></strong> 
                                អត្តសញ្ញាណប័ណ្ណការងារលេខ...<strong class="pr_employee_id"></strong>.... នៅកម្រិតទី...<strong class="level"></strong>...ប្រចាំ...<strong class="pr_branch"></strong>... ហើយនឹងទទួលបានប្រាក់បៀវត្សគោលចំនួន..<strong class="pr_basic_salary"></strong>..<strong>ដុល្លារអាមេរិក</strong> និងអត្ថប្រយោជន៍ផ្សេងៗទៅតាមគោលការណ៍របស់គ្រឹះស្ថាន ខេមា មីក្រូហិរញ្ញវត្ថុ លីមីតធីត។
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
                            <td class="table_tr" style="white-space: nowrap !important">
                                សេចក្តីសម្រេចនេះមានប្រសិទ្ធភាពចាប់ពី ថ្ងៃទី <strong class="pr_join_day"></strong> ខែ <strong class="pr_join_month"></strong> ឆ្នាំ <strong class="pr_join_year"></strong>.. នេះតទៅ។
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
                                សាមីខ្លួនមិនត្រូវសួរអំពីប្រាក់បៀវត្សរបស់បុគ្គលិកដទៃ និងមិនត្រូវប្រាប់ពីប្រាក់បៀវត្សរបស់ខ្លួនទៅបុគ្គលិកផ្សេងឡើយ។
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
                            <td class="table_tr" style="white-space: nowrap !important">
                                សេចក្តីសម្រេចណាដែលមានខ្លឹមសារផ្ទុយពីសេចក្តីសម្រេចនេះចាត់ទុកជានិរាករណ៍។
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="style-table">
                <div>
                    <table style="width:100%">
                        <tr>
                            <td class="table_tr" style="white-space: nowrap !important"><strong>ប្រការ ៥.</strong></td>
                        </tr>
                    </table>
                </div>
                <div>
                    <table style="width:100%">
                        <tr>
                            <td class="table_tr" style="white-space: nowrap !important">
                                <strong>បុគ្គលិក</strong> នឹងត្រូវធ្វើការវាយតម្លៃការងារសាកល្បងនៅ ថ្ងៃទី<strong class="pr_end_day"></strong> ខែ <strong class="pr_end_month"></strong> ឆ្នាំ <strong class="pr_end_year"></strong>.. ខាងមុខនេះ។
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="style-table">
                <div>
                    <table style="width:100%">
                        <tr>
                            <td class="table_tr" style="white-space: nowrap !important"><strong>ប្រការ ៦.</strong></td>
                        </tr>
                    </table>
                </div>
                <div>
                    <table style="width:100%">
                        <tr>
                            <td class="table_tr">
                                សាមីខ្លួន នាយក/នាយិកា គ្រប់នាយកដ្ឋាន និងការិយាល័យ-សាខាទាំងអស់ របស់គ្រឹះស្ថាន ខេមា មីក្រូហិរញ្ញវត្ថុ លីមីតធីត ត្រូវអនុវត្តឲ្យបានត្រឹមត្រូវ និងមានប្រសិទ្ធភាពខ្ពស់បំផុត។
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <br><br>
            <div style="
                    display: flex; 
                    justify-content: space-between; 
                    align-items: flex-start; 
                    width: 100%; 
                ">

                <div style="font-size: 9pt; text-align: left; line-height: 1.6; margin-top: 60px;">
                    <strong style="font-family: 'Khmer OS Muol Light', serif; text-decoration: underline;">ចម្លងជូនៈ</strong>
                    <ul style="list-style-type: none; padding-left: 0; margin-top: 5px; margin-bottom: 0;">
                        <li>- សាមីខ្លួន</li>
                        <li style="padding-left: 15px; font-style: italic;">“ដើម្បីជ្រាបជាព័ត៌មាន និងអនុវត្ត”</li>
                        <li>- ឯកសារ-កាលប្បវត្តិ</li>
                    </ul>
                </div>

                <div style="text-align: center; min-width: 4cm; position: relative; padding-right: 20px;">
                    <div style="font-family: 'Khmer OS Muol Light', serif; font-size: 11pt; margin-bottom: 1.8cm;">
                        អគ្គនាយកប្រតិបត្តិ
                    </div>
                    
                    <div class="pr_ceo" style="font-family: 'Khmer OS Muol Light', serif; font-size: 11pt;"></div>
                </div>

            </div>
        </div>
    </div>
</div>