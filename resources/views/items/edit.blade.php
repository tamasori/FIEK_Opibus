@include("MainParts.header")

<h1 class="h3 mb-2 text-gray-800">Eszközök</h1>
          <p class="mb-4">{!! Texts::GetText("items_desc") !!}</p>
          <form class="user" method="post">
                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first('name') }}
                        {{ $errors->first('lab_id') }}
                        {{ $errors->first('supervisor_id') }}
                        {{ $errors->first('file_url') }}
                    </div>
                @endif
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-group">
                      <input type="text" class="form-control" name="name" value="{{ old("name", $current_item->name) }}" placeholder="Név">
                    </div>

                    <div class="form-group">
                        <textarea name="description" class="form-control" placeholder="Leírás">{{ old("description", $current_item->description) }}</textarea>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="youtube_link" value="{{ old("youtube_link", $current_item->youtube_link) }}" placeholder="Youtube link">
                    </div>

                    <div class="form-group">
                      <button id="file" type="button" class="btn btn-primary btn-sm">Kép</button>
                      <input type="text" id="file_url" name="file_url" value="{{old("file_url", $current_item->image)}}">
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                          <input type="checkbox" class="custom-control-input" name="remote_access" id="customCheck" value="1" {{old("remote_access", $current_item->remote_access) === false ? "" : "checked"}}>
                          <label class="custom-control-label" for="customCheck">Távoli elérés</label>
                        </div>
                      </div>
                    <hr />

                    <div class="form-group">
                    <label for="lab_id">Tartózkodás</label>
                    <select class="form-control" id="lab-select" name="lab_id" >
                        @foreach(Labs::all() as $lab)
                          <option value="{{$lab->id}}" @if(old('lab_id', $current_item->lab_id) == $lab->id) {{"selected"}} @endif>{{$lab->name}}</option>
                        @endforeach
                    </select>
                    </div>

                    <hr />

                     <div class="form-group" id="multi">
                      <label for="lab_id">Felügyelő</label>
                      <select class="form-control" id="user-select" name="supervisor_id[]" style="display:none" multiple="multiple">
                          <option value="-1">Nincs felügyelő</option>
                          @foreach(User::all() as $user)
                            <option value="{{$user->id}}" @if(strpos($current_item->supervisor_id, '"' . strval($user->id) . '"') !== false) {{"selected"}} @endif >{{$user->name}}</option>
                          @endforeach
                      </select>
                    </div>

                    <hr />

                    <div class="form-group">
                    <h3>Ha lefoglalják, akkor ezek is elérhetetlenek lesznek:</h3>
                    @foreach(Items::all()->except($current_item->id) as $item)
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                      <input type="checkbox" class="custom-control-input" name="item-{{$item['id']}}" id="{{$item['id']}}" value="{{$item['id']}}" {{old("item-".$item['id'], $current_item->Unaccesible($item['id'])) === false ? "": "checked"}}>
                        <label class="custom-control-label" for="{{$item['id']}}">{{ $item['name'] }}</label>
                      </div>
                    </div>
                    @endforeach
                    </div>

                    <input type="submit" class="btn btn-primary btn-user btn-block" value="Mentés">
                    </form>


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

                      $("#multi").dropdown({
	                        input: '<input type="text" placeholder="Felügyelő">', 
                          searchNoData: '<li">Nincs találat</li>'
                      });
                      
                      </script>
                    @stop

                    
          @include("MainParts.footer")