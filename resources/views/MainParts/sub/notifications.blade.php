<li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger badge-counter">{{ App\Notifications::where('user_id','=', Auth::User()->id)->where("opened","=","0")->count() }}</span>
              </a>
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Értesítések
                </h6>
                @forelse ( App\Notifications::where('user_id','=', Auth::User()->id)->orderBy("created_at","DESC")->limit(5)->get() as $notification)
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">{{$notification->created_at}}</div>
                    <span class="font-weight-bold">{{$notification->message}}</span>
                  </div>
                </a>
                @empty
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500"></div>
                    <span class="font-weight-bold">Nincsenek értesítések</span>
                  </div>
                </a>
                @endforelse
                
                <a class="dropdown-item text-center small text-gray-500" href="/fiokom#ertesitesek">Összes értesítés</a>
              </div>
            </li>