/**
 * 
 */
package com.aaron.recipe.web.action;

import java.util.Map;

import org.apache.struts2.interceptor.SessionAware;

import com.opensymphony.xwork2.ActionContext;
import com.opensymphony.xwork2.ActionSupport;

/**
 * @author Aaron
 *
 */
public class LogoutAction extends ActionSupport implements SessionAware
{
    private Map<String, Object> session;
    
    public String execute()
    {
        this.session.clear();

        return SUCCESS;
    }

    @Override
    public void setSession(Map<String, Object> session)
    {
        this.session = session;
    }
}
