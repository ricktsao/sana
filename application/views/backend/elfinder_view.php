<? $templateUrl=base_url()."/template/backend/"?>
<!--jquery-->
<script src="<? echo $templateUrl?>js/jquery.js" ></script>
<!--jquery ui-->
<script src="<? echo $templateUrl?>js/jquery-ui-1.8.18.custom.min.js"></script>
<link href="<? echo $templateUrl?>js/ui-themes/smoothness/jquery-ui-1.8.18.custom.css" rel="stylesheet" type="text/css" />
<!--elfinder-->
<link rel="stylesheet" type="text/css" media="screen" href="<? echo $templateUrl?>js/elfinder/css/elfinder.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="<? echo $templateUrl?>js/elfinder/css/theme.css">
<script type="text/javascript" src="<? echo $templateUrl?>js/elfinder/elfinder.min.js"></script>
<script type="text/javascript" src="<? echo $templateUrl?>js/elfinder/i18n/elfinder.zh_CN.js"></script>
<!--tiny mce-->
<script type="text/javascript" src="<? echo $templateUrl?>js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<? echo $templateUrl?>js/tiny_mce/tiny_mce_popup.js"></script>
<!-- -->



<script type="text/javascript">

  var tinymce;
  var FileBrowserDialogue = {
    init: function() {
      // Here goes your code for setting your custom things onLoad.
    },
    mySubmit: function (URL) {
      var win = tinyMCEPopup.getWindowArg('window');

      // pass selected file path to TinyMCE
      win.document.getElementById(tinyMCEPopup.getWindowArg('input')).value = URL;

      // are we an image browser?
      if (typeof(win.ImageDialog) != 'undefined') {
        // update image dimensions
        if (win.ImageDialog.getImageData) {
          win.ImageDialog.getImageData();
        }
        // update preview if necessary
        if (win.ImageDialog.showPreviewImage) {
          win.ImageDialog.showPreviewImage(URL);
        }
      }

      // close popup window
      tinyMCEPopup.close();
    }
  }

  tinyMCEPopup.onInit.add(FileBrowserDialogue.init, FileBrowserDialogue);

  $().ready(function() {
    var elf = $('#elfinder').elfinder({
      // set your elFinder options here
      url: '<?php echo getBackendUrl("loadElfinder");?>',  // connector URL
      getFileCallback: function(url) { // editor callback
        FileBrowserDialogue.mySubmit(url); // pass selected file path to TinyMCE 
      }
    }).elfinder('instance');      
  });
</script>


<div id="elfinder"></div>
