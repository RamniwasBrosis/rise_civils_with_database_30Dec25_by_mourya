@extends('admin.layout.main')
@section('content')
  <style>
      .stat-card {
          border-radius: 15px;
          padding: 20px;
          color: white;
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
          transition: transform 0.2s ease;
      }

      .stat-card:hover {
          transform: translateY(-5px);
      }

      .icon-box {
          font-size: 40px;
          margin-bottom: 10px;
      }

      .bg-users {
          background: linear-gradient(135deg, #4CAF50, #2E7D32);
      }

      .bg-tickets {
          background: linear-gradient(135deg, #2196F3, #1565C0);
      }

      .bg-collection {
          background: linear-gradient(135deg, #FF9800, #E65100);
      }
  </style>
    <div class="content-wrapper">
      <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-lg-8 mb-4 order-0" style="width:100%;">
                    <div class="card mb-3 p-3 d-flex flex-row justify-content-between align-items-center">
                        <div class="fw-bold fs-5">
                            Admin Panel
                        </div>
                        <div class="text-end">
                            <span class="d-block fw-semibold">{{ $adminData->username }}</span>
                            <small class="text-muted">{{ $adminData->email }}</small>
                        </div>
                    </div>

                  <div class="card" style="height: 230%;">
                      <div class="d-flex align-items-end row">
                          <div class="col-sm-7">
                              <div class="card-body">
                                  <div class="me-3">
                                      <!--<img src="{{url('farnt/images/logo.png')}}" alt="Logo" height="80">-->
                                  </div>
                                  <!--<h5 class="card-title text-primary">Khole ke Hanumanji 🎉</h5>-->
                                  <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">-->
                                    @php
                                        $user = Auth::guard('admin')->user();
                                    @endphp
                                    @if($user->role === 'super-admin')
                                    <div class="container my-4" 
                                         style="background-image: url('{{ asset('assets_rise/img/logo/logo.png') }}');
                                                background-size: contain;
                                                background-repeat: no-repeat;
                                                background-position: center;
                                                height: 200px;">
                                    </div>
                                  @endif
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  @endsection