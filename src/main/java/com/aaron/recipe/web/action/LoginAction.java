/**
 * 
 */
package com.aaron.recipe.web.action;

import java.io.ByteArrayInputStream;
import java.io.InputStream;
import java.util.Map;

import org.apache.commons.lang3.StringUtils;
import org.apache.struts2.interceptor.SessionAware;

import com.aaron.recipe.web.bean.User;
import com.aaron.recipe.web.constants.ResponseText;
import com.aaron.recipe.web.service.LoginService;
import com.opensymphony.xwork2.ActionContext;
import com.opensymphony.xwork2.ActionSupport;
import com.opensymphony.xwork2.ModelDriven;

import static com.aaron.recipe.web.constants.SessionKey.*;

/**
 * @author Aaron
 *
 */
public class LoginAction extends ActionSupport implements ModelDriven<User>, SessionAware
{
    private static final long serialVersionUID = 7614847096813970821L;
    private User user;
    private InputStream responseStream;
    private Map<String, Object> session;

    @Override
    public void validate()
    {
        if(this.user == null || StringUtils.isEmpty(this.user.getUsername()) || StringUtils.isEmpty(this.user.getPassword()))
        {
            this.responseStream = new ByteArrayInputStream(ResponseText.FIELDS_INCOMPLETE.getBytes());
            this.addFieldError("username", "");
            this.addFieldError("password", "");
        }
    }

    @Override
    public String execute()
    {
        LoginService loginService = new LoginService();
        
        if(loginService.isValidUserLogin(this.user))
        {
            this.responseStream = new ByteArrayInputStream(ResponseText.SUCCESS.getBytes());
            this.session.put(loggedIn.name(), this.user.getUsername());

            return SUCCESS;
        }
        else
        {
            this.responseStream = new ByteArrayInputStream(ResponseText.UNMATCHED_USERNAME_AND_PASSWORD.getBytes());
            return LOGIN;
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

    @Override
    public void setSession(Map<String, Object> session)
    {
        this.session = session;
    }

    public User getUser()
    {
        return this.user;
    }

    public void setUser(final User user)
    {
        this.user = user;
    }

    public InputStream getResponseStream()
    {
        return this.responseStream;
    }
}
