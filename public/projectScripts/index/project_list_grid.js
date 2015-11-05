
var baseUrl = $('#baseUrl').val();

//$('#myModal1').modal('toggle')
//$('#myModal1').modal('show')
//$('#myModal1').modal('hide')

function getCallBAck(project_id,project_title){
    $('#callBackPrjName').text(project_title);
    //$('#callBackInputEmail').val('');
    //$('#callBackInputMobile').val('');
    $('#callBackProjectId').val(project_id);
    $('#callBackInputEmail').css('border-color','#ccc');
    $('#callBackInputMobile').css('border-color','#ccc');
    $('#myModal1').modal('show');
}
function submitCallBack(){
    //alert('AAAA');
    var email       = $('#callBackInputEmail').val();
    var mobile      = $('#callBackInputMobile').val();
    var project_id  = $('#callBackProjectId').val();
    
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if(emailReg.test(email)==false || email==''){
        $('#callBackInputEmail').css('border-color','red');
        return false;
    }else{
        $('#callBackInputEmail').css('border-color','#ccc');
    }
    var pattern = /^\d{10}$/;
    if (pattern.test(mobile)==false || mobile=='') {
        $('#callBackInputMobile').css('border-color','red');
        return false;
    }else{
         $('#callBackInputMobile').css('border-color','#ccc');
    }
    $('#callBackSubmit').hide();
    $('#callBackLoader').show();
    $.post(baseUrl+'/front-end/index/getcallback',{email:email,mobile:mobile,project_id:project_id},function(){
        $('#callBackSubmit').show();
        $('#callBackLoader').hide();
        $('#myModal1').modal('hide');
        $('#callBackInputName').val('');
        $('#callBackInputCity').val('');
        $('#callBackInputEmail').val('');
        $('#callBackInputMobile').val('');
        $('#callBackInputEmail').css('border-color','#ccc');
        $('#callBackInputMobile').css('border-color','#ccc');
    });
}

function updateValues(){
    
    var possessionValues        = $('#PossessionFilters').val();
    var propertyTypeValues      = $('#PropertyTypeFilters').val();
    var BudgetValues            = $('#BudgetFilters').val();
    var BedroomValues           = $('#BedroomFilters').val();
    
    if(possessionValues != ''){
        var possessionValuesArr = possessionValues.split(',');
       // alert(possessionValuesArr.length);
        $.each(possessionValuesArr, function(i, val) {
            $('#'+val).attr('checked', true);
        });
        var ctr = (possessionValuesArr.length>1) ? '+'+(possessionValuesArr.length-1): '';
        
       //  alert(ctr);
       // $('#possessionText').text($('#text_'+possessionValuesArr[0]).text()+ctr);
    } 
    if(propertyTypeValues != ''){
        var propertyTypeValuesArr = propertyTypeValues.split(',');
        $.each(propertyTypeValuesArr, function(i, val) {
            $('#propertyType_'+val).attr('checked', true);
        });
    } 
    if(BudgetValues != ''){
        var BudgetValuesArr = BudgetValues.split(',');
        $.each(BudgetValuesArr, function(i, val) {
            $('#budget_'+val).attr('checked', true);
        });
    } 
    if(BedroomValues != ''){
        var BedroomValuesArr = BedroomValues.split(',');
        $.each(BedroomValuesArr, function(i, val) {
            $('#bedroom_'+val).attr('checked', true);
        });
    }
}   
$('#resetFilter').click(function(){
    
    var pageName = $('#pageName').val();
    var builderDetailId = $('#builderDetailId').val();
    var params = '';
    
//    alert(builderDetailId);
    
    if(builderDetailId !== ''){
       var params = '?id='+builderDetailId; 
    }
//    window.location.href = baseUrl+'/index/'+pageName+params;
    window.location.href = window.location.pathname+params;
});

function changeView(viewType) {
    SITEROOT = baseUrl;
    var PossessionFilters = $('#PossessionFilters').val();
    var PropertyTypeFilters = $('#PropertyTypeFilters').val();
    var BudgetFilters = $('#BudgetFilters').val();
    var BedroomFilters = $('#BedroomFilters').val();
    $('#loaderDiv').show();
    $('#searchProjects').addClass('opacity3');
    $.post(SITEROOT + '/front-end/index/changesearchview', {viewType: viewType,PossessionFilters: PossessionFilters,PropertyTypeFilters: PropertyTypeFilters,BudgetFilters: BudgetFilters,BedroomFilters: BedroomFilters}, function (response) {
        $('#loaderDiv').hide();
        $('#searchProjects').removeClass('opacity3');
        if (response.length > 0) {
            var monthNames = ["Jan","Feb","Mar","Apr", "May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
            var str = '';
            
            if(viewType=='grid'){
                str = '<div class="content_fullwidth"><div class="featured_section102"><div class="container insidepg-proj-grid-row">';
                var count =0;
                $.each(response, function(id,value) {
                   count++;
                   var d = new Date(value.possession);
                    var addRemoveDiv = '';
                    if ($.inArray(parseInt(value.project_id), CompareProjectsArr) !== -1) {
                       addRemoveDiv = '<a onclick=\'addRemoveCompare('+value.project_id+')\'><span class="glyphicon glyphicon-check" aria-hidden="true" ></span> Remove from Compare</a>';
                    }else{
                       addRemoveDiv = '<a class="addToCompare" data-toggle="tooltip" title="Maximum 3 Projects" onclick=\'addRemoveCompare('+value.project_id+')\'><span class="glyphicon glyphicon-unchecked" aria-hidden="true" ></span> Add to Compare</a>';
                   }
                   var last = (count % 4 == 0) ? 'last' : '';
                   var floorPriceArr = new Array();
                   var floorSizeArr = new Array();
                   $.each(value.floor_plans, function(id,floor_plan) {
                       floorPriceArr[id] = parseFloat(floor_plan.price); 
                       floorSizeArr[id] = parseFloat(floor_plan.size);
                   });
                   
                    var bhkArray = new Array();
                    if(value.has_1BHK==1)
                       bhkArray.push(1);
                    if(value.has_2BHK==1)
                       bhkArray.push(2);
                    if(value.has_3BHK==1)
                       bhkArray.push(3);
                    if(value.has_4BHK==1)
                       bhkArray.push(4);
                    if(value.has_5BHK==1)
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
                   
                   str += '<div class="one_fourth_less '+last+'"> <a href="'+SITEROOT+'/projects-in-'+value.citySlug.toLowerCase()+'/'+value.projectSlug+'"><img src="'+SITEROOT+'/public/uploadfiles/'+value.project_image+'" alt="" /></a><h5><a href="'+SITEROOT+'/projects-in-'+value.citySlug.toLowerCase()+'/'+value.projectSlug+'">'+value.project_title+'</a> <em>'+value.city_name+', '+value.state_name+'</em></h5><div class="grid_type">'+bhkStr+' BHK ( '+value.min_floor_plan_size+' - '+value.max_floor_plan_size+' sq ft )<br><span class="grid_type_left_smltxt">Possession Date: '+monthNames[d.getMonth()]+' `'+d.getFullYear()+'</span></div><div class="grid_button"><div class="grid_button_left"> <span class="grid_button_left_smltxt">STARTING PRICE</span><br> <span class="rupee">`</span> '+value.min_floor_plan_price+'</div><div class="grid_button_right cursor" id="addCompareDiv_'+value.project_id+'">'+addRemoveDiv+'</div></div><div class="row projlistpg-compare-pad"><button type="button" class="btn btn-danger btn-sm" data-toggle="modal" onclick="return getCallBAck('+value.project_id+',\''+value.project_title+'\')">GET CALL BACK</button></div></div>';  
                   
                    if(count % 4 == 0 && count != response.length){ 
                        str += '<div style="border-bottom: 4px double #ccc;">&nbsp;</div>';
                    }
                    if(count % 8 == 0){
                        var returnArr = shuffleProjectBanner();
                        //alert(returnArr['project_id']+'======='+returnArr['banner_image']);
                        str += '<div class="container insidepg-proj-row"><div class="clearfix margin_top3"></div><div class="row"><a style="float:left" href="'+SITEROOT+'/projects/'+returnArr['projectSlug']+'"><img width="1160" height="100" src="'+SITEROOT+'/public/uploadfiles/'+returnArr['banner_image']+'"></a></div><div class="clearfix margin_top3"></div></div>';
                    }
                });
                str += '</div></div></div>';
            }else{
                var ii = 0;
                $.each(response, function(id,value) {
                    str += '<div class="container insidepg-proj-row"><div class="row"><div class="col-md-3  insidepg-proj-img-box"><a href="'+SITEROOT+'/projects-in-'+value.citySlug.toLowerCase()+'/'+value.projectSlug+'"><img src="'+SITEROOT+'/public/uploadfiles/'+value.project_image+'" class="img-responsive"></a></div><div class="col-md-7 insidepg-proj-detail"><div class="bs-example" data-example-id="bordered-table"><h4 id="tables-bordered"><a href="'+SITEROOT+'/projects-in-'+value.citySlug.toLowerCase()+'/'+value.projectSlug+'">'+value.project_title+'</a></h4><p>'+value.address+'</p>';
                    str += '<table class="table table-bordered"><thead><tr><th>PROPERTY</th><th>SIZE</th><th>BUILDER PRICE</th></tr></thead><tbody>';
                    var pp = 1111;  
                    $.each(value.floor_plans, function(id,floor_plan) {
                        var max_size = (floor_plan.floor_plan_list.length >1) ? ' - '+floor_plan.max_size : '';
                        var max_price = (floor_plan.floor_plan_list.length >1) ? ' - <span class="rupee">`</span> '+floor_plan.max_price : '';
                        str += '<tr onClick="showRow(\'subrow'+value.project_id+pp+'\',this);" id=\'head'+value.project_id+pp+'\' style="cursor:pointer;"><td>'+floor_plan.BHK+' Bedroom &nbsp;<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></td><td>'+floor_plan.min_size+''+max_size+' '+floor_plan.size_unit+'</td><td><span class="rupee">`</span> '+floor_plan.min_price+''+max_price+'</td></tr>';
                        if(floor_plan.floor_plan_list.length > 0){     
                                str += '<tr class="subrow'+value.project_id+pp+' hide-row-bg" onClick="hideRow(\'subrow'+value.project_id+pp+'\',\'head'+value.project_id+pp+'\');" style="cursor:pointer;display:none;"><td>'+floor_plan.BHK+' Bedroom &nbsp;<span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></td><td>&nbsp;</td><td>&nbsp;</td></tr>';              
                                $.each(floor_plan.floor_plan_list, function(id,floor_plan_list) { 
                                str += '<tr class="subrow'+value.project_id+pp+'" style="display:none;"><td class="hide-cell-pad">'+floor_plan_list.plan_type+' </td><td class="hide-cell-pad">'+floor_plan_list.size+' '+floor_plan_list.unit+'</td><td class="hide-cell-pad"><span class="rupee">`</span> '+floor_plan_list.price+' '+floor_plan_list.price_unit+'</td></tr>';
                            });
                        }
                        pp++;
                    });
                    str += '</tbody></table>';
                    var d = new Date(value.possession);
                    var addRemoveDiv = '';
                    if ($.inArray(parseInt(value.project_id), CompareProjectsArr) !== -1) {
                       addRemoveDiv = '<a onclick=\'addRemoveCompare('+value.project_id+')\'><span class="glyphicon glyphicon-check" aria-hidden="true" ></span> Remove from Compare</a>';
                    }else{
                       addRemoveDiv = '<a class="addToCompare" data-toggle="tooltip" title="Maximum 3 Projects" onclick=\'addRemoveCompare('+value.project_id+')\'><span class="glyphicon glyphicon-unchecked" aria-hidden="true" ></span> Add to Compare</a>';
                   }
                    str += '</div></div><div class="col-md-2 insidepg-proj-builder"><div class="row insidepg-proj-builder-img" align="center"><a href="'+SITEROOT+'/builders/'+value.builderSlug+'"><img src="'+SITEROOT+'/public/uploadfiles/'+value.builder_image+'"  class="img-responsive"></a></div><div class="row insidepg-proj-builder-price text-center"><div class="proj-price-text"><span class="rupee">`</span>  '+value.min_floor_plan_price+' - <span class="rupee">`</span> '+value.max_floor_plan_price+'</div>POSSESSION '+monthNames[d.getMonth()]+' `'+d.getFullYear()+'</div><div class="clearfix"></div><div class="row projlistpg-compare-pad cursor" align="center" id="addCompareDiv_'+value.project_id+'">'+addRemoveDiv+'</div><div class="row" align="center"><button type="button" class="btn btn-danger btn-sm" onclick="return getCallBAck('+value.project_id+',\''+value.project_title+'\')">GET CALL BACK</button></div></div></div></div>  ';
                    
                    ii++; 
                    if(ii % 4 == 0 && ii != response.length){
                        var returnArr = shuffleProjectBanner();
                        str += '<div class="container insidepg-proj-row"><div class="clearfix margin_top3"></div><div class="row"><a style="float:left" href="'+SITEROOT+'/projects/'+returnArr['projectSlug']+'"><img width="1160" height="100" src="'+SITEROOT+'/public/uploadfiles/'+returnArr['banner_image']+'"></a></div><div class="clearfix margin_top3"></div></div>';
                    }  
                });
            }
            $('#searchProjects').html(str);
            if(CompareProjectsArr.length > 2)   $('[data-toggle="tooltip"]').tooltip();
            return false;
        } else {
            $('#searchProjects').text('No Result Found.');
            return false;
        }
    },'json');
}
function managePossession(value){
   var possessionValues = $('#PossessionFilters').val();
   var allPossessionValues = '';
   if($('#'+value).is(':checked')){
       allPossessionValues = (possessionValues!='') ? possessionValues+','+value : value;
   }else{
       var possessionValuesArr = possessionValues.split(',');
       var strList = '';
       $.each(possessionValuesArr,function(i,val){
           if(val !== value){
               strList += (strList !== '') ? ','+val :val ;
           }
       });
       allPossessionValues = strList;
   }
   $('#PossessionFilters').val(allPossessionValues);
   return redirectUrl(0);
}
function managePropertyType(value){
   var propertyTypeValues = $('#PropertyTypeFilters').val();
    var allPropertyTypeValues = '';
    if($('#propertyType_'+value).is(':checked')){
        allPropertyTypeValues = (propertyTypeValues!='') ? propertyTypeValues+','+value : value;
    }else{
        var propertyTypeValuesArr = propertyTypeValues.split(',');
        var strList = '';
        $.each(propertyTypeValuesArr,function(i,val){
            if(parseInt(val) !== parseInt(value)){
                strList += (strList !== '') ? ','+val :val ;
            }
        });
        allPropertyTypeValues = strList;
    }
   $('#PropertyTypeFilters').val(allPropertyTypeValues);
   return redirectUrl(0);
}
function manageBudget(value){
    var BudgetValues = $('#BudgetFilters').val();
    var allBudgetValues = '';
    if($('#budget_'+value).is(':checked')){
        allBudgetValues = (BudgetValues!='') ? BudgetValues+','+value : value;
    }else{
        var BudgetValuesArr = BudgetValues.split(',');
        var strList = '';
        $.each(BudgetValuesArr,function(i,val){
            if(parseInt(val) !== parseInt(value)){
                strList += (strList !== '') ? ','+val :val ;
            }
        });
        allBudgetValues = strList;
    }
    
//    
//    alert(allBudgetValues);
//    return false;
    $('#BudgetFilters').val(allBudgetValues);
    return redirectUrl(0);
}
function manageBedrooms(value){
   var BedroomValues = $('#BedroomFilters').val();
   var allBedroomValues = '';
    if($('#bedroom_'+value).is(':checked')){
        allBedroomValues = (BedroomValues!=='') ? BedroomValues+','+value : value;
    }else{
        var BedroomValuesArr = BedroomValues.split(',');
        var strList = '';
        $.each(BedroomValuesArr,function(i,val){
            if(parseInt(val) !== parseInt(value)){
                strList += (strList !== '') ? ','+val :val ;
            }
        });
        allBedroomValues = strList;
    }
   $('#BedroomFilters').val(allBedroomValues);
   return redirectUrl(0);
}

function redirectUrl(isMapview){
    var possessionValues        = $('#PossessionFilters').val();
    var propertyTypeValues      = $('#PropertyTypeFilters').val();
    var BudgetValues            = $('#BudgetFilters').val();
    var BedroomValues           = $('#BedroomFilters').val();
    // used in builder-detail page
    var builderDetailId           = $('#builderDetailId').val();
    
    var paramStr = '';
    var paramCount=0;
    if(builderDetailId!=''){
        paramStr += '?id='+builderDetailId;
        paramCount++;
    }
    if(possessionValues!==''){
        paramStr += (paramCount==0)? '?possession='+possessionValues : '&possession='+possessionValues;
        paramCount++;
    }
    
    if(propertyTypeValues!==''){
        paramStr += (paramCount==0)? '?propertyType='+propertyTypeValues : '&propertyType='+propertyTypeValues;
        paramCount++;
    }
    
    if(BudgetValues!==''){
        paramStr += (paramCount==0)? '?budget='+BudgetValues : '&budget='+BudgetValues;
        paramCount++;
    }
    
    if(BedroomValues!==''){
        paramStr += (paramCount==0)? '?bedroom='+BedroomValues : '&bedroom='+BedroomValues;
        paramCount++;
    }
//    alert(paramStr);    
//    return false;   
    var pageName = $('#pageName').val();
    if(isMapview==1){
        window.location.href = baseUrl+'/maps/projects'+paramStr;
    }else{
        if(isMapview==2)
            window.location.href = projectListPage+paramStr;
        else
            window.location.href = window.location.pathname+paramStr;
    }
    
//    window.location.href = baseUrl+'/index/'+pageName+paramStr;
    //return false;

}

   $('#projectSearchInput').keyup(function(){
  
        var searchStr = $(this).val();
        
        //alert(searchStr.length);return false;
        if(searchStr.length > 1){
        $.post(baseUrl + '/front-end/index/project-search', {searchStr: searchStr}, function (response) {
            var htmlStr = '';
            if (response.cityarr.length > 0) {
                
                htmlStr += '<ul><li class="magicsearch-results-align">Location</li>';
                $.each(response.cityarr, function(id,value) {
                    var re = new RegExp(searchStr,"gi");
                    var new_city_name = value.city_name.replace(re, "<b>"+ucFirst(searchStr)+"</b>")
                    htmlStr += '<a href="'+baseUrl+'/projects-in-'+value.citySlug+'"><li class="magicsearch-results-leftpad"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> <span style="padding-left:2%;">'+new_city_name+'</span></li></a>';
                });
                htmlStr += '</ul>';
            }
            if (response.builderarr.length > 0) {
                htmlStr += '<ul><li class="magicsearch-results-align">Builder</li>';
                $.each(response.builderarr, function(id,value) {
                    var re = new RegExp(searchStr,"gi");
                    var new_builder_name = value.builder_name.replace(re, "<b>"+ucFirst(searchStr)+"</b>")
                   htmlStr += '<a href="'+baseUrl+'/builders/'+value.builderSlug+'"><li class="magicsearch-results-leftpad"><span class="glyphicon glyphicon glyphicon-stats" aria-hidden="true"></span> <span style="padding-left:2%;">'+new_builder_name+'</span></li></a>';
                });
                htmlStr += '</ul>';
            }
            if (response.projectarr.length > 0) {
                htmlStr += '<ul><li class="magicsearch-results-align">Project</li>';
                $.each(response.projectarr, function(id,value) {
                    var re = new RegExp(searchStr,"gi");
                    var new_project_title = value.project_title.replace(re, "<b>"+ucFirst(searchStr)+"</b>")
                    htmlStr += '<a href="'+baseUrl+'/projects/'+value.projectSlug+'"><li class="magicsearch-results-leftpad"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <span style="padding-left:2%;">'+new_project_title+'</span></li></a>';
                });
                htmlStr += '</ul>';
            }
//            var re = new RegExp(searchStr,"gi");
//            var newHtml = htmlStr.replace(re, '<b>'+ucFirst(searchStr)+'</b>')
            
            
            $('#inputSearchResults').html(htmlStr);
        },'json');
    }else{
        $('#inputSearchResults').html('');
    }   
    return false;
    });
    
    function ucFirst(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
    
    function showRow(cl,t1){
        $("."+ cl).show();
        $(t1).hide();
    }
    function hideRow(cl,t1){
        $("."+ cl).hide();
        $("#" + t1).show();
    }
   