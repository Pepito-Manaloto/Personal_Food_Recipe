baseUrl = "http://192.168.1.101:8080/Recipe";

function navigationBarActions()
{
    $("#recipeLink, #recipeNavList").hover(
                            function()
                            {
                                $("#recipeNavList").css("display", "block");
                            },
                            function()
                            {
                                $("#recipeNavList").css("display", "none");
                            });     
                            
    $("#ingredientLink, #ingredientNavList").hover(
                            function()
                            {
                                $("#ingredientNavList").css("display", "block");
                            },
                            function()
                            {                   
                                $("#ingredientNavList").css("display", "none");
                            }); 
    $("#nameLink, #nameNavList").hover(
                            function()
                            {
                                $("#nameNavList").css("display", "block");      
                                $("#nameLink img").attr("src", baseUrl + "/images/chef_hat_hover.png");    
                            },
                            function()
                            {
                                $("#nameNavList").css("display", "none");
                                $("#nameLink img").attr("src", baseUrl + "/images/chef_hat.png");
                            });                         
}

function createSpanTab(text)
{
    var span = document.createElement('span');
    var textNode = document.createTextNode(text);
    span.className = 'spanTab handle';
    span.appendChild(textNode);

    return span;
}

function createIngredientSet()
{
    var div = document.createElement('div');
    var quantity = document.createElement('input');
    var measurement = document.createElement('input');
    var ingredient = document.createElement('input');
    var comment = document.createElement('input');
    var remove = document.createElement('input');
    
    div.className = 'ingredientsDiv';
    
    quantity.type = 'text';
    quantity.name = 'quantities[]';
    quantity.className= 'quantityField';
    
    measurement.type = 'text';
    measurement.name = 'measurements[]';
    measurement.className= 'measurementField';
    
    ingredient.type = 'text';
    ingredient.name = 'ingredients[]';
    ingredient.className= 'ingredientField';
    
    comment.type = 'text';
    comment.name = 'comments[]';
    comment.className= 'commentField';
    
    remove.type = 'button';
    remove.value = '-';
    remove.className = 'addremoveButton removeIngredient';

    div.appendChild(quantity);
    div.appendChild(measurement);
    div.appendChild(ingredient);
    div.appendChild(comment);
    div.appendChild(remove);
    
    return div;
}

function createInstructionSet()
{
    var div = document.createElement('div');
    var instructions = document.createElement('textarea');
    var remove = document.createElement('input');
    
    div.className = 'instructionsDiv';
    instructions.name = 'instructions[]';
    instructions.cols = '35';
    instructions.rows = '5';
    remove.type = 'button';
    remove.value = '-';
    remove.className = 'addremoveButton removeInstruction';
            
    div.appendChild(instructions);
    div.appendChild(remove);

    return div;
}

function createEditRecipeActions()
{
    $("body").on("click", ".removeIngredient, .removeInstruction",
                                            function()
                                            {       
                                                $(this).parent().nextAll().each(function(index) // Edit its succeeding next parents' count label, reduce by one.
                                                    {
                                                        var span = $(this).find("span");
                                                        var newCount = Number(span.text()) -1;

                                                        $(this).find("span").text(newCount);
                                                    });
                                                    
                                                $(this).parent().remove();
                                            }
                                        );  
                                        
    $("body").on("blur", ".quantityField, .measurementField, .ingredientField, .commentField",
                                function()
                                {                   
                                    if( $.trim($(this).val()) == "" )
                                    {
                                        name = $(this).attr("name").substring( 0, $(this).attr("name").length - 3 ); // Remove "s[]" from the name attrib of the field.
                                        
                                        if( name == "quantitie" )
                                        {
                                            name = "quantity";
                                        }
                                        
                                        $(this).css("font-style", "italic");
                                        $(this).val( name );
                                        $(this).css("color", "gray");
                                    }
                                    
                                }
                            );                                  
    $("body").on("focus", ".quantityField, .measurementField, .ingredientField, .commentField",
                                function()
                                {   
                                    name = $(this).attr("name").substring(0, $(this).attr("name").length - 3); // Remove "s[]" from the name attrib of the field.
                                    if( name == "quantitie" )
                                    {
                                        name = "quantity";
                                    }

                                    if( $(this).val() == name )
                                    {
                                        $(this).val("");
                                        $(this).css("font-style", "normal");
                                        $(this).css("color", "black");
                                    }
                                }
                            );

    $("#addIngredient").click(function()
                {        
                    $("#ingredientsContainer").append(createIngredientSet()); // Create the div element first.

                    var ingredientsCount = $("#ingredientsContainer").children().length;
                    $("#ingredientsContainer").children().last().prepend(createSpanTab(ingredientsCount)); // Prepend to last inserted div

                    $(".quantityField, .measurementField, .ingredientField, .commentField").blur();
                }); 
    $("#addInstruction").click(function()
                {
                    $("#instructionsContainer").append(createInstructionSet());  // Create the div element first.

                    var instructionsCount = $("#instructionsContainer").children().length;
                    $("#instructionsContainer").children().last().prepend(createSpanTab(instructionsCount)); // Prepend to last inserted div
                });

    $("#ingredientsContainer, #instructionsContainer").sortable(
                    {
                        axis: "y",
                        handle: ".handle",
                        placeholder: "draggablePlaceholder",
                        forcePlaceholderSize: true,
                        update: function(event, ui) // Only executes once, if DOM position has changed.
                                {   
                                    $(this).children().each(function(index) // Iterates through each div in the container and updates its count span text
                                    {
                                        var newCount = index + 1;
                                        $(this).find("span").text(newCount);
                                    });
                                },
                    });
}

function profileEvents()
{
    $("#editProfileShadow, #editProfileExitButton").click(function(e)
                        {
                            e.preventDefault();

                            $("#editProfileDiv, #editProfileShadow").hide();
                            
                            return false;
                        });

    $("#profileEditLink").click(function(e)
                    {
                        e.preventDefault();
                        console.log(123);
                        $("#editProfileDiv, #editProfileShadow").show();
                        
                        return false;
                    });

    $("#profileExpandLink").click(function(e)
                    {
                        e.preventDefault();

                        $("#profileRecipeList").toggle();
                        
                        return false;
                    });
}

/*Global variables*/
var sortCategory = "All";
var orderBy = "Asc";
var typeParam = getUrlParam("type");
var pageParam = getUrlParam("page");

$(document).ready(
            function()
            {
                $("#submitIndicator").hide();
                
                $(".button").hover(function()
                                    {
                                        $(this).css("color","Black");
                                    },
                                    function()
                                    {
                                        $(this).css("color","#333333");
                                    });

                // viewRecipe.jsp
                $("#orderCategoryHeader, #orderCategoryDiv").hover(function()
                        {
                            $("#orderCategoryDiv").css("display", "block");
                        }, 
                        function()
                        {
                            $("#orderCategoryDiv").css("display", "none");
                        });

                navigationBarActions(); 
                createEditRecipeActions();
                profileEvents();

                $(".createAddButtons").click();
            }); 