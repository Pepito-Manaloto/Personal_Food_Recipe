/**
 * 
 */
package com.aaron.recipe.web.service;

import static com.aaron.recipe.web.constants.ResponseText.PASSWORD_LENGTH_ERROR;
import static com.aaron.recipe.web.constants.ResponseText.PASSWORD_REGEX_ERROR;
import static com.aaron.recipe.web.constants.ResponseText.UNMATCHED_PASSWORD_AND_CONFIRMPW;
import static com.aaron.recipe.web.constants.ResponseText.USERNAME_LENGTH_ERROR;
import static com.aaron.recipe.web.service.UserService.PASSWORD_PATTERN;

import java.util.regex.Matcher;
import java.util.regex.Pattern;

/**
 * @author Aaron
 *
 */
public class UserService
{
    protected static final Pattern PASSWORD_PATTERN = Pattern.compile("^[a-zA-Z0-9]*([a-zA-Z]+[0-9]+|[0-9]+[a-zA-Z]+)[a-zA-Z0-9]*$");
    protected String errorMessage;
    
    protected boolean isValidUsername(final String username)
    {
        if(username.length() < 5)
        {
            this.errorMessage = USERNAME_LENGTH_ERROR;
            return false;
        }

        return true;
    }

    protected boolean isValidPassword(final String password, final String confirmPassword)
    {
        if(password.length() > 4)
        {
            Matcher matcher = PASSWORD_PATTERN.matcher(password);

            if(matcher.matches())
            {
                if(password.equals(confirmPassword))
                {
                    return true;
                }
                else
                {
                    this.errorMessage = UNMATCHED_PASSWORD_AND_CONFIRMPW;
                    return false;
                }
            }
            else
            {
                this.errorMessage = PASSWORD_REGEX_ERROR;
                return false;
            }
        }
        else
        {
            this.errorMessage = PASSWORD_LENGTH_ERROR;
            return false;
        }
    }

    public byte[] getErrorMessageBytes()
    {
        return this.errorMessage.getBytes();
    }

    public String getErrorMessage()
    {
        return this.errorMessage;
    }
}
