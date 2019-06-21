@include("MainParts.header")

<h1 class="h3 mb-2 text-gray-800">Eszközök</h1>
          <p class="mb-4">{!! Texts::GetText("items_desc") !!}</p>

                    <p><b>Név: </b><span class="text-primary">{{ $item->name }}</span></p>

                    <p><b>Leírás: </b><span class="text-primary">{{ $item->description }}</span></p>

                    <p><b>Youtube Link: </b><a class="text-primary" href="{{$item->youtube_link}}">{{ $item->youtube_link }}</a></p>

                    <p><b>Labor: </b><span class="text-primary">{{ Labs::find($item->lab_id)->name }}</span></p>

                    <p><b>Felügyelő: </b><span class="text-primary">{{$item->Supervisors()}}</span></p>

                    <p><b>Távoli elérés: </b>@if($item->remote_access)<i class="fas fa-check text-primary"></i> @else <i class="fas fa-times text-primary"></i> @endif</p>

                    <p><b>Ha lefoglalják, akkor ezek is elérhetetlenek lesznek:</b></p>
                    <ul>
                    @foreach(Items::all()->except($item->id) as $el)
                    @if($item->Unaccesible($el->id))
                    <li>{{$el->name}}</li>
                    @endif
                    @endforeach
                    </ul>

                    <hr />
                    <img src="{{$item->image}}">
                    <hr />


                    
          @include("MainParts.footer")