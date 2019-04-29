
  $( "#uvjet" ).autocomplete({
    source: putanja + "gledatelj/traziGledatelj",
    minLength: 1,
    focus: function(event,ui){
      event.preventDefault();
    },
    select:function(_event,ui){
      spremi(ui.item);
    }
  }).data("ui-autocomplete")._renderItem=function(ul,objekt){
      return $("<li>" + objekt.ime + " " + objekt.prezime  + " " + objekt.telefon  + " " + objekt.eMail + "</li>").appendTo(ul);
  };

  function spremi(gledatelj){

    $.ajax({
      type: "POST",
      url: putanja + "sjedalo/edit",
      data: "sjedalo=" + sifraSjedalo + "&gledatelj=" + gledatelj.sifra + "&dogadaj=" + sifraDogadaj,
      success: function(){
        
          $("#podaci").append(
            "<tr>" + 
              "<td>" + gledatelj.ime + " " + gledatelj.prezime + "</td>" +
           "</tr>");
        }
      });

  }

  function definirajBrisanje(){
    $(".obrisi").click(function(){
      //console.log($(this).attr("id"));
      //let id = $(this).attr("id");
      //let sifraPolaznika = id.split("_")[1];
      //console.log(sifraPolaznika);
      let a = $(this);
      $.ajax({
        type: "POST",
        url: putanja + "sjedalo/obrisiGledatelja",
        data: "sjedalo=" + sifrasjedalo +"&gledatelj=" + a.attr("id").split("_")[1],
        success: function(vratioServer){
          if(vratioServer==="OK"){
           a.parent().parent().remove();
          }else{
            alert(vratioServer);
          }
        }
      });
  
  
    });  
  }
  definirajBrisanje();
