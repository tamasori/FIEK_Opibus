@include("MainParts.header")

@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif

<h1 class="h3 mb-2 text-gray-800">Hírek</h1>
          <p class="mb-4">{!! Texts::GetText("news_desc") !!}</p>
          
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                  <a href="/hirek/uj" class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                      <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Létrehozás</span>
                  </a></h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Kép</th>
                      <th>Cím</th>
                      <th>Szerző</th>
                      <th>Státusz</th>
                      <th>Létrehozás dátuma</th>
                      <th>Időzítés dátuma</th>
                      <th>Lehetőségek</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Kép</th>
                      <th>Cím</th>
                      <th>Szerző</th>
                      <th>Státusz</th>
                      <th>Létrehozás dátuma</th>
                      <th>Időzítés dátuma</th>
                      <th>Lehetőségek</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach($news as $new)
                    <tr>
                      <td><img src="{{$new->lead_picture}}" style="max-height: 100px;"></td>
                      <td><a href="/hirek/{{$new->id}}">{{$new->title}}</a></td>
                      <td>{{ App\User::find($new->user_id)->name }}</a></td>
                      <td>{{$new->status}}</td>
                      <td>{{$new->created_at}}</td>
                      <td>{{$new->publish_on}}</td>
                      <td>
                          <a style="display: inline-block;" class="btn btn-warning btn-circle btn-sm" href="/hirek/{{$new->id}}/szerkeszt"><i class="fas fa-edit"></i></a>
                          <form style="display: inline-block;" action="/hirek/{{$new->id}}" method="POST">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button class="btn btn-danger btn-circle btn-sm" type="submit"><i class="fas fa-trash-alt"></i></button>
                        </form>
                        
                    </td>
                    </tr>
                        
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          @include("MainParts.footer")