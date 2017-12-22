var baseUrl = "http://localhost/Recipe";
function loginAjax()
{
    $("#loginButton").click(function()
                            {
                                var username = $("#username").val();
                                var password = $("#password").val();

                                var datastr ="username=" + username + "&password=" + password;

                                $.ajax({
                                    type: "POST",
                                    url: baseUrl + "/php_scripts/Login_script.php",
                                    beforeSend: function(xhr)
                                                {
                                                    $("#loginArea img").show();
                                                },
                                    data: datastr
                                }).done(function(result,b,c)
                                        {
                                           $("#loginArea img").hide();

                                           if(result !== "Login Successful!")
                                           {
                                               $("#login_error").css("color", "red");
                                           }
                                           else
                                           {
                                               $("#login_error").css("color", "green");
                                               window.location.href = baseUrl + "/Home/";
                                           }

                                           $("#login_error").text(result);
                                         });

                                return false;
                            });
}

function registerAjax()
{
    $("#registerButton").click(function()
                                {
                                    var username = $("#username").val();
                                    var password = $("#password").val();
                                    var confirmPassword = $("#confirmPassword").val();
                                    var datastr ="username=" + username + "&password=" + password + "&confirmPassword=" + confirmPassword;

                                    $.ajax({
                                        type: "POST",
                                        url: baseUrl + "/php_scripts/Register_script.php",
                                        beforeSend: function(xhr)
                                                    {
                                                        $("#registerForm img").show();
                                                    },
                                        data: datastr
                                    }).done(function(result)
                                            {
                                               $("#registerForm img").hide();

                                               if(result != "Success")
                                               {
                                                   $("#register_error").css("color","red");
                                                   $("#register_error").text(result);
                                               }
                                               else
                                               {
                                                   $("#register_error").css("color","green");
                                                   $("#register_error").text("You have been registered successfully.");

                                                   setTimeout(function()
                                                              {
                                                                  window.location.href = baseUrl + "/Login/";
                                                              },500);
                                                }
                                             });

                                    return false;
                                });
}

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
    var span = document.createElement("span");
    var textNode = document.createTextNode(text);
    span.className = "spanTab handle";
    span.appendChild(textNode);

    return span;
}

function createIngredientSet()
{
    var div = document.createElement("div");
    var quantity = document.createElement("input");
    var measurement = document.createElement("input");
    var ingredient = document.createElement("input");
    var comment = document.createElement("input");
    var remove = document.createElement("input");

    div.className = "ingredientsDiv";

    quantity.type = "text";
    quantity.name = "quantities[]";
    quantity.className= "quantityField";

    measurement.type = "text";
    measurement.name = "measurements[]";
    measurement.className= "measurementField";

    ingredient.type = "text";
    ingredient.name = "ingredients[]";
    ingredient.className= "ingredientField";

    comment.type = "text";
    comment.name = "comments[]";
    comment.className= "commentField";

    remove.type = "button";
    remove.value = "-";
    remove.className = "addremoveButton removeIngredient";

    div.appendChild(quantity);
    div.appendChild(measurement);
    div.appendChild(ingredient);
    div.appendChild(comment);
    div.appendChild(remove);

    return div;
}

function createInstructionSet()
{
    var div = document.createElement("div");
    var instructions = document.createElement("textarea");
    var remove = document.createElement("input");

    div.className = "instructionsDiv";
    instructions.name = "instructions[]";
    instructions.cols = "35";
    instructions.rows = "5";
    remove.type = "button";
    remove.value = "-";
    remove.className = "addremoveButton removeInstruction";

    div.appendChild(instructions);
    div.appendChild(remove);

    return div;
}

function createEditRecipeAjax(button,script)
{
    $(button).click(function(e)
                    {
                        e.preventDefault();

                        $(".quantityField, .measurementField, .ingredientField, .commentField").each(function()
                            {
                                if( $(this).val() === "quantity" || $(this).val() === "measurement" || $(this).val() === "ingredient" || $(this).val() === "comment")
                                {
                                    $(this).val("");
                                }
                            });

                        var jsonObject = { title:null,category:null,preparationTime:null,description:null,servings:null,quantities:{},measurements:{},ingredients:{},comments:{},instructions:{} };

                        jsonObject.title = $("#titleField").val();
                        jsonObject.preparationTime = $("#timeField").val();
                        jsonObject.category = $("#categoryBox").val();
                        jsonObject.description = $("#descriptionField").val();
                        jsonObject.servings = $("#servingField").val();

                        $('#ingredientsContainer input[name="quantities[]"]').each(function(index)
                            {
                                jsonObject.quantities[index] = $(this).val();
                            });
                        $('#ingredientsContainer input[name="measurements[]"]').each(function(index)
                            {
                                jsonObject.measurements[index] = $(this).val();
                            });
                        $('#ingredientsContainer input[name="ingredients[]"]').each(function(index)
                            {
                                jsonObject.ingredients[index] = $(this).val();
                            });
                        $('#ingredientsContainer input[name="comments[]"]').each(function(index)
                            {
                                if($(this).val() !== "comment")
                                {
                                    jsonObject.comments[index] = $(this).val();
                                }
                            });
                        $("#instructionsContainer textarea").each(function(index)
                            {
                                jsonObject.instructions[index] = $(this).val();
                            });

                        $.ajax({
                            type: "POST",
                            url: baseUrl + "/php_scripts/" + script,
                            contentType: "application/json; charset=UTF-8",
                            beforeSend: function(xhr)
                                        {
                                            $("#createValidateDiv").text("Processing data please wait...");
                                        },
                            data: JSON.stringify(jsonObject)
                        }).done( function(result)
                                 {
                                    $("#createValidateDiv").text(result);
                                    $(".quantityField, .measurementField, .ingredientField, .commentField").blur();

                                    if(result === "Recipe Added!")
                                    {
                                        window.location.href = baseUrl + "/Browse_Recipe/?type=My";
                                    }

                                 });

                        return false;
                    });
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
                                    if($.trim($(this).val()) === "")
                                    {
                                        name = $(this).attr("name").substring(0, $(this).attr("name").length - 3); // Remove "s[]" from the name attrib of the field.

                                        if(name === "quantitie")
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
                                    name = $(this).attr("name").substring( 0, $(this).attr("name").length - 3 ); // Remove "s[]" from the name attrib of the field.
                                    if(name === "quantitie")
                                    {
                                        name = "quantity";
                                    }

                                    if($(this).val() === name)
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
                    $("#instructionsContainer").append( createInstructionSet()); // Create the div element first.

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

function deleteRecipeAjax()
{
    $("body").on("click","#deleteLink", function(e)
                            {
                                e.preventDefault();

                                var result = confirm("Are you sure?");

                                if(result === true)
                                {
                                    var data = {title: null, author: null};

                                    data.title = $(this).closest("tr").find("td:eq(1)").text();

                                    $(this).closest("tr").find("td:eq(0)").text("DELETING");
                                    $(this).closest("tr").find("td:eq(1)").text("DELETING");
                                    $(this).closest("tr").find("td:eq(2)").text("DELETING");
                                    $(this).closest("tr").find("td:eq(3)").text("DELETING");
                                    $(this).closest("tr").find("td:eq(4)").text("DELETING");

                                    $.ajax({
                                        type: "POST",
                                        url: baseUrl + "/php_scripts/DeleteRecipe_script.php",
                                        contentType: "application/json; charset=UTF-8",
                                        data: JSON.stringify(data)
                                    }).done(function(result)
                                            {
                                               window.location.href = baseUrl + "/Browse_Recipe/?type=My";
                                            });

                                }

                                return false;
                            });
}

function profileEvents()
{
    $("#editProfileShadow, #editProfileExit").click(function(e)
                        {
                            e.preventDefault();

                            $("#editProfileDiv, #editProfileShadow").hide();

                            return false;
                        });

    $("#profileEditLink").click(function(e)
                    {
                        e.preventDefault();

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

function editProfileAjax()
{
    $("#editProfileButton").click(function(e)
                        {
                            e.preventDefault();

                            var name = $("#username").val();
                            var password = $("#password").val();
                            var confirmPassword = $("#confirmPassword").val();

                            var datastr ="name=" + name + "&password=" + password + "&confirmPassword=" + confirmPassword;

                            $.ajax({
                                      type: "POST",
                                      url: baseUrl + "/php_scripts/EditUser_script.php",
                                      beforeSend: function(xhr)
                                      {
                                          $("#editProfileValidateDiv").css("color","blue");
                                          $("#editProfileValidateDiv").text("Processing data please wait...");
                                      },
                                      data: datastr
                                   }).done(function(result)
                                           {
                                              $("#editProfileDiv").css("height", "210px");
                                              $("#editProfileDiv").css("margin", "-160px 0 0 -160px");

                                              if(result != "Success")
                                              {
                                                  $("#editProfileValidateDiv").css("color","red");
                                                  $("#editProfileValidateDiv").text(result);
                                              }
                                              else
                                              {
                                                  $("#editProfileValidateDiv").css("color","green");
                                                  $("#editProfileValidateDiv").text("Account updated.");

                                                  setTimeout(function()
                                                             {
                                                                 window.location.href = baseUrl + "/Profile/";
                                                             },500);
                                              }
                                           });

                            return false;
                        });
}

//source: https://gist.github.com/alkos333/1771618
function getUrlParam(key)
{
    var result = new RegExp(key + "=([^&]*)", "i").exec(window.location.search);

    /*
        In javascript, the rightmost TRUE value is returned.

        if(result == true)
        {
            return decodeURIComponent(result[1]);
        }
        else
        {
            return result || ""; (return rightmost)
                => return "";
        }
    */
    return result && decodeURIComponent(result[1]) || "";
}

/*Global variables*/
var sortCategory = "All";
var orderBy = "Asc";
var typeParam = getUrlParam("type");
var pageParam = getUrlParam("page");

function viewRecipeSortAjax()
{
    var titleHeader = "";

    $("#orderTitleHeader").click(function(e)
                        {
                            e.preventDefault();

                            if( $("#orderTitleHeader").text() === "Title \u2191" ) // up arrow (ascending)
                            {
                                titleHeader = "Title \u2193";
                                orderBy = "Desc";
                            }
                            else if( $("#orderTitleHeader").text() === "Title \u2193" ) // down arrow (descending)
                            {
                                titleHeader = "Title \u2191";
                                orderBy = "Asc";
                            }

                            $.ajax({
                                      type: "GET",
                                      beforeSend: function(xhr)
                                                  {
                                                      $("#viewTable tbody").css("background","black");
                                                      $("#viewTable tbody").css("filter","alpha(opacity=75)");
                                                      $("#viewTable tbody").css("-moz-opacity","0.75");
                                                      $("#viewTable tbody").css("-khtml-opacity","0.75");
                                                      $("#viewTable tbody").css("opacity","0.75");
                                                  },
                                      url: baseUrl + "/php_scripts/ViewRecipeSort_script.php?type="+ typeParam +"&page=" + pageParam + "&order="+orderBy + "&category=" + sortCategory
                                    }).done(function(result)
                                            {
                                                $("#orderTitleHeader").text(titleHeader);
                                                $("#viewTable tbody").html(result);
                                                $("#viewTable tbody").css("background","white");
                                                $("#viewTable tbody").css("filter","alpha(opacity=75)");
                                                $("#viewTable tbody").css("-moz-opacity","1");
                                                $("#viewTable tbody").css("-khtml-opacity","1");
                                                $("#viewTable tbody").css("opacity","1");
                                            });

                            return false;
                        });

    $("#orderCategoryHeader, #orderCategoryDiv").hover(function()
                        {
                            $("#orderCategoryDiv").css("display", "block");
                        },
                        function()
                        {
                            $("#orderCategoryDiv").css("display", "none");
                        });

    $("#orderCategoryDiv p").click(function()
                        {
                            sortCategory = $(this).text();

                            if(orderBy === "")
                            {
                                orderBy ="Asc";
                            }
                            
                            $.ajax({
                                      type: "GET",
                                      beforeSend: function(xhr)
                                                  {
                                                      $("#viewTable tbody").css("background","black");
                                                      $("#viewTable tbody").css("filter","alpha(opacity=75)");
                                                      $("#viewTable tbody").css("-moz-opacity","0.75");
                                                      $("#viewTable tbody").css("-khtml-opacity","0.75");
                                                      $("#viewTable tbody").css("opacity","0.75");
                                                  },
                                      url: baseUrl + "/php_scripts/ViewRecipeSort_script.php?type="+ typeParam +"&page=" + pageParam + "&order=" + orderBy + "&category=" + sortCategory
                                    }).done(function(result)
                                            {
                                                if( sortCategory !== "All" )
                                                {
                                                    $("#orderCategoryDiv").css("display", "none");
                                                    $("#orderCategoryHeader span").html("<br/>( " + sortCategory + " )");
                                                    $("#orderCategoryDiv").css("top", "302px");
                                                }
                                                else
                                                {
                                                    $("#orderCategoryDiv").css("display", "none");
                                                    $("#orderCategoryHeader span").html("");
                                                    $("#orderCategoryDiv").css("top", "273px");
                                                }

                                                $("#viewTable tbody").html(result);

                                                $("#viewTable tbody").css("background","white");
                                                $("#viewTable tbody").css("filter","alpha(opacity=75)");
                                                $("#viewTable tbody").css("-moz-opacity","1");
                                                $("#viewTable tbody").css("-khtml-opacity","1");
                                                $("#viewTable tbody").css("opacity","1");
                                            });
                        });
}

function viewRecipePagination()
{
    $("body").on("click", "#viewPaginationDiv a",function(e)
            {
                e.preventDefault();

                pageParam = $(this).text();

                $.ajax({
                    type: "GET",
                    url: baseUrl + "/php_scripts/ViewRecipeSort_script.php?type="+ typeParam +"&page=" + pageParam + "&order="+orderBy + "&category=" + sortCategory
                }).done(function(result)
                        {
                            $("#viewTable tbody").html(result);
                            $("#viewPaginationDiv span").replaceWith("<a href='#'>" + $("#viewPaginationDiv span").text() + "</a>");
                            $("#viewPaginationDiv a:contains(" + pageParam + ")").replaceWith("<span>" + pageParam + "<span/>");
                        });

                return false;
            });

}

$(document).ready(
            function()
            {
                $("#registerForm img").hide();
                $("#loginArea img").hide();

                $(".button").hover(function()
                                    {
                                        $(this).css("color","Black");
                                    },
                                    function()
                                    {
                                        $(this).css("color","#333333");
                                    });

                loginAjax();
                registerAjax();

                navigationBarActions();

                createEditRecipeAjax("#continueButton", "CreateRecipe_script.php");
                createEditRecipeAjax("#editButton", "EditRecipe_script.php");
                createEditRecipeActions();

                deleteRecipeAjax();

                profileEvents();
                editProfileAjax();

                viewRecipeSortAjax();
                viewRecipePagination();

                $(".createAddButtons").click();
            });