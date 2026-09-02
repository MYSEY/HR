<table id="recruitment-export" border="1" style="border-collapse: collapse; width: 100%; font-family: 'Kantumruy Pro', 'Khmer OS Battambang', sans-serif; font-size: 11px;">
    
    <tr>
        <td colspan="29" style="border: none; padding: 10px 5px; text-align: left; vertical-align: middle;">
            {{-- <img src="{{ asset('/admin/img/camma-logo.png') }}" height="80" style="vertical-align: middle; margin-right: 15px;"> --}}
        </td>
    </tr>

    <tr>
        <td colspan="29" style="border: none; padding: 5px; text-align: left; font-size: 16pt; font-weight: bold; color: #000;">
            Recruitment_Application Report
        </td>
    </tr>

    <tr style="height: 15px;">
        <td colspan="29" style="border: none;"></td>
    </tr>

    <thead>
        <tr style="font-weight: bold; font-style: italic; font-size: 11px; height: 25px;">
            <td colspan="14" style="background-color: #d9e1f2; text-align: center; border: 1px solid #000;">
                Add New Candidate CV
            </td>
            <td style="background-color: #fce4d6; text-align: center; border: 1px solid #000;">
                Status
            </td>
            <td colspan="6" style="background-color: #fce4d6; text-align: center; border: 1px solid #000;">
                Short List
            </td>
            <td colspan="6" style="background-color: #bfbfbf; text-align: center; border: 1px solid #000;">
                Candidate Result &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Signed Contract
            </td>
            <td rowspan="2" style="background-color: #f2f2f2; text-align: center; border: 1px solid #000; font-weight: bold; vertical-align: middle; font-size: 12px; width: 120px;">
                Remarks
            </td>
        </tr>

        <tr style="background-color: #f2f2f2; text-align: center; font-weight: bold; height: 30px; vertical-align: middle;">
            <th style="border: 1px solid #000; width: 40px; font-weight: bold; vertical-align: middle">No</th>
            <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle">First_Name_eng</th>
            <th style="border: 1px solid #000; color: #c00000; font-weight: bold; vertical-align: middle">First_Name_eng Formula</th>
            <th style="border: 1px solid #000; color: #385723; font-weight: bold; vertical-align: middle">Gender</th>
            <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle">Current_Position</th>
            <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle">Companey_Name</th>
            <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle">Current_Address</th>
            <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle">Position_Applied</th>
            <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle">Location_Applied</th>
            <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle">Received_Date</th>
            <th style="border: 1px solid #000; color: #ff0000; font-weight: bold; vertical-align: middle">Month</th>
            <th style="border: 1px solid #000; color: #385723; font-weight: bold; vertical-align: middle">Recruitment_Channel</th>
            <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle">Referral Name</th>
            <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle">Contact_Number</th>
            <th style="border: 1px solid #000; color: #ff0000; font-weight: bold; vertical-align: middle">Status</th>

            <th style="border: 1px solid #000; color: #385723; font-weight: bold; vertical-align: middle">Phone Interview</th>
            <th style="border: 1px solid #000; color: #ff0000; font-weight: bold; vertical-align: middle">Short_list</th>
            <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle">Interviewed_Date</th>
            <th style="border: 1px solid #000; color: #ff0000; font-weight: bold; vertical-align: middle">Month</th>
            <th style="border: 1px solid #000; color: #385723; font-weight: bold; vertical-align: middle">Interviewed_Channel</th>
            <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle">Committee_Interview</th>
            
            <th style="border: 1px solid #000; color: #00b050; font-weight: bold; vertical-align: middle">Joined_Interview</th>
            <th style="border: 1px solid #000; color: #00b050; font-weight: bold; vertical-align: middle">Interviewed_Result</th>
            <th style="border: 1px solid #000; color: #00b050; font-weight: bold; vertical-align: middle">Job Offer</th>
            <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle">Contract_Date</th>
            <th style="border: 1px solid #000; color: #ff0000; font-weight: bold; vertical-align: middle">Month</th>
            <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle">Join_Date</th>
            </tr>
    </thead>
    <tbody>
        @if(isset($data) && count($data) > 0)
            @foreach($data as $key => $row)
                <tr>
                    <td style="border: 1px solid #000; text-align: center;">{{ $key + 1 }}</td>
                    <td style="border: 1px solid #000;">{{ $row->name_en ?? '' }}</td>
                    <td style="border: 1px solid #000;">{{ $row->name_kh ?? '' }}</td>
                    <td style="border: 1px solid #000; text-align: center;">{{ $row->CandidateGender ?? '' }}</td>
                    <td style="border: 1px solid #000;">{{ $row->current_position ?? '' }}</td>
                    <td style="border: 1px solid #000;">{{ $row->companey_name ?? '' }}</td>
                    <td style="border: 1px solid #000;">{{ $row->current_address ?? '' }}</td>
                    <td style="border: 1px solid #000;">{{ $row->CandidatePosition ?? '' }}</td>
                    <td style="border: 1px solid #000;">{{ $row->CandidateBranch ?? '' }}</td>
                    <td style="border: 1px solid #000; text-align: center;">{{ $row->received_date ? \Carbon\Carbon::parse($row->received_date)->format('D-M-Y') : '' }}</td>
                    <td style="border: 1px solid #000; text-align: center; color: #ff0000;">{{ $row->received_date ? \Carbon\Carbon::parse($row->received_date)->format('F') : '' }}</td>
                    <td style="border: 1px solid #000;">{{ $row->recruitment_channel ?? '' }}</td>
                    <td style="border: 1px solid #000;">
                        {{ $row->referral_name ?? ''}}
                    </td> 
                    <td style="border: 1px solid #000;">{{ $row->contact_number ?? '' }}</td>
                    <td style="border: 1px solid #000;color: #ff0000;">
                        @if($row->emp_status =="Cancel")
                            Canceled Contract
                        @else
                            @if($row->short_list == "1" && $row->status == "2") 
                                Short List
                            @elseif(in_array($row->short_list, ["2", "7"])) 
                                Non Shortlisted
                            @elseif($row->status == '3' && in_array($row->interviewed_result, [1, 3, 4])) 
                                Inter Result
                            @elseif($row->status == '3' && (!in_array($row->interviewed_result, [1, 3, 4]) || is_null($row->interviewed_result))) 
                                Inter Failed
                            @elseif($row->status == '4') 
                                Processing Contract
                            @elseif($row->status == 'Cancel') 
                                Cancel processing contract
                            @elseif($row->status == '5') 
                                Upcoming Staff
                            @else 
                                {{ $row->status ?? '' }}
                            @endif
                        @endif
                    </td>
                    
                    <td style="border: 1px solid #000; text-align: center;"></td>
                    <td style="border: 1px solid #000; text-align: center; olor: #ff0000;">
                        @if ($row->short_list == '2' || $row->short_list == "7")
                        @else
                            Short List
                        @endif
                    </td>
                    <td style="border: 1px solid #000; text-align: center;">{{ $row->interviewed_date ? \Carbon\Carbon::parse($row->interviewed_date)->format('D-M-Y') : '' }}</td>
                    <td style="border: 1px solid #000; text-align: center; color: #ff0000;">{{ $row->interviewed_date ? \Carbon\Carbon::parse($row->interviewed_date)->format('F') : '' }}</td>
                    <td style="border: 1px solid #000;">{{ $row->interviewed_channel ?? '' }}</td>
                    <td style="border: 1px solid #000;">{{ $row->committee_interview ?? '' }}</td>

                    <td style="border: 1px solid #000; text-align: center;">
                        @if($row->joined_interview == '1') Yes
                        @elseif($row->joined_interview == '2') No
                        @elseif($row->joined_interview == '3') Delay
                        @else {{ $row->joined_interview ?? '' }}
                        @endif
                    </td>
                    <td style="border: 1px solid #000; text-align: center;">
                        @if($row->interviewed_result == '1') Passed
                        @elseif($row->interviewed_result == '2') Failed
                        @elseif($row->interviewed_result == '3') Waiting
                        @elseif($row->interviewed_result == '4') Pending
                        @elseif($row->interviewed_result == '5') High Expected Salary
                        @elseif($row->interviewed_result == '6') Rejected Offered
                        @elseif($row->interviewed_result == '7') Blacklist
                        @else {{ $row->interviewed_result ?? '' }}
                        @endif
                    </td>
                    <td style="border: 1px solid #000; text-align: center;">
                        @if($row->emp_status =="Cancel")
                            Canceled Contract
                        @else
                            @if ($row->status == "4" )On going process
                            @elseif($row->status == "Cancel")Rejected Job Offered
                            @elseif($row->interviewed_result == '1' && $row->status =="5")
                                Signed Contract
                            @else
                            @endif
                        @endif
                    </td>
                    <td style="border: 1px solid #000; text-align: center;">{{ $row->contract_date ? \Carbon\Carbon::parse($row->contract_date)->format('D-M-Y') : '' }}</td>
                    <td style="border: 1px solid #000; text-align: center; color: #ff0000;">{{ $row->contract_date ? \Carbon\Carbon::parse($row->contract_date)->format('F') : '' }}</td>
                    <td style="border: 1px solid #000; text-align: center;">{{ $row->join_date ? \Carbon\Carbon::parse($row->join_date)->format('D-M-Y') : '' }}</td>
                    
                    <td style="border: 1px solid #000;">{{ $row->remark ?? '' }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>