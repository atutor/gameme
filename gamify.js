$(document).ready(function(){
        if($("div[role='tabpanel'], panel1").attr("aria-hidden") == "false"){
            $("#tab1").addClass("active");
            $("#panel1").attr("aria-hidden", "false");
        } 
        //} 
/*        if($("div[role='tabpanel'], panel2").attr("aria-hidden") == "false"){
            $("#tab2").addClass("active");
        } 
        if($("div[role='tabpanel'], panel3").attr("aria-hidden") == "false"){
            $("#tab3").addClass("active");
        } 
*/
     $("#tab1").click(function(){
            $("#tab2").removeClass("active");
            $("#tab3").removeClass("active");
            $("#tab1").addClass("active");
            $("#panel2").attr("aria-hidden","true");
            $("#panel3").attr("aria-hidden","true");
            $("#panel1").attr("aria-hidden","false");
        });
       $("#tab2").click(function(){
            $("#tab1").removeClass("active");
            $("#tab3").removeClass("active");
            $("#tab2").addClass("active");
            $("#panel1").attr("aria-hidden","true");
            $("#panel3").attr("aria-hidden","true");
            $("#panel2").attr("aria-hidden","false");
        });
        $("#tab3").click(function(){
            $("#tab1").removeClass("active");
            $("#tab2").removeClass("active");
            $("#tab3").addClass("active");
            $("#panel1").attr("aria-hidden","true");
            $("#panel2").attr("aria-hidden","true");
            $("#panel3").attr("aria-hidden","false");
        });
        $("#tab1").keydown(function(){
            $("#tab2").removeClass("active");
            $("#tab3").removeClass("active");
            $("#tab1").addClass("active");
            $("#panel2").attr("aria-hidden","true");
            $("#panel3").attr("aria-hidden","true");
            $("#panel1").attr("aria-hidden","false");
        });
       $("#tab2").keydown(function(){
            $("#tab1").removeClass("active");
            $("#tab3").removeClass("active");
            $("#tab2").addClass("active");
            $("#panel1").attr("aria-hidden","true");
            $("#panel3").attr("aria-hidden","true");
            $("#panel2").attr("aria-hidden","false");
        });
        $("#tab3").keydown(function(){
            $("#tab1").removeClass("active");
            $("#tab2").removeClass("active");
            $("#tab3").addClass("active");
            $("#panel1").attr("aria-hidden","true");
            $("#panel2").attr("aria-hidden","true");
            $("#panel3").attr("aria-hidden","false");
        });
        
        //$(this).attr("aria-selected","true");
        //  $(this).attr("tabindex","0");
        //var tabpanid= $(this).attr("aria-controls");
        //var tabpan = $("#"+tabpanid);
        //$("div[role='tabpanel']:not(tabpan)").attr("aria-hidden","true");
        //$("div[role='tabpanel']:not(tabpan)").addClass("hidden");

        //tabpan.removeClass("hidden");
        //tabpan.className = "panel";
        //tabpan.attr("aria-hidden","false");		
      });
  
      //This adds keyboard accessibility by adding the enter key to the basic click event.
/*
      $("li[role='tab']").keydown(function(ev) {
        if (ev.which ==13) {
            $(this).click();
            }
        }); 
        */
/* 
      //This adds keyboard function that pressing an arrow left or arrow right from the tabs toggel the tabs. 
       $("li[role='tab']").keydown(function(ev) {
            if ((ev.which ==39)||(ev.which ==37))  {
                var selected= $(this).attr("aria-selected");
                    if  (selected =="true"){
                        $("li[aria-selected='false']").attr("aria-selected","true").focus() ;
                        $(this).attr("aria-selected","false");

                        var tabpanid= $("li[aria-selected='true']").attr("aria-controls");
                        var tabpan = $("#"+tabpanid);
                        $("div[role='tabpanel']:not(tabpan)").attr("aria-hidden","true");
                        $("div[role='tabpanel']:not(tabpan)").addClass("hidden");

                        tabpan.attr("aria-hidden","false");
                        tabpan.removeClass("hidden");
                        //tabpan.className = "panel";
                }
            }
    }); 
    */
    // go back to previously select tab panel
    var tab = getUrlVars()["tab"];
    if(tab >1){
        $("#tab"+tab).attr("aria-selected","true").focus();
        $("#panel"+tab).attr("aria-hidden","false");
        $("#tab1").attr("aria-selected","false");
        $("#panel1").attr("aria-hidden","true");
    }
    function getUrlVars(){
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }
    
    function saveEvent(editableObj,column,id) {
	//$(editableObj).css("background","#FFF url(loaderIcon.gif) no-repeat right");
        $.ajax({
            url: "save_event.php",
            type: "POST",
            data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
            success: function(data){
                $(editableObj).css("background","#FDFDFD");
            }        
        });
    }
//}); 