<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%@ taglib prefix="s" uri="/struts-tags"%>
<%@ taglib prefix="sj" uri="/struts-jquery-tags" %>

<html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="<s:url value="/images/favicon.png"/>" />
        <link rel="stylesheet" type="text/css" href="<s:url value="/css/General.css"/>" />
        <sj:head/>
    </head>

    <body>

    <div class="outer"> 
        <div class="mainContent">

            <img class="headerImage" src="<s:url value="/images/header.jpg"/>" alt="Header Image" title="Header" />

            <div id="divider">
                <nav>
                    <ul>
                        <li> <s:a id="homeLink" action="home" class="link">Home</s:a> </li>
                        <li> <a id="recipeLink" href="#" onClick="return false;">Recipe</a> </li>
                        <li> <a id="ingredientLink" href="#" onClick="return false;">Ingredient</a> </li>
                        <li> 
                            <a id="nameLink" href="#" onClick="return false;"> 
                                <img src="<s:url value="/images/chef_hat.png" />" alt="Chef "/>
                                <s:property value="#session.loggedIn" />
                            </a> 
                        </li>
                    </ul>
                    <p class="pclear"></p>
                </nav>

                <nav id="recipeNavList" class="navList">
                    <s:url action="browseRecipe" var="browseRecipeMyUrl">
                        <s:param name="type">My</s:param>
                        <s:param name="page">1</s:param>
                    </s:url>
                    <s:a href="%{browseRecipeMyUrl}" class="link">My Recipes</s:a>

                    <s:a action="submitRecipe" class="link">Submit Recipe</s:a>

                    <s:url action="browseRecipe" var="browseRecipeAllUrl">
                        <s:param name="type">All</s:param>
                        <s:param name="page">1</s:param>
                    </s:url>
                    <s:a href="%{browseRecipeAllUrl}" class="link">Browse Recipes</s:a>
                </nav>

                <nav id="ingredientNavList" class="navList">
                    <s:a action="myIngredient" class="link">My Ingredients</s:a>
                    <a href="" class="link">Browse Ingredients</a>
                </nav>

                <nav id="nameNavList" class="navList">
                    <s:a action="profile" class="link">Profile</s:a>
                    <s:a action="logout">Logout</s:a>
                </nav>
            </div> 