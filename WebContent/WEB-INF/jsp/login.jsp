<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%@ taglib prefix="s" uri="/struts-tags"%>
<%@ taglib prefix="sj" uri="/struts-jquery-tags" %>

<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="<s:url value="/images/favicon.png" />" />
        <link rel="stylesheet" type="text/css" href="<s:url value="/css/General.css" />">

        <title>Personal Food Recipe - Login</title>
        <sj:head />
    </head>
    
    <body>
    <div class="outer">
    <div>
        <img class="logo" src="<s:url value="/images/recipe_logo.gif" />" alt="Recipe Exchange" title="Logo" />
        
        <fieldset id="loginArea">
            
            <legend>Login</legend>

                <div id="loginValidateDiv">
                </div>

                <s:form id="loginForm" action="userLogin" method="POST">
                    <p>Username: <s:textfield key="username" id="username" maxlength="30" /></p>
                    <p>Password&nbsp;: <s:password key="password" id="password" maxlength="20" /></p>

                    <div>
                        <sj:submit formId="loginForm"
                                   targets="none"
                                   onBeforeTopics="loginBefore"
                                   onCompleteTopics="loginComplete" 
                                   onErrorTopics="loginError"
                                   indicator="submitIndicator"
                                   id="loginButton" cssClass="button" value="Login" />
                        
                        <img id="submitIndicator" src="<s:url value="/images/loader_short.gif" />" height="20" width="20"/>
                        <p id="registerParagraph">Do not have an account?
                            <s:a class="anchor" action="register" >Register</s:a>
                        </p> 
                    </div>
                </s:form>
                     
        </fieldset>
<%@ include file="footer.jsp" %>