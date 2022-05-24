var mapEngine = new BravoMapEngine('map',{
    fitBounds:true,
    center: bravo_map_data.center,
    zoom:9,
    disableScripts:true,
    ready: function (engineMap) {
        if(bravo_map_data.markers){
            engineMap.addMarker3(bravo_map_data.markers);
        }
    }
});
