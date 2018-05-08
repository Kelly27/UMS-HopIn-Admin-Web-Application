<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARzgseB8wPPpiP65N9rzPqFwcdA4WuugY&callback=initMap"></script>
<script type="text/javascript" src="{{asset('js/Sortable.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/tinymce/js/tinymce/tinymce.min.js')}}"></script>
<script type="text/javascript">
    tinymce.init({
        selector: '#desc_field',
        plugins : 'advlist autolink link image lists charmap print preview',
        skin: 'lightgray'
    });

</script>
<script type="text/javascript" src="{{asset('js/jscolor.min.js')}}"></script>
<script>
    var map;
    var directionsService;
    var directionsDisplay;
    var selectedRoute = [];
    var allMarkers = [];
    var pathArchive; //save path retrieve from google direction service
    var pathArr = [];
    var plineArray = [];
    var directionDataArr = [] // to save the whole direction data
    var routeDom = document.getElementById('setRouteArr');

    function initMap() {
        directionsService = new google.maps.DirectionsService();
        directionsDisplay = new google.maps.DirectionsRenderer();
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: {lat: 6.0333, lng: 116.1229},
            disableDefaultUI: true
        });

        directionsDisplay.setMap(map);
    }

    function resetRoute(){
        removePolylines();
        setMapOnAll(null);
        removeAllMarkers();
    }

    var el = document.getElementById('stop-item');
    var sortable = Sortable.create(el,{
        group: {name: "sorting", put: true, pull: true},
        sort: false,
        animation: 100,
        scroll: true, // or HTMLElement
        scrollSensitivity: 30, // px, how near the mouse must be to an edge to start scrolling.
        scrollSpeed: 10,
    });
    var el2 = document.getElementById('stop-item2');
    var onSort = Sortable.create(el2,{
        group: {name: "sorting", put: true, pull: true},
        sort: true,
        animation: 100,
        onSort: function(evt){
            selectedRoute = []; //init selected route array to empty
            allMarkers = [];
            plineArray = [];
            pathArr = [];
            updateList();
            showRoute();
        },
        onRemove: function(){
            removePolylines();
            updateList();
            showRoute();
            removeAllMarkers();
        }
    });

    function updateList(){
        let DOMarray = [];
        var stop = @php echo $bus_stops_map; @endphp;

        for(var i = 1; i < el2.childNodes.length; i++){
            DOMarray.push(el2.childNodes[i].textContent);
        }

        for(var j = 0; j < DOMarray.length; j++){
            for(var k = 0; k < stop.length; k++){
                if(DOMarray[j] == stop[k].name){
                    selectedRoute.push(stop[k]);
                }
            }

        };
        console.log('selectedRoute', selectedRoute);
        showRoute();
    }

    function showRoute(){
        if(selectedRoute.length >= 2){
            for(var i = 0; i < selectedRoute.length - 1; i++){
                //making request to Google Javascript API to get the polyline path
                var request = {
                    origin: selectedRoute[i].location,
                    destination: selectedRoute[i+1].location, //change here
                    travelMode: 'DRIVING'
                };
                directionsService.route(request, function(result, status) {
                    if (status == 'OK') {
                        addPath(google.maps.geometry.encoding.decodePath(result.routes[0].overview_polyline));
                        // this.pathArchive = google.maps.geometry.encoding.decodePath(result.routes[0].overview_polyline);
                    }
                });
            };
        };

        for(var j = 0; j < selectedRoute.length; j++){
            var m = new google.maps.Marker({
                position: selectedRoute[j].location,
                title: selectedRoute[j].name,
                map: map,
            });
            allMarkers.push(m);
        };
        this.setSelectedRoute(selectedRoute, plineArray);
    };

    function addPath(path){
        // pathArchive = path;
        pathArr.push(path);
        //path.push(path);
        createPolylines(pathArr);
        console.log('path',path);
        console.log('pathArr', pathArr);
        saveDirectionData(pathArr);
    };

    function createPolylines(pathArray){
        // console.log('patharray',pathArray);
        for(var i = 0; i < pathArray.length; i++){
            // console.log('pa', pathArray[i]);
            let pline = new google.maps.Polyline({
                path: pathArray[i],
                stokeColor: "#ff0000",
                strokeOpacity: 1.0,
                strokeWeight: 3
            });

            plineArray.push(pline);
            pline.setMap(map);
        };

    }

    function removePolylines(){
        for(var i = 0; i < plineArray.length; i++){
            plineArray[i].setMap(null);
        }
        selectedRoute = [];
        pathArr = [];
        plineArray = [];
    }

    function setMapOnAll(map) {
        for (var i = 0; i < allMarkers.length; i++) {
            allMarkers[i].setMap(map);
        }
    };

    function removeAllMarkers(){
        allMarkers = [];
        setMapOnAll(null);
    }

    //saves the data from google map direction
    function saveDirectionData(){
        // directionDataArr.push(data);
        let pathDom = document.getElementById('setPathArr');
        pathDom.value = JSON.stringify(pathArr);
        console.log(pathDom.value);
    }

        //save selected route data to database
    function setSelectedRoute(data, plineArray){
        let routeDom = document.getElementById('setRouteArr');
        routeDom.value = JSON.stringify(data);
    }
</script>