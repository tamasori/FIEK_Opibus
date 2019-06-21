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


<h1 class="h3 mb-2 text-gray-800">Foglalás</h1>
          <p class="mb-4">{!! Texts::GetText("reservation_desc") !!}</p>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                  <a href="/foglalas/uj" class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                      <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Létrehozás</span>
                  </a></h6>
                  <h6 class="m-0 font-weight-bold text-primary">
                  <a href="/foglalas/elfogad-mind" class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                      <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Összes elfogadása</span>
                  </a></h6>

            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Ember</th>
                      <th>Eszköz</th>
                      <th>Ettől</th>
                      <th>Eddig</th>
                      <th>Elfogadva</th>

                      <th>Lehetőségek</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Ember</th>
                      <th>Eszköz</th>
                      <th>Ettől</th>
                      <th>Eddig</th>
                      <th>Elfogadva</th>
                      <th>Lehetőségek</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach($reservations as $reservation)
                    <tr>
                      <td>{{User::find($reservation->user_id)->name}}</td>
                      <td>{{Items::find($reservation->item_id)->name}}</td>
                      <td>{{$reservation->from_date}}</td>
                      <td>{{$reservation->to_date}}</td>
                      <td>@if($reservation->accepted == 1)
                            Igen
                          @else
                            Nem
                          @endif</td>
                      <td>
                      @if($reservation->accepted == 0)
                      <form style="display: inline-block;" action="/foglalas/elfogad/{{$reservation->id}}" method="POST">
                            {{ csrf_field() }}
                            <button class="btn btn-success btn-circle btn-sm" type="submit"><i class="fas fa-check"></i></button>
                        </form>
                        @endif
                          <form style="display: inline-block;" action="/foglalas/{{$reservation->id}}" method="POST">
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
                        "order": [[ 1, "asc" ]]
                      });
                      </script>
                    @stop

          @include("MainParts.footer")