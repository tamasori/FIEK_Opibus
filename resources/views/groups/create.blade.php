@include("MainParts.header")

<h1 class="h3 mb-2 text-gray-800">Felhasználó csoportok</h1>
<p class="mb-4">{!! Texts::GetText("groups_desc") !!}</p>
          
          <form method="post" class="user">
                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                    {{ csrf_field() }}
                    <div class="form-group">
                      <input type="text" class="form-control" name="name" value="{{ old("name") }}" placeholder="Név">
                    </div>

                    <hr />
                    <h3>Adminisztrációs engedélyek</h3>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" name="adminmenu-all" id="adminmenu-all" value="adminmenu-all" {{old("adminmenu-all") === null ? "": "checked"}}>
                          <label class="custom-control-label" for="adminmenu-all">Összes menüpont</label>
                        </div>
                      </div>
                      <hr />
                    <div id="adminmenus">
                    @foreach(Config::get("constants.menus.administration") as $menu)
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                      <input type="checkbox" class="custom-control-input" name="adminmenu-{{$menu['perm']}}" id="{{$menu['perm']}}" value="{{$menu['perm']}}" {{old("adminmenu-".$menu['perm']) === null ? "": "checked"}}>
                        <label class="custom-control-label" for="{{$menu['perm']}}">{{ $menu['name'] }}</label>
                      </div>
                    </div>
                    @endforeach
                    </div>
                    <hr />
                    <h3>Laborok engedélyezése</h3>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" name="labs-all" id="labs-all" value="labs-all" {{old("labs-all") === null ? "": "checked"}}>
                          <label class="custom-control-label" for="labs-all">Összes labor</label>
                        </div>
                    </div>
                    <hr />
                    <div id="labs">
                    @foreach(Labs::all() as $lab)
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                      <input type="checkbox" class="custom-control-input" name="lab-{{$lab['id']}}" id="{{$lab['id']}}" value="{{$lab['id']}}" {{old("lab-".$lab['id']) === null ? "": "checked"}}>
                        <label class="custom-control-label" for="{{$lab['id']}}">{{ $lab['name'] }}</label>
                      </div>
                    </div>
                    @endforeach
                    </div>
                    <hr />
                    <h3>Eszközök engedélyezése</h3>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" name="items-all" id="items-all" value="items-all" {{old("items-all") === null ? "": "checked"}}>
                          <label class="custom-control-label" for="items-all">Összes eszköz</label>
                        </div>
                    </div>
                    <hr />
                    <div id="items">
                    @foreach(Items::all() as $item)
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                      <input type="checkbox" class="custom-control-input" name="item-{{$item['id']}}" id="{{$item['id']}}" value="{{$item['id']}}" {{old("item-".$item['id']) === null ? "": "checked"}}>
                        <label class="custom-control-label" for="{{$item['id']}}">{{ $item['name'] }}</label>
                      </div>
                    </div>
                    @endforeach
                    </div>
                    <input type="submit" class="btn btn-primary btn-user btn-block" value="Hozzáadás">
                    </form>

                    @section('scripts')
                    <script>
                      $(document).ready(function() {
                        if($("#adminmenu-all").is(":checked")){
                          $("#adminmenus input[type=checkbox]").prop('checked', true).prop('disabled', true);
                        }
                        if($("#labs-all").is(":checked")){
                          $("#labs input[type=checkbox]").prop('checked', true).prop('disabled', true);
                        }
                        if($("#items-all").is(":checked")){
                          $("#items input[type=checkbox]").prop('checked', true).prop('disabled', true);
                        }
                      });

                      $("#adminmenu-all").on("change", function(){
                        if($("#adminmenu-all").is(":checked")){
                          $("#adminmenus input[type=checkbox]").prop('checked', true).prop('disabled', true);
                        }
                        else{
                          $("#adminmenus input[type=checkbox]").prop('checked', false).prop('disabled', false);
                        }
                      });  

                      $("#labs-all").on("change", function(){
                        if($("#labs-all").is(":checked")){
                          $("#labs input[type=checkbox]").prop('checked', true).prop('disabled', true);
                        }
                        else{
                          $("#labs input[type=checkbox]").prop('checked', false).prop('disabled', false);
                        }
                      });  

                      $("#items-all").on("change", function(){
                        if($("#items-all").is(":checked")){
                          $("#items input[type=checkbox]").prop('checked', true).prop('disabled', true);
                        }
                        else{
                          $("#items input[type=checkbox]").prop('checked', false).prop('disabled', false);
                        }
                      });  
                    </script>
                     @stop

          @include("MainParts.footer")