(function ($) {
  'use strict';

  $(document).ready(function(){

     // CSS EDITOR 
    var cssEditorTargetId = "single_custom_css";
    if ( $('#main_custom_css').length > 0 )
      cssEditorTargetId = "main_custom_css";

    var editor = ace.edit(cssEditorTargetId + "_ace");
    var textarea = $('#' + cssEditorTargetId);

    if ( $('.wpacc_editor_dark').length > 0 )
      editor.setTheme("ace/theme/tomorrow_night");

    editor.session.setMode("ace/mode/css");
    editor.setOptions({
      fontSize: 14,
      tabSize: 2
    });

    editor.getSession().setValue(textarea.val());
    editor.getSession().on('change', function(){
      textarea.val(editor.getSession().getValue());
    });

    $('.wccj_csseditor_container').resizable({
      maxHeight: 2000,
      minHeight: 300,
      handles: 's',
      resize: function( event, ui ) {
        editor.resize();
      }
    });


  // JS EDITOR 
    var jsEditorTargetId = "single_custom_js";
    if ( $('#main_custom_css').length > 0 )
      jsEditorTargetId = "main_custom_css";

    var editor = ace.edit(jsEditorTargetId + "_ace");
    var textarea = $('#' + jsEditorTargetId);

    if ( $('.wpacc_editor_dark').length > 0 )
      editor.setTheme("ace/theme/tomorrow_night");

    editor.session.setMode("ace/mode/css");
    editor.setOptions({
      fontSize: 14,
      tabSize: 2
    });

    editor.getSession().setValue(textarea.val());
    editor.getSession().on('change', function(){
      textarea.val(editor.getSession().getValue());
    });

    $('.wccj_jsseditor_container').resizable({
      maxHeight: 2000,
      minHeight: 300,
      handles: 's',
      resize: function( event, ui ) {
        editor.resize();
      }
    });













  });

})(jQuery);
