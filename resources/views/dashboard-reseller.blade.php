@extends('layouts.admin.template-reseller')
@section('content')
<div class="row">
    <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
        <div class="card overflow-hidden">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h3 class="mb-2 fw-semibold">{{ $transaksi }}</h3>
                        <p class="text-muted fs-13 mb-0">Omzet</p>
                        {{-- <p class="text-muted mb-0 mt-2 fs-12">
                            <span class="icn-box text-success fw-semibold fs-13 me-1">
                                <i class="fa fa-long-arrow-up"></i>
                                42%</span>
                            since last month
                        </p> --}}
                    </div>
                    <div class="col col-auto top-icn dash">
                        <div class="counter-icon bg-primary dash ms-auto box-shadow-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-white" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="M12,8c-2.2091675,0-4,1.7908325-4,4s1.7908325,4,4,4c2.208252-0.0021973,3.9978027-1.791748,4-4C16,9.7908325,14.2091675,8,12,8z M12,15c-1.6568604,0-3-1.3431396-3-3s1.3431396-3,3-3c1.6561279,0.0018311,2.9981689,1.3438721,3,3C15,13.6568604,13.6568604,15,12,15z M21.960022,11.8046875C19.9189453,6.9902344,16.1025391,4,12,4s-7.9189453,2.9902344-9.960022,7.8046875c-0.0537109,0.1246948-0.0537109,0.2659302,0,0.390625C4.0810547,17.0097656,7.8974609,20,12,20s7.9190063-2.9902344,9.960022-7.8046875C22.0137329,12.0706177,22.0137329,11.9293823,21.960022,11.8046875z M12,19c-3.6396484,0-7.0556641-2.6767578-8.9550781-7C4.9443359,7.6767578,8.3603516,5,12,5s7.0556641,2.6767578,8.9550781,7C19.0556641,16.3232422,15.6396484,19,12,19z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
        <div class="card overflow-hidden">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h3 class="mb-2 fw-semibold">{{ $transaksi }}</h3>
                        <p class="text-muted fs-13 mb-0">Omzet Dropshipper</p>
                        {{-- <p class="text-muted mb-0 mt-2 fs-12">
                            <span class="icn-box text-success fw-semibold fs-13 me-1">
                                <i class="fa fa-long-arrow-up"></i>
                                42%</span>
                            since last month
                        </p> --}}
                    </div>
                    <div class="col col-auto top-icn dash">
                        <div class="counter-icon bg-primary dash ms-auto box-shadow-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-white" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="M12,8c-2.2091675,0-4,1.7908325-4,4s1.7908325,4,4,4c2.208252-0.0021973,3.9978027-1.791748,4-4C16,9.7908325,14.2091675,8,12,8z M12,15c-1.6568604,0-3-1.3431396-3-3s1.3431396-3,3-3c1.6561279,0.0018311,2.9981689,1.3438721,3,3C15,13.6568604,13.6568604,15,12,15z M21.960022,11.8046875C19.9189453,6.9902344,16.1025391,4,12,4s-7.9189453,2.9902344-9.960022,7.8046875c-0.0537109,0.1246948-0.0537109,0.2659302,0,0.390625C4.0810547,17.0097656,7.8974609,20,12,20s7.9190063-2.9902344,9.960022-7.8046875C22.0137329,12.0706177,22.0137329,11.9293823,21.960022,11.8046875z M12,19c-3.6396484,0-7.0556641-2.6767578-8.9550781-7C4.9443359,7.6767578,8.3603516,5,12,5s7.0556641,2.6767578,8.9550781,7C19.0556641,16.3232422,15.6396484,19,12,19z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
        <div class="card overflow-hidden">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h3 class="mb-2 fw-semibold">{{ $transaksi }}</h3>
                        <p class="text-muted fs-13 mb-0">Total Orders</p>
                        {{-- <p class="text-muted mb-0 mt-2 fs-12">
                            <span class="icn-box text-success fw-semibold fs-13 me-1">
                                <i class="fa fa-long-arrow-up"></i>
                                42%</span>
                            since last month
                        </p> --}}
                    </div>
                    <div class="col col-auto top-icn dash">
                        <div class="counter-icon bg-primary dash ms-auto box-shadow-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-white" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="M12,8c-2.2091675,0-4,1.7908325-4,4s1.7908325,4,4,4c2.208252-0.0021973,3.9978027-1.791748,4-4C16,9.7908325,14.2091675,8,12,8z M12,15c-1.6568604,0-3-1.3431396-3-3s1.3431396-3,3-3c1.6561279,0.0018311,2.9981689,1.3438721,3,3C15,13.6568604,13.6568604,15,12,15z M21.960022,11.8046875C19.9189453,6.9902344,16.1025391,4,12,4s-7.9189453,2.9902344-9.960022,7.8046875c-0.0537109,0.1246948-0.0537109,0.2659302,0,0.390625C4.0810547,17.0097656,7.8974609,20,12,20s7.9190063-2.9902344,9.960022-7.8046875C22.0137329,12.0706177,22.0137329,11.9293823,21.960022,11.8046875z M12,19c-3.6396484,0-7.0556641-2.6767578-8.9550781-7C4.9443359,7.6767578,8.3603516,5,12,5s7.0556641,2.6767578,8.9550781,7C19.0556641,16.3232422,15.6396484,19,12,19z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
        <div class="card overflow-hidden">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h3 class="mb-2 fw-semibold">{{ $dropshipper }}</h3>
                        <p class="text-muted fs-13 mb-0">Total</p>
                        {{-- <p class="text-muted mb-0 mt-2 fs-12">
                            <span class="icn-box text-danger fw-semibold fs-13 me-1">
                                <i class="fa fa-long-arrow-down"></i>
                                12%</span>
                            since last month
                        </p> --}}
                    </div>
                    <div class="col col-auto top-icn dash">
                        <div class="counter-icon bg-secondary dash ms-auto box-shadow-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-white" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="M19.5,7H16V5.9169922c0-2.2091064-1.7908325-4-4-4s-4,1.7908936-4,4V7H4.5C4.4998169,7,4.4996338,7,4.4993896,7C4.2234497,7.0001831,3.9998169,7.223999,4,7.5V19c0.0018311,1.6561279,1.3438721,2.9981689,3,3h10c1.6561279-0.0018311,2.9981689-1.3438721,3-3V7.5c0-0.0001831,0-0.0003662,0-0.0006104C19.9998169,7.2234497,19.776001,6.9998169,19.5,7z M9,5.9169922c0-1.6568604,1.3431396-3,3-3s3,1.3431396,3,3V7H9V5.9169922z M19,19c-0.0014038,1.1040039-0.8959961,1.9985962-2,2H7c-1.1040039-0.0014038-1.9985962-0.8959961-2-2V8h3v2.5C8,10.776123,8.223877,11,8.5,11S9,10.776123,9,10.5V8h6v2.5c0,0.0001831,0,0.0003662,0,0.0005493C15.0001831,10.7765503,15.223999,11.0001831,15.5,11c0.0001831,0,0.0003662,0,0.0006104,0C15.7765503,10.9998169,16.0001831,10.776001,16,10.5V8h3V19z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<div>
    <canvas id="myLineChart" width="400" height="200"></canvas>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('myLineChart').getContext('2d');
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Label 1', 'Label 2', 'Label 3', 'Label 4', 'Label 5'],
                datasets: [{
                    label: 'Dataset Label',
                    data: [10, 20, 15, 25, 18],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection
