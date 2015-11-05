
var baseUrl = $('#projectBaseUrl').val();

//alert(baseUrl);
function openSignUp(){
   $('.userName,.userPassword,.userEmail,.userMobile').val('');
   $('#userExistMsg').html('');
   $('#loginForm').modal('hide');
   $('#signUpForm').modal('show');
   $('.signUpButton').show();
   $('#signUpLoader').hide();
}
function openLoginForm(){
   //$('.userLoginEmail,.userLoginPassword').val('');
   $('#loginForm').modal('show');
//   $(window).disablescroll();
//   $(window).disablescroll("undo");
}
function forgotPassword(){
   $('.forgotEmail').val('');
   $('#loginForm').modal('hide');
   $('#forgotPwswd').modal('show');
}
$('.userLogin').click(function(){
    var userLoginEmail = $('.userLoginEmail').val();
    var userLoginPassword = $('.userLoginPassword').val();
    var remember_me = ($('#remember_me').is(':checked'))? 1 : 0;
    
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var error = 0;
    if(userLoginEmail=='' || emailReg.test(userLoginEmail)==false){
        $('.userLoginEmail').css('border-color','red');
        error = 1;
    }else{
        $('.userLoginEmail').css('border-color','#ccc');
        error = 0;
    }
    if(userLoginPassword==''){
        $('.userLoginPassword').css('border-color','red');
        error = 1;
    }else{
        $('.userLoginPassword').css('border-color','#ccc');
        error = 0;
    }
    if(error==0){
        $.post(baseUrl + '/front-end/user/user-login', {userLoginEmail: userLoginEmail,userLoginPassword:userLoginPassword,remember_me:remember_me}, function (response) {
            if(response=='LoginFailed'){
                $('#userLoginMsg').html('<p style="color:red">Something went wrong.Please try again.</p>').show();
            }else
                location.reload();
        });
    }else{
        return false;
    }
});


$('.signUpButton').click(function(){
    var userName = $('.userName').val();
    var userPassword = $('.userPassword').val();
    var userEmail = $('.userEmail').val();
    var userMobile = $('.userMobile').val();
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var error = 0;
    if(userName==''){
        $('.userName').css('border-color','red');
        error = 1;
    }else{
        $('.userName').css('border-color','#ccc');
        error = 0;
    }
    if(userPassword==''){
        $('.userPassword').css('border-color','red');
        error = 1;
    }else{
        $('.userPassword').css('border-color','#ccc');
        error = 0;
    }
    if(userEmail=='' || emailReg.test(userEmail)==false){
        $('.userEmail').css('border-color','red');
        error = 1;
    }else{
        $('.userEmail').css('border-color','#ccc');
        error = 0;
    }
    
    if(error==0){
        $('.signUpButton').hide();
        $('#signUpLoader').show();
        $.post(baseUrl + '/front-end/user/user-register', {userName: userName,userPassword:userPassword,userEmail:userEmail,userMobile:userMobile}, function (response) {
            if(response=='userexist'){
                $('#userExistMsg').html('<p style="color:red">This email is already registered. Click forgot password to reset your password.</p>').show();
            }else{
                $('#userExistMsg').html('<p style="color:red">Thank you for Signing up! You will receive an email from Aadinath India shortly which will allow you to verify your email.</p>').show();
                $('.signUpButton').show();
                $('#signUpLoader').hide();
                $('.userName,.userPassword,.userEmail,.userMobile').val(''); 
            }
            return false;
        });
    }else{
        return false;
    }
});

$('.forgotPswd').click(function(){
    var forgotEmail = $('#forgotEmail').val();
    var error = 0;
     if(forgotEmail==''){
        $('#forgotEmail').css('border-color','red');
        error = 1;
    }else{
        $('#forgotEmail').css('border-color','#ccc');
        error = 0;
    }
    if(error==0){
       // $('.signUpButton').hide();
       // $('#signUpLoader').show();
        $.post(baseUrl + '/front-end/user/forgot-password', {forgotEmail: forgotEmail}, function (response) {
            $('.messageBody').html('<p>We have sent the password reset instructions on '+forgotEmail+'. Kindly follow the instructions in the mail for resetting your password.</p>');
            
           // $('#signUpForm').modal('hide');
           // $('#loginForm').modal('show'); 
           // $('.userName,.userPassword,.userEmail,.userMobile').val('');
        });
    }else{
        return false;
    }
});


/* Facebook Login Script Start */

//Load the Facebook JS SDK
(function(d){
   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "//connect.facebook.net/en_US/all.js";
   ref.parentNode.insertBefore(js, ref);
 }(document));

// Init the SDK upon load
window.fbAsyncInit = function() {
  FB.init({
    appId      : '129874794027773', // App ID
    status     : true, // check login status
    cookie     : true, // enable cookies to allow the server to access the session
    xfbml      : true  // parse XFBML
  });


// Specify the extended permissions needed to view user data
// The user will be asked to grant these permissions to the app (so only pick those that are needed)
        var permissions = [
          'email',
          'user_likes',
          'user_about_me',
          'user_birthday',
          'user_education_history',
          'user_hometown',
          'user_relationships',
          'user_relationship_details',
          'user_location',
          'user_religion_politics',
          'user_website',
          'user_work_history'
          ].join(',');

// Specify the user fields to query the OpenGraph for.
// Some values are dependent on the user granting certain permissions
        var fields = [
          'id',
          'name',
          'first_name',
          'middle_name',
          'last_name',
          'gender',
          'locale',
          'languages',
          'link',
          'timezone',
          'verified',
          'age_range',
          'birthday',
          'email',
          'location',
          'picture'
          ].join(',');

  function showDetails() {
    FB.api('/me', {fields: fields}, function(details) {
        $.post(baseUrl + '/front-end/user/login-with-fb',{name: details.name,email: details.email}, function (response) {
            $('#loginForm').modal('hide');
            location.reload();
        });
    });
  }


  $('.login-fb-bttn').click(function(){
    //initiate OAuth Login
    FB.login(function(response) { 
      // if login was successful, execute the following code
      if(response.authResponse) {
          showDetails();
      }
    }, {scope: permissions});
  });

};
/* Facebook Login Script End */

/* google + login script start */

function gPOnLoad(){
     // G+ api loaded
     document.getElementById('gp_login').style.display = 'block';
}
function googleAuth() {
    gapi.auth.signIn({
        //callback: gPSignInCallback,
        callback: googleSigninCallback,
        clientid: "253871329066-r0lfdsidubn6slbq33n1hrr1vdq5147n.apps.googleusercontent.com",
        cookiepolicy: "single_host_origin",
        requestvisibleactions: "http://schema.org/AddAction",
        scope: "https://www.googleapis.com/auth/plus.login email"
    })
}


function googleSigninCallback(authResult) {
//  if (authResult['status']['signed_in'] && authResult['status']['method'] == 'PROMPT') {
//	console.log('11111');
      // User clicked on the sign in button. Do your staff here.
//  } else 
      
    if (authResult['status']['signed_in']) {
		gapi.client.load("plus", "v1", function() {
            if (authResult["access_token"]) {
                getProfile()
            } else if (authResult["error"]) {
                console.log("There was an error: " + authResult["error"])
            }
        })
      // This is called when the status has changed and method is not 'PROMPT'.
  } else {
      // Update the app to reflect a signed out user
      // Possible error values:
      //   "user_signed_out" - User is signed-out
      //   "access_denied" - User denied access to your app
      //   "immediate_failed" - Could not automatically log in the user
      console.log('Sign-in state: ' + authResult['error']);
  }
  }


function getProfile() {
    var e = gapi.client.plus.people.get({
        userId: "me"
    });
    e.execute(function(e) {
        if (e.error) {
            console.log(e.message);
            return
        } else if (e.id) {
            var email = e.emails.filter(function(v) {
                 return v.type === 'account'; // Filter out the primary email
            })[0].value;
            $.post(baseUrl + '/front-end/user/login-with-gmail',{name: e.displayName,email: email}, function (response) {
                $('#loginForm').modal('hide');
                location.reload();
            });
            return false;
        }
    })
}

(function() {
    var e = document.createElement("script");
    e.type = "text/javascript";
    e.async = true;
    e.src = "https://apis.google.com/js/client:platform.js?onload=gPOnLoad";
    var t = document.getElementsByTagName("script")[0];
    t.parentNode.insertBefore(e, t)
})()


/* google + login script end */


function userLogout(){
    $.post(baseUrl + '/front-end/user/logout', function (response) {
//        alert(location);
//        return false;
        location.reload();
    });
}

    $('#addPropertyCity').keyup(function(){
        var searchStr = $(this).val();
        if(searchStr.length > 0){
            $.post(baseUrl + '/front-end/user/get-cities', {searchStr: searchStr}, function (response) {
                var htmlStr = '';
                if(response.length >0){
                    htmlStr += '<ul id="cityList">';
                    $.each(response, function(id,value) {
                       htmlStr += '<li class="magicsearch-results-leftpad" onclick="return selectCity('+value.id+',\''+value.city_name+'\')"><span style="padding-left:2%;" >'+value.city_name+'</span></li>';
                    });
                    htmlStr += '</ul>';
                    $('.allCities').html(htmlStr);
                }else{ $('.allCities').html('');}
            },'json');
        }else{
            $('.allCities').html('');
        }   
        return false;
    });


    function selectCity(id,city_name){
        $('#addPropertyCityId').val(id);
        $('#addPropertyCity').val(city_name);
        $('.allCities').html('');
        $('#addPropertyProject').removeAttr('disabled');
        return false;
    }
    
    $('#addPropertyProject').keyup(function(){
        var searchStr = $(this).val();
        var cityId = $('#addPropertyCityId').val();
        if(searchStr.length > 0){
            $.post(baseUrl + '/front-end/user/get-project-by-city', {searchStr: searchStr,cityId: cityId}, function (response) {
                var htmlStr = '';
                if(response.length >0){
                    htmlStr += '<ul id="prjList">';
                    $.each(response, function(id,value) {
//                     alert(value.prj_id+'==='+value.project_title);
                       htmlStr += '<li class="magicsearch-results-leftpad" onclick="return selectProject('+value.prj_id+',\''+value.project_title+'\')"><span style="padding-left:2%;" >'+value.project_title+'</span></li>';
                    });
                    htmlStr += '</ul>';
                    $('.allProjects').html(htmlStr);
                }else{ $('.allProjects').html('');}
            },'json');
        }else{
            $('.allProjects').html('');
        }   
        return false;
    });
    
    function selectProject(id,project_title){
        $('#addPropertyPrjId').val(id);
        $('#addPropertyProject').val(project_title);
        $('.allProjects').html('');
        return false;
    }
    
    function getPropertyDetail(){
        
        var prjId = $('#addPropertyPrjId').val();
        if(prjId.length > 0){
            $.post(baseUrl + '/front-end/user/get-project-detail', {prjId: prjId}, function (response) {
                $('#add-property-step1Modal').modal('hide');
                $('#add-property-step2Modal').modal('show');
                $.each(response.projectDetail, function(id,value) {
                    $('.prjName').text(value.project_title);
                    $('#form2prjName').val(value.project_title);
                    $('.location').text(value.location+', '+value.city_name);
                });
                var htmlStr = '';
                htmlStr += '<option value="">---Select Configuration---</option>';
                $.each(response.floor_plans, function(id,value) {
//                     alert(value.prj_id+'==='+value.project_title);
                   htmlStr += '<option value="'+value.id+'##'+value.size+'">'+value.plan_type+' ('+value.size+' sq ft)</option>';
                });
                $('.flrPlanList').html(htmlStr);
            },'json');
        }else{
            $('.flrPlanList').html('');
        }   
        return false;
    }
    
 
    $(".flrPlanList").change(function(){
        var configVal = $(this).val().split("##");
        if(configVal==""){
            $('#form2FlrPlnId').val('');
            $('#flrPlanSize').val('');
            $('.flrPlanSizeDiv').hide();
        }else{
            $('#form2FlrPlnId').val(configVal[0]);
            $('#flrPlanSize').val(configVal[1]);
            $('.flrPlanSizeDiv').show();
        }
        return false;
    });
    
    $('#backToForm1').click(function (){
        $('#add-property-step1Modal').modal('show');
        $('#add-property-step2Modal').modal('hide');
    });
    
    $('#goToForm3').click(function (){
        $('#add-property-step3Modal').modal('show');
        $('#add-property-step2Modal').modal('hide');
    });
    
    $('#backToForm2').click(function (){
        $('#add-property-step2Modal').modal('show');
        $('#add-property-step3Modal').modal('hide');
    });
 
    $('#saveAddPrpty').click(function (){
        var prjId               = $('#addPropertyPrjId').val();
        var form2FlrPlnId       = $('#form2FlrPlnId').val();
        var form2Purchasedfor   = $('#form2Purchasedfor').val();
        var form2DateofPurchase = $('#form2DateofPurchase').val();
        var form2Unit           = $('#form2Unit').val();
        var form2Floor          = $('#form2Floor').val();
        var form2Tower          = $('#form2Tower').val();
        var form3BasicSalePrice = $('#form3BasicSalePrice').val();
        var form3OtherExpenses  = $('#form3OtherExpenses').val();
        var form3TotalPrice     = $('#form3TotalPrice').val();
        var form3GoalAmount     = $('#form3GoalAmount').val();
        var form3LoanStatus     = $('#form3LoanStatus').val();
        $.post(baseUrl + '/front-end/user/add-resale-project', {prjId:prjId,form2FlrPlnId: form2FlrPlnId,form2Purchasedfor: form2Purchasedfor,form2DateofPurchase: form2DateofPurchase,form2Unit: form2Unit,form2Floor: form2Floor,form2Tower: form2Tower,form3BasicSalePrice: form3BasicSalePrice,form3OtherExpenses: form3OtherExpenses,form3TotalPrice: form3TotalPrice,form3GoalAmount: form3GoalAmount,form3LoanStatus: form3LoanStatus}, function (response) {
            $('#addPropertyProject,#addPropertyCity,#addPropertyPrjId,#form2FlrPlnId,#form2Purchasedfor,#form2DateofPurchase,#form2Unit,#form2Floor,#form2Tower,#form3BasicSalePrice,#form3OtherExpenses,#form3TotalPrice,#form3GoalAmount,#form3LoanStatus').val('');
            $('.allCities,.allProjects').html('');
            location.reload();
        });
       
//        $('#add-property-step3Modal').modal('show');
//        $('#add-property-step2Modal').modal('hide');
    });


    
