/**
 * 
 */
package com.aaron.recipe.web.service;

import java.util.regex.Matcher;
import java.util.regex.Pattern;

import com.aaron.recipe.web.bean.User;

import static com.aaron.recipe.web.constants.ResponseText.*;

/**
 * @author Aaron
 *
 */
public class RegisterService extends UserService
{
    public boolean isValidUserRegister(final User user, final String confirmPassword)
    {
        if(this.isValidUsername(user.getUsername()) && this.isValidPassword(user.getPassword(), confirmPassword))
        {
            //insert to db
            return true;
        }
        else
        {
            return false;
        }
    }
}
