@include("MainParts.header")

<h1 class="h3 mb-2 text-gray-800">Hibabejelentés</h1>
          <p class="mb-4">{!! Texts::GetText("errors_desc") !!}</p>
          <form class="user" method="post">
                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first('item_id') }}
                        {{ $errors->first('worker_id') }}
                        {{ $errors->first('description') }}
                        {{ $errors->first('status') }}
                    </div>
                @endif
                    {{ csrf_field() }}
                    {{ method_field("PUT") }}

                    <div class="form-group">
                      <label for="item-select">Eszköz</label>
                      <select class="form-control" id="item-select" name="item_id" >
                          @foreach($items as $item)
                            <option value="{{$item->id}}" @if($error->item_id == $item->id) {{"selected"}} @endif>{{$item->name}}</option>
                          @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="user-select">Hozzárendelt user</label>
                      <select class="form-control" id="user-select" name="worker_id" >
                        <option value="-1" @if($error->worker_id == "-1") {{"selected"}} @endif>Nincs hozzárendelt felülvizsgáló</option>
                          @foreach($users as $user)
                            <option value="{{$user->id}}" @if($error->worker_id == $user->id) {{"selected"}} @endif>{{$user->name}}</option>
                          @endforeach
                      </select>
                    </div>

                    <div class="form-group">
                      <textarea class="form-control" name="description" placeholder="Leírás">{{ $error->description }}</textarea>
                    </div>

                    <div class="form-group">
                      <label for="status-select">Állapot</label>
                      <select class="form-control" id="status-select" name="status" >
                          <option value="published" @if($error->status  == "published") {{"selected"}} @endif>Közzétéve</option>
                          <option value="under_investigation" @if($error->status == "under_investigation") {{"selected"}} @endif>Felülvizsgálat</option>
                          <option value="repairing" @if($error->status == "repairing") {{"selected"}} @endif>Javítás alatt</option>
                          <option value="archive" @if($error->status == "archive") {{"selected"}} @endif>Archiválás</option>
                      </select>
                    </div>

                    <input type="submit" class="btn btn-primary btn-user btn-block" value="Ment">
                    </form>

                    <div> 

                        <table class="table table-bordered" style="margin-top: 20px;" width="100%" cellspacing="0">
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
                              @foreach(Logs::where("message", "LIKE", "%Errors%")->where("connected_id", "=", $error->id)->get() as $log)
                              <tr>
                                <td>{{$log->message}} <br /> Régi adatok:<code>{{$log->old}}</code><br /> Új adatok:<code>{{$log->new}}</code></td>
                                <td>{{$log->created_at}}</td>
                                <td>{{$log->ip_address}}</td>
                              </tr>
                                  
                              @endforeach
                            </tbody>
                          </table>


                    </div>

                    @section('scripts')
                    <script>
                      
                      $("#file").on("click", function(){
                        selectFileWithCKFinder('file_url');
                      });
                      
                      
                      function selectFileWithCKFinder(elementId){
                          CKFinder.modal({
                              chooseFiles: true,
                              width: 800,
                              height: 600,
                              onInit: function(finder){
                                  finder.on('files:choose', function(evt){
                                      var file = evt.data.files.first();
                                      var output = document.getElementById(elementId);
                                      output.value = file.getUrl();
                                  });
                                  finder.on('file:choose:resizedImage', function(evt){
                                      var output = document.getElementById(elementId);
                                      
                                      output.value = evt.data.resizedUrl;
                                  });
                              }
                          });
                      }
                      
                      </script>
                    @stop

                    
          @include("MainParts.footer")