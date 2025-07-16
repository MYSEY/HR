<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Performance;
use Illuminate\Http\Request;

class PerformanceAppraisalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Performance::with('PerformanceDetails')->where('id',24)->where('status','approve')->get();
        $results = [];
        
        $targetDate = \Carbon\Carbon::parse('2025-01-15'); // For date comparisons
        
        foreach ($data as $performance) {
            foreach ($performance->PerformanceDetails as $detail) {
                $goalType = $detail->goal_type;
                $lines = explode("\n", trim($detail->goal));
        
                foreach ($lines as $index => $line) {
                    [$min, $max] = preg_split('/\s+/', trim($line));
        
                    switch ($goalType) {
                        case 'number':
                            if (is_numeric($min) && is_numeric($max)) {
                                if ($min <= $max) {
                                    $results[$goalType] = [
                                        'range' => "$min - $max",
                                        'score' => $detail->score,
                                        'kpi'   => $detail->key_kpi ?? null,
                                    ];
                                }
                            }
                            break;
                        case 'currency':
                        case 'percent':
                            if (is_numeric($min) && is_numeric($max)) {
                                if ($min <= $max) {
                                    $results[$goalType] = [
                                        'range' => "$min - $max",
                                        'score' => $detail->score,
                                        'kpi'   => $detail->key_kpi ?? null,
                                    ];
                                }
                            }
                            break;
        
                        case 'date':
                            try {
                                $d1 = \Carbon\Carbon::parse($min);
                                $d2 = \Carbon\Carbon::parse($max);
                                if ($targetDate->between($d1, $d2)) {
                                    $results['date'][] = [
                                        'range' => "$min to $max",
                                        'score' => $detail->score,
                                        'kpi'   => $detail->key_kpi ?? null,
                                    ];
                                }
                            } catch (\Exception $e) {
                                // Invalid date, skip
                            }
                            break;
                    }
                }
            }
        }
        
        dd($results);
        
        return view('performance_appraisal.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
