@extends('layouts/admin/app')

@section('custom_css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
<link rel="stylesheet" href="{{ asset('css/filterCSS.css') }}">
@endsection

@section('custom_script')

@endsection

@section('content')



<div class="card">
    <div class="backlink">
        <a href="/admin/events"><i class="fas fa-arrow-left"></i> {{__('events.show_overview')}}</a>
    </div>

    <div class="card-body">

        <div class="create-event">

            <h1>{{ $data['event']->id }}: {{ $data['event']->eventName }}</h1>


            <form action="/admin/events/{{$data['event']->id}}" method="POST">
                @method("PATCH")
                @csrf
                <h3>{{__('events.edit_header_info')}}</h3>
                <div class="description">
                    <h5>{{__('events.edit_info_title')}}</h5>
                    <input type="text" id="title" name="activityName"
                        placeholder="{{__('events.edit_placeholder_title')}}" oninput="update_counter_title(this)"
                        maxlength="30" required value="{{ $data['event']->eventName }}">
                    <span id="chars_title"></span> {{__('events.edit_characters_remaining')}}
                    @if ($errors->has('activityName'))
                    @foreach($errors->get('activityName') as $error)
                    <div class="error">{{$error}}</div>
                    @endforeach
                    @endif
                </div>
                <div class="description">
                    <h5>{{__('events.edit_info_description')}}</h5>
                    <textarea id="desc" name="description" placeholder="{{__('events.edit_placeholder_description')}}"
                        oninput="update_counter_desc(this)" maxlength="150"
                        required>{{ $data['event']->description }}</textarea>
                    <span id="chars_desc"></span> {{__('events.edit_characters_remaining')}}
                    @if ($errors->has('description'))
                    @foreach($errors->get('description') as $error)
                    <div class="error">{{$error}}</div>
                    @endforeach
                    @endif
                </div>
                <div class="description">
                    <h5>{{__('events.edit_info_highlighted')}}</h5>
                    <div class="custom-control custom-switch">
                        @if($data['event']->isHighlighted == 0)
                        <input type="checkbox" name="isHighlighted" class="custom-control-input" id="customSwitches">
                        @else
                        <input type="checkbox" name="isHighlighted" class="custom-control-input" id="customSwitches"
                            checked>
                        @endif
                        <label class="custom-control-label" for="customSwitches"></label>
                    </div>
                </div>
                <div class="date">
                    <div class="description">
                        <h5>{{__('events.edit_info_date')}}</h5>
                        <input id="date" name="startDate" type="date" value="{{ $data['event']->startDate }}" required>
                        <h5>{{__('events.edit_info_time')}}</h5>
                        <input id="date" name="startTime" type="time" value="{{ $data['event']->startTime }}" required>
                        @if ($errors->has('startDate'))
                        @foreach($errors->get('startDate') as $error)
                        <div class="error">{{$error}}</div>
                        @endforeach
                        @endif
                    </div>
                </div>

                <div>
                    <div class="description">
                        <h5>{{__('events.edit_info_amountofparticipants')}}</h5>
                        <input type="number" name="numberOfPeople" min="1" max="100"
                            value="{{ $data['event']->numberOfPeople }}">
                        <span class="number_desc">{{__('events.edit_info_amountofparticipants_desc')}}</span>
                        @if ($errors->has('numberOfPeople'))
                        @foreach($errors->get('numberOfPeople') as $error)
                        <div class="error">{{$error}}</div>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="type">
                    <h3>{{__('events.edit_header_category')}}</h3>
                    <div class="types">
                        <div class="box">
                            @foreach ($data['tags'] as $tag)
                            <input type="radio" id="{{$tag->tag}}" name="tag" value="{{$tag->id}}"
                                onclick="check({{$tag->id }})" @if($tag->id == $data["event"]->tag_id)
                            @php($selectedTag = $tag)
                            checked
                            @endif
                            >
                            <label for="{{$tag->tag}}" class="category" title="Uitje met gezinnen">
                                <?php echo '<img class="default" src="data:image/jpeg;base64,' . base64_encode($tag->imageDefault) . '"/>'; ?>
                                <?php echo '<img class="selected" src="data:image/jpeg;base64,' . base64_encode($tag->imageSelected) . '"/>'; ?>
                                <span>{{$tag->tag}}</span>
                            </label>
                            @endforeach
                        </div>
                        @if ($errors->has('tag'))
                        @foreach($errors->get('tag') as $error)
                        <div class="error">{{$error}}</div>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="pic">
                    <h3>{{__('events.edit_header_banner')}}</h3>
                    <div class="types">
                        <div id="box2" class="box">
                            @foreach($selectedTag->eventPictures()->get() as $picture)
                            <input type='radio' id='{{$picture->id}}' class='picture {{$picture->id}}' name='picture'
                                value='{{$picture->id}}' @if($picture->id == $data["event"]->event_picture_id)
                            checked
                            @endif
                            >
                            <label for='{{$picture->id}}' class='picture {{$picture->id}}' title='Uitje met gezinnen'>
                                <?php echo '<img class="default" src="data:image/jpeg;base64,' . base64_encode($picture->picture) . '"/>'; ?>
                            </label>
                            @endforeach
                        </div>
                        @if ($errors->has('picture'))
                        @foreach($errors->get('picture') as $error)
                        <div class="error">{{$error}}</div>
                        @endforeach
                        @endif
                    </div>
                </div>


                <div class="description">
                    <h3>{{__('events.edit_header_location')}}</h3>
                    <div class="description location">
                        <input type="hidden" name="lng" id="lng"
                            value="{{$data['event']->location()->first()->locLongtitude}}">
                        <input type="hidden" name="lat" id="lat"
                            value="{{$data['event']->location()->first()->locLatitude}}">
                        <input type="hidden" name="houseNumber" id="houseNumber"
                            value="{{$data['event']->location()->first()->houseNumber}}">
                        <input type="hidden" name="postalCode" id="postalCode"
                            value="{{$data['event']->location()->first()->postalcode}}">
                        <input type="hidden" name="locality" id="locality"
                            value="{{$data['event']->location()->first()->locality}}">
                        <input type="hidden" name="route" id="route"
                            value="{{$data['event']->location()->first()->route}}">

                        <input id="pac-input" name="location" class="controls" type="text" placeholder="Search Box"
                            required @if(old('location')==null)
                            value="{{ $data['event']->location()->first()->route }} {{ $data['event']->location()->first()->houseNumber }}, {{ $data['event']->location()->first()->locality }}"
                            @else value="{{old('location')}}" @endif>
                        <div id="map"></div>
                        @if ($errors->has('lat'))
                        <div class="error">{{__('events.create_error_location_required')}}</div>
                        @endif
                        @if ($errors->has('houseNumber'))
                        <div class="error">{{__('events.create_error_house_number')}}</div>
                        @endif
                        @if ($errors->has('postalCode'))
                        <div class="error">{{__('events.create_error_postalcode')}}</div>
                        @endif
                    </div>
                </div>

                <input class="submit" type="submit" name="verzenden" value="{{ __('events.edit_btn_update') }}">
            </form>
        </div>
    </div>
</div>
<script>
function check(tag) {
    fetch_customer_data(tag);
}

function fetch_customer_data(query) {
    $.ajax({
        url: "{{ route('events_controller.action')}}",
        method: 'POST',
        data: {
            query: query,
            _token: '{{ csrf_token() }}'
        },
        dataType: 'json',
        success: function(data) {
            console.log(data);
            if (data == "") {
                $('#box2').html("<h5><i>Kies eerst het type event</i></h5>");
            } else {
                $('#box2').html("");
                data.forEach(function(element) {
                    //TODO: add if statement if element tag equals tag in given event add "checked"
                    $('#box2').html($("#box2").html() + "<input type='radio' id='" +
                        element['id'] + "' class='picture " + element['tag_id'] +
                        "' name='picture' value='" + element['id'] + "'> <label for='" +
                        element['id'] + "' class='picture " + element['tag_id'] +
                        "' title='Uitje met gezinnen'> <img class='default' src='data:image/jpeg;base64," +
                        element['picture'] + "'/> </label>");
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            //console.log('jqXHR:');
            //console.log(jqXHR);
            //console.log('textStatus:');
            //console.log(textStatus);
            //console.log('errorThrown:');
            //console.log(errorThrown);
        }

    })
}
</script>
<script>
function update_counter_title(text) {
    var len = parseInt(text.getAttribute("maxlength"), 10);
    document.getElementById('chars_title').innerHTML = len - text.value.length;
}

function update_counter_desc(textarea) {
    var len = parseInt(textarea.getAttribute("maxlength"), 10);
    document.getElementById('chars_desc').innerHTML = len - textarea.value.length;
}
window.onload = function() {
    var len = $("#title").attr('maxLength');
    document.getElementById('chars_title').innerHTML = len - $("#title").val().length;

    var len = $("#desc").attr('maxLength');
    document.getElementById('chars_desc').innerHTML = len - $("#desc").val().length;
};

function initAutocomplete() {
    var Eventlat = <?php echo $data['event']->location()->first()->locLatitude ?>;
    var Eventlng = <?php echo $data['event']->location()->first()->locLongtitude ?>;
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {
            lat: Eventlat,
            lng: Eventlng
        },
        zoom: 13,
        mapTypeId: 'roadmap'
    });

    // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
    });
    var markers = [];
    var myLatlng = new google.maps.LatLng(Eventlat, Eventlng);

    var marker = new google.maps.Marker({
        position: myLatlng,
        title: "Hello World!"
    });

    marker.setMap(map);
    markers.push(marker);
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        // Clear out the old markers.
        markers.forEach(function(marker) {
            marker.setMap(null);
        });
        markers = [];

        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
            if (!place.geometry) {
                console.log("Returned place contains no geometry");
                return;
            }
            var icon = {
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
                map: map,
                icon: icon,
                title: place.name,
                position: place.geometry.location
            }));

            var myAddressNumber = "";
            var myPostalCode = "";
            var myRoute = "";
            var myLocality = "";
            for (i = 0; i < place.address_components.length; i++) {
                if (place.address_components[i].types == "street_number") {
                    myAddressNumber = place.address_components[i].long_name;
                } else if (place.address_components[i].types == "postal_code") {
                    myPostalCode = place.address_components[i].long_name;
                } else if (place.address_components[i].types[0] == "locality") {
                    myLocality = place.address_components[i].long_name;
                } else if (place.address_components[i].types == "route") {
                    myRoute = place.address_components[i].long_name;
                }
            }

            $('#lng').val(place.geometry.location.lng);
            $('#lat').val(place.geometry.location.lat);

            $('#houseNumber').val(myAddressNumber);
            $('#postalCode').val(myPostalCode);
            $('#route').val(myRoute);
            $('#locality').val(myLocality);

            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    });
}
</script>
<script
    src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_KEY')}}&libraries=places&callback=initAutocomplete"
    async defer></script>
@endsection