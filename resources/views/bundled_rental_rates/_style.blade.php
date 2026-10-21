<style>
    .rental-page{ max-width:1050px; margin:0 auto 24px; background:#fff; border:1px solid #e6e0e0; border-radius:12px; padding:20px; color:#2a1b1c; }
    .rental-ui .f{ margin-bottom:12px; }
    .rental-ui .lbl{ display:block; font-size:13px; color:#6b6264; margin-bottom:4px; }
    .rental-ui .lbl .text-danger{ color:inherit !important; }
    .rental-ui .form-control{ font:inherit; font-size:14px; padding:8px 12px; border:1px solid #e6e0e0; border-radius:8px; background:#f8f9fa; color:#2a1b1c; box-shadow:none; }
    .rental-ui .form-control:focus{ border-color:#9f2e32; box-shadow:0 0 0 2px rgba(159,46,50,.15); }
    .rental-ui .f > .form-control{ height:40px; }
    .rental-ui .form-control[multiple]{ height:auto; }
    .rental-ui .f .e{ display:none; color:#9f2e32; font-size:12px; margin-top:3px; }
    .rental-ui .f:has(.is-invalid) .e{ display:block; }
    .rental-ui .is-invalid{ border-color:#9f2e32 !important; background-image:none !important; }
    .rental-ui .sub{ font-size:13px; color:#6b6264; margin:6px 0 8px; }

    /* Form Rental: ជួរ field */
    .rental-ui .fr{ display:flex; gap:6px; flex-wrap:nowrap; align-items:flex-start; margin-bottom:8px; }
    .rental-ui .fr .fl{ flex:1; min-width:0; margin:0; }
    .rental-ui .fr .ft{ width:116px; flex:none; }
    .rental-ui .fr .form-control{ height:38px; padding-top:0; padding-bottom:0; }
    .rental-ui .chk{ display:flex; align-items:center; gap:5px; font-size:13px; color:#6b6264; white-space:nowrap; margin:0; }
    .rental-ui .fr .chk{ height:38px; }
    .rental-ui .chk input{ width:17px; height:17px; accent-color:#9f2e32; }
    .rental-ui .cond{ padding:0 0 10px 2px; margin-top:-2px; }
    .rental-ui .option-wrapper{ margin:0 0 12px; }
    .rental-ui .fr .delete-row{ width:38px; height:38px; }

    /* Bundled Rental Rate: ជួរ rate */
    .rental-ui #rateRows{ counter-reset:rr; }
    .rental-ui .rate-row{ border:1px solid #e6e0e0; border-radius:10px; padding:12px; margin-bottom:10px; }
    .rental-ui .rr-head{ display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; }
    .rental-ui .rr-no{ font-size:13px; color:#6b6264; }
    .rental-ui .rr-no::before{ counter-increment:rr; content:"#" counter(rr); }
    .rental-ui .g2{ display:grid; grid-template-columns:1fr 1fr; gap:10px; }
    .rental-ui .rr-head .delete-row{ width:32px; height:32px; }

    .rental-ui .delete-row{ flex:none; border:1px solid #e6e0e0; background:#fff; border-radius:8px; color:#2a1b1c; cursor:pointer; line-height:1; }
    .rental-ui .delete-row:hover{ border-color:#9f2e32; color:#9f2e32; }
    @media (max-width:480px){ .rental-ui .fr{ flex-wrap:wrap; } .rental-ui .g2{ grid-template-columns:1fr; } }


    /* Select2 (multi) ត្រូវ style ដូច input */
    .rental-ui .select2-container{ width:100% !important; }
    .rental-ui .select2-container--default .select2-selection--multiple{ min-height:40px; border:1px solid #e6e0e0; border-radius:8px; background:#f8f9fa; }
    .rental-ui .select2-container--default.select2-container--focus .select2-selection--multiple{ border-color:#9f2e32; }
    .rental-ui .select2-container--default .select2-selection--multiple .select2-selection__choice{ background:#f5e1e2; border:0; color:#2a1b1c; border-radius:6px; }

    .rental-ui .is-invalid + .select2-container .select2-selection{ border-color:#9f2e32 !important; }

    /* ប៊ូតុង */
    .rental-ui .btn-m{ display:inline-block; font:inherit; font-size:13px; padding:6px 14px; border-radius:7px; border:1px solid #e6e0e0; background:#fff; color:#2a1b1c; cursor:pointer; text-decoration:none; }
    .rental-ui .btn-m:hover{ border-color:#9f2e32; color:#2a1b1c; }
    .rental-ui .btn-m.p{ background:#9f2e32; border-color:#9f2e32; color:#fff; }
    .rental-ui .btn-m:disabled{ opacity:.6; cursor:wait; }
    .rental-ui .act{ display:flex; justify-content:flex-end; gap:8px; margin-top:16px; }
</style>