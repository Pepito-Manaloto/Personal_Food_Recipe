'use strict';
var baseUrl = "http://localhost/Recipe";

var RestClient = (function()
{
    // Constructor
    function RestClient()
    {
    }

    function beforeCreateOrEditRecipe(xhr)
    {
        $("#createValidateDiv").text("Processing data please wait...");
    }

    function doneCreatingOrEditingRecipe(result)
    {
        $("#createValidateDiv").text(result);
        $(".quantityField, .measurementField, .ingredientField, .commentField").blur();

        if(result === "Recipe Added!")
        {
            window.location.href = baseUrl + "/Browse_Recipe/?type=My";
        }
    }

    function blurRecipeListTableBody(xhr)
    {
        $("#viewTable tbody").css("background","black");
        $("#viewTable tbody").css("filter","alpha(opacity=75)");
        $("#viewTable tbody").css("-moz-opacity","0.75");
        $("#viewTable tbody").css("-khtml-opacity","0.75");
        $("#viewTable tbody").css("opacity","0.75");
    }
    
    function unblurRecipeListTableBody(result)
    {
        $("#viewTable tbody").html(result);
        $("#viewTable tbody").css("background","white");
        $("#viewTable tbody").css("filter","alpha(opacity=75)");
        $("#viewTable tbody").css("-moz-opacity","1");
        $("#viewTable tbody").css("-khtml-opacity","1");
        $("#viewTable tbody").css("opacity","1");
    }

    // Public
    RestClient.prototype.login = function(postData)
    {
        $.ajax({
            type: "POST",
            url: baseUrl + "/php_scripts/Login.php",
            beforeSend: function(xhr)
            {
                $("#loginArea img").show();
            },
            data: postData
        })
        .done(function(result,b,c)
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
    };

    RestClient.prototype.register = function(postData)
    {
        $.ajax({
            type: "POST",
            url: baseUrl + "/php_scripts/Register.php",
            beforeSend: function(xhr)
            {
                $("#registerForm img").show();
            },
            data: postData
        })
        .done(function(result)
        {
           $("#registerForm img").hide();

           if(result !== "Success")
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
    };

    RestClient.prototype.createRecipe = function(postData)
    {
        $.ajax({
            type: "POST",
            url: baseUrl + "/php_scripts/Recipe.php",
            contentType: "application/json; charset=UTF-8",
            beforeSend: beforeCreateOrEditRecipe,
            data: JSON.stringify(postData)
        })
        .done(doneCreatingOrEditingRecipe);
    };

    RestClient.prototype.editRecipe = function(postData)
    {
        $.ajax({
            type: "PUT",
            url: baseUrl + "/php_scripts/Recipe.php",
            contentType: "application/json; charset=UTF-8",
            beforeSend: beforeCreateOrEditRecipe,
            data: JSON.stringify(postData)
        })
        .done(doneCreatingOrEditingRecipe);
    };

    RestClient.prototype.deleteRecipe = function(postData)
    {
        $.ajax({
            type: "DELETE",
            url: baseUrl + "/php_scripts/Recipe.php",
            contentType: "application/json; charset=UTF-8",
            data: JSON.stringify(postData)
        })
        .done(function(result)
        {
           window.location.href = baseUrl + "/Browse_Recipe/?type=My";
        });
    };

    RestClient.prototype.editProfile = function(postData)
    {
        $.ajax({
          type: "PUT",
          url: baseUrl + "/php_scripts/Profile.php",
          beforeSend: function(xhr)
          {
              $("#editProfileValidateDiv").css("color","blue");
              $("#editProfileValidateDiv").text("Processing data please wait...");
          },
          data: postData
       })
       .done(function(result)
       {
          $("#editProfileDiv").css("height", "210px");
          $("#editProfileDiv").css("margin", "-160px 0 0 -160px");

          if(result !== "Success")
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
                         }, 500);
          }
       });
    };

    RestClient.prototype.sortRecipeByTitle = function(titleHeader, typeParam, pageParam, orderBy, sortCategory)
    {
        $.ajax({
          type: "GET",
          beforeSend: blurRecipeListTableBody,
          url: baseUrl + "/php_scripts/Recipe.php?type="+ typeParam +"&page=" + pageParam + "&order="+orderBy + "&category=" + sortCategory
        })
        .done(function(result)
        {
            $("#orderTitleHeader").text(titleHeader);
            unblurRecipeListTableBody(result);
        });
    };

    RestClient.prototype.sortRecipeByCategory = function(typeParam, pageParam, orderBy, sortCategory)
    {
        $.ajax({
          type: "GET",
          beforeSend: blurRecipeListTableBody,
          url: baseUrl + "/php_scripts/Recipe.php?type="+ typeParam +"&page=" + pageParam + "&order=" + orderBy + "&category=" + sortCategory
        })
        .done(function(result)
        {
            $("#orderCategoryDiv").css("display", "none");
            
            if( sortCategory !== "All" )
            {
                $("#orderCategoryHeader span").html("<br/>( " + sortCategory + " )");
                $("#orderCategoryDiv").css("top", "302px");
            }
            else
            {
                $("#orderCategoryHeader span").html("");
                $("#orderCategoryDiv").css("top", "273px");
            }

            unblurRecipeListTableBody(result);
        });
    };

    RestClient.prototype.recipePagination = function(typeParam, pageParam, orderBy, sortCategory)
    {
        $.ajax({
            type: "GET",
            url: baseUrl + "/php_scripts/Recipe.php?type="+ typeParam +"&page=" + pageParam + "&order="+orderBy + "&category=" + sortCategory
        })
        .done(function(result)
        {
            $("#viewTable tbody").html(result);
            $("#viewPaginationDiv span").replaceWith("<a href='#'>" + $("#viewPaginationDiv span").text() + "</a>");
            $("#viewPaginationDiv a:contains(" + pageParam + ")").replaceWith("<span>" + pageParam + "<span/>");
        });
    };

    return RestClient;
})();