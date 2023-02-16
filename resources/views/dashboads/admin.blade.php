@extends('layouts.master')
@section('content')
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Welcome Admin!</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-cubes"></i></span>
                        <div class="dash-widget-info">
                            <h3>112</h3>
                            <span>Projects</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-usd"></i></span>
                        <div class="dash-widget-info">
                            <h3>44</h3>
                            <span>Clients</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-diamond"></i></span>
                        <div class="dash-widget-info">
                            <h3>37</h3>
                            <span>Tasks</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                        <div class="dash-widget-info">
                            <h3>218</h3>
                            <span>Employees</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Total Revenue</h3>
                                <div id="bar-charts"
                                    style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"><svg
                                        height="342" version="1.1" width="569" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        style="overflow: hidden; position: relative; left: -0.800018px; top: -0.600006px;">
                                        <desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël
                                            2.3.0</desc>
                                        <defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><text
                                            x="32.52499961853027" y="303.3999996185303" text-anchor="end"
                                            font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                            font-weight="normal">
                                            <tspan dy="4.39998722076416"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan>
                                        </text>
                                        <path fill="none" stroke="#aaaaaa" d="M45.02499961853027,303.3999996185303H544"
                                            stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                        </path><text x="32.52499961853027" y="233.7999997138977" text-anchor="end"
                                            font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                            font-weight="normal">
                                            <tspan dy="4.399993419647217"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">25</tspan>
                                        </text>
                                        <path fill="none" stroke="#aaaaaa" d="M45.02499961853027,233.7999997138977H544"
                                            stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                        </path><text x="32.52499961853027" y="164.19999980926514" text-anchor="end"
                                            font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                            font-weight="normal">
                                            <tspan dy="4.399999618530273"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">50</tspan>
                                        </text>
                                        <path fill="none" stroke="#aaaaaa" d="M45.02499961853027,164.19999980926514H544"
                                            stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                        </path><text x="32.52499961853027" y="94.59999990463257" text-anchor="end"
                                            font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                            font-weight="normal">
                                            <tspan dy="4.399998188018799"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">75</tspan>
                                        </text>
                                        <path fill="none" stroke="#aaaaaa"
                                            d="M45.02499961853027,94.59999990463257H544" stroke-width="0.5"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text
                                            x="32.52499961853027" y="25" text-anchor="end"
                                            font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                            font-weight="normal">
                                            <tspan dy="4.399999618530273"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">100</tspan>
                                        </text>
                                        <path fill="none" stroke="#aaaaaa" d="M45.02499961853027,25H544"
                                            stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                        </path><text x="508.35892854418074" y="315.8999996185303" text-anchor="middle"
                                            font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                            font-weight="normal" transform="matrix(1,0,0,1,0,6.8)">
                                            <tspan dy="4.39998722076416"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2012</tspan>
                                        </text><text x="365.79464272090365" y="315.8999996185303" text-anchor="middle"
                                            font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                            font-weight="normal" transform="matrix(1,0,0,1,0,6.8)">
                                            <tspan dy="4.39998722076416"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2010</tspan>
                                        </text><text x="223.2303568976266" y="315.8999996185303" text-anchor="middle"
                                            font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                            font-weight="normal" transform="matrix(1,0,0,1,0,6.8)">
                                            <tspan dy="4.39998722076416"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2008</tspan>
                                        </text><text x="80.66607107434953" y="315.8999996185303" text-anchor="middle"
                                            font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                            font-weight="normal" transform="matrix(1,0,0,1,0,6.8)">
                                            <tspan dy="4.39998722076416"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2006</tspan>
                                        </text>
                                        <rect x="53.93526748248509" y="25" width="25.23080359186445"
                                            height="278.3999996185303" rx="0" ry="0" fill="#ff9b44"
                                            stroke="none" fill-opacity="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                                        <rect x="82.16607107434953" y="52.83999996185301" width="25.23080359186445"
                                            height="250.55999965667726" rx="0" ry="0" fill="#fc6075"
                                            stroke="none" fill-opacity="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                                        <rect x="125.21741039412362" y="94.59999990463257" width="25.23080359186445"
                                            height="208.7999997138977" rx="0" ry="0" fill="#ff9b44"
                                            stroke="none" fill-opacity="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                                        <rect x="153.44821398598808" y="122.43999986648558" width="25.23080359186445"
                                            height="180.9599997520447" rx="0" ry="0" fill="#fc6075"
                                            stroke="none" fill-opacity="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                                        <rect x="196.49955330576216" y="164.19999980926514" width="25.23080359186445"
                                            height="139.19999980926514" rx="0" ry="0" fill="#ff9b44"
                                            stroke="none" fill-opacity="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                                        <rect x="224.73035689762662" y="192.03999977111818" width="25.23080359186445"
                                            height="111.3599998474121" rx="0" ry="0" fill="#fc6075"
                                            stroke="none" fill-opacity="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                                        <rect x="267.7816962174007" y="94.59999990463257" width="25.23080359186445"
                                            height="208.7999997138977" rx="0" ry="0" fill="#ff9b44"
                                            stroke="none" fill-opacity="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                                        <rect x="296.01249980926514" y="122.43999986648558" width="25.23080359186445"
                                            height="180.9599997520447" rx="0" ry="0" fill="#fc6075"
                                            stroke="none" fill-opacity="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                                        <rect x="339.0638391290392" y="164.19999980926514" width="25.23080359186445"
                                            height="139.19999980926514" rx="0" ry="0" fill="#ff9b44"
                                            stroke="none" fill-opacity="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                                        <rect x="367.29464272090365" y="192.03999977111818" width="25.23080359186445"
                                            height="111.3599998474121" rx="0" ry="0" fill="#fc6075"
                                            stroke="none" fill-opacity="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                                        <rect x="410.3459820406777" y="94.59999990463257" width="25.23080359186445"
                                            height="208.7999997138977" rx="0" ry="0" fill="#ff9b44"
                                            stroke="none" fill-opacity="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                                        <rect x="438.57678563254217" y="122.43999986648558" width="25.23080359186445"
                                            height="180.9599997520447" rx="0" ry="0" fill="#fc6075"
                                            stroke="none" fill-opacity="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                                        <rect x="481.6281249523163" y="25" width="25.23080359186445"
                                            height="278.3999996185303" rx="0" ry="0" fill="#ff9b44"
                                            stroke="none" fill-opacity="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                                        <rect x="509.85892854418074" y="52.83999996185301" width="25.23080359186445"
                                            height="250.55999965667726" rx="0" ry="0" fill="#fc6075"
                                            stroke="none" fill-opacity="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                                    </svg>
                                    <div class="morris-hover morris-default-style" style="left: 24.3721px; top: 132px;">
                                        <div class="morris-hover-row-label">2006</div>
                                        <div class="morris-hover-point" style="color: #ff9b44">
                                            Total Income:
                                            100
                                        </div>
                                        <div class="morris-hover-point" style="color: #fc6075">
                                            Total Outcome:
                                            90
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Sales Overview</h3>
                                <div id="line-charts"
                                    style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"><svg
                                        height="342" version="1.1" width="569" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        style="overflow: hidden; position: relative; left: -0.400024px; top: -0.600006px;">
                                        <desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël
                                            2.3.0</desc>
                                        <defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><text
                                            x="32.52499961853027" y="303.3999996185303" text-anchor="end"
                                            font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                            font-weight="normal">
                                            <tspan dy="4.39998722076416"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan>
                                        </text>
                                        <path fill="none" stroke="#aaaaaa"
                                            d="M45.02499961853027,303.3999996185303H544" stroke-width="0.5"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text
                                            x="32.52499961853027" y="233.7999997138977" text-anchor="end"
                                            font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                            font-weight="normal">
                                            <tspan dy="4.399993419647217"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">25</tspan>
                                        </text>
                                        <path fill="none" stroke="#aaaaaa"
                                            d="M45.02499961853027,233.7999997138977H544" stroke-width="0.5"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text
                                            x="32.52499961853027" y="164.19999980926514" text-anchor="end"
                                            font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                            font-weight="normal">
                                            <tspan dy="4.399999618530273"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">50</tspan>
                                        </text>
                                        <path fill="none" stroke="#aaaaaa"
                                            d="M45.02499961853027,164.19999980926514H544" stroke-width="0.5"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text
                                            x="32.52499961853027" y="94.59999990463257" text-anchor="end"
                                            font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                            font-weight="normal">
                                            <tspan dy="4.399998188018799"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">75</tspan>
                                        </text>
                                        <path fill="none" stroke="#aaaaaa"
                                            d="M45.02499961853027,94.59999990463257H544" stroke-width="0.5"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text
                                            x="32.52499961853027" y="25" text-anchor="end"
                                            font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                            font-weight="normal">
                                            <tspan dy="4.399999618530273"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">100</tspan>
                                        </text>
                                        <path fill="none" stroke="#aaaaaa" d="M45.02499961853027,25H544"
                                            stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                        </path><text x="544" y="315.8999996185303" text-anchor="middle"
                                            font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                            font-weight="normal" transform="matrix(1,0,0,1,0,6.8)">
                                            <tspan dy="4.39998722076416"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2012</tspan>
                                        </text><text x="460.87545634904774" y="315.8999996185303" text-anchor="middle"
                                            font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                            font-weight="normal" transform="matrix(1,0,0,1,0,6.8)">
                                            <tspan dy="4.39998722076416"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2011</tspan>
                                        </text><text x="377.7509126980955" y="315.8999996185303" text-anchor="middle"
                                            font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                            font-weight="normal" transform="matrix(1,0,0,1,0,6.8)">
                                            <tspan dy="4.39998722076416"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2010</tspan>
                                        </text><text x="294.62636904714316" y="315.8999996185303" text-anchor="middle"
                                            font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                            font-weight="normal" transform="matrix(1,0,0,1,0,6.8)">
                                            <tspan dy="4.39998722076416"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2009</tspan>
                                        </text><text x="211.27408692043485" y="315.8999996185303" text-anchor="middle"
                                            font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                            font-weight="normal" transform="matrix(1,0,0,1,0,6.8)">
                                            <tspan dy="4.39998722076416"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2008</tspan>
                                        </text><text x="128.14954326948256" y="315.8999996185303" text-anchor="middle"
                                            font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                            font-weight="normal" transform="matrix(1,0,0,1,0,6.8)">
                                            <tspan dy="4.39998722076416"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2007</tspan>
                                        </text><text x="45.02499961853027" y="315.8999996185303" text-anchor="middle"
                                            font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                            font-weight="normal" transform="matrix(1,0,0,1,0,6.8)">
                                            <tspan dy="4.39998722076416"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2006</tspan>
                                        </text>
                                        <path fill="none" stroke="#fc6075"
                                            d="M45.02499961853027,52.83999996185301C65.80613553126835,70.23999993801115,107.36840735674448,105.03999989032744,128.14954326948256,122.43999986648558C148.93067918222064,139.83999984264372,190.49295100769677,192.03999977111818,211.27408692043485,192.03999977111818C232.11215745211194,192.03999977111818,273.78829851546607,122.43999986648558,294.62636904714316,122.43999986648558C315.40750495988124,122.43999986648558,356.9697767853574,192.03999977111818,377.7509126980955,192.03999977111818C398.53204861083356,192.03999977111818,440.09432043630966,125.9199998617172,460.87545634904774,122.43999986648558C481.6565922617858,118.95999987125396,523.218864087262,153.75999982357024,544,164.19999980926514"
                                            stroke-width="3px" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                        </path>
                                        <path fill="none" stroke="#ff9b44"
                                            d="M45.02499961853027,164.19999980926514C65.80613553126835,146.799999833107,107.36840735674448,94.59999990463257,128.14954326948256,94.59999990463257C148.93067918222064,94.59999990463257,190.49295100769677,164.19999980926514,211.27408692043485,164.19999980926514C232.11215745211194,164.19999980926514,273.78829851546607,94.59999990463257,294.62636904714316,94.59999990463257C315.40750495988124,94.59999990463257,356.9697767853574,164.19999980926514,377.7509126980955,164.19999980926514C398.53204861083356,164.19999980926514,440.09432043630966,111.99999988079071,460.87545634904774,94.59999990463257C481.6565922617858,77.19999992847443,523.218864087262,42.39999997615814,544,25"
                                            stroke-width="3px" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                        </path>
                                        <circle cx="45.02499961853027" cy="52.83999996185301" r="4"
                                            fill="#fc6075" stroke="#ffffff" stroke-width="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="128.14954326948256" cy="122.43999986648558" r="4"
                                            fill="#fc6075" stroke="#ffffff" stroke-width="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="211.27408692043485" cy="192.03999977111818" r="4"
                                            fill="#fc6075" stroke="#ffffff" stroke-width="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="294.62636904714316" cy="122.43999986648558" r="4"
                                            fill="#fc6075" stroke="#ffffff" stroke-width="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="377.7509126980955" cy="192.03999977111818" r="4"
                                            fill="#fc6075" stroke="#ffffff" stroke-width="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="460.87545634904774" cy="122.43999986648558" r="4"
                                            fill="#fc6075" stroke="#ffffff" stroke-width="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="544" cy="164.19999980926514" r="4" fill="#fc6075"
                                            stroke="#ffffff" stroke-width="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="45.02499961853027" cy="164.19999980926514" r="4"
                                            fill="#ff9b44" stroke="#ffffff" stroke-width="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="128.14954326948256" cy="94.59999990463257" r="4"
                                            fill="#ff9b44" stroke="#ffffff" stroke-width="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="211.27408692043485" cy="164.19999980926514" r="4"
                                            fill="#ff9b44" stroke="#ffffff" stroke-width="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="294.62636904714316" cy="94.59999990463257" r="4"
                                            fill="#ff9b44" stroke="#ffffff" stroke-width="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="377.7509126980955" cy="164.19999980926514" r="4"
                                            fill="#ff9b44" stroke="#ffffff" stroke-width="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="460.87545634904774" cy="94.59999990463257" r="4"
                                            fill="#ff9b44" stroke="#ffffff" stroke-width="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="544" cy="25" r="4" fill="#ff9b44"
                                            stroke="#ffffff" stroke-width="1"
                                            style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                    </svg>
                                    <div class="morris-hover morris-default-style" style="left: 457.062px; top: 35px;">
                                        <div class="morris-hover-row-label">2012</div>
                                        <div class="morris-hover-point" style="color: #ff9b44">
                                            Total Sales:
                                            100
                                        </div>
                                        <div class="morris-hover-point" style="color: #fc6075">
                                            Total Revenue:
                                            50
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card-group m-b-30">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">New Employees</span>
                                </div>
                                <div>
                                    <span class="text-success">+10%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">10</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;"
                                    aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Overall Employees 218</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Earnings</span>
                                </div>
                                <div>
                                    <span class="text-success">+12.5%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">$1,42,300</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;"
                                    aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Previous Month <span class="text-muted">$1,15,852</span></p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Expenses</span>
                                </div>
                                <div>
                                    <span class="text-danger">-2.8%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">$8,500</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;"
                                    aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Previous Month <span class="text-muted">$7,500</span></p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Profit</span>
                                </div>
                                <div>
                                    <span class="text-danger">-75%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">$1,12,000</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;"
                                    aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Previous Month <span class="text-muted">$1,42,000</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-4 d-flex">
                <div class="card flex-fill dash-statistics">
                    <div class="card-body">
                        <h5 class="card-title">Statistics</h5>
                        <div class="stats-list">
                            <div class="stats-info">
                                <p>Today Leave <strong>4 <small>/ 65</small></strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 31%"
                                        aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="stats-info">
                                <p>Pending Invoice <strong>15 <small>/ 92</small></strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 31%"
                                        aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="stats-info">
                                <p>Completed Projects <strong>85 <small>/ 112</small></strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 62%"
                                        aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="stats-info">
                                <p>Open Tickets <strong>190 <small>/ 212</small></strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 62%"
                                        aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="stats-info">
                                <p>Closed Tickets <strong>22 <small>/ 212</small></strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 22%"
                                        aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <h4 class="card-title">Task Statistics</h4>
                        <div class="statistics">
                            <div class="row">
                                <div class="col-md-6 col-6 text-center">
                                    <div class="stats-box mb-4">
                                        <p>Total Tasks</p>
                                        <h3>385</h3>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6 text-center">
                                    <div class="stats-box mb-4">
                                        <p>Overdue Tasks</p>
                                        <h3>19</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-purple" role="progressbar" style="width: 30%" aria-valuenow="30"
                                aria-valuemin="0" aria-valuemax="100">30%</div>
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 22%"
                                aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">22%</div>
                            <div class="progress-bar bg-success" role="progressbar" style="width: 24%"
                                aria-valuenow="12" aria-valuemin="0" aria-valuemax="100">24%</div>
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 26%" aria-valuenow="14"
                                aria-valuemin="0" aria-valuemax="100">21%</div>
                            <div class="progress-bar bg-info" role="progressbar" style="width: 10%" aria-valuenow="14"
                                aria-valuemin="0" aria-valuemax="100">10%</div>
                        </div>
                        <div>
                            <p><i class="fa fa-dot-circle-o text-purple me-2"></i>Completed Tasks <span
                                    class="float-end">166</span></p>
                            <p><i class="fa fa-dot-circle-o text-warning me-2"></i>Inprogress Tasks <span
                                    class="float-end">115</span></p>
                            <p><i class="fa fa-dot-circle-o text-success me-2"></i>On Hold Tasks <span
                                    class="float-end">31</span></p>
                            <p><i class="fa fa-dot-circle-o text-danger me-2"></i>Pending Tasks <span
                                    class="float-end">47</span></p>
                            <p class="mb-0"><i class="fa fa-dot-circle-o text-info me-2"></i>Review Tasks <span
                                    class="float-end">5</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <h4 class="card-title">Today Absent <span class="badge bg-inverse-danger ms-2">5</span></h4>
                        <div class="leave-info-box">
                            <div class="media d-flex align-items-center">
                                <a href="https://smarthr.dreamguystech.com/laravel/template/public/profile"
                                    class="avatar"><img alt=""
                                        src="https://smarthr.dreamguystech.com/laravel/template/public/assets/img/user.jpg"></a>
                                <div class="media-body flex-grow-1">
                                    <div class="text-sm my-0">Martin Lewis</div>
                                </div>
                            </div>
                            <div class="row align-items-center mt-3">
                                <div class="col-6">
                                    <h6 class="mb-0">4 Sep 2019</h6>
                                    <span class="text-sm text-muted">Leave Date</span>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="badge bg-inverse-danger">Pending</span>
                                </div>
                            </div>
                        </div>
                        <div class="leave-info-box">
                            <div class="media d-flex align-items-center">
                                <a href="https://smarthr.dreamguystech.com/laravel/template/public/profile"
                                    class="avatar"><img alt=""
                                        src="https://smarthr.dreamguystech.com/laravel/template/public/assets/img/user.jpg"></a>
                                <div class="media-body flex-grow-1">
                                    <div class="text-sm my-0">Martin Lewis</div>
                                </div>
                            </div>
                            <div class="row align-items-center mt-3">
                                <div class="col-6">
                                    <h6 class="mb-0">4 Sep 2019</h6>
                                    <span class="text-sm text-muted">Leave Date</span>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="badge bg-inverse-success">Approved</span>
                                </div>
                            </div>
                        </div>
                        <div class="load-more text-center">
                            <a class="text-dark" href="javascript:void(0);">Load More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 d-flex">
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Invoices</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-nowrap custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Invoice ID</th>
                                        <th>Client</th>
                                        <th>Due Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><a
                                                href="https://smarthr.dreamguystech.com/laravel/template/public/invoice-view">#INV-0001</a>
                                        </td>
                                        <td>
                                            <h2><a href="#">Global Technologies</a></h2>
                                        </td>
                                        <td>11 Mar 2019</td>
                                        <td>$380</td>
                                        <td>
                                            <span class="badge bg-inverse-warning">Partially Paid</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a
                                                href="https://smarthr.dreamguystech.com/laravel/template/public/invoice-view">#INV-0002</a>
                                        </td>
                                        <td>
                                            <h2><a href="#">Delta Infotech</a></h2>
                                        </td>
                                        <td>8 Feb 2019</td>
                                        <td>$500</td>
                                        <td>
                                            <span class="badge bg-inverse-success">Paid</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a
                                                href="https://smarthr.dreamguystech.com/laravel/template/public/invoice-view">#INV-0003</a>
                                        </td>
                                        <td>
                                            <h2><a href="#">Cream Inc</a></h2>
                                        </td>
                                        <td>23 Jan 2019</td>
                                        <td>$60</td>
                                        <td>
                                            <span class="badge bg-inverse-danger">Unpaid</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="https://smarthr.dreamguystech.com/laravel/template/public/invoices">View all invoices</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex">
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Payments</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th>Invoice ID</th>
                                        <th>Client</th>
                                        <th>Payment Type</th>
                                        <th>Paid Date</th>
                                        <th>Paid Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><a
                                                href="https://smarthr.dreamguystech.com/laravel/template/public/invoice-view">#INV-0001</a>
                                        </td>
                                        <td>
                                            <h2><a href="#">Global Technologies</a></h2>
                                        </td>
                                        <td>Paypal</td>
                                        <td>11 Mar 2019</td>
                                        <td>$380</td>
                                    </tr>
                                    <tr>
                                        <td><a
                                                href="https://smarthr.dreamguystech.com/laravel/template/public/invoice-view">#INV-0002</a>
                                        </td>
                                        <td>
                                            <h2><a href="#">Delta Infotech</a></h2>
                                        </td>
                                        <td>Paypal</td>
                                        <td>8 Feb 2019</td>
                                        <td>$500</td>
                                    </tr>
                                    <tr>
                                        <td><a
                                                href="https://smarthr.dreamguystech.com/laravel/template/public/invoice-view">#INV-0003</a>
                                        </td>
                                        <td>
                                            <h2><a href="#">Cream Inc</a></h2>
                                        </td>
                                        <td>Paypal</td>
                                        <td>23 Jan 2019</td>
                                        <td>$60</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="payments">View all payments</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 d-flex">
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Clients</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="#" class="avatar"><img alt=""
                                                        src="https://smarthr.dreamguystech.com/laravel/template/public/assets/img/profiles/avatar-19.jpg"></a>
                                                <a
                                                    href="https://smarthr.dreamguystech.com/laravel/template/public/client-profile">Barry
                                                    Cuda <span>CEO</span></a>
                                            </h2>
                                        </td>
                                        <td>barrycuda@example.com</td>
                                        <td>
                                            <div class="dropdown action-label">
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-success"></i> Active
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i
                                                            class="fa fa-dot-circle-o text-success"></i> Active</a>
                                                    <a class="dropdown-item" href="#"><i
                                                            class="fa fa-dot-circle-o text-danger"></i> Inactive</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="javascript:void(0)"><i
                                                            class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0)"><i
                                                            class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="#" class="avatar"><img alt=""
                                                        src="https://smarthr.dreamguystech.com/laravel/template/public/assets/img/profiles/avatar-19.jpg"></a>
                                                <a
                                                    href="https://smarthr.dreamguystech.com/laravel/template/public/client-profile">Tressa
                                                    Wexler <span>Manager</span></a>
                                            </h2>
                                        </td>
                                        <td>tressawexler@example.com</td>
                                        <td>
                                            <div class="dropdown action-label">
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-danger"></i> Inactive
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i
                                                            class="fa fa-dot-circle-o text-success"></i> Active</a>
                                                    <a class="dropdown-item" href="#"><i
                                                            class="fa fa-dot-circle-o text-danger"></i> Inactive</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="javascript:void(0)"><i
                                                            class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0)"><i
                                                            class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="https://smarthr.dreamguystech.com/laravel/template/public/client-profile"
                                                    class="avatar"><img alt=""
                                                        src="https://smarthr.dreamguystech.com/laravel/template/public/assets/img/profiles/avatar-07.jpg"></a>
                                                <a
                                                    href="https://smarthr.dreamguystech.com/laravel/template/public/client-profile">Ruby
                                                    Bartlett <span>CEO</span></a>
                                            </h2>
                                        </td>
                                        <td>rubybartlett@example.com</td>
                                        <td>
                                            <div class="dropdown action-label">
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-danger"></i> Inactive
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i
                                                            class="fa fa-dot-circle-o text-success"></i> Active</a>
                                                    <a class="dropdown-item" href="#"><i
                                                            class="fa fa-dot-circle-o text-danger"></i> Inactive</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="javascript:void(0)"><i
                                                            class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0)"><i
                                                            class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="https://smarthr.dreamguystech.com/laravel/template/public/client-profile"
                                                    class="avatar"><img alt=""
                                                        src="https://smarthr.dreamguystech.com/laravel/template/public/assets/img/profiles/avatar-06.jpg"></a>
                                                <a
                                                    href="https://smarthr.dreamguystech.com/laravel/template/public/client-profile">
                                                    Misty Tison <span>CEO</span></a>
                                            </h2>
                                        </td>
                                        <td>mistytison@example.com</td>
                                        <td>
                                            <div class="dropdown action-label">
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-success"></i> Active
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i
                                                            class="fa fa-dot-circle-o text-success"></i> Active</a>
                                                    <a class="dropdown-item" href="#"><i
                                                            class="fa fa-dot-circle-o text-danger"></i> Inactive</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="javascript:void(0)"><i
                                                            class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0)"><i
                                                            class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="https://smarthr.dreamguystech.com/laravel/template/public/client-profile"
                                                    class="avatar"><img alt=""
                                                        src="https://smarthr.dreamguystech.com/laravel/template/public/assets/img/profiles/avatar-14.jpg"></a>
                                                <a
                                                    href="https://smarthr.dreamguystech.com/laravel/template/public/client-profile">
                                                    Daniel Deacon <span>CEO</span></a>
                                            </h2>
                                        </td>
                                        <td>danieldeacon@example.com</td>
                                        <td>
                                            <div class="dropdown action-label">
                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle"
                                                    href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-dot-circle-o text-danger"></i> Inactive
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i
                                                            class="fa fa-dot-circle-o text-success"></i> Active</a>
                                                    <a class="dropdown-item" href="#"><i
                                                            class="fa fa-dot-circle-o text-danger"></i> Inactive</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="javascript:void(0)"><i
                                                            class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0)"><i
                                                            class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="clients">View all clients</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex">
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Recent Projects</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Project Name </th>
                                        <th>Progress</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h2><a
                                                    href="https://smarthr.dreamguystech.com/laravel/template/public/project-view">Office
                                                    Management</a></h2>
                                            <small class="block text-ellipsis">
                                                <span>1</span> <span class="text-muted">open tasks, </span>
                                                <span>9</span> <span class="text-muted">tasks completed</span>
                                            </small>
                                        </td>
                                        <td>
                                            <div class="progress progress-xs progress-striped">
                                                <div class="progress-bar" role="progressbar" data-bs-toggle="tooltip"
                                                    style="width: 65%" aria-label="65%"></div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="javascript:void(0)"><i
                                                            class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0)"><i
                                                            class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2><a
                                                    href="https://smarthr.dreamguystech.com/laravel/template/public/project-view">Project
                                                    Management</a></h2>
                                            <small class="block text-ellipsis">
                                                <span>2</span> <span class="text-muted">open tasks, </span>
                                                <span>5</span> <span class="text-muted">tasks completed</span>
                                            </small>
                                        </td>
                                        <td>
                                            <div class="progress progress-xs progress-striped">
                                                <div class="progress-bar" role="progressbar" data-bs-toggle="tooltip"
                                                    style="width: 15%" aria-label="15%"></div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="javascript:void(0)"><i
                                                            class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0)"><i
                                                            class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2><a
                                                    href="https://smarthr.dreamguystech.com/laravel/template/public/project-view">Video
                                                    Calling App</a></h2>
                                            <small class="block text-ellipsis">
                                                <span>3</span> <span class="text-muted">open tasks, </span>
                                                <span>3</span> <span class="text-muted">tasks completed</span>
                                            </small>
                                        </td>
                                        <td>
                                            <div class="progress progress-xs progress-striped">
                                                <div class="progress-bar" role="progressbar" data-bs-toggle="tooltip"
                                                    style="width: 49%" aria-label="49%"></div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="javascript:void(0)"><i
                                                            class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0)"><i
                                                            class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2><a
                                                    href="https://smarthr.dreamguystech.com/laravel/template/public/project-view">Hospital
                                                    Administration</a></h2>
                                            <small class="block text-ellipsis">
                                                <span>12</span> <span class="text-muted">open tasks, </span>
                                                <span>4</span> <span class="text-muted">tasks completed</span>
                                            </small>
                                        </td>
                                        <td>
                                            <div class="progress progress-xs progress-striped">
                                                <div class="progress-bar" role="progressbar" data-bs-toggle="tooltip"
                                                    style="width: 88%" aria-label="88%"></div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="javascript:void(0)"><i
                                                            class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0)"><i
                                                            class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2><a
                                                    href="https://smarthr.dreamguystech.com/laravel/template/public/project-view">Digital
                                                    Marketplace</a></h2>
                                            <small class="block text-ellipsis">
                                                <span>7</span> <span class="text-muted">open tasks, </span>
                                                <span>14</span> <span class="text-muted">tasks completed</span>
                                            </small>
                                        </td>
                                        <td>
                                            <div class="progress progress-xs progress-striped">
                                                <div class="progress-bar" role="progressbar" data-bs-toggle="tooltip"
                                                    style="width: 100%" aria-label="100%"></div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="javascript:void(0)"><i
                                                            class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0)"><i
                                                            class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="projects">View all projects</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
