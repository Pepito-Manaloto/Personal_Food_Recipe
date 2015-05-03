/**
 * 
 */
package com.aaron.recipe.web.service;

import java.io.File;
import java.io.IOException;
import java.util.HashMap;
import java.util.Map;

import com.aaron.recipe.web.bean.Recipe.Category;
import com.aaron.recipe.web.bean.User;

/**
 * @author Aaron
 *
 */
public class ProfileService extends UserService
{
    public User getUser(final String username)
    {
        // get user from db
        User user = new User();
        user.setUsername(username);
        user.setPassword("pw");
        user.setNumberOfIngredient(10);
        user.setNumberOfRecipe(100);
        Map<Category, Integer> recipeCountMap = new HashMap<>();
        recipeCountMap.put(Category.Beef, 14);
        recipeCountMap.put(Category.Chicken, 177);
        recipeCountMap.put(Category.Pasta, 98);
        
        user.setRecipeCountMap(recipeCountMap);
        
        return user;
    }

    public boolean isValidUserEdit(final String username, final User newUser, final String confirmPassword)
    {
        if(this.isValidUsername(username) && newUser.getPassword().isEmpty() && confirmPassword.isEmpty())
        {
          //update db, username only.
        }
        else if(this.isValidUsername(username) && this.isValidPassword(newUser.getPassword(), confirmPassword))
        {
          //update db.
        }
        else
        {
            return false;
        }

        return true;
    }

    /**
     * Executes the given script, and sends output to a file.
     * @param script array of scripts
     * @param outputPath the path where the output file will be saved
     * @return true if successful, otherwise false
     */
    public boolean createBackup(final String script, final String outputPath)
    {
        boolean successful = false;
        File path = new File(outputPath);
        int result = 0;

        if(!path.exists())
        {
            path.mkdir();
        }

        try
        {
            // Current path is C:\Program Files\eclipse\${path}
            Process runtimeProcess = Runtime.getRuntime().exec(script, null, path); 
            result = runtimeProcess.waitFor(); // Returns the result of the runtime execution.

            if(result == 0)
            {
                successful = true;
            }
        }
        catch (final IOException | InterruptedException ex)
        {
            successful = false;
            this.errorMessage = ex.getMessage();
        }

        return successful;
    }
}
