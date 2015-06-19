$(function(){
    $('#tfe_librairiebundle_livre_ajout_format').autocomplete({
        source: function(requete, reponse){
            var motcle = $('#tfe_librairiebundle_livre_ajout_format').val();
            $.ajax({
                type:"GET",
                url : "../../../../../src/TFE/LibrairieBundle/Controller/",
                dataType : 'json',
                data : {'motcle': motcle},

                success : function(donnee){
                    reponse($.map(donnee, function(object){
                        return object['nomFormat'];
                    }));
                }
            });
        },
        minLength : 3
    });
});