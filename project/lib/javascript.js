jQuery.noConflict();
/*Button CLOSE*/
jQuery(function ButtonClose() {
jQuery('.js-close').click(function () {
    jQuery(this).parent().fadeOut(700);
    return false;
  });
});

jQuery(function ButtonOpenClose() {
  jQuery('.js-menuForPart').click(function (event) {
    event.stopPropagation();
    var opUl=jQuery(this).children(); 
   
     opUl.next().toggle(500);
     opUl.children().toggleClass('activ');
   });
}); 

/*Открывает скрытый элемент*/
jQuery(function ButtonOp() {
jQuery('.js-secondButton').click(function (event) {
event.stopPropagation();
    let th=jQuery(this);
    let double=th.next();//alert(double.children().next().children().html());
    //if (jQuery(this).is(":visible"))
    //th.hide();
    double.slideDown(900);
    return false;
  });
});

/*Button vverh-vniz*/
jQuery(function OnDown(){
//event.stopPropagation();
if (jQuery(window).scrollTop()>="250") jQuery("#js-OnTop").fadeIn("slow");
jQuery(window).scroll(function(){
if (jQuery(window).scrollTop()<="250") jQuery("#js-OnTop").fadeOut("slow");
else jQuery("#js-OnTop").fadeIn("slow");
 });
if (jQuery(window).scrollTop()<=jQuery(document).height()-"999") jQuery("#js-OnBottom").fadeIn("slow");
jQuery(window).scroll(function(){
if (jQuery(window).scrollTop()>=jQuery(document).height()-"999") jQuery("#js-OnBottom").fadeOut("slow");
else jQuery("#js-OnBottom").fadeIn("slow");
 });
jQuery("#js-OnTop").click(function(){jQuery("html,body").animate({scrollTop:0},"slow");});
jQuery("#js-OnBottom").click(function(){jQuery("html,body").animate({scrollTop:jQuery(document).height()},"slow");});
});

/*Предупреждение об отсутствии поддержки браузером js*/
jQuery(function linkDownload() { 

jQuery('.js-button').click(function(event) {
event.stopPropagation();
var down=jQuery(this).attr('download');
var tab=jQuery('.js-warning');
if(down===undefined)
tab.fadeIn();
});
});

/*Выпадающий список меню*/
jQuery(function ArrowReturn() {   
  jQuery('.js-menuArrow').click(function (event) {
  event.stopPropagation();
    var openUl=jQuery(this).children(); 
    var openUlLi=openUl.next();
    var openSpan=openUl.children();
     openUlLi.stop().animate({'height':'toggle'},500);
     openSpan.toggleClass('activeArrow');

   });
});
 
/*Предупреждение о куки*/
jQuery(function ViewWarning()  {
//event.stopPropagation();
const container = document.querySelector(".warn");
if (document.cookie.indexOf("warning") != -1) {
    container.classList.remove("warn-act");    
}
if (document.querySelector(".warn")) {
    const apply = container.querySelector(".warn-but");
    apply.addEventListener("click",() =>{
    container.classList.remove("warn-act");
    document.cookie = "warning=true; max-age=2592000;path=/";
    });
}
});
/*Фрейм для авторизации*/
/*jQuery('#insheet').click(function (event) {
    event.stopPropagation();
   // event.preventDefault();
    let op=jQuery('.iframe');
    
    alert(jQuery(this.attr('id')));    
    op.attr('src','http://apiunatka/login/login-ya.html'); 
    if (op.attr('src') === 'http://apiunatka/login/login-ya.html') { //alert('YES');
            jQuery('#sheet div').hide();
            //jQuery('.js-secondButton').hide();
            }
     });*/

jQuery(function IframeOpenClose() {
    let needsrc =jQuery('.iframe');
    let messagenick = jQuery('#message-nick');
    let messagemail = jQuery('#message-ml'); 
    let messagegr = jQuery('#message-gr'); 
    let messagenmb = jQuery('#message-nmb');         
    let messagediv = jQuery('#resmessage');
    let supportdiv = jQuery('#forbutton');
    
    jQuery('.insheet').click(function() { 
        event.stopPropagation();
    let id = jQuery(this).attr('id');

    switch(id) {
    case'insheet':
     needsrc.attr('src','http://apiunatka/login/login-ya.html'); 
    break;
    case 'insheet-one':
   needsrc.attr('src','http://apiunatka/login/login-vk.html'); 

    break;
    case 'insheet-two':
         needsrc.attr('src','http://apiunatka/login/login.html'); 
    //alert(needsrc.attr('src'));
    break;
    default:
        needsrc.attr('src',''); 
            break;
    }

   if (needsrc.attr('src') !== "") {
    supportdiv.hide();
    jQuery('.js-close').hide(); 
    }
    
    
    jQuery(window).on("message", function(e) {
      let data = JSON.parse(e.originalEvent.data);
      messagenick.text(data.nicknameuser);
      messagemail.text(data.emailuser);
      messagegr.text(data.gruppa);
      messagenmb.text(data.number);            
      if(messagenick.text())
   if (messagediv.is(":hidden")) messagediv.show(); 
     
    });
   
         
 }); 
 
    jQuery('#messages').click(function() { 
   
    //if (supportdiv.is(":visible")) supportdiv.hide();
    document.cookie ="nicknameuser=" +messagenick.text()+ ";max-age=3600;"; 

    document.cookie ="gruppa=" +messagegr.text()+ ";max-age=3600;";
    if (document.cookie = "number=" +messagenmb.text()+ ";max-age=3600;") {       
    localStorage.setItem(messagenick.text(), messagemail.text());
    /*localStorage.setItem("nicknameuser", messagenick.text());
    localStorage.setItem("emailuser", messagemail.text());*/
    jQuery('#mask').fadeOut(700);    
   }
     


    });    
});
    /*
    /*jQuery('#leavecomment').attr("href","#openModal");
    jQuery('#leavecomment').text('Оставить комментарий');
    document.cookie="nicknameuser="+messagenick.text()+";max-age=3600;";
    jQuery(function OpDialog() {
    let localnick = localStorage.getItem("nicknameuser");//alert(localnick);
    if (localnick) {
    jQuery('#leavecomment').attr("href","#openModal").removeClass('js-secondButton').text('Оставить комментарий');
    }
    });*/ 
 /* jQuery('.js-closeiframe').click(function () {
    event.stopPropagation();
    jQuery(this).parent().fadeOut(700);
    needsrc.attr('src','');
    if (supportdiv.is(":hidden")) supportdiv.show();
    if (messagenick.text() !== "") messagenick.text("");
   });*/
 
 
/* своя раскраска кодов в статье
jQuery(function ChangeCode(event) {
event.stopPropagation;
jQuery('.language-html').css('position', 'relative').append('<p style="position:absolute; left:-10px; bottom:0;width:50px; height:30px;background-color: rgba(255,249,227,0.5);text-align: center; border-top: 1px solid lightgray; border-left:1px solid lightgray;border-right:1px solid lightgray;">HTML</p>');
jQuery('.language-css').css('position', 'relative').append('<p style="position:absolute; left:-10px; bottom:0;width:50px; height:30px;background-color: rgba(255,249,227,0.5);text-align: center;border-top: 1px solid lightgray; border-left:1px solid lightgray;border-right:1px solid lightgray;">CSS</p>');
jQuery('.language-php').css('position', 'relative').append('<p style="position:absolute; left:-10px; bottom:0;width:50px; height:30px;background-color: rgba(255,249,227,0.5);text-align: center;border-top: 1px solid lightgray; border-left:1px solid lightgray;border-right:1px solid lightgray;">PHP</p>');
});*/

/* получение гет-переменных из адресной строки
jQuery(function(){

   const paramsFromUrl=new URLSearchParams(window.location.search);
  
   let division = paramsFromUrl.get('division');
   let alias = paramsFromUrl.get('alias');
   let crossing = paramsFromUrl.get('crossing');

   jQuery('.js-div').val(division);
   jQuery('.js-al').val(alias);
   jQuery('.js-cr').val(crossing);
});*/
