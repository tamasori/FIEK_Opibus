@include("MainParts.header")

    <img src="{{ $news->lead_picture }}" class="img-responsive img" style="max-width: 500px; max-height: 500px;">
    <h1 class="h3 mb-2 text-gray-800">{{$news->title}}</h1>
    <hr />
          <p class="mb-4">{{ App\User::find($news->user_id)->name }} • {{ $news->created_at }}</p>
    <hr />

                    <p>
                        {!!$news->excerpt!!}
                    </p>

                    <div>
                        {!!$news->article!!}
                    </div>

@include("MainParts.footer")