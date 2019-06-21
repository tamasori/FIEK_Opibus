@include("MainParts.header")

@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif

@if(session()->has('deleteError'))
    <div class="alert alert-danger">
        {{session()->get("deleteError")}}
    </div>
@endif


<h1 class="h3 mb-2 text-gray-800">Felügyelet jelenlét</h1>
          <p class="mb-4">{!! Texts::GetText("overwatch_desc") !!}</p>
          <h1 class="h3 mb-2 text-gray-800">Saját felügyeleti jelenlét</h1>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                  <a href="/felugyelet-jelenlet/uj" class="btn btn-success btn-icon-split">
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
                      <th>Felügyelő</th>
                      <th>Ettől</th>
                      <th>Eddig</th>
                      <th>Laboratórium</th>
                      <th>Lehetőségek</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                        <th>Felügyelő</th>
                        <th>Ettől</th>
                        <th>Eddig</th>
                        <th>Laboratórium</th>
                        <th>Lehetőségek</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach($own_overwatches as $overwatch)
                    <tr>
                      <td>{{User::find($overwatch->user_id)->name}}</td>
                      <td>{{$overwatch->from_date}}</td>
                      <td>{{$overwatch->to_date}}</td>
                      <td>{{Labs::find($overwatch->lab_id)->name}}</td>
                      <td>
                          <form style="display: inline-block;" action="/felugyelet-jelenlet/{{$overwatch->id}}" method="POST">
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
          <h1 class="h3 mb-2 text-gray-800">Összes felügyeleti jelenlét</h1>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                  <a href="/felugyelet-jelenlet/uj" class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                      <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Létrehozás</span>
                  </a></h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table2" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Felügyelő</th>
                      <th>Ettől</th>
                      <th>Eddig</th>
                      <th>Laboratórium</th>
                      <th>Lehetőségek</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                        <th>Felügyelő</th>
                        <th>Ettől</th>
                        <th>Eddig</th>
                        <th>Laboratórium</th>
                        <th>Lehetőségek</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach($overwatches as $overwatch)
                    <tr>
                      <td>{{User::find($overwatch->user_id)->name}}</td>
                      <td>{{$overwatch->from_date}}</td>
                      <td>{{$overwatch->to_date}}</td>
                      <td>{{Labs::find($overwatch->lab_id)->name}}</td>
                      <td>
                          <form style="display: inline-block;" action="/felugyelet-jelenlet/{{$overwatch->id}}" method="POST">
                            {{ csrf_field() }}
                            <button class="btn btn-danger btn-circle btn-sm" type="submit" @if($overwatch->user_id <> Auth::User()->id) {{"disabled"}} @endif><i class="fas fa-trash-alt"></i></button>
                        </form>
                        
                    </td>
                    </tr>
                        
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          @section('scripts')
                    <script>
                      datatable.destroy();
                      $("#table").DataTable({
                        "order": [[ 1, "asc" ]]
                      });

                      $("#table2").DataTable({
                        "order": [[ 1, "asc" ]]
                      });
                      </script>
                    @stop

          @include("MainParts.footer")