<!-- Nav Item - Messages -->
<li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">{{ App\Messages::where('user_id','=', Auth::User()->id)->where("opened","=","0")->orderBy("created_at","DESC")->count() }}</span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Üzenetek
                </h6>
                @forelse (App\Messages::where('user_id','=', Auth::User()->id)->orderBy("created_at","DESC")->limit(5)->get() as $message)
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="font-weight-bold">
                    <div class="text-truncate">{{ $message->subject }}</div>
                    <div class="small text-gray-500">{{ $message->created_at }}</div>
                  </div>
                </a>
                @empty
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="font-weight-bold">
                    <div class="text-truncate">Nincsenek üzenetek.</div>
                    <div class="small text-gray-500"></div>
                  </div>
                </a>
                @endforelse
                
                <a class="dropdown-item text-center small text-gray-500" href="/fiokom#uzenetek">Összes üzenet</a>
              </div>
            </li>