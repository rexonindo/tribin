@extends('frame')

@section('konten')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Home</h1>
    <div class="btn-toolbar mb-2 mb-md-0">

    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12" id="div-alert">

        </div>
    </div>
    <div class="row">
        <div class="col-md-12" id="divDashboardContainer">

        </div>
    </div>
    <hr>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <div class="col">
            <div class="card">
                <div class="card-header text-center">
                    Sales
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col text-end border-bottom" id="divCreatedSales">
                                -
                            </div>
                            <div class="col border-start border-bottom">
                                Created
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-end ">
                                -
                            </div>
                            <div class="col border-start ">
                                Need to deliver
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-body-secondary text-center" id="divTimeSales">
                    -
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header  text-center">
                    Rent Status
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col text-end">
                                -
                            </div>
                            <div class="col border-start bg-warning border-info">
                                Need to be returned
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-body-secondary text-center">
                    -
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header  text-center">
                    Quotation Status
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col text-end border-bottom" id="divCreatedQuotations">
                                ?
                            </div>
                            <div class="col border-start border-bottom">
                                Created
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-end" id="divApprovedQuotations">
                                7
                            </div>
                            <div class="col border-start">
                                Approved
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-body-secondary text-center" id="divTimeQuotations">
                    -
                </div>
            </div>
        </div>
    </div>

</div>
@if (in_array(Auth::user()->role, ['director','manager', 'general_manager']) )
<script src="{{ url('assets/js/JOSDashboard.js') }} "></script>
@endif
<script>
    $.ajax({
        type: "GET",
        url: "dashboard-resource",
        dataType: "json",
        success: function(response) {
            divCreatedQuotations.innerText = response.data.createdQuotations
            divApprovedQuotations.innerText = response.data.approvedQuotations
            divTimeQuotations.innerText = moment(response.data.lastCreatedQuotationDateTime).startOf('hour').fromNow()
            divTimeQuotations.title = response.data.lastCreatedQuotationDateTime
            divCreatedSales.innerText = response.data.createdSales
            divTimeSales.innerText = moment(response.data.lastCreatedSODateTime).startOf('hour').fromNow()
            divTimeSales.title = response.data.lastCreatedSODateTime
        }
    });
</script>

@endsection