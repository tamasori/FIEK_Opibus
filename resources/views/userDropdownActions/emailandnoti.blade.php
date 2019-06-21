@include("MainParts.header")


          <h1 class="h3 mb-2 text-gray-800">Értesítések</h1>
          <div class="card shadow mb-4">
            
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Dátum</th>
                      <th>Értesítés</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                        <th>Dátum</th>
                        <th>Értesítés</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach(Notifications::where("user_id","=", Auth::User()->id)->orderBy("created_at","DESC")->get() as $notification)
                    <tr>
                      <td>{{$notification->created_at}}</td>
                      <td>{{$notification->message}}</td>
                    </tr>
                        
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <h1 class="h3 mb-2 text-gray-800">Üzenetek</h1>
          <div class="card shadow mb-4">
            
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table2" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Dátum</th>
                      <th>Üzenet</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                        <th>Dátum</th>
                        <th>Üzenet</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach(Messages::where("user_id","=", Auth::User()->id)->orderBy("created_at","DESC")->get() as $message)
                    <tr>
                      <td>{{$message->created_at}}</td>
                      <td>{{$message->message}}</td>
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