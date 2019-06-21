@include("MainParts.header")

<h1 class="h3 mb-2 text-gray-800">Laborok</h1>
<p class="mb-4">{!! Texts::GetText("labs_desc") !!}</p>

<form action="/laborok/uj" class="user" method="post">
                    <p>
                        {{ $errors->first('name') }}
                        {{ $errors->first('short_name') }}
                        {{ $errors->first('place') }}
                    </p>
                    {{ csrf_field() }}
                    <div class="form-group">
                      <input type="text" class="form-control" name="name" value="{{ old("name") }}" placeholder="Név">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" id="short_name" name="short_name" value="{{ old("short_name") }}" placeholder="Azonosító">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" name="place" value="{{ old("place") }}" placeholder="Elhelyezkedés">
                    </div>
                    
                    <input type="submit" class="btn btn-primary btn-user btn-block" value="Létrehozás">
                    </form>

                    
          @include("MainParts.footer")