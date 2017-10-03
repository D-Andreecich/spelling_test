
    tinymce.create("tinymce.plugins.green_button_plugin", {

        //url argument holds the absolute url of our plugin directory
        init : function(ed, url) {

            //add new button     
            ed.addButton("green", {
                title : "Add spelling test",
                cmd : "green_command",
                image : "https://cdn3.iconfinder.com/data/icons/softwaredemo/PNG/32x32/Circle_Green.png"
            });

            //button functionality.
            ed.addCommand("green_command", function() {
                //var selected_text = ed.selection.getContent();
                var insert_text = "<span style='color: red'>[spelling_test test=?]</span>";
                ed.execCommand("mceInsertContent", 0, insert_text);
            });

        },

        createControl : function(n, cm) {
            return null;
        },

        getInfo : function() {
            return {
                longname : "Extra Buttons",
                author : "",
                version : "1"
            };
        }
    });

    tinymce.PluginManager.add("green_button_plugin", tinymce.plugins.green_button_plugin);
