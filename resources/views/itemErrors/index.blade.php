@include("MainParts.header")

@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Hibabejelentések</h1>
          <p class="mb-4">{!! Texts::GetText("errors_desc") !!}</p>
          
          
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                  <a href="/hiba-bejelentesek/uj" class="btn btn-success btn-icon-split">
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
                      <th>Eszköz</th>
                      <th>Közzétette</th>
                      <th>Felülvizsgáló</th>
                      <th>Státusz</th>
                      <th>Létrehozás dátuma</th>
                      <th>Lehetőségek</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Eszköz</th>
                      <th>Közzétette</th>
                      <th>Felülvizsgáló</th>
                      <th>Státusz</th>
                      <th>Létrehozás dátuma</th>
                      <th>Lehetőségek</th>
                    </tr>
                  </tfoot>
                  <tbody>

                    @foreach($notUsersErrors as $error)
                    <tr>
                    <td>{{App\Items::find($error->item_id)->name}}</td>
                    <td>{{App\User::find($error->user_id)->name}}</td>
                    <td>@if($error->worker_id == -1){{"Nincs felülvizsgáló"}} @else{{User::find($error->worker_id)->name}}@endif</td>
                    <td>
                    @if($error->status == "published"){{"Létrehozva"}} @endif
                    @if($error->status == "under_investigation"){{"Felülvizsgálat alatt"}} @endif
                    @if($error->status == "repairing"){{"Javítás alatt"}} @endif
                    @if($error->status == "archive"){{"Archiválva"}} @endif
                    </td>
                    <td>{{$error->created_at}}</td>
                    <td>
                        <a style="display: inline-block;" class="btn btn-warning btn-circle btn-sm" href="/hiba-bejelentesek/{{$error->id}}/szerkeszt"><i class="fas fa-edit"></i></a>
                        <form style="display: inline-block;" action="/hiba-bejelentesek/{{$error->id}}" method="POST">
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


                    @section('scripts')
                    <script>
                      datatable.destroy();
                      $("#table").DataTable({
                        "order": [[ 4, "desc" ]]
                      });
                      </script>
                    @stop
  
          @include("MainParts.footer")