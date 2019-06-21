@include("MainParts.header")

<h1 class="h3 mb-2 text-gray-800">Profil szerkesztése</h1>
<p class="mb-4">{!! Texts::GetText("myprofile_dropdown") !!}</p>

          <form class="user" method="post">
                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first('email') }}
                        {{ $errors->first('password') }}
                        {{ $errors->first('phone_number') }}
                        {{ $errors->first('emailExists') }}
                    </div>
                @endif
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                    {{ csrf_field() }}
                    {{ method_field("PUT") }}
                    <div class="form-group">
                      <input type="text" class="form-control" name="name" value="{{ $user->name }}" placeholder="Név">
                    </div>
                    <div class="form-group">
                      <input type="email" class="form-control" id="exampleInputEmail" name="email" aria-describedby="emailHelp" value="{{ $user->email }}" placeholder="Email">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" name="phone_number" value="{{ $user->phone_number }}" placeholder="Telefonszám">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" name="github" value="{{ $user->github }}" placeholder="GitHub felhasználónév">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" id="exampleInputPassword" name="password" placeholder="Új jelszó">
                    </div>
                    <input type="submit" class="btn btn-primary btn-user btn-block" value="Mentés">
                    </form>

          @include("MainParts.footer")