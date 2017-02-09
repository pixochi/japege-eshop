$(function(){

  $('.owned_product').on('click',function(){
    $product_id = $(this).find('input.product_id').val();
    find_users($product_id);
  });
//FIND USERS WHO OWN THE PRODUCT YOU CLICKED ON
function find_users(product_id){

  $.ajax({
   type: "post",
   url: "https://japege.herokuapp.com/my_profile",
   cache: false,    
   data:{product_id:product_id},
   success: function(response){

    var obj = JSON.parse(response);
    if(obj.length > 0){

     try{
      var users=[];  
      $.each(obj, function(i,val){  

        $first_name = $("<figcaption>").text(val.first_name);
        $last_name = $("<figcaption>").text(val.last_name);
        var img_src;

        if(val.image == null){
          img_src = config.protocol+config.domain+"/assets/images/public/profile_pic.jpg";
        } else { 
          if(val.image.indexOf("/") >= 0){
            img_src = val.image; 
          } else {
            img_src = config.protocol+config.domain+"/assets/images/uploads/customers/"+val.id+"/"+val.image;
          }}
          $image = $("<img>").attr('src',img_src);
          $article = $("<article>");
          $figure =$("<figure>").append($image, $first_name, $last_name);
          $article.append($figure);

          $user = $("<a>").addClass('user_profile').attr({target:'_blank',href:config.protocol+config.domain+"/user/"+val.id}).append($article);
          users.push($user);
        }); 
      $('#users').html('');
      $('#users').append.apply($('#users'), users);

    }catch(e) {  
      // alert('Exception while request..');
    }  
  } else {$('#users').css({'color':'black','text-align':'center'});
  $('#users').html($('<h1>').text('This is amazing!'));
  $('#users').append($('<h2>').text('You are the first person with this starter pack!').css('color','black'));
}

},
error: function(){      
  // alert('Error while request..');
}
});
};

});



