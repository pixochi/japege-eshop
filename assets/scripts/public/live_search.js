$(function(){

//LOAD DATA WHEN THE SEARCH_QUERY OR CATEGORY CHANGE
  $("#search_nav, #category_nav").on('input change focusin mouseover',post_search);

//DISPLAY "ALL PRODUCTS" BUTTON IN NAVBAR
  function display_advanced_btn(){
    $filter = $('<a>').attr({'id':'advanced','href':"./search"});
        $filter.html('All Products &nbsp;<span class="glyphicon glyphicon-filter"></span>');
         $('#search_results').append($filter);  
  }
               

//DISPLAY ADVANCED_SEARCH_BTN WHEN A USER ENTERS FOCUS TO SEARCH INPUT
 $("#search_nav").on('focusin',function(){
  if($(this).val().length < 2){
   $('#search_results').html("");
   display_advanced_btn();
  }
 });

//DISPLAY "ALL PRODUCTS" BUTTON WHEN A USER STARTS TO TYPE
  $("#search_nav").on('input',function(){
  if($(this).val().length != 0){
   $('#search_results').html("");
   display_advanced_btn();
  }
 });

    $("#header_navigation").on('mouseover',function(){
  if(!$("#advanced").length){
   display_advanced_btn();
  }
 });

    $("#header_navigation").on('mouseleave',function(){
   $('#search_results').html("");
 });

//HIDE RESULTS WHEN A USER CLICKS OUT OF THE INPUTS
   $("#search_nav, #category_nav").on('focusout',function(){
    window.setTimeout(function() { $('#search_results').html(""); }, 200);
 });

//REDIRECT TO /SEARCH PAGE ON ENTER KEYPRESS
   $('#search_nav').keypress(function (e) {
 var key = e.which;
 if(key == 13)  // the enter key code
  {
    $(location).attr('href','search');
    return false;  
  }
});  

//LOAD DATA DEPENDING ON THE SEARCH_QUERY AND A CATEGORY
  function post_search(){
    $search = $("#search_nav");
    $category = $('#category_nav');

    if($.trim($search.val().length)>1){
      $.ajax({
       type: "post",
       url: "https://japege.herokuapp.com",
       cache: false,    
       data:{search:$.trim($search.val())},
   success: function(response){

    $('#search_results').html("");

var tmp = [];
    var obj = JSON.parse(response);
    if(obj.length>0){
      //FILTER BY CATEGORY START
      if($category.val() != 'all'){
        
        $.each(obj,function(i,val){
          if(val.category.toLowerCase() == $category.val().toLowerCase()){
            tmp.push(val);
          }
        });
        obj = tmp;
        if(obj.length == 0){
           $('#search_results').html("");
           display_advanced_btn();
          $('#search_results').append("<a id='no_products' href='javascript:void(0)'>No products found in category: "+$category.val()+"</a>"); 
        } 
      }
      //FILTER BY CATEGORY END
      //FIND MOST RELEVANT RESULTS START
      if(obj.length>5) {
$.merge(tmp,find_relevant(obj,1));

        if(tmp.length < 5){
          $.merge(tmp,find_relevant(obj,2));

        }
        if($category.val == 'all'){
          if(tmp.length < 5){
 $.merge(tmp,find_relevant(obj,3));
          }}
          //FIND MOST RELEVANT RESULTS END
          obj = tmp.slice(0,5);
        }
        try{
          var products=[];  
          $.each(obj, function(i,val){  

          $found_product = $("<a>").attr('href',window.location.origin+"/product/"+val.id);
          $found_product.append($('<h4>').text(val.name));
          $found_product.append($('<i>').text(val.category));
   
            products.push($found_product);
          }); 

        if(tmp.length != 0 || products.length > 0) display_advanced_btn();
         $('#search_results').append($('<div>').attr('class','advanced_search'));
           $('.advanced_search').append.apply($('.advanced_search'), products);
        }catch(e) {  
         // alert('Exception while request..');
        }  
      }else{
        display_advanced_btn();
          $('#search_results').append("<a id='no_products' href='javascript:void(0)'>No products found</a>"); 
     }  

   },
   error: function(){      
   // alert('Error while request..');
  }
});
    } else{
     // $('#search_results').html("");
   }
   return false;
 }

//in live_search products ordered by relevance
 function find_relevant(obj,priority){
  tmp = [];
  var property;
          $.each(obj,function(i,val){
          if(typeof val !== 'undefined'){
            if(priority == 1){
               property = val.name;
            }else if(priority == 2){
             property = val.description;
            } else{
              property = val.category;
            }
            if(property.toLowerCase().indexOf($search.val().toLowerCase()) >=0 ){
              tmp.push(val);
              obj.splice(i,1);
            }
          }
        }); return tmp;
 }
 
});
//Slider in /search page
$("#ex2").slider({});


  

