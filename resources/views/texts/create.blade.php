@include("MainParts.header")

<h1 class="h3 mb-2 text-gray-800">Szövegek</h1>
          <p class="mb-4">{!! Texts::GetText("texts_desc") !!}</p>
          
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

                    <div class="form-group">
                        <input type="text" class="form-control" name="command_name" value="{{ old("command_name") }}" placeholder="Azonosító név">
                    </div>

                    <hr />

                    <textarea name="text">{{old("text")}}</textarea>

                    <input type="submit" class="btn btn-primary btn-user btn-block" value="Hozzáadás">
                    </form>

                    @section('scripts')
                    <script>
                        var editor = CKEDITOR.replace( 'text' );
                        CKFinder.setupCKEditor( editor );
                    </script>
                     @stop

          @include("MainParts.footer")