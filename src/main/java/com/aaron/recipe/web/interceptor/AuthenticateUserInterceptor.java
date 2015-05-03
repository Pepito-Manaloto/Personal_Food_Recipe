/**
 * 
 */
package com.aaron.recipe.web.interceptor;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;

import org.apache.struts2.ServletActionContext;

import com.aaron.recipe.web.constants.SessionKey;
import com.opensymphony.xwork2.Action;
import com.opensymphony.xwork2.ActionContext;
import com.opensymphony.xwork2.ActionInvocation;
import com.opensymphony.xwork2.interceptor.Interceptor;

/**
 * @author Aaron
 *
 */
public class AuthenticateUserInterceptor implements Interceptor
{
    private static final long serialVersionUID = 2579528141872271594L;

    @Override
    public void destroy()
    {

    }

    @Override
    public void init()
    {

    }

    @Override
    public String intercept(ActionInvocation invocation) throws Exception
    {
        final ActionContext context = invocation.getInvocationContext();
        HttpServletRequest request = (HttpServletRequest) context.get(ServletActionContext.HTTP_REQUEST);
        HttpSession session = request.getSession(true);

        String loggedIn = String.valueOf(session.getAttribute(SessionKey.loggedIn.name()));

        if("null".equals(loggedIn))
        {
            return Action.LOGIN;
        }
        
        return invocation.invoke();
    }
}
