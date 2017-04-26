var AJAX = {
    $: function(method, page, callback, contenttype="application/x-www-form-urlencoded", mode=true){
        console.log(method+" "+callback+" "+mode);
        var xhr = new XMLHttpRequest(method, page, mode);
        xhr.setRequestHeader("Content-type", contenttype);
        xhr.onreadystatechange = function(){
            if(xhr.readyState==4 && xhr.status==200){
                console.log(xhr.responseText);
            }
        }
        xhr.send("name=bob&age=17");
    },
};