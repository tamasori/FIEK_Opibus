@include("MainParts.header")
@if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first('from_date.*') }}
                        {{ $errors->first('type_select.*') }}
                        {{ $errors->first('from_time.*') }}
                        {{ $errors->first('to_time.*') }}
                        {{ $errors->first('weeks.*') }}
                        {{ $errors->first('to_date.*') }}
                        {{ $errors->first('reserve_error') }}

                    </div>
                @endif
                @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
<h1 class="h3 mb-2 text-gray-800">Foglalás</h1>
          <p class="mb-4">{!! Texts::GetText("reservation_desc") !!}</p>
        <div class="row">
            <div class="col-md-3">
                
                <div class="form-group">
                    <input type="text" id="search-items" class="form-control" name="search" placeholder="Keresés...">
                  </div>

            </div>
            <div class="col-md-9">

                <select class="form-control" id="item_select">
        

                    @foreach($items as $item)
                        <option value="{{$item->id}}" search-name="{{$item->name}}" search-description="{{$item->description}}">{{$item->name}}</option>
                    @endforeach
        

                </select>

            </div>
        </div>
        

        <button class="btn btn-primary my-2" id="add_item_to_list">Hozzáadás</button>


          <form method="post" class="user my-2" id="item_list"> 

                    {{ csrf_field() }}

                    


                     <hr />

                    

                    <input type="submit" class="btn btn-primary btn-user btn-block" value="Foglalás">
                    <input type="button" class="btn btn-success btn-user btn-block" id="check_button" value="Ellenőrzés">
                    </form>

                    @section('scripts')
                    <script>
                        var template= '{!! $template !!}';

                        $("#item_select").on("change", function(){
                            if($("#item_select").val() == null || $("#item_select").val() == 0){
                                $("#add_item_to_list").prop('disabled', true);
                            }
                            else{
                                $("#add_item_to_list").prop('disabled', false);
                            }
                        });
                     

                        $(document).ready(function(){
                            switch_view();
                            
                            $(".type_select").on("change", function(event){
                                
                                switch_view(event.target);
                            });
                        });


                        function switch_view(el){
                            if($(el).parent().find(".type_select").val()==2){
                                $(el).parent().find(".type1").hide();
                                $(el).parent().find(".type2").show();
                            }
                            else{
                                $(el).parent().find(".type1").show();
                                $(el).parent().find(".type2").hide();
                            }
                        }

                        $("#search-items").on('change keydown', function(){
                            var term = $("#search-items").val();
                            var items = $("#item_select").children().not(".selected-item");  
                            for (var i = 0; i < items.length; i++) {
                                if(!items[i].getAttribute("search-name").toUpperCase().includes(term.toUpperCase()) && !items[i].getAttribute("search-description").toUpperCase().includes(term.toUpperCase())){
                                    $(items[i]).hide();
                                }
                                else{
                                    $(items[i]).show();
                                }
                            }
                            //$("#item_select").val(0);
                            $("#item_select").val($("#item_select").children(":visible").first().val());
                        });

                        $("#add_item_to_list").on("click", function(){
                            var selected = $("#item_select").val();
                            $("#item_select option[value='"+selected+"']").hide();
                            $("#item_select option[value='"+selected+"']").addClass("selected-item");
                            $("#item_select").val(0);
                            $("#item_select").trigger("change");
                            
                            $.getJSON('/get/item/' + selected , function(data) {
                                console.log(data);
                                $('#item_list').prepend(template.split("[[ID]]").join(data[0].id).split("[[NAME]]").join(data[0].name).split("[[DESC]]").join(data[0].description).split("[[YOUTUBE]]").join(data[0].youtube_link));
                                
                                $(".type_select").on("change", function(event){
                                    switch_view(event.target);
                                });

                                var new_item = $("#item_selected-"+data[0].id);
                                switch_view(new_item.find(".type_select"));

                                $.datepicker.regional[ "hu" ];
                                $.datetimepicker.setDateFormatter('moment');
                                
                                new_item.find("#from_date-"+selected+", #to_date-"+selected).datepicker({minDate:0});
                                new_item.find("#from_time-"+selected).datetimepicker({
                                    datepicker:false, 
                                    format:"HH:mm", 
                                    step: 15,
                                    onSelectTime: function(ct, i){
                                        new_item.find("#to_time-"+selected).datetimepicker({datepicker:false, format:"HH:mm", step: 15, minTime: i.val()});

                                    }
                                });

                                new_item.find("#to_time-"+selected).datetimepicker({datepicker:false, format:"HH:mm", step: 15});

                                new_item.find("#from_date-"+selected).on("change", function(){
                                    new_item.find("#to_date-"+selected).datepicker('option', 'minDate',  new_item.find("#from_date-"+selected).datepicker("getDate"));
                                }); 
                            });

                         
                            
                        });

                        function deleteItemFromList(elm){
                            var selected = elm.getAttribute("parent-id");
                                console.log(selected);
                                $("#item_select option[value='"+selected+"']").show();
                                $("#item_select option[value='"+selected+"']").removeClass("selected-item");
                                $("#item_selected-"+ selected).remove();
                        }

                        function expandData(elm){
                            var selected = elm.getAttribute("parent-id");
                            $('select[name^="type_select"]').each(function() {
                                $(this).val( $('select[name="type_select['+ selected +']"]').val() );
                                switch_view($(this));
                            });
                            $('input[name^="from_date"]').each(function() {
                                $(this).val( $('input[name="from_date['+ selected +']"]').val() );
                            });
                            $('input[name^="to_date"]').each(function() {
                                $(this).val( $('input[name="to_date['+ selected +']"]').val() );
                            });
                            $('input[name^="from_time"]').each(function() {
                                $(this).val( $('input[name="from_time['+ selected +']"]').val() );
                            });
                            $('input[name^="to_time"]').each(function() {
                                $(this).val( $('input[name="to_time['+ selected +']"]').val() );
                            });
                            $('input[name^="weeks"]').each(function() {
                                $(this).val( $('input[name="weeks['+ selected +']"]').val() );
                            });
                            for (var index = 0; index < 7; index++) {
                                
                                if ($('input[name="weekday-'+index+'['+selected+']"]').is(':checked')) {
                                    
                                    $('input[name^="weekday-'+index+'"]').each(function() {
                                        $(this).prop('checked', true);
                                    });
                                }
                                else{
                                    $('input[name^="weekday-'+index+'"]').each(function() {
                                        $(this).prop('checked', false);
                                    });
                                }
                            }
                            
                        }

                        $("#check_button").on("click", function(){
                             $.post("/get/check", $("#item_list").serialize(), function(data) {
                                 console.log(data);
                                 
                                 $.each(data, function(key, val){
                                     var err = "";
                                     console.log(val);
                                     if(val.length == 0) {
                                         err += "<span class='text-success'>Minden dátum foglalható.</span>";
                                     }
                                     else{
                                        $.each(val, function(k, v){
                                            err += v+"<br>";
                                        });
                                     }
                                    $("#item_selected-"+key).find(".errors").html(err);                                        
                                 });
                            });
                        });
                    </script>
                    @stop
                   

          @include("MainParts.footer")