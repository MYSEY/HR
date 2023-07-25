<style>
    .loading-spinner{
        width:30px;
        height:30px;
        border:2px solid indigo;
        border-radius:50%;
        border-top-color:#0001;
        display:inline-block;
        animation:loadingspinner .7s linear infinite;
    }
    @keyframes loadingspinner{
        0%{
            transform:rotate(0deg)
        }
        100%{
            transform:rotate(360deg)
        }
    }
</style>
<div class="modal" id="modal-loading" data-bs-backdrop="static">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="loading-spinner mb-2"></div>
                <div>Loading</div>
            </div>
        </div>
    </div>
</div>
