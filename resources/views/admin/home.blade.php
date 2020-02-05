@extends('admin.layout.master')

@section('content')
 <div class="container">
            <div class="page-header">
              <h1 class="page-title">
                Dashboard
              </h1>
            </div>
            <div class="row row-cards">
              <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="h1 m-0">1</div>
                    <div class="text-muted mb-4">Todays Order</div>
                  </div>
                </div>
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-3 text-center">

                    <div class="h1 m-0">1</div>
                    <div class="text-muted mb-4">Total Orders</div>
                  </div>
                </div>
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="h1 m-0">1</div>
                    <div class="text-muted mb-4">Available </div>
                  </div>
                </div>
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="h1 m-0">1</div>
                    <div class="text-muted mb-4">Guest Booking</div>
                  </div>
                </div>
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-3 text-center">

                    <div class="h1 m-0">1</div>
                    <div class="text-muted mb-4">Total Franchise</div>
                  </div>
                </div>
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="h1 m-0">1</div>
                    <div class="text-muted mb-4">Total Doctors</div>
                  </div>
                </div>
              </div>





            </div>

            <div class="row row-cards row-deck">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Bookings (Recent 20 bookings)</h3>
                  </div>
                  <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                      <thead>
                        <tr>
                          <th class="w-1">Sl.</th>
                          <th>Transaction No</th>
                          <th>Appointment Date</th>
                          <th>Email</th>
                          <th>Slot</th>
                          <th>Doctor Name</th>
                          <th>Doctor Phone no</th>
                          <th>Patient Name</th>
                          <th>Amount Paid</th>
                        </tr>
                      </thead>
                      <tbody>



                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection
