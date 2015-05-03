/**
 * 
 */
package com.aaron.recipe.web.action;

import java.io.ByteArrayInputStream;
import java.io.InputStream;

import org.apache.commons.lang3.StringUtils;

import com.aaron.recipe.web.bean.User;
import com.aaron.recipe.web.constants.ResponseText;
import com.aaron.recipe.web.service.RegisterService;
import com.opensymphony.xwork2.ActionSupport;
import com.opensymphony.xwork2.ModelDriven;

/**
 * @author Aaron
 *
 */
public class RegisterAction extends ActionSupport implements ModelDriven<User>
{
    private User user;
    private InputStream responseStream;
    private String confirmPassword;

    @Override
    public void validate()
    {
        if(this.user == null || StringUtils.isEmpty(this.user.getUsername()) || StringUtils.isEmpty(this.user.getPassword()) ||
           this.confirmPassword == null || StringUtils.isEmpty(this.confirmPassword))
        {
            this.responseStream = new ByteArrayInputStream(ResponseText.FIELDS_INCOMPLETE.getBytes());
            this.addFieldError("username", "");
            this.addFieldError("password", "");
            this.addFieldError("confirmPassword", "");
        }
    }

    @Override
    public String execute()
    {
        RegisterService registerService = new RegisterService();
        
        if(registerService.isValidUserRegister(this.user, this.confirmPassword))
        {
            this.responseStream = new ByteArrayInputStream(ResponseText.SUCCESS.getBytes());
            return SUCCESS;
        }
        else
        {
            this.responseStream = new ByteArrayInputStream(registerService.getErrorMessageBytes());
            return INPUT;
        }
    }

    public String forward()
    {
        return SUCCESS;
    }

    @Override
    public User getModel()
    {
        this.user = new User();
        return this.user;
    }

    public User getUser()
    {
        return this.user;
    }

    public void setUser(final User user)
    {
        this.user = user;
    }

    /**
     * @return the registerConfirmPassword
     */
    public String getConfirmPassword()
    {
        return this.confirmPassword;
    }

    /**
     * @param registerConfirmPassword the registerConfirmPassword to set
     */
    public void setConfirmPassword(final String confirmPassword)
    {
        this.confirmPassword = confirmPassword;
    }

    public InputStream getResponseStream()
    {
        return this.responseStream;
    }
}
