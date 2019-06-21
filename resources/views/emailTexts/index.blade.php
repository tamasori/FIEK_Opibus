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


<h1 class="h3 mb-2 text-gray-800">Email szövegek</h1>
          <p class="mb-4">{!! Texts::GetText("emailtext_desc") !!}</p>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Megnevezés</th>

                      <th>Lehetőségek</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                        <th>Megnevezés</th>

                        <th>Lehetőségek</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach(App\EmailText::all() as $emailtext)
                    <tr>
                      <td>{{$emailtext->name}}</td>
                      
                      <td>
                      
                      <a style="display: inline-block;" class="btn btn-warning btn-circle btn-sm" href="/email-szovegek/{{$emailtext->id}}/szerkeszt"><i class="fas fa-edit"></i></a>
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
                      </script>
                    @stop

          @include("MainParts.footer")