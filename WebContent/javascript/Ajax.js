baseUrl = "http://192.168.1.101:8080/Recipe";

function enableSubmitButton(cssId)
{
    $(cssId).css("filter", "");
    $(cssId).css("-webkit-filter", "");
    $(cssId).prop("disabled", false);
}

function disableSubmitButton(cssId)
{
    $(cssId).prop("disabled", true);
    $(cssId).css("filter", "brightness(0.8)");
    $(cssId).css("-webkit-filter", "brightness(0.8)");
}

function loginAjax()
{
    $.subscribe('loginBefore', function(event, data)
    {
        disableSubmitButton("#loginButton");
    });

    $.subscribe('loginComplete', function(event, data)
    {
        response = event.originalEvent.request.responseText;

        if(event.originalEvent.request.responseText == "Success")
        {
            $("#loginValidateDiv").css("color","green");
            $("#loginValidateDiv").text("Login Successful!");
            window.location.href = baseUrl + "/home";
        }
        else
        {
           $("#loginValidateDiv").css("color","red");
           $("#loginValidateDiv").text(response);
        }

        $("#loginUsername").val('');
        $("#loginPassword").val('');
        enableSubmitButton("#loginButton");
    });

    $.subscribe('loginError', function(event, data)
    {
        $("#loginValidateDiv").css("color","red");
        $("#loginValidateDiv").text("Error, status code: " + event.originalEvent.request.status);
    });
}   

function registerAjax()
{
    $.subscribe('registerBefore', function(event, data)
    {
        disableSubmitButton("#registerButton");
    });

    $.subscribe('registerComplete', function(event, data)
    {
        response = event.originalEvent.request.responseText;
        
        if(response == "Success")
        {
            $("#registerValidateDiv").css("color","green");
            $("#registerValidateDiv").text("You have been registered successfully.");
            window.location.href = baseUrl + "/login";
        }
        else
        {
            $("#registerValidateDiv").css("color","red");
            $("#registerValidateDiv").text(response);
        }

        $("#registerUsername").val('');
        $("#registerPassword").val('');
        $("#registerConfirmPassword").val('');
        enableSubmitButton("#registerButton");
    });
    
    $.subscribe('registerError', function(event, data)
    {
        $("#registerValidateDiv").css("color","red");
        $("#registerValidateDiv").text("Error, status code: " + event.originalEvent.request.status);
    });
}

function createEditRecipeAjax(button,script)
{
    $(button).click(function(e)
                                {
                                    e.preventDefault();
                                    
                                    $(".quantityField, .measurementField, .ingredientField, .commentField").each(function()
                                        { 
                                            if( $(this).val() == "quantity" || $(this).val() == "measurement" || $(this).val() == "ingredient" || $(this).val() == "comment")
                                                $(this).val(""); 
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
                                            if( $(this).val() != "comment" )
                                                jsonObject.comments[index] = $(this).val();
                                        }); 
                                    $('#instructionsContainer textarea').each(function(index)
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
                                                
                                                if(result == "Recipe Added!")
                                                    window.location.href = baseUrl + "/Browse_Recipe/?type=My";
                                                    
                                             });    
                                             
                                    return false;       
                                });                     
}

function deleteRecipeAjax()
{
    $("body").on("click","#deleteLink", function(e)
                            {
                                e.preventDefault();
                                
                                var result = confirm("Are you sure?");
                                                    
                                if(result == true)
                                {
                                    var data = {title: null, author: null};
    
                                    data.title = $(this).closest('tr').find("td:eq(1)").text();
                                    
                                    $(this).closest('tr').find("td:eq(0)").text("DELETING");
                                    $(this).closest('tr').find("td:eq(1)").text("DELETING");
                                    $(this).closest('tr').find("td:eq(2)").text("DELETING");
                                    $(this).closest('tr').find("td:eq(3)").text("DELETING");
                                    $(this).closest('tr').find("td:eq(4)").text("DELETING");

                                    $.ajax({
                                    
                                        type: "POST",
                                        url: baseUrl + "/php_scripts/DeleteRecipe_script.php", 
                                        contentType: "application/json; charset=UTF-8",
                                        data: JSON.stringify(data)  
                                        
                                    }).done( function(result)
                                             {
                                                window.location.href = baseUrl + "/Browse_Recipe/?type=My";                                                                                    
                                             });    
                                             
                                }
                                
                                return false;
                            });
}

function editProfileAjax()
{
    $.subscribe('editUserBefore', function(event, data)
    {
        $("#editProfileValidateSpan").css("color", "blue");
        $("#editProfileValidateSpan").text("Processing data please wait...");
        disableSubmitButton("#editProfileButton");
    });

    $.subscribe('editUserComplete', function(event, data)
    {
        $("#editProfileDiv").css("height", "210px");
        $("#editProfileDiv").css("margin", "-160px 0 0 -160px");
        
        response = event.originalEvent.request.responseText;

        if(response == "Success")
        {
            $("#editProfileValidateSpan").css("color","green");
            $("#editProfileValidateSpan").text("Account updated.");
            window.location.href = baseUrl + "/profile";
        }
        else
        {
            $("#editProfileValidateSpan").css("color","red");
            $("#editProfileValidateSpan").text(response);
        }

        $("#profileUsername").val('');
        $("#profilePassword").val('');
        $("#profileConfirmPassword").val('');
        enableSubmitButton("#editProfileButton");
    });

    $.subscribe('editUserError', function(event, data)
    {

        $("#editProfileValidateSpan").css("color","red");
        $("#editProfileValidateSpan").text("Error, status code: " + event.originalEvent.request.status);
    });
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

                            if( $("#orderTitleHeader").text() == "Title \u2191" ) // up arrow (ascending)
                            {
                                titleHeader = "Title \u2193";
                                orderBy = "Desc";
                            }
                            else if( $("#orderTitleHeader").text() == "Title \u2193" ) // down arrow (descending)
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

    $("#orderCategoryDiv p").click(function()
                        {
                            sortCategory = $(this).text();
                            
                            if(orderBy == "")
                                orderBy ="Asc";
                                
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
                                                if( sortCategory != "All" )
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

function viewRecipePaginationAjax()
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
                loginAjax();
                registerAjax();
                createEditRecipeAjax("#continueButton", "CreateRecipe_script.php");
                createEditRecipeAjax("#editButton", "EditRecipe_script.php");
                deleteRecipeAjax();
                editProfileAjax();
                viewRecipeSortAjax();
                viewRecipePaginationAjax();
            }); 