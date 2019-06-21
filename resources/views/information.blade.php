@include("MainParts.header")
@php
$news = App\News::where("status","=","published")->where("publish_on", "<=", date("Y-m-d"))->get();
@endphp


<h1 class="h3 mb-2 text-gray-800">Hírek</h1>
          <p class="mb-4">{!! Texts::GetText("information_desc") !!}</p>
          
          <div class="card shadow mb-4">
            
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Kép</th>
                      <th>Cím</th>
                      <th>Kivonat</th>
                      <th>Szerző</th>
                      <th>Dátum</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                    <th>Kép</th>
                      <th>Cím</th>
                      <th>Kivonat</th>
                      <th>Szerző</th>
                      <th>Dátum</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach($news as $new)
                    <tr>
                      <td><img src="{{$new->lead_picture}}" style="max-height: 100px;"></td>
                      <td><a href="/hirek/{{$new->id}}">{{$new->title}}</a></td>
                      <td>{{$new->excerpt}}</td>
                      <td>{{ App\User::find($new->user_id)->name }}</a></td>
                      <td>{{$new->publish_on}}</td>
                    </tr>
                        
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          @include("MainParts.footer")