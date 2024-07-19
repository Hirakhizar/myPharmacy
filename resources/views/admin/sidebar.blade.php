 <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="{{asset('pharmacy/index.html')}}" class="logo">


                <h2 class="text-section">Pharmacy</h2>

            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item active">
                <a

                  href="{{ url('/') }}"

                >
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                  <span class=""></span>
                </a>

              </li>
               <li class="nav-item">
                <a data-bs-toggle="collapse" href="#customer">
                  <i class="fas fa-users"></i>
                  <p>Customer</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="customer">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="{{asset('pharmacy/components/avatars.html')}}">
                        <span class="sub-item">Add Customer</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{asset('pharmacy/components/buttons.html')}}">
                        <span class="sub-item">Customer List</span>
                      </a>
                    </li>

                  </ul>
                </div>
              </li>
               <li class="nav-item">
                <a data-bs-toggle="collapse" href="#medicine">
                  <i class="fas fa-pills"></i>
                  <p>Medicine</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="medicine">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="{{asset('pharmacy/components/avatars.html')}}">
                        <span class="sub-item">Add Medicine</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{asset('pharmacy/components/buttons.html')}}">
                        <span class="sub-item">Medicine List</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{asset('pharmacy/components/buttons.html')}}">
                        <span class="sub-item">Medicine Details</span>
                      </a>
                    </li>

                  </ul>
                </div>
              </li>
                <li class="nav-item">
                <a data-bs-toggle="collapse" href="#manufacturer">
                  <i class="fas fa-industry"></i>
                  <p>Manufacturer</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="manufacturer">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="{{asset('pharmacy/components/avatars.html')}}">
                        <span class="sub-item">Add Manufacturer</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{asset('pharmacy/components/buttons.html')}}">
                        <span class="sub-item">Manufacturer List</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
                <li class="nav-item">
                <a data-bs-toggle="collapse" href="#human">
                  <i class="fas fa-user"></i>
                  <p>Human Resource</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="human">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="{{asset('pharmacy/components/avatars.html')}}">
                        <span class="sub-item">Members</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{asset('pharmacy/components/buttons.html')}}">
                        <span class="sub-item">Attendance </span>
                      </a>
                    </li>
                     <li>
                      <a href="{{asset('pharmacy/components/avatars.html')}}">
                        <span class="sub-item">Salary</span>
                      </a>
                    </li>
                    

                  </ul>
                </div>
              </li>
               <li class="nav-item">
                <a data-bs-toggle="collapse" href="#return">
                  <i class="fas fa-undo"></i>
                  <p>Return</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="return">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="{{asset('pharmacy/components/avatars.html')}}">
                        <span class="sub-item">Add Wastage Return</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{asset('pharmacy/components/buttons.html')}}">
                        <span class="sub-item">Wastage Return List</span>
                      </a>
                    </li>
                     <li>
                      <a href="{{asset('pharmacy/components/avatars.html')}}">
                        <span class="sub-item">Add Manufacturer Return</span>
                      </a>
                    </li>
                     <li>
                      <a href="{{asset('pharmacy/components/avatars.html')}}">
                        <span class="sub-item">Manufacturer Return List</span>
                      </a>
                    </li>

                  </ul>
                </div>
              </li>

               <li class="nav-item">
                <a data-bs-toggle="collapse" href="#report">
                  <i class="fas fa-chart-bar"></i>
                  <p>Report</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="report">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="{{asset('pharmacy/components/avatars.html')}}">
                        <span class="sub-item">Sales Report</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{asset('pharmacy/components/buttons.html')}}">
                        <span class="sub-item">Purchaces Report</span>
                      </a>
                    </li>
                     <li>
                      <a href="{{asset('pharmacy/components/avatars.html')}}">
                        <span class="sub-item">Stock Report</span>
                      </a>
                    </li>
                    

                  </ul>
                </div>
              </li>
             
            </ul>
          </div>
        </div>
      </div>