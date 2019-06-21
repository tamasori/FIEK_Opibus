@include("MainParts.header")
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Felhasználók</h1>
          <p class="mb-4">{!! Texts::GetText("users_desc") !!}</p>

                      <p><b>Felhasználónév: </b><span class="text-primary">{{ $user->name }}</span></p>
  
                      <p><b>Email cím: </b><span class="text-primary">{{ $user->email }}</span></p>

                      <p><b>Telefon szám: </b><span class="text-primary">{{ $user->phone_number }}</span></p>
                      <p><b>Létrehozva: </b><span class="text-primary">{{ $user->created_at }}</span></p>
                      <p><b>Szerkesztve: </b><span class="text-primary">{{ $user->updated_at }}</span></p>

                    <p><b>Felhasználó engedélyezve: </b>@if($user->accepted)<i class="fas fa-check text-primary"></i> @else <i class="fas fa-times text-primary"></i> @endif</p>


                    <hr />
                    <h3>Adminisztrációs engedélyek</h3>
                    <p><b>Összes menü: </b>@if($user->CanAccessMenu("all")) <i class="fas fa-check text-primary"></i> @else <i class="fas fa-times text-primary"></i>@endif</p>
                    @foreach(Config::get("constants.menus.administration") as $menu)
                        <p><b>{{$menu['name']}}: </b>@if($user->CanAccessMenu($menu['perm'])) <i class="fas fa-check text-primary"></i> @else <i class="fas fa-times text-primary"></i>@endif</p>
                    @endforeach
                    <hr />
                    <h3>Laborok engedélyezése</h3>
                    <p><b>Összes labor: </b>@if($user->CanAccessLab("all")) <i class="fas fa-check text-primary"></i> @else <i class="fas fa-times text-primary"></i>@endif</p>
                    @foreach(Labs::all() as $lab)
                        <p><b>{{$lab['name']}}: </b>@if($user->CanAccessLab($lab['id'])) <i class="fas fa-check text-primary"></i> @else <i class="fas fa-times text-primary"></i>@endif</p>
                    @endforeach
                    <hr />
                    <h3>Eszközök engedélyezése</h3>
                    <p><b>Összes eszköz: </b>@if($user->CanAccessItem("all")) <i class="fas fa-check text-primary"></i> @else <i class="fas fa-times text-primary"></i>@endif</p>
                    @foreach(Items::all() as $item)
                        <p><b>{{$item['name']}}: </b>@if($user->CanAccessItem($item['id'])) <i class="fas fa-check text-primary"></i> @else <i class="fas fa-times text-primary"></i>@endif</p>
                    @endforeach

          @include("MainParts.footer")