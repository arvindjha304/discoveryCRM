
var baseUrl = $('#baseUrl').val();
 
function floorPlanInfo(floorPlanId,divId,project_id){
     $.post(baseUrl + '/front-end/index/get-floor-plan-info', {project_id: project_id,floorPlanId:floorPlanId}, function (response) {
         if(floorPlanId==''){
            $('#area_'+divId).text(response.maxMinFloorSize.minFloorSize+' - '+response.maxMinFloorSize.maxFloorSize);
            $('#totalPrice_'+divId).text(response.min_floor_plan_price+' - '+response.max_floor_plan_price);
            $('#floorPlanCount_'+divId).text(response.countFloorPlan+' Floor Plan');
         }else{
            $('#area_'+divId).text(response.floorPlanDetail.size+' '+response.floorPlanDetail.unit);
            $('#totalPrice_'+divId).text(response.floorPlanDetail.price+' '+response.floorPlanDetail.price_unit);
            $('#floorPlanCount_'+divId).html('<a class="yo" href="'+baseUrl+'/public/uploadfiles/'+response.floorPlanDetail.floor_plan_image+'" title=""><span class="glyphicon glyphicon-open" aria-hidden="true"></span>Click to view Floor Plan</a>');
             
         }
     },'json');
//    alert(floorPlanId+'==='+divId);
//    return false;
}
function addRemoveCompare(project_id,is_menu){
    if(project_id!==''){
        if ($.inArray(project_id, CompareProjectsArr) !== -1) {
               $('#addCompareDiv_'+project_id).html('<a  data-toggle="tooltip" title="Maximum 3 Projects" onclick=\'addRemoveCompare('+project_id+',0)\'><span class="glyphicon glyphicon-unchecked" aria-hidden="true" ></span> Add to Compare</a>');
            var index = CompareProjectsArr.indexOf(project_id);
            CompareProjectsArr.splice(index, 1);
            if(CompareProjectsArr.length < 3) $('[data-toggle="tooltip"]').tooltip('destroy');
        }else{
            if(CompareProjectsArr.length !=3){
                $('#addCompareDiv_'+project_id).html('<a onclick=\'addRemoveCompare('+project_id+',0)\'><span class="glyphicon glyphicon-check" aria-hidden="true" ></span> Remove from Compare</a>');
                CompareProjectsArr.push(project_id);
            } 
            if(CompareProjectsArr.length > 2)   $('[data-toggle="tooltip"]').tooltip();
        }
        $.post(baseUrl + '/front-end/index/addcompare', {project_id: project_id,allCompareProjects:CompareProjectsArr}, function (response) {
            var liString = '';
            var kk = 0;
            $.each(response, function(id,value) {
                liString += '<li ><div class="col-md-12" style="border-bottom: 1px solid #ddd;"><div class="compare-dropdown-menu"><a href="'+baseUrl+'/projects/'+value.projectSlug+'">'+value.project_title+'</a></div><div onclick="addRemoveCompare('+value.id+',1)" class="cursor compare-dropdown-menu-remove"><a   class="compare-dropdown-menu-remove-btn"><span class="glyphicon glyphicon-remove-circle"></span></a></div></div></li>';
                kk++;
            });
            if(response.length > 0){
                var disabled = (response.length < 2) ? 'disabled' : '';
                $('.compareProjectsList').html(liString+'<li><button '+disabled+' type="button" class="btn btn-danger btn-xs" onclick="window.location.href=\''+baseUrl+'/compare-projects\'" style="width:100%;">Compare</button></li>');             
                if(is_menu!=0) $('.openCompare').addClass('open');
            }else{
              $('.compareProjectsList').html('<li><div class="col-md-12" style="border-bottom: 1px solid #ddd;"><div class="compare-dropdown-menu">No Project Selected</div></div></li>');   
            }
            $('#countCompare').text(kk);
        },'json'); 
    }
}

