<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ExportLoanDetailListing implements FromCollection, WithColumnWidths, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $export_datas;

    public function __construct($request)
    {
        // -------------------------
        // 1) SUBQUERY FIXED
        // -------------------------
        $subQuery = DB::connection('pgsql')
            ->table('MKT_PD_DATE')
            ->where(function ($q) {
                $q->where('OutIntAmountAS', '>', 0)
                ->orWhere('OutPriAmountAS', '>', 0);
            })
            ->select(
                DB::raw('"ID"'),
                DB::raw('MAX(CAST("NumDayDue" AS INTEGER)) AS "DueDay"'),
                DB::raw('MAX("DueDate") AS "DueDate"'),
                DB::raw('MAX("OutIntAmountAS") AS "OutIntAmountAS"'),
                DB::raw('MAX("OutPriAmountAS") AS "OutPriAmountAS"')
            )
        ->groupBy('ID');

        $subQueryACCENTR = DB::connection('pgsql')
        ->table('MKT_ACC_ENTRY')
        ->select(
            'Reference',
            DB::raw('MAX("TransactionDate") AS "LastPaymentDate"')
        )
        ->groupBy('Reference');

        // -------------------------
        // 2) MAIN QUERY
        // -------------------------
        $query = DB::connection('pgsql')
            ->table('MKT_LOAN_CONTRACT as LC')
            ->select([
                'LC.ID',
                'LC.ContractCustomerID',
                'LC.Branch',
                'LC.Account',
                'LC.Currency',
                'LC.Disbursed',
                'LC.LoanBalanceAS',
                'LC.OutstandingAmountAS',
                'LC.InterestRate',
                'LC.AIRAS',
                'LC.AIRCurrentAS',
                'LC.TotalInterest',
                'LC.ValueDate',
                'LC.MaturityDate',
                'LC.Term',
                'LC.DisbursedStat',
                'LC.AssetClass',
                'LC.MoreThanOneYear',
                'LC.CBCSubSection',
                'LC.LoanPurpose',
                'LC.ContractOfficerID',
                'LC.LoanType',
                'LC.RestructuredCycle',
                'LCol.Collateral as CollateralID',
                'LC.Amount',
                'LC.OutstandingAmount',
                'LC.EIRRate',
                'LC.AccrInterest',
                'LC.IntIncEarned',
                'LC.Sector as MACode',
                'LC.LoanProduct',
                'LC.Cycle',
                'LC.SubAmount',
                'LC.SubLoanPurpose',
                'LC.PartneredWith',
                'LC.RestructureType',
                'CUST.LastNameEn',
                'CUST.FirstNameEn',
                'CUST.Gender',
                'CUST.IDType',
                'CUST.IDNumber',
                'CUST.Mobile1',
                'CUST.Mobile2',
                'CUST.CBCISSubSection as CBCISSubSectionCuSt',
                'CUST.Village as AddressCode',
                'CUST.Street',
                'VL.LocalDescription as Village',
                'CM.LocalDescription as Commune',
                'DS.LocalDescription as District',
                'PR.LocalDescription as Province',
                'Sct.Description as MADes',
                'LPr.Description as LoanProductDes',
                'PD.DueDay',
                'PD.DueDate as OverdueDate',
                'LCh1.Charge AS LoanCharge101',
                'LCh1.Charge AS LoanCharge',
                'LCh1.ChargeEarned',
                'LCh1.ChargeUnearned',
                'LCh2.Charge AS LoanCharge102',
                'LCh2.Charge as RegularCharge',
                'POS.Description as CustomerOccupation',
                'SD.RepMode as ScheduleType',
                'ACC.Reference',
                'ACC.LastPaymentDate',
            ])

            // CUSTOMER AND REFERENCE TABLES
            ->leftJoin('MKT_CUSTOMER as CUST', 'LC.ContractCustomerID', '=', 'CUST.ID')
            ->leftJoin('MKT_SCHED_DEFINE as SD', 'LC.ID', '=', 'SD.ID')
            ->leftJoin('MKT_POSITION as POS', 'POS.ID', '=', 'CUST.Position')
            ->leftJoin('MKT_VILLAGE as VL', 'CUST.Village', '=', 'VL.ID')
            ->leftJoin('MKT_COMMUNE as CM', 'CUST.Commune', '=', 'CM.ID')
            ->leftJoin('MKT_DISTRICT as DS', 'CUST.District', '=', 'DS.ID')
            ->leftJoin('MKT_PROVINCE as PR', 'CUST.Province', '=', 'PR.ID')
            ->leftJoin('MKT_SECTOR as Sct', 'LC.Sector', '=', 'Sct.ID')
            ->leftJoin('MKT_LOAN_COLLATERAL as LCol', 'LC.ID', '=', 'LCol.ID')
            ->leftJoin('MKT_LOAN_PRODUCT as LPr', 'LC.LoanProduct', '=', 'LPr.ID')

            // -------------------------
            // SUBQUERY JOIN FIXED
            // -------------------------
            ->leftJoinSub($subQuery, 'PD', function ($join) {
                $join->whereRaw('"PD"."ID" = \'PD\' || "LC"."ID"');
            })
            
            ->leftJoinSub($subQueryACCENTR, 'ACC', function ($join) {
                $join->on('ACC.Reference', '=', 'LC.ID');
            })
            // LOAN CHARGES
            ->leftJoin('MKT_LOAN_CHARGE as LCh1', function($q){
                $q->on('LC.ID', '=', 'LCh1.ID')
                ->where('LCh1.ChargeKey', '=', 101);
            })
            ->leftJoin('MKT_LOAN_CHARGE as LCh2', function($q){
                $q->on('LC.ID', '=', 'LCh2.ID')
                ->where('LCh2.ChargeKey', '=', 102);
            });

        // -------------------------
        // FILTERS (if used)
        // -------------------------
        $query->when($request->branch_id, fn($q,$branch_id) =>
            $q->where('LC.Branch', $branch_id)
        );

        // GET DATA
        $data = $query->get();

        // -------------------------
        // EXPORT FORMAT
        // -------------------------
        $dataExcel = [];
        foreach ($data as $row) {
            $dataExcel[] = [
                $row->ID,
                $row->ContractCustomerID,
                $row->LastNameEn . ' ' . $row->FirstNameEn,
                $row->Branch,
                $row->Gender,
                $row->Street,
                $row->Village,
                $row->Commune,
                $row->District,
                $row->Province,
                $row->Account,
                $row->Currency,
                $row->Disbursed,
                $row->LoanBalanceAS,
                $row->OutstandingAmountAS,
                $row->InterestRate,
                $row->AIRAS,
                $row->AIRCurrentAS,
                $row->TotalInterest,
                // $row->ValueDate,
                // $row->MaturityDate,
                $this->formatDate($row->ValueDate),
                $this->formatDate($row->MaturityDate),
                $row->LoanProduct . ' ' .$row->LoanProductDes,
                $row->Term,
                $row->DisbursedStat,
                $row->AssetClass,
                $row->MoreThanOneYear,
                $row->CBCSubSection,
                $row->CBCISSubSectionCuSt,
                $row->MACode,
                $row->MADes,
                $row->LoanPurpose,
                $row->ContractOfficerID,
                $row->IDType,
                $row->IDNumber,
                // $row->LastPaymentDate,
                $this->formatDate($row->LastPaymentDate),
                $row->DueDay,
                // $row->OverdueDate,
                $this->formatDate($row->OverdueDate),
                $row->LoanType,
                $row->LoanCharge,
                $row->ChargeEarned,
                $row->ChargeUnearned,
                $row->ScheduleType,
                $row->CustomerOccupation,
                $row->RestructuredCycle,
                $row->AddressCode,
                $row->CollateralID,
                $row->Mobile1. ' '. $row->Mobile2,
                $row->Cycle,
                $row->Amount,
                $row->OutstandingAmount,
                $row->EIRRate,
                $row->AccrInterest,
                $row->IntIncEarned,
                $row->RegularCharge,
                $row->SubAmount,
                $row->SubLoanPurpose,
                $row->PartneredWith,
                $row->RestructureType,
            ];
        }

        $this->export_datas = $dataExcel;
    }


    private function formatDate($date)
    {
        if (!$date) return '';
        return date('m/d/Y', strtotime($date));
    }
    public function collection()
    {
        return new Collection([
            $this->export_datas,
        ]);
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function headings(): array
    {
        return [
            "ID",
            "Customer ID",
            "Name",
            "Branch",
            "Gender",
            "Address",
            "Village",
            "Commune",
            "District",
            "Province",
            "Account #",
            "Currency",
            "Disburse",
            "Loan Amount AS",
            "Outstanding Amount AS",
            "Interest Rate AS",
            "Accrued Interest AS",
            "Interest Earned ($)",
            "Total Interest",
            "Disbursement Date",
            "Maturity Date",
            "Loan Product",
            "Term",
            "Status",
            "Asset Class",
            "More Than One Year",
            "CBCSubSection (Loan)",
            "CBCSubSection (Customer)",
            "MA Code",
            "MA Description",
            "Loan Purpose",
            "Officer",
            "ID Type",
            "ID Number",
            "Last Payment Date",
            "Overdue Days",
            "Overdue Date",
            "Loan Type",
            "Loan Charge(%)",
            "Charge Earned",
            "Charge Unearned",
            "Schedule Type (1=Dec, 2=Ann)",
            "Customer Occupation",
            "Restructured Cycle",
            "Address Code",
            "Collateral ID",
            "Customer Phone Number",
            "Loan Cycle",
            "Loan Amount FIRS",
            "Outstanding Amount FIRS",
            "Interest Rate FIRS",
            "Interest Per Day FIRS",
            "Accrued Interest FIRS",
            "Regular Charge(%)",
            "Sub Amount",
            "Sub Loan Purpose",
            "Partnered With",
            "Restructure Type",
        ];
    }

    public function columnWidths(): array
    {
        $columns = [];

        // A → Z
        foreach (range('A', 'Z') as $col) {
            $columns[$col] = 18; // default width
        }

        // AA → ZZ
        foreach (range('A', 'Z') as $first) {
            foreach (range('A', 'Z') as $second) {
                $columns[$first.$second] = 18;
            }
        }

        return $columns;
    }

    public function registerEvents(): array
    {
        return [
            // AfterSheet::class => function(AfterSheet $event) {

            //     $sheet = $event->sheet->getDelegate();

            //     // Get the last row automatically
            //     $lastRow = $sheet->getHighestRow();

            //     // Apply border
            //     $sheet->getStyle("A1:O{$lastRow}")
            //         ->applyFromArray([
            //             'borders' => [
            //                 'allBorders' => [
            //                     'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            //                 ],
            //             ],
            //         ]);
            // },
        ];
    }
}
