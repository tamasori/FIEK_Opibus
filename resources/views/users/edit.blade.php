@include("MainParts.header")
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Felhasználók</h1>
          <p class="mb-4">{!! Texts::GetText("users_desc") !!}</p>
          
          <!-- DataTales Example -->
          <form action="/felhasznalok/{{$user->id}}/szerkeszt" class="user" method="post">
                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first('email') }}
                        {{ $errors->first('password') }}
                        {{ $errors->first('phone_number') }}
                        {{ $errors->first('emailExists') }}
                    </div>
                @endif
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="form-group">
                      <input type="text" class="form-control" name="name" value="{{ old("name", $user->name) }}" placeholder="Név">
                    </div>
                    <div class="form-group">
                      <input type="email" class="form-control" id="exampleInputEmail" name="email" aria-describedby="emailHelp" value="{{ old("email", $user->email) }}" placeholder="Email">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" name="phone_number" value="{{ old("phone_number", $user->phone_number) }}" placeholder="Telefonszám">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" name="github" value="{{ old("github", $user->github) }}" placeholder="GitHub felhasználónév">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" id="exampleInputPassword" name="password" placeholder="Jelszó">
                    </div>

                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" name="userEnable" id="customCheck" value="1" {{old("userEnable", $user->accepted) != 1 ? "" : "checked"}} @if($user->id == Auth::User()->id) {{"disabled"}} @endif>
                        <label class="custom-control-label" for="customCheck">Felhasználó engedélyezése</label>
                      </div>
                    </div> 
                    <hr />
                    <h3>Felhasználó csoport</h3>
                    <select class="form-control" id="group-select">
                        <option value="0">Nincs csoport</option>
                      @foreach($groups as $group)
                        <option value="{{$group->id}}">{{$group->name}}</option>
                      @endforeach
                    </select>
                    <hr />
                    <h3>Adminisztrációs engedélyek</h3>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" name="adminmenu-all" id="adminmenu-all" value="adminmenu-all" {{old("adminmenu-all",  $user->CanAccessMenu("all")) === false ? "": "checked"}} @if($user->id == Auth::User()->id) {{"disabled"}} @endif>
                          <label class="custom-control-label" for="adminmenu-all">Összes menüpont</label>
                        </div>
                      </div>
                      <hr />
                    <div id="adminmenus">
                    @foreach(Config::get("constants.menus.administration") as $menu)
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                      <input type="checkbox" class="custom-control-input" name="adminmenu-{{$menu['perm']}}" id="{{$menu['perm']}}" value="{{$menu['perm']}}" {{old("adminmenu-".$menu['perm'], $user->CanAccessMenu($menu['perm'])) === false ? "": "checked"}}  @if($user->id == Auth::User()->id) {{"disabled"}} @endif>
                        <label class="custom-control-label" for="{{$menu['perm']}}">{{ $menu['name'] }}</label>
                      </div>
                    </div>
                    @endforeach
                  </div>
                    <hr />
                    <h3>Laborok engedélyezése</h3>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" name="labs-all" id="labs-all" value="labs-all" {{old("labs-all",  $user->CanAccessLab("all")) === false ? "": "checked"}} @if($user->id == Auth::User()->id) {{"disabled"}} @endif>
                          <label class="custom-control-label" for="labs-all">Összes labor</label>
                        </div>
                    </div>
                    <hr />
                    <div id="labs">
                    @foreach(Labs::all() as $lab)
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                      <input type="checkbox" class="custom-control-input" name="lab-{{$lab['id']}}" id="{{$lab['id']}}" value="{{$lab['id']}}" {{old("lab-".$lab['id'], $user->CanAccessLab($lab['id'])) === false ? "": "checked"}}  @if($user->id == Auth::User()->id) {{"disabled"}} @endif>
                        <label class="custom-control-label" for="{{$lab['id']}}">{{ $lab['name'] }}</label>
                      </div>
                    </div>
                    @endforeach
                  </div>
                    <hr />
                    <h3>Eszközök engedélyezése</h3>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" name="items-all" id="items-all" value="items-all" {{old("items-all", $user->CanAccessItem("all")) === false ? "": "checked"}} @if($user->id == Auth::User()->id) {{"disabled"}} @endif>
                          <label class="custom-control-label" for="items-all">Összes eszköz</label>
                        </div>
                    </div>
                    <hr />
                    <div id="items">
                    @foreach(Items::all() as $item)
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                      <input type="checkbox" class="custom-control-input" name="item-{{$item['id']}}" id="{{$item['id']}}" value="{{$item['id']}}" {{old("item-".$item['id'], $user->CanAccessItem($item['id'])) === false ? "": "checked"}}>
                        <label class="custom-control-label" for="{{$item['id']}}">{{ $item['name'] }}</label>
                      </div>
                    </div>
                    @endforeach
                    </div>
                    <input type="submit" class="btn btn-primary btn-user btn-block" value="Mentés">
                    </form>

                    @section('scripts')
                    <script>
                        var groups_data = {
                          @foreach($groups as $group)
                          "{!!$group->id!!}":{!!$group->can_access!!},
                          @endforeach
                        };
  
                        $("#group-select").on("change", function(){
                          $("input[type=checkbox]").not("#customCheck").prop('checked', false);
                          $("input[type=checkbox]").not("#customCheck").prop('disabled', false);
                          if(groups_data[$("#group-select").val()]["menus"].includes("all")){
                            $("#adminmenu-all").prop('checked', true);
                            $("#adminmenu-all").trigger("change");
                          }
                          if(groups_data[$("#group-select").val()]["labs"].includes("all")){
                            $("#labs-all").prop('checked', true);
                            $("#labs-all").trigger("change");
                          }
                          if(groups_data[$("#group-select").val()]["items"].includes("all")){
                            $("#items-all").prop('checked', true);
                            $("#items-all").trigger("change");
                          }
                          Object.values(groups_data[$("#group-select").val()]).forEach(element => {
                            element.forEach(sub =>{
                              $("#"+sub).prop('checked', true);
                            })
                          });
                        }); 
                        
                        $("input[type=checkbox]").on("click", function(){
                          $("#group-select").val("0");
                        });
  
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