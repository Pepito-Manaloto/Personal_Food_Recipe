/**
 * 
 */
package com.aaron.recipe.web.action;

import java.io.ByteArrayInputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.InputStream;
import java.util.Map;

import org.apache.commons.lang3.StringUtils;
import org.apache.struts2.interceptor.SessionAware;

import com.aaron.recipe.web.bean.User;
import com.aaron.recipe.web.constants.ResponseText;
import com.aaron.recipe.web.constants.SessionKey;
import com.aaron.recipe.web.service.ProfileService;
import com.opensymphony.xwork2.ActionSupport;
import com.opensymphony.xwork2.ModelDriven;

import static com.aaron.recipe.web.constants.Constant.*;

/**
 * @author Aaron
 *
 */
public class ProfileAction extends ActionSupport implements ModelDriven<User>, SessionAware
{
    private InputStream responseStream;
    
    private InputStream downloadStream;
    private String fileName;

    private User user;
    private Map<String, Object> session;
    private ProfileService profileService = new ProfileService();

    private String confirmPassword;

    public String forward()
    {
        String username = String.valueOf(this.session.get(SessionKey.loggedIn.name()));
        this.setUser(this.profileService.getUser(username));

        return SUCCESS;
    }

    @Override
    public void validate()
    {
        if(this.user == null || StringUtils.isEmpty(this.user.getUsername()))
        {
            this.responseStream = new ByteArrayInputStream(ResponseText.FIELDS_INCOMPLETE.getBytes());
            this.addFieldError("username", "");
        }
    }

    public void edit()
    {
        String username = String.valueOf(this.session.get(SessionKey.loggedIn.name()));

        if(this.profileService.isValidUserEdit(username, this.user, this.confirmPassword))
        {
            this.responseStream = new ByteArrayInputStream(ResponseText.SUCCESS.getBytes());
        }
        else
        {
            this.responseStream = new ByteArrayInputStream(this.profileService.getErrorMessageBytes());
        }
    }

    public String createBackup()
    {
        boolean isSuccessful = this.profileService.createBackup(BACKUP_SCRIPT, BACKUP_FOLDER);

        if(isSuccessful)
        {
            File fileToDownload = new File(BACKUP_FOLDER + "/" + BACKUP_FILENAME);
            this.setFileName(fileToDownload.getName());

            try
            {
                this.downloadStream = new FileInputStream(fileToDownload);
            }
            catch (FileNotFoundException e)
            {
                this.addActionError("Error occurred in downloading backup: " + e.getMessage());
                return ERROR;
            }
            return SUCCESS;
        }
        else
        {
            this.addActionError("Error occurred in creating backup: " + this.profileService.getErrorMessage());
            return ERROR;
        }
    }

    /**
     * @return the user
     */
    public User getUser()
    {
        return this.user;
    }

    /**
     * @param user the user to set
     */
    public void setUser(final User user)
    {
        this.user = user;
    }

    public InputStream getResponseStream()
    {
        return this.responseStream;
    }

    public InputStream getDownloadStream()
    {
        return this.downloadStream;
    }

    /**
     * @return the fileName
     */
    public String getFileName()
    {
        return this.fileName;
    }

    /**
     * @param fileName the fileName to set
     */
    public void setFileName(final String fileName)
    {
        this.fileName = fileName;
    }

    /**
     * @return the confirmPassword
     */
    public String getConfirmPassword()
    {
        return this.confirmPassword;
    }

    /**
     * @param confirmPassword the confirmPassword to set
     */
    public void setConfirmPassword(final String confirmPassword)
    {
        this.confirmPassword = confirmPassword;
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
}
