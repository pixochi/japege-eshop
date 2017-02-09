  $(function(){
                        $.getJSON( "../../../assets/scripts/public/countries.json", function( data ) {  
                            $.each( data, function(index,country) {
                             $("#country").append("<option value='"+country.code+"'>"+country.name+"</option>");
                            });

                         locale = Cookies.get("locale") ? Cookies.get("locale") : "";
                         country_code = locale.substr(locale.length -2, locale.length).toUpperCase();
                         has_locale = false, has_country = false;

                         country_customer = "<?= ucfirst($address['country']); ?>";
                        if(country_customer.length > 0){
                            has_country = true;
                            $("#country").find("option:selected").attr("selected",false);
                             $("#country").find("option[value="+country_customer+"]").attr("selected",true);
                        } 
                         if(!has_country && country_code.length > 0){
                            $("#country").find("option:selected").attr("selected",false);
                            $("#country").find("option[value="+country_code+"]").attr("selected",true);
                            has_locale = true;
                        } 

                        if(!has_country && !has_locale) {
                            $("#country").find("option:selected").attr("selected",false);
                            $("#country").find("option[value=DK]").attr("selected",true);
                        }
                        });
                    });