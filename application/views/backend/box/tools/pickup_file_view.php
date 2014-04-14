<?php
if ( ! is_array($elements))
{
	$elements["no"] = "1";
	$elements["field_name"] = "filename";
}
?>
<script type="text/javascript">
	$().ready(function() {    
	    $('#open_media<?php echo $elements["no"];?>').click(function() 
	    {   
		    load_elfinder<?php echo $elements["no"];?>();		    
	    })	  
	    
	    
	    $('#del_img<?php echo $elements["no"];?>').click(function() 
	    {   
	       $('#filename<?php echo $elements["no"];?>').val('');
	       $('#thumb<?php echo $elements["no"];?>').hide();
	       $('#del_img<?php echo $elements["no"];?>').hide();
	    })  
	});


	function load_elfinder<?php echo $elements["no"];?>(id) {
	
	    var opt = {      // Must change variable name elfinder onlyMimes
	    url : '<?php echo getBackendUrl("loadelfinder");?>',
	    lang : 'en',

	    closeOnEditorCallback : true,
	    docked : false,
	    dialog : { title : 'File Manager', height: 500 },
	    
	    
        onlyMimes: ["image"],
        resizable: false
	    
	    }
	
	
	    $('div#main_window<?php echo $elements["no"];?>').dialog({
	        modal: true,
	        width: "60%",
	        title: "Images OverView"
	    }).
	    elfinder({
	        //lang:'ru',//Select lang
	        url: '<?php echo getBackendUrl("loadelfinder");?>',
	        onlyMimes: ["image"],
	        // display all images
	        getFileCallback: function (url) {
	            $('#filename<?php echo $elements["no"];?>').val(url);
	            $('#thumb<?php echo $elements["no"];?>').attr("src", url).show();
				$("#del_img<?php echo $elements["no"];?>").show();	
	            $('a.ui-dialog-titlebar-close[role="button"]').click()
	        },
	        resizable: false
	    }).elfinder('instance')
	}

</script>

<input id="filename<?php echo $elements["no"];?>" type="hidden" name="<?php echo $elements["field_name"];?>" value="" />
<input id="open_media<?php echo $elements["no"];?>" type="button" value="browse" />
<input id="del_img<?php echo $elements["no"];?>" type="button" value="delete" style="display: none" />
<div><img id="thumb<?php echo $elements["no"];?>" style='display:none'></div>
<div id="main_window<?php echo $elements["no"];?>"></div>
