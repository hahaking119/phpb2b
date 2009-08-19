var Tab={
    para:"c",
    showNum:0,
    init:function(){
        var c=getRequest();
        if(c[Tab.para]=='0'||c[Tab.para]=='2'||c[Tab.para]=='3'||c[Tab.para]=='1')
            Tab.change(c[Tab.para]);
    },
    change:function(i){
            $("li_tab"+Tab.showNum).className="";
            $("li_tab"+i).className="hsearch_title_now";
            $("div_cont"+Tab.showNum).style.display="none";
            $("div_cont"+i).style.display="";
            Tab.showNum=i;
    }
}