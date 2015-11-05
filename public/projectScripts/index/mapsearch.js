
var baseUrl = $('#baseUrl').val();
var locations = [];
var latlongArr = [];
$.each(searchResultJsonArr, function(id,value) {
    locations.push([value.project_title,value.latitude,value.longitude,value.project_id]);
    latlongArr.push(value.latitude);
    latlongArr.push(value.longitude);
});

var myCenter=new google.maps.LatLng(Math.min.apply(Math,latlongArr),Math.max.apply(Math,latlongArr));
var markers = [];
var map;
function initialize()
{
    //apply location marker to centre on
    var mapProp = {
      center:myCenter,
      zoom:12,
      disableDefaultUI: true,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

//    var marker=new google.maps.Marker({
//    position:myCenter,
//    title: 'My centre location marker'
//    });

    //marker.setMap(map);

    var image = baseUrl+'/public/images/icon-loc.png';
    // apply other location markers
    for (i = 0; i < locations.length; i++) {
        marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                title: locations[i][0],
                    icon: image
        });
        markers.push(marker);
        var contentString = '<div id="content" class="cursor" onclick="projectInfo('+locations[i][3]+')">'+
        '<div >'+
        '</div>'+
        '<h5 >'+locations[i][0]+'</h5>'+
        '</div>';
        projectInfoWindow(marker, contentString,locations[i][3]);
    }
}
    function projectInfoWindow(marker, content, project_id) {
        var infowindow = new google.maps.InfoWindow({
            content: content
        });
        marker.addListener('mouseover', function() {
            infowindow.open(marker.get('map'), marker);
        });
        marker.addListener('mouseout', function() {
            infowindow.close();
        });
        marker.addListener('click', function() {
            infowindow.open(map, marker);
            return projectInfo(project_id);
        });
    }
    function scrollToMarker(index) {
        map.panTo(markers[index].getPosition());
    }
    var lasIndex='';
    function mouseOverProject(index){
        if(lasIndex!='') google.maps.event.trigger(markers[lasIndex], 'mouseout');
        google.maps.event.trigger(markers[index], 'mouseover');
        lasIndex = index;
    }
    function clickProject(index){
        if(lasIndex!='') google.maps.event.trigger(markers[lasIndex], 'mouseout');
        google.maps.event.trigger(markers[index], 'click');
        scrollToMarker(index);
        lasIndex = index;
        
    }
    function gridListView(viewType){
        SITEROOT = baseUrl;
        var PossessionFilters = $('#PossessionFilters').val();
        var PropertyTypeFilters = $('#PropertyTypeFilters').val();
        var BudgetFilters = $('#BudgetFilters').val();
        var BedroomFilters = $('#BedroomFilters').val();
        $.post(SITEROOT + '/front-end/index/changesearchview', {viewType: viewType,PossessionFilters: PossessionFilters,PropertyTypeFilters: PropertyTypeFilters,BudgetFilters: BudgetFilters,BedroomFilters: BedroomFilters}, function (response) {
             redirectUrl(2);       
        });
    }
    function closePrjDiv(){
        $('#googleMap').removeClass('col-md-6 col-md-offset-3').addClass('col-md-9');
        $('#prjDetailDiv').hide();
    }
function projectInfo(project_id){
    var htmlStr = '';
    htmlStr += '<div class="col-md-11 map-proj-detail-left"><div class="clearfix margin_top2"></div><div class="col-md-12 map-proj-detail-main text-center"><img height=100 width=100 style="margin-right:20px; margin-top: 50%;" src="'+baseUrl+'/public/images/ajax-loader-2.gif"></div><div class="clearfix margin_top2"></div></div><a href="#"><div class="col-md-1 map-close-button-right text-center"><strong>x</strong></div></a>';
    
    $('#googleMap').removeClass('col-md-9').addClass('col-md-6 col-md-offset-3');
    $('#prjDetailDiv').html(htmlStr).show();

    $.post(baseUrl + '/front-end/index/getprojectinfo', {project_id: project_id}, function (response) {
        htmlStr = '';
        htmlStr += '<div class="col-md-11 map-proj-detail-left"><div class="clearfix margin_top2"></div><div class="row"><h3 class="margin_bottom2" style="padding-left: 20px;">'+response.projectDetail.project_title+'</h3></div><div class="col-md-12 map-proj-detail-main"><div id="carousel-example-generic" class="carousel slide" data-ride="carousel"><ol class="carousel-indicators">';
        
 
    htmlStr += '<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>';
    htmlStr += '<li data-target="#carousel-example-generic" data-slide-to="1"></li>';
    htmlStr += '<li data-target="#carousel-example-generic" data-slide-to="2"></li>';
    htmlStr += '<li data-target="#carousel-example-generic" data-slide-to="3"></li>';
    htmlStr += '<li data-target="#carousel-example-generic" data-slide-to="4"></li>';
    if(response.projectDetail.slide_image_6!='')
    htmlStr += '<li data-target="#carousel-example-generic" data-slide-to="5"></li>';
    if(response.projectDetail.slide_image_7!='')
    htmlStr += '<li data-target="#carousel-example-generic" data-slide-to="6"></li>';
    if(response.projectDetail.slide_image_8!='')
    htmlStr += '<li data-target="#carousel-example-generic" data-slide-to="7"></li>';
    if(response.projectDetail.slide_image_9!='')
    htmlStr += '<li data-target="#carousel-example-generic" data-slide-to="8"></li>';
    if(response.projectDetail.slide_image_10!='')
    htmlStr += '<li data-target="#carousel-example-generic" data-slide-to="9"></li>';
    
    htmlStr += '</ol><div class="carousel-inner" role="listbox">';
    
    htmlStr += '<div class="item active"><img src="'+baseUrl+'/public/uploadfiles/'+response.projectDetail.slide_image_1+'"></div>';
    
    htmlStr += '<div class="item"><img src="'+baseUrl+'/public/uploadfiles/'+response.projectDetail.slide_image_2+'"></div>';
    
    htmlStr += '<div class="item"><img src="'+baseUrl+'/public/uploadfiles/'+response.projectDetail.slide_image_3+'"></div>';
    
    htmlStr += '<div class="item"><img src="'+baseUrl+'/public/uploadfiles/'+response.projectDetail.slide_image_4+'"></div>';
    
    htmlStr += '<div class="item"><img src="'+baseUrl+'/public/uploadfiles/'+response.projectDetail.slide_image_5+'"></div>';
    
    if(response.projectDetail.slide_image_6!='')
        htmlStr += '<div class="item"><img src="'+baseUrl+'/public/uploadfiles/'+response.projectDetail.slide_image_6+'"></div>';
    
    if(response.projectDetail.slide_image_7!='')
        htmlStr += '<div class="item"><img src="'+baseUrl+'/public/uploadfiles/'+response.projectDetail.slide_image_7+'"></div>';
    
    if(response.projectDetail.slide_image_8!='')
        htmlStr += '<div class="item"><img src="'+baseUrl+'/public/uploadfiles/'+response.projectDetail.slide_image_8+'"></div>';
    
    if(response.projectDetail.slide_image_9!='')
        htmlStr += '<div class="item"><img src="'+baseUrl+'/public/uploadfiles/'+response.projectDetail.slide_image_9+'"></div>';
    
    if(response.projectDetail.slide_image_10!='')
        htmlStr += '<div class="item"><img src="'+baseUrl+'/public/uploadfiles/'+response.projectDetail.slide_image_10+'"></div>';
    var bhkArray = new Array();
    if(response.projectDetail.has_1BHK==1)
       bhkArray.push(1);
    if(response.projectDetail.has_2BHK==1)
       bhkArray.push(2);
    if(response.projectDetail.has_3BHK==1)
       bhkArray.push(3);
    if(response.projectDetail.has_4BHK==1)
       bhkArray.push(4);
    if(response.projectDetail.has_5BHK==1)
       bhkArray.push(5);
    var bhkStr = '';
    var pp=0;
    $.each(bhkArray,function(id,val){
        if(bhkStr!=''){
            if(pp==bhkArray.length-1)
                bhkStr += ' & ';
            else
                bhkStr += ', ';
        }
        bhkStr += val;
        pp++;  
    });
    var monthNames = ["Jan","Feb","Mar","Apr", "May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
    var d = new Date(response.projectDetail.possession);
   // if(response.projectDetail.slide_image_6!='')
        htmlStr += '</div><a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span><span class="sr-only">Previous</span></a><a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><span class="sr-only">Next</span></a></div></div><div class="col-md-12 margin_top3 map-proj-detail-main"><h4>Project Details</h4><div class="bs-example" data-example-id="bordered-table"><table class="table table-bordered map-proj-detail-tbl"><tbody><tr><td scope="row">Configurations</td><td>'+bhkStr+' BHK Apartment</td></tr><tr><td scope="row">Super Builtup Area</td><td>'+response.min_floor_plan+' - '+response.max_floor_plan+' sq.ft.</td></tr><tr><td scope="row">Starting Price</td><td><span class="rupee">`</span> '+response.min_floor_plan_price+'</td></tr><tr><td scope="row">Possession Date</td><td>'+monthNames[d.getMonth()]+' `'+d.getFullYear()+'</td></tr></tbody></table></div></div>';
   
   htmlStr += '<div class="col-md-12 margin_top3 map-proj-detail-main"><h4>Amenities</h4><div class="bs-example" data-example-id="bordered-table"><table class="table table-bordered map-proj-detail-tbl"><tbody>';

$.each(response.amenitiesArr, function(id,value) {
    htmlStr += '<tr><td scope="row"><img src="'+baseUrl+'/public/uploadfiles/'+value.amenity_image+'"></td><td>'+value.amenity_name+'</td></tr>';
});
 

        

    htmlStr += '</tbody></table></div></div><div class="clearfix margin_top2"></div><div class="col-md-12" align="center"><a href="'+baseUrl+'/projects-in-'+response.projectDetail.citySlug.toLowerCase()+'/'+response.projectDetail.projectSlug+'"><button type="button" class="btn btn-danger">Click for more details</button></a></div><div class="clearfix margin_top2"></div></div><a ><div class="col-md-1 map-close-button-right cursor text-center"  onclick="closePrjDiv()"><strong>x</strong></div></a>';
    //$('#googleMap').removeClass('col-md-9').addClass('col-md-6 col-md-offset-3');
    $('#prjDetailDiv').html(htmlStr).show();
    },'json');
    
}
google.maps.event.addDomListener(window, 'load', initialize);