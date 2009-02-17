/*  
    EP_Tools (Eros Pedrini Tools) Thickbox Valdation Fix (js lib)

    This javascript fixs some bugs of the thickbox library and with the provided
    css files permits to validate correctly the thickbox library.
    
    Coded by Eros Pedrini   (mailto: contezero74@yahoo.it)
    
    Version: 1.3
    

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
    
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function getHeight() {
    var h = 0;

    if (typeof(window.innerHeight) == "number") {
        h = window.innerHeight;
    } else {
        if (document.documentElement && document.documentElement.clientHeight) {
            h = document.documentElement.clientHeight;
        } else {
            if (document.body && document.body.clientHeight) {
                h = document.body.clientHeight;
            }
        }
    }

    return h;
}


jQuery(document).ready(function(){      
    jQuery('a.thickbox, area.thickbox, input.thickbox').click(function(){
        jQuery('.TB_overlayBG').css({'filter':'alpha(opacity=75)', '-moz-opacity':'0.75', 'opacity':'0.75'});    // lines 41  - 43
        jQuery('#TB_HideSelect').css({'filter':'alpha(opacity=0)', '-moz-opacity':'0', 'opacity':'0'});          // lines 154 - 156
        jQuery('#TB_iframeContent').css({'_margin-bottom':'1px'});                                              // line  175
        
        var isMSIE6 = jQuery.browser.msie && /MSIE 6\.0/i.test(window.navigator.userAgent) && !/MSIE 7\.0/i.test(window.navigator.userAgent);
        
        // IE 6 hacks
        if (isMSIE6) {
            var Height_0 = document.body.scrollHeight > document.body.offsetHeight ? document.body.scrollHeight : document.body.offsetHeight + 'px'
            jQuery('#TB_overlay').css({'height':Height_0});                                                     // line  50
            
            var MarginTop_0 = 0 - parseInt(this.offsetHeight / 2) + (TBWindowMargin = document.documentElement && document.documentElement.scrollTop || document.body.scrollTop) + 'px';
            jQuery('#TB_window').css({'margin-top':MarginTop_0});                                               // line  69
            
            var MarginTop_1 = 0 - parseInt(this.offsetHeight / 2) + (TBWindowMargin = document.documentElement && document.documentElement.scrollTop || document.body.scrollTop) + 'px';
            jQuery('#TB_load').css({'margin-top':MarginTop_1});                                                 // line  142
            
            var Height_1 = document.body.scrollHeight > document.body.offsetHeight ? document.body.scrollHeight : document.body.offsetHeight + 'px';
            jQuery('#TB_HideSelect').css({'height':Height_1});                                                  // line  165
        }
        
        var TB_HEIGHT = getHeight() - 50; // 50px seems to work in all most cases        
        if (!isMSIE6) {
            jQuery("#TB_window").css({marginTop: '-' + parseInt((TB_HEIGHT / 2),10) + 'px'});
        }
        
        return false;
    });
});