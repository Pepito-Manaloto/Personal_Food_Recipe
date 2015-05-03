/**
 * 
 */
package com.aaron.recipe.web.constants;

/**
 * @author Aaron
 *
 */
public class ResponseText
{
    // General
    public static final String SUCCESS = "Success";
    public static final String FIELDS_INCOMPLETE = "Complete all fields";

    // Login
    public static final String UNMATCHED_USERNAME_AND_PASSWORD = "Invalid username or password.";

    // Register
    public static final String USERNAME_LENGTH_ERROR = "Username must be at least 5 characters";
    public static final String PASSWORD_LENGTH_ERROR = "Password must be at least 5 characters";
    public static final String PASSWORD_REGEX_ERROR = "Password must contain letters and digits";
    public static final String UNMATCHED_PASSWORD_AND_CONFIRMPW = "Password and confirm password do not match";
    
}
