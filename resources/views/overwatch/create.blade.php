@include("MainParts.header")

<h1 class="h3 mb-2 text-gray-800">Felügyelet jelenlét</h1>
          <p class="mb-4">{!! Texts::GetText("overwatch_desc") !!}</p>
          
          <form method="post" class="user">
                @if($errors->any())
                    <div class="alert alert-danger">
                            {{ $errors->first('from_date') }}
                            {{ $errors->first('to_date') }}
                    </div>
                @endif
                    {{ csrf_field() }}

                    <h5>Fajta:</h5>
                    <select class="form-control" name="type_select" id="type_select">
                        <option value="1" @if(old('type_select') == 1) {{"selected"}}@endif>Rövid időtartamra</option>
                        <option value="2" @if(old('type_select') == 3) {{"selected"}}@endif>Több hetes időtartamra</option>
                    </select>

                    <hr />
                    <h5>Időpont:</h5>
                    <div class="form-group">
                        <div class="form-inline m-1">
                            <input type="text" class="form-control mr-2" name="from_date" value="{{ old("from_date") }}" placeholder="Ettől" id="from_date" autocomplete="off">
                            <span>-</span>
                            <div class="type1">
                                <input type="text" class="form-control ml-2" name="to_date" value="{{ old("to_date") }}" placeholder="Eddig" id="to_date" autocomplete="off">
                            </div>
                            <div class="type2" style="display:none;">
                                <input type="number" class="form-control ml-2" name="weeks" min="1" value="{{old("weeks")}}" placeholder="Hány héten át?" id="weeks" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-inline m-1">
                            <input type="text" class="form-control mr-2" name="from_time" value="{{ old("from_time") }}" placeholder="Ettől" id="from_time" autocomplete="off">
                            <span>-</span>
                            <input type="text" class="form-control ml-2" name="to_time" value="{{ old("to_time") }}" placeholder="Attól" id="to_time" autocomplete="off">
                        </div>
                    </div>

                    <div class="type2 form-inline">
                            <div class="custom-control custom-checkbox small m-2">
                                <input type="checkbox" class="custom-control-input" name="weekday-1" id="weekday-1" value="weekday-1" {{old("weekday-1") === null ? "": "checked"}}>
                                <label class="custom-control-label" for="weekday-1">Hétfő</label>
                            </div>

                            <div class="custom-control custom-checkbox small m-2">
                                <input type="checkbox" class="custom-control-input" name="weekday-2" id="weekday-2" value="weekday-2" {{old("weekday-2") === null ? "": "checked"}}>
                                <label class="custom-control-label" for="weekday-2">Kedd</label>
                            </div>
                            
                            <div class="custom-control custom-checkbox small m-2">
                                    <input type="checkbox" class="custom-control-input" name="weekday-3"id="weekday-3" value="weekday-3" {{old("weekday-3") === null ? "": "checked"}}>
                                    <label class="custom-control-label" for="weekday-3">Szerda</label>
                                </div>
                                
                            <div class="custom-control custom-checkbox small m-2">
                                <input type="checkbox" class="custom-control-input" name="weekday-4" id="weekday-4" value="weekday-4" {{old("weekday-4") === null ? "": "checked"}}>
                                <label class="custom-control-label" for="weekday-4">Csütörtök</label>
                            </div>
                                
                            <div class="custom-control custom-checkbox small m-2">
                                <input type="checkbox" class="custom-control-input" name="weekday-5"id="weekday-5" value="weekday-5" {{old("weekday-5") === null ? "": "checked"}}>
                                <label class="custom-control-label" for="weekday-5">Péntek</label>
                            </div>
                            
                            <div class="custom-control custom-checkbox small m-2">
                                <input type="checkbox" class="custom-control-input" name="weekday-6" id="weekday-6" value="weekday-6" {{old("weekday-6") === null ? "": "checked"}}>
                                <label class="custom-control-label" for="weekday-6">Szombat</label>
                            </div>

                            <div class="custom-control custom-checkbox small m-2">
                                <input type="checkbox" class="custom-control-input" name="weekday-0" id="weekday-0" value="weekday-0" {{old("weekday-0") === null ? "": "checked"}}>
                                <label class="custom-control-label" for="weekday-0">Vasárnap</label>
                            </div>
                        </div>
                </div>

                     <hr />

                    <h5>Laboratórium:</h5>
                    <select class="form-control" name="lab_select">
                        @foreach(Labs::all() as $lab)
                        <option value="{{$lab->id}}" @if(old("lab_id") == $lab->id){{"selected"}}@endif>{{$lab->name}}</option>
                        @endforeach
                    </select>

                    <hr />

                    <input type="submit" class="btn btn-primary btn-user btn-block" value="Hozzáadás">
                    </form>

                    @section('scripts')
                    <script>
                        $.datepicker.regional[ "hu" ];
                        $.datetimepicker.setDateFormatter('moment');
                        
                        $("#from_date, #to_date").datepicker({minDate:0});
                        $("#from_time").datetimepicker({
                            datepicker:false, 
                            format:"HH:mm", 
                            step: 15,
                            onSelectTime: function(ct, i){
                                $("#to_time").datetimepicker({datepicker:false, format:"HH:mm", step: 15, minTime: i.val()});

                            }
                        });

                        $("#to_time").datetimepicker({datepicker:false, format:"HH:mm", step: 15});

                        $("#from_date").on("change", function(){
                            $("#to_date").datepicker('option', 'minDate', $("#from_date").datepicker("getDate"));
                        });

                     

                        $(document).ready(function(){
                            switch_view();
                        });

                        $("#type_select").on("change", function(){
                            switch_view();
                        });

                        function switch_view(){
                            if($("#type_select").val()==2){
                                    $(".type1").hide();
                                    $(".type2").show();
                                }
                            else{
                                $(".type1").show();
                                $(".type2").hide();
                            }
                        }
                    </script>
                    @stop
                   

          @include("MainParts.footer")