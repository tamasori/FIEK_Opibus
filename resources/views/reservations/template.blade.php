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
                                <input type="text" class="form-control mr-2" name="from_date[[[ID]]]" placeholder="Ettől" id="from_date" autocomplete="off"><span>-</span>
                                <div class="type1">
                                    <input type="text" class="form-control ml-2" name="to_date[[[ID]]]" placeholder="Eddig" id="to_date" autocomplete="off">
                                </div>
                                <div class="type2" style="display:none;">
                                    <input type="number" class="form-control ml-2" name="weeks[[[ID]]]" min="1" placeholder="Hány héten át?" id="weeks" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-inline m-1">
                                    <input type="text" class="form-control mr-2" name="from_time[[[ID]]]"  placeholder="Ettől" id="from_time" autocomplete="off"><span>-</span>
                                    <input type="text" class="form-control ml-2" name="to_time[[[ID]]]" placeholder="Attól" id="to_time" autocomplete="off">
                                </div>

                                <div class="type2 form-inline">

                                    <div class="custom-control custom-checkbox small m-2">
                                        <input type="checkbox" class="custom-control-input" name="weekday-1[[[ID]]]" id="weekday-1" value="weekday-1">
                                        <label class="custom-control-label" for="weekday-1">Hétfő</label>
                                    </div>

                                    <div class="custom-control custom-checkbox small m-2">
                                        <input type="checkbox" class="custom-control-input" name="weekday-2[[[ID]]]" id="weekday-2" value="weekday-2" >
                                        <label class="custom-control-label" for="weekday-2">Kedd</label>
                                    </div>

                                    <div class="custom-control custom-checkbox small m-2">
                                        <input type="checkbox" class="custom-control-input" name="weekday-3[[[ID]]]" id="weekday-3" value="weekday-3" >
                                        <label class="custom-control-label" for="weekday-3">Szerda</label>
                                    </div>

                                    <div class="custom-control custom-checkbox small m-2">
                                        <input type="checkbox" class="custom-control-input" name="weekday-4[[[ID]]]" id="weekday-4" value="weekday-4" >
                                        <label class="custom-control-label" for="weekday-4">Csütörtök</label>
                                    </div>

                                    <div class="custom-control custom-checkbox small m-2">
                                        <input type="checkbox" class="custom-control-input" name="weekday-5[[[ID]]]" id="weekday-5" value="weekday-5" >
                                        <label class="custom-control-label" for="weekday-5">Péntek</label>
                                    </div>

                                    <div class="custom-control custom-checkbox small m-2">
                                        <input type="checkbox" class="custom-control-input" name="weekday-6[[[ID]]]" id="weekday-6" value="weekday-6">
                                        <label class="custom-control-label" for="weekday-6">Szombat</label>
                                    </div>

                                    <div class="custom-control custom-checkbox small m-2">
                                        <input type="checkbox" class="custom-control-input" name="weekday-0[[[ID]]]" id="weekday-0" value="weekday-0">
                                        <label class="custom-control-label" for="weekday-0">Vasárnap</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-danger delete" type="button" onclick="deleteItemFromList(this)" parent-id="[[ID]]">Törlés</button>
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