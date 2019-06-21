@include("MainParts.header")


<h1 class="h3 mb-2 text-gray-800">Tevékenységeim</h1>
          <p class="mb-4">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolor totam quam nulla explicabo nemo libero itaque modi repellat sunt. Exercitationem possimus repellendus voluptas consectetur quia earum harum tenetur sit tempore!</p>
          
          <div class="card shadow mb-4">
            <div class="card-header py-3">
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Esemény</th>
                      <th>Létrehozás dátuma</th>
                      <th>IP</th>

                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                        <th>Esemény</th>
                        <th>Létrehozás dátuma</th>
                        <th>IP</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach($logs as $log)
                    <tr>
                      <td>{{$log->message}} <br /> Régi adatok:<code>{{$log->old}}</code><br /> Új adatok:<code>{{$log->new}}</code></td>
                      <td>{{$log->created_at}}</td>
                      <td>{{$log->ip_address}}</td>
                    </tr>
                        
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          @include("MainParts.footer")