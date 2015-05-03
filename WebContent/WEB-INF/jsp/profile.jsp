<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%@ taglib prefix="s" uri="/struts-tags"%>
<%@ taglib prefix="sj" uri="/struts-jquery-tags" %>

<jsp:include page="header.jsp" />

    <h1>Profile</h1>

    <div id="profileDiv">
        <p>Username:  <s:property value="user.username" /> <a id ="profileEditLink" class="profileLinks" href="#">Edit</a> </p> 
        <p>Number of Recipes: <s:property value="user.numberOfRecipe" /> <a id= "profileExpandLink" class="profileLinks" href="#">Expand</a> </p> 
        <ul id="profileRecipeList" class="profileLists">
            <s:iterator value="user.recipeCountMap" >
                <li><s:property value="key.name" /> : <s:property value="value" /></li>
            </s:iterator>
        </ul>
        
        <p>Number of Ingredients: <s:property value="user.numberOfIngredient" /> <a class="profileLinks" href="#">Expand</a> </p>

        <s:form action="createBackup" method="POST" id="submitForm">
            <s:submit id="backupButton" cssClass="button" value="Create Backup"/>
        </s:form>
        <s:actionerror />
    </div>

    <div id="editProfileDiv">
        
        <s:form id="editUserForm" action="editProfile" method="POST">
            <p>Username: <s:textfield id="profileUsername" name="username" maxlength="30"/> </p>
            <p>Password: <s:password id="profilePassword" name="password" maxlength="20"/></p>
            <p>Confirm Password: <s:password id="profileConfirmPassword" name="confirmPassword" maxlength="20" /></p>
            <p>Note: Leave password empty if you do not want to change password.</p>
            <span>
                <span id="editProfileValidateSpan"></span>
                <sj:submit formId="editUserForm"
                           targets="none"
                           onBeforeTopics="editUserBefore"
                           onCompleteTopics="editUserComplete"
                           onErrorTopics="editUserError"
                           indicator="submitIndicator"
                    id="editProfileButton" cssClass="button" value="Continue"/>

            </span>
    
            <button id="editProfileExitButton" class="button">X</button>
        </s:form>
        
    </div>
    
    <div id="editProfileShadow"></div>
    <script type="text/javascript" src="<s:url value="/javascript/jquery-ui-1.10.4.js" />" ></script>
<%@ include file="footer.jsp" %>