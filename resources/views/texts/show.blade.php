@include("MainParts.header")

    <h1 class="h3 mb-2 text-gray-800">Szövegek</h1>
          <p class="mb-4">{!! Texts::GetText("texts_desc") !!}</p>
                    <p><b>Név: </b><span class="text-primary">{{ $text->name }}</span></p>

                    <p><b>Azonosító név: </b><span class="text-primary">{{ $text->command_name }}</span></p>

                    <p><b>Létrehozva: </b><span class="text-primary">{{ $text->created_at }}</span></p>
                    <p><b>Szerkesztve: </b><span class="text-primary">{{ $text->updated_at }}</span></p>

                    <hr />

                    <div>
                        {!!$text->text!!}
                    </div>

@include("MainParts.footer")