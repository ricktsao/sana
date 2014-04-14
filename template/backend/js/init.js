// JavaScript Document

$(function(){
	$('#dataTable > tbody > tr:odd ').addClass('tr_odd');			   
	contentResize();
	$(window).resize(function(){
		contentResize();
	})	
	
	$('.btn').append('<div></div>');	
})


function contentResize(){
	var h=$(window).height()-$('#header').height()-$('#footer').height()-53;
	var secondaryHeight=$('#secondary').height();
	if(h>secondaryHeight){		
		$('#container').css('min-height',h);		
	}else{		
		$('#container').css('min-height',secondaryHeight);		
	}
}