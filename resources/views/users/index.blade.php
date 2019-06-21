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


<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Felhasználók</h1>
          <p class="mb-4">{!! Texts::GetText("users_desc") !!}</p>
          
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                  <a href="/felhasznalok/uj" class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                      <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Létrehozás</span>
                  </a></h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Név</th>
                      <th>Email</th>
                      <th>Engedélyezett</th>
                      <th>Telefonszám</th>
                      <th>GitHub</th>
                      <th>Létrehozás dátuma</th>
                      <th>Lehetőségek</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                        <th>Név</th>
                        <th>Email</th>
                        <th>Engedélyezett</th>
                        <th>Telefonszám</th>
                        <th>GitHub</th>
                        <th>Létrehozás dátuma</th>
                        <th>Lehetőségek</th>
                    </tr>
                  </tfoot>
                  <tbody>

                    @foreach($users as $user)
                    <tr>
                    <td><a href="/felhasznalok/{{$user->id}}">{{$user->name}}</a></td>
                      <td>{{$user->email}}</td>
                      <td>
                          @if($user->accepted == 1)
                            Igen
                          @else
                            Nem
                          @endif
                      </td>
                      <td>{{$user->phone_number}}</td>
                      <td>{{$user->github}}</td>
                      <td>{{$user->created_at}}</td>
                      <td>
                      <div class="row" style="margin: 6px;">
                          <a style="display: inline-block;" class="btn btn-warning btn-circle btn-sm" href="/felhasznalok/{{$user->id}}/szerkeszt"><i class="fas fa-edit"></i></a>
                          <form style="display: inline-block;" action="/felhasznalok/{{$user->id}}" method="POST">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                          <button class="btn btn-danger btn-circle btn-sm" type="submit" @if($user->id == Auth::User()->id) {{"disabled"}} @endif><i class="fas fa-trash-alt"></i></button>
                          <br />
                          </div>
                          @if($user->accepted == 0)
                          <div class="dropdown" style="display: inline-block;">
                          <button  class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{$user->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Elfogadás módja
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{$user->id}}" >
                          @foreach(Groups::all() as $group)
                            <a class="dropdown-item" href="/activate-user/{{ $user->id }}/{{ $group->id }}">{{ $group->name }}</a>
                          @endforeach
                          </div>
                          @endif
                          
                        </div>
                        </form>
                        
                    </td>
                    </tr>
                        
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          @include("MainParts.footer")