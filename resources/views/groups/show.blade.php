@include("MainParts.header")
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Felhasználó csoportok</h1>
          <p class="mb-4">{!! Texts::GetText("groups_desc") !!}</p>

                      <p><b>Név: </b><span class="text-primary">{{ $group->name }}</span></p>
                      <p><b>Létrehozva: </b><span class="text-primary">{{ $group->created_at }}</span></p>
                      <p><b>Szerkesztve: </b><span class="text-primary">{{ $group->updated_at }}</span></p>

                    <hr />
                    <h3>Adminisztrációs engedélyek</h3>
                    <p><b>Összes menü: </b>@if($group->CanAccessMenu("all")) <i class="fas fa-check text-primary"></i> @else <i class="fas fa-times text-primary"></i>@endif</p>
                    @foreach(Config::get("constants.menus.administration") as $menu)
                        <p><b>{{$menu['name']}}: </b>@if($group->CanAccessMenu($menu['perm'])) <i class="fas fa-check text-primary"></i> @else <i class="fas fa-times text-primary"></i>@endif</p>
                    @endforeach
                    <hr />
                    <h3>Laborok engedélyezése</h3>
                    <p><b>Összes labor: </b>@if($group->CanAccessLab("all")) <i class="fas fa-check text-primary"></i> @else <i class="fas fa-times text-primary"></i>@endif</p>
                    @foreach(Labs::all() as $lab)
                        <p><b>{{$lab['name']}}: </b>@if($group->CanAccessLab($lab['id'])) <i class="fas fa-check text-primary"></i> @else <i class="fas fa-times text-primary"></i>@endif</p>
                    @endforeach
                    <hr />
                    <h3>Eszközök engedélyezése</h3>
                    <p><b>Összes eszköz: </b>@if($group->CanAccessItem("all")) <i class="fas fa-check text-primary"></i> @else <i class="fas fa-times text-primary"></i>@endif</p>
                    @foreach(Items::all() as $item)
                        <p><b>{{$item['name']}}: </b>@if($group->CanAccessItem($item['id'])) <i class="fas fa-check text-primary"></i> @else <i class="fas fa-times text-primary"></i>@endif</p>
                    @endforeach

          @include("MainParts.footer")