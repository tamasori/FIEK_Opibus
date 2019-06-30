<div class="card m-2" id="item_selected-[[ID]]">
    <div class="card-header" id="headingOne-[[ID]]">
        <h5 class="mb-0"><button class="btn btn-link name" type="button" data-toggle="collapse"
                data-target="#collapseOne-[[ID]]">[[NAME]]</button></h5>
    </div>
    <div id="collapseOne-[[ID]]" class="collapse show" aria-labelledby="headingOne-[[ID]]">
        <div class="card-body ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <p class="desc">[[DESC]]</p>
                        <h5>Fajta:</h5>
                        <select class="form-control type_select" name="type_select[[[ID]]]">
                            <option value="1">Rövid időtartamra</option>
                            <option value="2">Több hetes időtartamra</option>
                        </select>
                        <hr />
                        <h5>Időpont:</h5>
                        <div class="form-group">
                            <div class="form-inline m-1">
                                <input type="text" class="form-control mr-2" name="from_date[[[ID]]]" placeholder="Ettől" id="from_date-[[ID]]" autocomplete="off"><span>-</span>
                                <div class="type1">
                                    <input type="text" class="form-control ml-2" name="to_date[[[ID]]]" placeholder="Eddig" id="to_date-[[ID]]" autocomplete="off">
                                </div>
                                <div class="type2" style="display:none;">
                                    <input type="number" class="form-control ml-2" name="weeks[[[ID]]]" min="1" placeholder="Hány héten át?" id="weeks-[[ID]]" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-inline m-1">
                                    <input type="text" class="form-control mr-2" name="from_time[[[ID]]]"  placeholder="Ettől" id="from_time-[[ID]]" autocomplete="off"><span>-</span>
                                    <input type="text" class="form-control ml-2" name="to_time[[[ID]]]" placeholder="Attól" id="to_time-[[ID]]" autocomplete="off">
                                </div>

                                <div class="type2 form-inline">

                                    <div class="custom-control custom-checkbox small m-2">
                                        <input type="checkbox" class="custom-control-input" name="weekday-1[[[ID]]]" id="weekday-1_[[ID]]" value="weekday-1">
                                        <label class="custom-control-label" for="weekday-1_[[ID]]">Hétfő</label>
                                    </div>

                                    <div class="custom-control custom-checkbox small m-2">
                                        <input type="checkbox" class="custom-control-input" name="weekday-2[[[ID]]]" id="weekday-2_[[ID]]" value="weekday-2" >
                                        <label class="custom-control-label" for="weekday-2_[[ID]]">Kedd</label>
                                    </div>

                                    <div class="custom-control custom-checkbox small m-2">
                                        <input type="checkbox" class="custom-control-input" name="weekday-3[[[ID]]]" id="weekday-3_[[ID]]" value="weekday-3" >
                                        <label class="custom-control-label" for="weekday-3_[[ID]]">Szerda</label>
                                    </div>

                                    <div class="custom-control custom-checkbox small m-2">
                                        <input type="checkbox" class="custom-control-input" name="weekday-4[[[ID]]]" id="weekday-4_[[ID]]" value="weekday-4" >
                                        <label class="custom-control-label" for="weekday-4_[[ID]]">Csütörtök</label>
                                    </div>

                                    <div class="custom-control custom-checkbox small m-2">
                                        <input type="checkbox" class="custom-control-input" name="weekday-5[[[ID]]]" id="weekday-5_[[ID]]" value="weekday-5" >
                                        <label class="custom-control-label" for="weekday-5_[[ID]]">Péntek</label>
                                    </div>

                                    <div class="custom-control custom-checkbox small m-2">
                                        <input type="checkbox" class="custom-control-input" name="weekday-6[[[ID]]]" id="weekday-6_[[ID]]" value="weekday-6">
                                        <label class="custom-control-label" for="weekday-6_[[ID]]">Szombat</label>
                                    </div>

                                    <div class="custom-control custom-checkbox small m-2">
                                        <input type="checkbox" class="custom-control-input" name="weekday-0[[[ID]]]" id="weekday-0_[[ID]]" value="weekday-0">
                                        <label class="custom-control-label" for="weekday-0_[[ID]]">Vasárnap</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-danger delete" type="button" onclick="deleteItemFromList(this)" parent-id="[[ID]]">Törlés</button>
                        <button class="btn btn-primary expand" type="button" onclick="expandData(this)" parent-id="[[ID]]">Kiterjesztés</button>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <iframe width="560" height="315" src="[[YOUTUBE]]" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <div class="errors text-danger"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>