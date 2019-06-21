@include('MainParts.header')
<style>
  .news-card{
    padding: 3px;
    border-bottom: 1px solid #b7b9cc;
  }
  </style>
  @php
  $news = App\News::where("status","=","published")->where("publish_on", "<=", date("Y-m-d"))->limit(5)->get();
  $reservations = App\Reservation::where("user_id","=",Auth::User()->id)->where("to_date", ">=", date("Y-m-d"))->limit(5)->get();
  $logs = App\Logs::where("user_id","=",Auth::User()->id)->orderBy("created_at")->limit(5)->get();
  @endphp
<div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Vezérlőpult</h1>
          </div>
          <div class="row">

            <div class="col-xl-6 col-lg-6">
              <div class="card shadow mb-4">
                
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Hibabejelentés</h6>
                </div>
                <div class="card-body">
                    @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                @if(session()->has('errors'))
                <div class="alert alert-danger">
                    {{ $errors->first('item_id') }}
                    {{ $errors->first('description') }}

                </div>
                @endif
                    <form class="user" method="post">
                        <input type="hidden" name="type" value="error">
                            {{ csrf_field() }}
                  <div class="form-group">
                    <label for="item-select">Eszköz</label>
                    <select class="form-control" id="item-select" name="item_id" >
                        @foreach($items as $item)
                          <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <textarea class="form-control" name="description" placeholder="Leírás"></textarea>
                  </div>
                  <input type="submit" class="btn btn-primary btn-user btn-block" value="Hozzáadás">
                  </form>

                </div>
              </div>
            </div>

            <div class="col-xl-6 col-lg-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Hírek</h6>
                </div>
                <div class="card-body">
                  @foreach ($news as $new)
                <a href="/hirek/{{$new->id}}">
                  <div class="row news-card">
                  <div class="col-md-2"><img class="img-responsive" style="width: 100%;" src="{{$new->lead_picture}}" /></div>
                      <div class="col-md-10"><p>{{$new->title}}</p></div>
                  </div>
                  </a>
                  @endforeach
                  <a class="dropdown-item text-center small text-gray-500" href="/informaciok">Összes hír</a>
                </div>
              </div>
            </div>
          </div>

          <div class="row">

            <div class="col-xl-6 col-lg-6">
              <div class="card shadow mb-4">
                
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Foglalásaim</h6>
                </div>
                <div class="card-body">
                
                  @foreach ($reservations as $reservation)
                
                  <div class="row news-card">
                  <div class="col-md-6"><p>{{$reservation->from_date}}</p><p>{{$reservation->to_date}}</p></div>
                      <div class="col-md-6"><p>{{Items::find($reservation->item_id)->name}}</p></div>
                  </div>
                  @endforeach
                  <a class="dropdown-item text-center small text-gray-500" href="/foglalasaim">Összes foglalásom</a>
                    
                </div>
              </div>
            </div>

            <div class="col-xl-6 col-lg-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Tevékenységeim</h6>
                </div>
                <div class="card-body">
                  @foreach ($logs as $log)
                
                  <div class="row news-card">
                  <div class="col-md-6">{{$log->created_at}}</div>
                  <div class="col-md-6"><p>{{$log->message}}</p></div>
                  </div>
                  @endforeach
                  <a class="dropdown-item text-center small text-gray-500" href="/tevekenysegem">Összes tevékenységem</a>
                </div>
              </div>
            </div>
          </div>

@include('MainParts.footer')