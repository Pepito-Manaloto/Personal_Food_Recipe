/**
 * 
 */
package com.aaron.recipe.web.constants;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Calendar;

/**
 * @author Aaron
 *
 */
public class Constant
{
    public static final String BACKUP_FOLDER = "./backup";
    public static final String BACKUP_SCRIPT;
    public static final String BACKUP_FILENAME;
    public static final String CURRENT_DATE;

    static
    {
        DateFormat dateFormat = new SimpleDateFormat("MMMM dd, yyyy");
        Calendar cal = Calendar.getInstance();
        CURRENT_DATE = dateFormat.format(cal.getTime());
        BACKUP_FILENAME = "personal_food_recipe ("+ CURRENT_DATE +").sql";
        BACKUP_SCRIPT = "mysqldump --routines -uroot -proot --add-drop-database -B personal_food_recipe -r \"" + BACKUP_FILENAME + "\"";
    }
}
