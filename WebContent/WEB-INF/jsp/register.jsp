<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%@ taglib prefix="s" uri="/struts-tags"%>
<%@ taglib prefix="sj" uri="/struts-jquery-tags" %>

<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="<s:url value="/images/favicon.png" />" />
        <link rel="stylesheet" type="text/css" href="<s:url value="/css/General.css" />" />

        <title>Personal Food Recipe - Register</title>
        <sj:head />
    </head>
    
    <body>
    
    <div class="outer">  
    <div>
        <img class="logo" src="<s:url value="/images/recipe_logo.gif" />" alt="Recipe Exchange" title="Logo"/>

        <fieldset id="registerArea">
            
            <legend>Register</legend>
            
            <div id="registerValidateDiv">
            </div>

            <s:form id="registerForm" action="userRegister" method="POST">
                
                <p>Username: <s:textfield id="registerUsername" key="username" type="text" maxlength="30"/> </p>
                <p>Password: <s:password id="registerPassword" key="password" type="password" maxlength="20"/> </p>
                <p>Confirm Password: <s:password id="registerConfirmPassword" key="confirmPassword" type="password" maxlength="20"/> </p>

                <div>
                    <s:a class="anchor" action="login" >back</s:a>
                    <sj:submit formId="registerForm"
                               targets="none"
                               onBeforeTopics="registerBefore"
                               onCompleteTopics="registerComplete"
                               onErrorTopics="registerError"
                               indicator="submitIndicator"
                               id="registerButton" cssClass="button" value="Register" />

                    <img id="submitIndicator" src="<s:url value="/images/loader_short.gif" />" height="20" width="20"/>
                </div>
            </s:form>
            
        </fieldset> 
    
<%@ include file="footer.jsp" %>