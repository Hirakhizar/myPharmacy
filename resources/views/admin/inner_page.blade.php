 <div class="page-inner">
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>
                <h3 class="fw-bold mb-3">Dashboard</h3>
                <h6 class="op-7 mb-2">Welcome to Pharmacy Dashboard.</h6>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <a href="{{url('balanceSheet')}}" class="btn btn-label-info btn-round me-2">Balance Sheet</a>
                <a href="{{url('/manufacture/ledger')}}" class="btn btn-primary btn-round"> Ledger</a>
              </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-icon">
                            <div
                              class="icon-big text-center icon-secondary bubble-shadow-small"
                            >
                              <i class="far fa-check-circle"></i>
                            </div>
                          </div>
                          <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                              <p class="card-category">Total Order</p>
                              <h4 class="card-title">{{$order}}</h4>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-info bubble-shadow-small"
                        >
                          <i class="fas fa-user-check"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Purchases</p>
                          <h4 class="card-title">{{$purchase}}</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-success bubble-shadow-small"
                        >
                          <i class="fas fa-luggage-cart"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Sales</p>
                          <h4 class="card-title">{{number_format($sale)}} Rs/-</h4>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-secondary bubble-shadow-small"
                        >
                          <i class="far fa-check-circle"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Expense</p>
                          <h4 class="card-title">{{number_format($expense)}} Rs/-</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="card card-round">
                      <div class="card-header">
                        <div class="card-head-row card-tools-still-right">
                          <div class="card-title">Transaction History</div>
                          <div class="card-tools">

                          </div>
                        </div>
                      </div>
                      <div class="card-body p-0">
                        <div class="table-responsive">
                          <!-- Projects table -->
                          <table class="table align-items-center mb-0">
                            <thead class="thead-light">
                              <tr>
                                <th scope="col">Invoice</th>
                                <th scope="col" class="text-end">Date </th>
                                <th scope="col" class="text-end">Amount</th>

                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($payment as $pay)
                              <tr>
                                 <td class="text-end"> #{{$pay->invoice}}</td>

                                <td class="text-end">{{$pay->date}}</td>
                                <td class="text-end">{{number_format($pay->amount)}}Rs/-</td>





                              </tr>
                              @endforeach

                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>

              <div class="col-md-7">
                <div class="card card-round">
                  <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                      <div class="card-title">Product Detail</div>
                      <div class="card-tools">
                      </div>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <!-- Projects table -->
                      <table class="table align-items-center mb-0">
                        <thead class="thead-light text-center">
                          <tr>
                            <th scope="col"> Name</th>
                            <th scope="col" class="text-end">Expiry</th>
                            <th scope="col" class="text-end">stock</th>
                            <th scope="col" class="text-end">Status</th>
                          </tr>
                        </thead>
                        <tbody>
                            @php
                            use Carbon\Carbon;
                             $startOfThisMonth = Carbon::now()->startOfMonth();
                             $endOfThisMonth = Carbon::now()->endOfMonth();
                         @endphp
                            @foreach ($medicine as $med)
                            @if ($med->status == 'low' || $med->status == 'out of stock' ||  ($med->expire_date >= $startOfThisMonth && $med->expire_date <= $endOfThisMonth) )
                            <tr>
                                <th scope="row">
                                    <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    {{ $med->name }}
                                </th>
                                <td class="text-end">{{ \Carbon\Carbon::parse($med->expire_date)->format('Y-m-d') }}</td>
                                <td class="text-end">{{ $med->stock }}</td>
                                @if ($med->status == 'low')
                                    <td class="text-end">
                                        <span class="badge badge-warning">{{ $med->status }}</span>
                                    </td>
                                @elseif ($med->status == 'out of stock')
                                    <td class="text-end">
                                        <span class="badge badge-danger">{{ $med->status }}</span>
                                    </td>
                                    @else
                                    <td class="text-end">
                                        <span class="badge badge-secondary">Expire Soon</span>
                                    </td>
                                @endif
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
