package com.aaron.recipe.web.bean;

import java.io.Serializable;
import java.util.Map;
import java.util.Objects;

import com.aaron.recipe.web.bean.Recipe.Category;

/**
 * @author Aaron
 * 
 */
public class User implements Serializable
{
    private String username;
    private String password;
    private int numberOfRecipe;
    private int numberOfIngredient;
    private Map<Category, Integer> recipeCountMap;

    /**
     * Default empty constructor.
     */
    public User()
    {}

    /**
     * @return the username
     */
    public String getUsername()
    {
        return this.username;
    }

    /**
     * @param username the username to set
     */
    public void setUsername(final String username)
    {
        this.username = username;
    }

    /**
     * @return the password
     */
    public String getPassword()
    {
        return this.password;
    }

    /**
     * @param password the password to set
     */
    public void setPassword(final String password)
    {
        this.password = password;
    }

    /**
     * @return the numberOfRecipe
     */
    public int getNumberOfRecipe()
    {
        return this.numberOfRecipe;
    }

    /**
     * @param numberOfRecipe the numberOfRecipe to set
     */
    public void setNumberOfRecipe(final int numberOfRecipe)
    {
        this.numberOfRecipe = numberOfRecipe;
    }

    /**
     * @return the numberOfIngredient
     */
    public int getNumberOfIngredient()
    {
        return this.numberOfIngredient;
    }

    /**
     * @param numberOfIngredient the numberOfIngredient to set
     */
    public void setNumberOfIngredient(final int numberOfIngredient)
    {
        this.numberOfIngredient = numberOfIngredient;
    }

    /**
     * @return the recipeCountMap
     */
    public Map<Category, Integer> getRecipeCountMap()
    {
        return this.recipeCountMap;
    }

    /**
     * @param recipeCountMap the recipeCountMap to set
     */
    public void setRecipeCountMap(final Map<Category, Integer> recipeCountMap)
    {
        this.recipeCountMap = recipeCountMap;
    }

    /**
     * 
     */
    @Override
    public int hashCode()
    {
        int hash = 3;

        hash *= 47 + Objects.hashCode(this.username);
        hash *= 47 + Objects.hashCode(this.password);
        hash *= 47 + this.numberOfIngredient;
        hash *= 47 + this.numberOfRecipe;

        return hash;
    }

    /**
     * 
     */
    @Override
    public boolean equals(Object object)
    {
        if(!(object instanceof User))
        {
            return false;
        }
        else if(this == object)
        {
            return true;
        }
        else
        {
            User that = (User) object;

            return this.username.equals(that.getUsername()) &&
                   this.password.equals(that.getPassword()) &&
                   this.numberOfIngredient == that.getNumberOfIngredient() &&
                   this.numberOfRecipe == that.getNumberOfRecipe();
        }
    }

    /**
     * 
     */
    @Override
    public String toString()
    {
        return "Username: " + this.username + ", Password: " + this.password + ", # of Ingredients: " + this.getNumberOfIngredient() +
               ", # of Recipe: " + this.numberOfRecipe; 
    }
}
