(function() {
    tinymce.create('tinymce.plugins.WENbscolumns', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(ed, url) {
            ed.addButton('bscolumns-button', {
                title : "WEN's BootStrap Columns",
                cmd : 'bscolumns-button',
                image : url + '/bscolumns.png'                
            });

            ed.addCommand('bscolumns-button', function() {
                var number = prompt("How many columns do you want to show ( max 6) ? ") ,
                    shortcode;
                if (number !== null) {
                    number = parseInt(number);
                    if (number > 0 && number <= 6) { 
                        switch(number) {
                            case 2:
                                // shortcode = '<div class="row-fluid show-grid">';
                                    shortcode = '[bscolumns class="one_half"]Your Content Goes here[/bscolumns]';

                                    shortcode += '[bscolumns class="one_half_last_clear"]Your Content Goes here[/bscolumns]';
                                    shortcode += '[bscolumns class="clear"][/bscolumns]';
                                // shortcode += '</div>';
                                break;
                            case 3:
                                // shortcode = '<div class="row-fluid show-grid">';
                                    shortcode = '[bscolumns class="one_third"]Your Content Goes here[/bscolumns]';
                                    shortcode += '[bscolumns class="one_third"]Your Content Goes here[/bscolumns]';
                                    shortcode += '[bscolumns class="one_third_last"]Your Content Goes here[/bscolumns]';
                                    shortcode += '[bscolumns class="clear"][/bscolumns]';
                                // shortcode += '</div>';
                                break;
                            case 4:
                                // shortcode = '<div class="row-fluid show-grid">';
                                    shortcode = '[bscolumns class="one_fourth"]Your Content Goes here[/bscolumns]';
                                    shortcode += '[bscolumns class="one_fourth"]Your Content Goes here[/bscolumns]';
                                    shortcode += '[bscolumns class="one_fourth"]Your Content Goes here[/bscolumns]';
                                    shortcode += '[bscolumns class="one_fourth_last"]Your Content Goes here[/bscolumns]';
                                    shortcode += '[bscolumns class="clear"][/bscolumns]';
                                // shortcode += '</div>';
                                break;
                            case 5:
                                // shortcode = '<div class="row-fluid show-grid">';
                                    shortcode = '[bscolumns class="one_fifth"]Your Content Goes here[/bscolumns]';
                                    shortcode += '[bscolumns class="one_fifth"]Your Content Goes here[/bscolumns]';
                                    shortcode += '[bscolumns class="one_fifth"]Your Content Goes here[/bscolumns]';
                                    shortcode += '[bscolumns class="one_fifth"]Your Content Goes here[/bscolumns]';
                                    shortcode += '[bscolumns class="one_fifth_last"]Your Content Goes here[/bscolumns]';
                                    shortcode += '[bscolumns class="clear"][/bscolumns]';
                                // shortcode += '</div>';
                                break;
                            case 6:
                                // shortcode = '<div class="row-fluid show-grid">';
                                    shortcode = '[bscolumns class="one_sixth"]Your Content Goes here[/bscolumns]';
                                    shortcode += '[bscolumns class="one_sixth"]Your Content Goes here[/bscolumns]';
                                    shortcode += '[bscolumns class="one_sixth"]Your Content Goes here[/bscolumns]';
                                    shortcode += '[bscolumns class="one_sixth"]Your Content Goes here[/bscolumns]';
                                    shortcode += '[bscolumns class="one_sixth"]Your Content Goes here[/bscolumns]';
                                    shortcode += '[bscolumns class="one_sixth_last"]Your Content Goes here[/bscolumns]';
                                    shortcode += '[bscolumns class="clear"][/bscolumns]';
                                // shortcode += '</div>';
                                break;                            
                            default:
                                // shortcode = '<div class="row-fluid show-grid">';
                                    shortcode = '[bscolumns]Your Content Goes here[/bscolumns]';
                                // shortcode += '</div>';
                                break;
                        }                        
                        ed.execCommand('mceInsertContent', 0, shortcode);
                    }
                    else {
                        alert("The number value is invalid. It should be from 1 to 6.");
                    }
                }
            });
        },
 
        /**
         * Creates control instances based in the incomming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
         * method can be used to create those.
         *
         * @param {String} n Name of the control to create.
         * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
         * @return {tinymce.ui.Control} New control instance or null if no control was created.
         */
        createControl : function(n, cm) {
            /*
            if( 'bscolumns-list' == n ) {
                var bsc = cm.createListBox( 'bscolumns-list', {                    
                    title   : "WEN's BootStrap Columns",
                    onselect: function(v) {                                                                               
                        selected = tinyMCE.activeEditor.selection.getContent();
                        if( selected ) {
                            content = '[bscolumns class="' + v + '"]' + selected + '[/bscolumns]';
                        }else content= '[bscolumns class="' + v + '"][/bscolumns]';

                        tinymce.execCommand('mceInsertContent', false, content);                               
                    }
                });

                var bsc_shortcodes = [ 'one_half', 'one_half_last', 'one_third', 'one_third_last', 'one_fourth', 'one_fourth_last', 'one_fifth', 'one_fifth_last', 'one_sixth', 'one_sixth_last' ];
                for( var i in bsc_shortcodes ) {
                    var title = bsc_shortcodes[i].replace( '_', ' ' ); alert(title);
                    title = title.charAt(0).toUpperCase() + title.slice(1).toLowerCase()
                    bsc.add( title, bsc_shortcodes[i] );
                }

                return bsc;
            }
            */

            return null;
        },
 
        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo : function() {
            return {
                longname : "WEN's BootStrap Columns",
                author : 'The Web Experts Nepal Team',
                authorurl : 'http://webexpertsnepal.com/our-team',
                infourl : 'http://demo.webexpertsnepal.com',
                version : "2.0.1.3"
            };
        }
    });
 
    // Register plugin
    tinymce.PluginManager.add( 'bscolumns', tinymce.plugins.WENbscolumns );
})();