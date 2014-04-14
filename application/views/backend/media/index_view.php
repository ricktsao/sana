<script type="text/javascript" charset="utf-8">
	$().ready(function() {
		var elf = $('#elfinder').elfinder({			
			url : '<?php echo bUrl("loadElfinder");?>'  // connector URL (REQUIRED)
			//,lang: 'zh-tw'             // language (OPTIONAL)
		}).elfinder('instance');			
	});
</script>





<script type="text/javascript">

  	

  /*$().ready(function() {
    var elf = $('#elfinder').elfinder({
      // set your elFinder options here
      url: 'php/connector.php',  // connector URL
      getFileCallback: function(url) { // editor callback
        FileBrowserDialogue.mySubmit(url); // pass selected file path to TinyMCE 
      }
    }).elfinder('instance');      
  });*/
</script>


<div id="elfinder"></div>
