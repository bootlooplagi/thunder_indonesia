
  //AUTOCOMPLETE
var countries = [];

$.post(URL+'transaksi/getuser').done(function(data){
    var res = JSON.parse(data);
    $.each(res,function(index,item){
        // console.log(item.name);
        countries.push({
            id:item.id,
            name:item.name
        });
    });
    
});


function autocomplete(inp, arr) {    
    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    var currentFocus;
    var match = 0;
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function(e) {
        match = 0;

        var a, b, i, val = this.value;
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) { return false;}

        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);

        /*for each item in the array...*/
        
        for (i = 0; i < arr.length; i++) {
          /*check if the item starts with the same letters as the text field value:*/
          if (arr[i].name.substr(0, val.length).toUpperCase() == val.toUpperCase()) {
            /*create a DIV element for each matching element:*/
            if(arr[i].name.toUpperCase()==val.toUpperCase()){
                match = 1;
                var id_free = arr[i].id;

                // setTimeout(function(){
                $('#submit_ac').attr({
                    "class":"btn-success",
                    "value":"Pilih",
                    "onclick":"pilih_freelance("+id_free+",$('#myInput').val(),$('#submit_ac').attr('id-pem'))"
                }).css("backgroundColor","green");
                    
                // });
            }

            b = document.createElement("DIV");
            /*make the matching letters bold:*/
            b.innerHTML = "<strong>" + arr[i].name.substr(0, val.length) + "</strong>";
            b.innerHTML += arr[i].name.substr(val.length);
            /*insert a input field that will hold the current array item's value:*/
            b.innerHTML += "<input type='hidden' value='" + arr[i].name + "'>";
            b.innerHTML += "<input type='hidden' value='" + arr[i].id + "'>";
            /*execute a function when someone clicks on the item value (DIV element):*/
            b.addEventListener("click", function(e) {
                
                /*insert the value for the autocomplete text field:*/
                inp.value = this.getElementsByTagName("input")[0].value;
                var id = this.getElementsByTagName("input")[1].value;
                
                /*close the list of autocompleted values,
                (or any other open lists of autocompleted values:*/
                setTimeout(function(){
                    $('#submit_ac').attr({
                        "class":"btn-success",
                        "value":"Pilih",
                        "onclick":"pilih_freelance("+id+",$('#myInput').val(),$('#submit_ac').attr('id-pem'))"
                    }).css("backgroundColor","green");
                    
                });

                closeAllLists();
            });
            a.appendChild(b);
          }else{
            if(match==0){
                $('#submit_ac').attr({
                    "class":"btn-primary",
                    "value":"Tambahkan",
                    "onclick":"add_freelance_to_dialog($('#myInput').val(),$('#submit_ac').attr('id-pem'))"
                }).css("backgroundColor","#367fa9")  ;
            }
            // setTimeout(function(){
            // });
          }
        }
    });
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function(e) {
        
        setTimeout(function(){
          if($('#myInput').val()==''){
              $('#submit_ac').hide();
          }else{
              $('#submit_ac').show();
          }
        },10);
        if(arr.length>0){
            
        
        
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) {
              x = x.getElementsByTagName("div");
            }

            if (e.keyCode == 40) {
              /*If the arrow DOWN key is pressed,
              increase the currentFocus variable:*/
              currentFocus++;
              /*and and make the current item more visible:*/
              addActive(x);
            } else if (e.keyCode == 38) { //up
              /*If the arrow UP key is pressed,
              decrease the currentFocus variable:*/
              currentFocus--;
              /*and and make the current item more visible:*/
              addActive(x);
            } else if (e.keyCode == 13) {
              /*If the ENTER key is pressed, prevent the form from being submitted,*/
              e.preventDefault();
              if (currentFocus > -1) {
                /*and simulate a click on the "active" item:*/
                if (x) x[currentFocus].click();
              }
            }
        }else{
            $('#submit_ac').attr({
                    "class":"btn-primary",
                    "value":"Tambahkan",
                    "onclick":"add_freelance_to_dialog($('#myInput').val(),$('#submit_ac').attr('id-pem'))"
                }).css("backgroundColor","#367fa9")  ;
                
        }
    });
    function addActive(x) {
      /*a function to classify an item as "active":*/
      if (!x) return false;
      /*start by removing the "active" class on all items:*/
      removeActive(x);
      if (currentFocus >= x.length) currentFocus = 0;
      if (currentFocus < 0) currentFocus = (x.length - 1);
      /*add class "autocomplete-active":*/
      x[currentFocus].classList.add("autocomplete-active");
    }
    function removeActive(x) {
      /*a function to remove the "active" class from all autocomplete items:*/
      for (var i = 0; i < x.length; i++) {
        x[i].classList.remove("autocomplete-active");
      }
    }
    function closeAllLists(elmnt) {
      /*close all autocomplete lists in the document,
      except the one passed as an argument:*/
      var x = document.getElementsByClassName("autocomplete-items");
      for (var i = 0; i < x.length; i++) {
        if (elmnt != x[i] && elmnt != inp) {
          x[i].parentNode.removeChild(x[i]);
        }
      }
    }
    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {

        closeAllLists(e.target);
    });
}

autocomplete(document.getElementById("myInput"), countries);
//==================================