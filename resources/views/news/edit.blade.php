@include("MainParts.header")

<h1 class="h3 mb-2 text-gray-800">Hírek</h1>
          <p class="mb-4">{!! Texts::GetText("news_desc") !!}</p>
          
          <form method="post" class="user">
                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first('title') }}
                        {{ $errors->first('excerpt') }}
                        {{ $errors->first('text') }}
                        {{ $errors->first('lead_image') }}
                        {{ $errors->first('publish_on') }}
                     
                    </div>
                @endif
                {{ method_field('PUT') }}
                            {{ csrf_field() }}
                    <div class="form-group">
                      <input type="text" class="form-control" name="title" value="{{ $news->title }}" placeholder="Cím">
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="excerpt" value="{{ $news->excerpt }}" placeholder="Kivonat">
                    </div>

                    <div class="form-group">
                        <input type="hidden" class="form-control" name="lead_image" id="file_image_url" value="{{ $news->lead_picture }}">
                        <img id="kep" src="{{ $news->lead_picture }}" style="max-width: 500px; max-height: 500px;">
                        <button id="lead_image" type="button" class="btn btn-primary">Kép hozzáadás</button>
                    </div>

                    <hr />

                    <textarea name="text">{{ $news->article }}</textarea>

                    <hr />

                    <div class="form-group">
                        <input type="text" class="form-control" name="publish_on" value="{{ $news->publish_on }}" placeholder="Közzététel dátuma" id="publish_on">
                    </div>

                    <div class="form-group">
                    <label>Státusz</label>
                        <select name="status"  class="form-control" >
                            <option value="published" @if( $news->status == "published") {{ 'selected' }} @endif >Közzétéve</option>
                            <option value="draft" @if( $news->status == "draft") {{ 'selected' }} @endif>Piszkozat</option>
                        </select>
                    </div>

                    <input type="submit" class="btn btn-primary btn-user btn-block" value="Mentés">
                    </form>

                    @section('scripts')
                    <script>
                        var editor = CKEDITOR.replace( 'text' );
                        CKFinder.setupCKEditor( editor );
                        $.datepicker.regional[ "hu" ];
                        $.datetimepicker.setDateFormatter('moment');
                        $("#publish_on").datetimepicker();

                        var button_file = document.getElementById('lead_image');

                        button_file.addEventListener("click",function(){

                        selectFileWithCKFinder('file_image_url');

                        });


                        function selectFileWithCKFinder(elementId){
                            CKFinder.modal({
                                chooseFiles: true,
                                width: 800,
                                height: 600,
                                onInit: function(finder){
                                    finder.on('files:choose', function(evt){
                                        var file = evt.data.files.first();
                                        var output = document.getElementById(elementId);
                                        output.value = file.getUrl();
                                        document.getElementById("kep").src = output.value;
                                    });
                                    finder.on('file:choose:resizedImage', function(evt){
                                        var output = document.getElementById(elementId);
                                        
                                        output.value = evt.data.resizedUrl;
                                        document.getElementById("kep").src = output.value;
                                    });
                                }
                            });
                        }

                    </script>
                     @stop

          @include("MainParts.footer")