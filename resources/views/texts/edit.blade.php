@include("MainParts.header")

<h1 class="h3 mb-2 text-gray-800">Szövegek</h1>
          <p class="mb-4">{!! Texts::GetText("texts_desc") !!}</p>
          
          <form method="post" class="user">
                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first('name') }}
                        {{ $errors->first('text') }}
                        {{ $errors->first('command_name') }}
                    </div>
                @endif
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-group">
                      <input type="text" class="form-control" name="name" value="{{ old("name", $text->name) }}" placeholder="Név">
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="command_name" value="{{ old("command_name", $text->command_name) }}" placeholder="Azonosító név">
                    </div>

                    <hr />

                    <textarea name="text">{{old("text", $text->text)}}</textarea>

                    <input type="submit" class="btn btn-primary btn-user btn-block" value="Mentés">
                    </form>

                    @section('scripts')
                    <script>
                        var editor = CKEDITOR.replace( 'text' );
                        CKFinder.setupCKEditor( editor );
                    </script>
                     @stop

          @include("MainParts.footer")