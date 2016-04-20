
$("#rating").raty(
{
    half: true,
    click: function(score, evt)
    {
    var id = $(this).attr('data-id');

    $.ajax
    ({
        type:'POST',
        url:"../controllers/ratingAjax.php",
        data:
        {
            id: id,
            score: score
        },
        success:function(data)
        {
            $(this).raty("reload");
        },
        error:function(erreur)
        {
            alert("Une erreur est survenu : "+erreur);
        }
    });
    },
    score: function()
    {
    return $(this).attr('data-score');
    }
});

function removeCat(id, cat)
{
  var r = confirm("Voulez vous vraiment continuer ?");
  if (r == true)
  {
    $.ajax
    ({
        type:'POST',
        url:"../controllers/removeAjax.php",
        data:
        {
            id: id,
            name: cat
        },
        success:function()
        {   
            $("#"+cat+"-"+id).hide('slow', function(){$("#"+cat+"-"+id).remove(); });
        },
        error:function()
        {
             alert("Une erreur est survenu");
        }
    });
  }
}

function removeUser(id)
{
  var r = confirm("Voulez vous vraiment continuer ?");
  if (r == true)
  {
    $.ajax
    ({
        type:'POST',
        url:"../controllers/removeUser.php",
        data:
        {
            id: id
        },
        success:function()
        {
            $("#user-"+id).hide('slow', function(){$("#user-"+id).remove(); });
        },
        error:function()
        {
             alert("Une erreur est survenu");
        }
    });
  }
}


function addCat(name)
{
    var value = $("#"+name+"-input-name").val();

    if (name == "sp")
        var epsg = $("#"+name+"-input-epsg").val();

    $.ajax
    ({
        type:'POST',
        url:"../controllers/addAjax.php",
        data:
        {
          name: name,
          value: value,
          epsg: epsg
        },
        success:function(data)
        {
            $("#modal-"+name).hide("slow");
            location.reload();         
        },
        error:function(error)
        {
            alert("Une erreur est survenu : "+error);
        }
    });
}

function addComm()
{
    var value = $("#input-comm").val();
    var id_provider = $("#input-comm").data("provider");
    var id_user = $("#input-comm").data("user");

    $.ajax
    ({
        type:'POST',
        url:"../controllers/addComm.php",
        data:
        {
          value: value,
          id_user: id_user,
          id_provider: id_provider
          
        },
        success:function(data)
        {
            //$("#modal-"+name).hide("slow");
            location.reload();         
        },
        error:function(error)
        {
            alert("Une erreur est survenu : "+error);
        }
    });
}

$("#form-search > select").change(function()
{
    var e = $("#echelle").val();
    var t = $("#theme").val();
    var sp = $("#sp").val();

    $("#table-result tr").each(function(index, element)
    {
        if (index > 0)
        {
            $elemTh = $(element).data("theme").split(',');

            if (($(element).data("echelle") == e || e == 0) && ($(element).data("sp") == sp || sp == 0) && ($elemTh.indexOf(t) != -1 || t == 0))
                $(element).show("slow");
            else
                $(element).hide("slow");
        }
    });
});

$("#table-result .btn-danger").click(function()
{
    confirm("Vous êtes sur le point de supprimer la fiche d'une organisation, êtes-vous sûr de vouloir continuer ?");
});















$.widget( "custom.catcomplete", $.ui.autocomplete, {
    _create: function() {
      this._super();
      this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
    },
    _renderMenu: function( ul, items ) {
      var that = this,
        currentCategory = "";
      $.each( items, function( index, item ) {
        var li;
        if ( item.category != currentCategory ) {
          ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
          currentCategory = item.category;
        }
        li = that._renderItemData( ul, item );
        if ( item.category ) {
          li.attr( "aria-label", item.category + " : " + item.label );
        }
      });
    }
  });


$( "#search-input" ).catcomplete({
      source: function( request, response ) {
        $.ajax({
          url: "../controllers/autocomplete.php",
          dataType: "json",
          data: {
            q: request.term
          },
          success: function( data ) {
            response( data );
          }
        });
      },
      minLength: 0,
      select: function( event, ui ) {
        log( ui.item ?
          "Selected: " + ui.item.label :
          "Nothing selected, input was " + this.value);
      },
      open: function() {
        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    });