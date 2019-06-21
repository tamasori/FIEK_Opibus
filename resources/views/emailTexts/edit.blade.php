@include("MainParts.header")

<h1 class="h3 mb-2 text-gray-800">Szövegek</h1>
          <p class="mb-4">{!! Texts::GetText("emailtext_desc") !!}</p>
          
          <form method="post" class="user">
               
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <h2>{{$current->name}}</h2>
                    <p>{!! $current->description !!}</p>

                    <hr />

                    <textarea name="text">{!! $current->message !!}</textarea>

                    <input type="submit" class="btn btn-primary btn-user btn-block" value="Mentés">
                    </form>

                    @section('scripts')
                    <script>
                        var editor = CKEDITOR.replace( 'text' );
                        CKFinder.setupCKEditor( editor );
                    </script>
                     @stop

          @include("MainParts.footer")